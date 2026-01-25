<?php
/**
 * Header del Panel
 * Implementación: usa el panel activo y sus campos ACF
 */
global $panel_id;

// If no panel_id is set globally, get the active panel
if (!isset($panel_id) || !$panel_id) {
	$active_panel = okisam_get_active_panel();
	$panel_id = $active_panel ? $active_panel->ID : null;
}

// If still no panel, return
if (!$panel_id) {
	return;
}

$theme_uri = get_template_directory_uri();

// Get panel fields
$panel_title = get_field('panel_title', $panel_id);
$panel_subtitle = get_field('panel_subtitle', $panel_id);
$panel_intro = get_field('panel_intro', $panel_id);
$panel_report_delivery = get_field('panel_report_delivery', $panel_id);
$panel_image = get_field('panel_image', $panel_id);
$panel_video_title = get_field('panel_title_video', $panel_id);
$panel_video_thumbnail = get_field('panel_video_thumbnail', $panel_id);
$panel_video_url = get_field('panel_video', $panel_id);

// Fallback images if fields are empty - Handle different ACF return formats
$header_image_srcset = '';
$header_image_sizes = '';
$header_image_id = 0;

if (is_array($panel_image) && isset($panel_image['url'])) {
	$header_image = $panel_image['url'];
	$header_image_width = isset($panel_image['width']) ? (int) $panel_image['width'] : 0;
	$header_image_height = isset($panel_image['height']) ? (int) $panel_image['height'] : 0;
	$header_image_id = isset($panel_image['ID']) ? (int) $panel_image['ID'] : 0;
	
	// Generate srcset and sizes for responsive images (critical for mobile LCP)
	if ($header_image_id) {
		// Use medium_large (720px) as base size - WordPress will generate srcset with all available sizes
		$header_image_srcset = wp_get_attachment_image_srcset($header_image_id, 'medium_large');
		if (!$header_image_srcset) {
			// Fallback: try with large size
			$header_image_srcset = wp_get_attachment_image_srcset($header_image_id, 'large');
		}
		if (!$header_image_srcset && $header_image_width && $header_image_height) {
			// Last fallback: manually calculate srcset using available sizes
			$image_meta = wp_get_attachment_metadata($header_image_id);
			if ($image_meta && isset($image_meta['sizes'])) {
				$header_image_srcset = wp_calculate_image_srcset(
					array($header_image_width, $header_image_height),
					$header_image,
					$image_meta,
					$header_image_id
				);
			}
		}
		// For mobile: max 100vw, for desktop: max 775px (panel-image width)
		$header_image_sizes = '(max-width: 991px) 100vw, 775px';
		
		// DEBUG: Show image info (only for admins)
		if (current_user_can('administrator') && isset($_GET['debug_images'])) {
			$image_meta = wp_get_attachment_metadata($header_image_id);
			echo '<!-- DEBUG HEADER PANEL: ID=' . $header_image_id . ', URL=' . $header_image . ', Srcset=' . ($header_image_srcset ?: 'EMPTY') . ', Meta=' . print_r($image_meta, true) . ' -->';
		}
	}
} elseif (is_string($panel_image) && !empty($panel_image)) {
	$header_image = $panel_image;
	$header_image_width = 0;
	$header_image_height = 0;
} else {
	$header_image = $theme_uri . '/app/images/tmp/e11a6642c6aa3136891018c085b974f1db587f0a.jpg';
	$header_image_width = 0;
	$header_image_height = 0;
}

// Handle video thumbnail
if (is_array($panel_video_thumbnail) && isset($panel_video_thumbnail['url'])) {
	$video_bg = $panel_video_thumbnail['url'];
} elseif (is_string($panel_video_thumbnail) && !empty($panel_video_thumbnail)) {
	$video_bg = $panel_video_thumbnail;
} else {
	$video_bg = $theme_uri . '/app/images/tmp/95044467b2e4e5101cfa5e345d4455db03865474.jpg';
}
?>

