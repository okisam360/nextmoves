<?php
/**
 * Module: Video Sumario
 * Displays a summary video module
 */

$title = isset($module['video_sumario_title']) ? $module['video_sumario_title'] : '';
$url = isset($module['video_sumario_url']) ? $module['video_sumario_url'] : '';
$thumb = isset($module['video_sumario_thumb']) ? $module['video_sumario_thumb'] : '';
$desc = isset($module['video_sumario_desc']) ? $module['video_sumario_desc'] : '';
$size = isset($module['video_sumario_size']) ? $module['video_sumario_size'] : '1x1';

$thumb_url   = is_array($thumb) && isset($thumb['url']) ? $thumb['url'] : $thumb;
$thumb_width = is_array($thumb) && isset($thumb['width']) ? (int) $thumb['width'] : 0;
$thumb_height = is_array($thumb) && isset($thumb['height']) ? (int) $thumb['height'] : 0;
$thumb_id = is_array($thumb) && isset($thumb['ID']) ? (int) $thumb['ID'] : 0;

// Generate srcset and sizes for responsive images
$thumb_srcset = '';
$thumb_sizes = '';
if ($thumb_id) {
	// Use medium size (360px) as base - WordPress will generate srcset with all available sizes
	$thumb_srcset = wp_get_attachment_image_srcset($thumb_id, 'medium');
	if (!$thumb_srcset && $thumb_width && $thumb_height) {
		// Fallback: manually calculate srcset
		$image_meta = wp_get_attachment_metadata($thumb_id);
		if ($image_meta && isset($image_meta['sizes'])) {
			$thumb_srcset = wp_calculate_image_srcset(
				array($thumb_width, $thumb_height),
				$thumb_url,
				$image_meta,
				$thumb_id
			);
		}
	}
	// For grid modules: max 1/3 of viewport width on mobile (~400px), full width on desktop
	$thumb_sizes = '(max-width: 991px) 33vw, (max-width: 1200px) 300px, 400px';
	
	// DEBUG: Show image info (only for admins)
	if (current_user_can('administrator') && isset($_GET['debug_images'])) {
		$image_meta = wp_get_attachment_metadata($thumb_id);
		echo '<!-- DEBUG VIDEO SUMARIO: ID=' . $thumb_id . ', URL=' . $thumb_url . ', Srcset=' . ($thumb_srcset ?: 'EMPTY') . ', Meta=' . print_r($image_meta, true) . ' -->';
	}
}

// Tracking data
$m_phase = isset($phase) ? $phase : '';
$m_unlocked = isset($unlocked) ? $unlocked : 'true';
?>

<div class="module module-video-sumario module-size-<?php echo esc_attr($size); ?>" data-module-type="video-summary" data-video="true" data-phase="<?php echo esc_attr($m_phase); ?>" data-unlocked="<?php echo esc_attr($m_unlocked); ?>">
	<?php if ($thumb_url): ?>
		<div class="module-thumbnail">
			<?php if (current_user_can('administrator') && isset($_GET['debug_images'])): ?>
				<div style="background: yellow; padding: 10px; margin-bottom: 10px; font-size: 12px; color: black;">
					<strong>DEBUG VIDEO SUMARIO:</strong><br>
					ID: <?php echo $thumb_id ?: 'NO ID'; ?><br>
					URL: <?php echo esc_html($thumb_url); ?><br>
					Srcset: <?php echo $thumb_srcset ? esc_html($thumb_srcset) : 'EMPTY'; ?><br>
					Sizes: <?php echo esc_html($thumb_sizes); ?><br>
					Dimensions: <?php echo $thumb_width . 'x' . $thumb_height; ?>
				</div>
			<?php endif; ?>
			<img
				src="<?php echo esc_url($thumb_url); ?>"
				<?php if ($thumb_srcset): ?>
					srcset="<?php echo esc_attr($thumb_srcset); ?>"
					sizes="<?php echo esc_attr($thumb_sizes); ?>"
				<?php endif; ?>
				<?php if ($thumb_width && $thumb_height): ?>
					width="<?php echo esc_attr($thumb_width); ?>"
					height="<?php echo esc_attr($thumb_height); ?>"
				<?php endif; ?>
				alt="<?php echo esc_attr($title); ?>"
				loading="lazy"
			>
		</div>
	<?php endif; ?>
	
	<div class="module-content">
		<?php if ($title): ?>
			<h3 class="module-title"><?php echo esc_html($title); ?></h3>
		<?php endif; ?>
		
		<?php if ($url): ?>
			<a href="#" class="video-play-link js-video-modal-trigger" data-video-url="<?php echo esc_url($url); ?>" rel="noopener">
				<div class="play-icon-wrapper">
					<svg class="play-icon-circle-text" width="200" height="200" viewBox="0 0 200 200">
						<defs>
							<path id="circle-path-sumario" d="M 100, 100 m -45, 0 a 45,45 0 1,1 90,0 a 45,45 0 1,1 -90,0" />
						</defs>
						<text fill="#FFFFFF" font-family="Graphik, sans-serif" font-size="12.26" font-weight="500" line-height="100%" letter-spacing="0">
							<textPath href="#circle-path-sumario" startOffset="0%">
								Mira el video | Mira el video | Mira el video | Mira el video |
							</textPath>
						</text>
					</svg>
					<span class="play-icon">▶</span>
				</div>
			</a>
		<?php endif; ?>
		
		<?php if ($desc): ?>
			<p class="module-description"><?php echo esc_html($desc); ?></p>
		<?php endif; ?>
	</div>
</div>