<div class="panel-header">
	<div class="panel-top bg-brand">
		<div class="panel-band text-neutral-00 bg-neutral-95"> 
			<div class="panel-band-content">
				<p class="h1-semibold"><?php echo esc_html($panel_report_delivery ? $panel_report_delivery : 'Próxima Entrega'); ?></p>
				<p class="h4-regular">Informe 2026<?php if ($panel_report_delivery): ?><br>Entrega de mes<?php endif; ?></p>
			</div>
		</div>
		<div class="panel-info">
			<div class="panel-info-content">
				<div class="panel-info-title">
					<h1 class="display-xl-bold text-neutral-95"><?php echo esc_html($panel_title ? $panel_title : ''); ?></h1>
		
					<h2 class="h3-regular text-neutral-95"><?php echo esc_html($panel_subtitle ? $panel_subtitle : ''); ?></h2>
				</div>
	
				<p class="h4-regular text-neutral-95"><?php echo esc_html($panel_intro ? $panel_intro : ''); ?></p>
			</div>
		</div>

			<div class="panel-image">
				<?php if (current_user_can('administrator') && isset($_GET['debug_images'])): ?>
					<div style="background: yellow; padding: 10px; margin-bottom: 10px; font-size: 12px; color: black; position: relative; z-index: 9999;">
						<strong>DEBUG HEADER PANEL:</strong><br>
						ID: <?php echo $header_image_id ?: 'NO ID'; ?><br>
						URL: <?php echo esc_html($header_image); ?><br>
						Srcset: <?php echo $header_image_srcset ? esc_html($header_image_srcset) : 'EMPTY'; ?><br>
						Sizes: <?php echo esc_html($header_image_sizes); ?><br>
						Dimensions: <?php echo $header_image_width . 'x' . $header_image_height; ?>
					</div>
				<?php endif; ?>
				<img
					src="<?php echo esc_url($header_image); ?>"
					<?php if ($header_image_srcset): ?>
						srcset="<?php echo esc_attr($header_image_srcset); ?>"
						sizes="<?php echo esc_attr($header_image_sizes); ?>"
					<?php endif; ?>
					<?php if ($header_image_width && $header_image_height): ?>
						width="<?php echo esc_attr($header_image_width); ?>"
						height="<?php echo esc_attr($header_image_height); ?>"
					<?php endif; ?>
					alt="<?php echo esc_attr($panel_title ? $panel_title : __('Imagen del panel', 'okisam')); ?>"
					fetchpriority="high"
					loading="eager"
				>
		</div>
	</div>

	<?php if ($panel_video_title || $panel_video_thumbnail): ?>
	<div class="panel-video" style="background-image: url('<?php echo esc_url($video_bg); ?>');">
		<div class="video-overlay"></div>
		<div class="video-card">
			<h3 class="h2-bold title-video text-neutral-00"><?php echo esc_html($panel_video_title ? $panel_video_title : ''); ?></h3>

			<?php if ($panel_video_url): ?>
				<a href="#" class="video-play-link js-video-modal-trigger" data-video-url="<?php echo esc_url($panel_video_url); ?>" rel="noopener" data-module-type="video-header" data-video="true" data-unlocked="true">
					<div class="play-icon-wrapper">
						<svg class="play-icon-circle-text" width="200" height="200" viewBox="0 0 200 200">
							<defs>
								<path id="circle-path-panel" d="M 100, 100 m -45, 0 a 45,45 0 1,1 90,0 a 45,45 0 1,1 -90,0" />
							</defs>
							<text fill="#FFFFFF" font-family="Graphik, sans-serif" font-size="12.26" font-weight="500" line-height="100%" letter-spacing="0">
								<textPath href="#circle-path-panel" startOffset="0%">
									Mira el video | Mira el video | Mira el video | Mira el video |
								</textPath>
							</text>
						</svg>
						<span class="play-icon">▶</span>
					</div>
				</a>
			<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>
</div>
