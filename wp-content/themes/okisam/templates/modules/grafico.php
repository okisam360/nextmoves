<?php
/**
 * Module: Gráfico
 * Displays a graphic/chart module
 */

$image = isset($module['graphic_image']) ? $module['graphic_image'] : '';
$desc = isset($module['graphic_desc']) ? $module['graphic_desc'] : '';
$source = isset($module['graphic_source']) ? $module['graphic_source'] : '';
$color = isset($module['graphic_color']) ? $module['graphic_color'] : 'default';
$size = isset($module['graphic_size']) ? $module['graphic_size'] : '1x1';

$image_url    = is_array($image) && isset($image['url']) ? $image['url'] : $image;
$image_width  = is_array($image) && isset($image['width']) ? (int) $image['width'] : 0;
$image_height = is_array($image) && isset($image['height']) ? (int) $image['height'] : 0;
$image_id = is_array($image) && isset($image['ID']) ? (int) $image['ID'] : 0;

// Generate srcset and sizes for responsive images
$image_srcset = '';
$image_sizes = '';
if ($image_id) {
	// Use medium size (360px) as base - WordPress will generate srcset with all available sizes
	$image_srcset = wp_get_attachment_image_srcset($image_id, 'medium');
	if (!$image_srcset && $image_width && $image_height) {
		// Fallback: manually calculate srcset
		$image_meta = wp_get_attachment_metadata($image_id);
		if ($image_meta && isset($image_meta['sizes'])) {
			$image_srcset = wp_calculate_image_srcset(
				array($image_width, $image_height),
				$image_url,
				$image_meta,
				$image_id
			);
		}
	}
	// For grid modules: max 1/3 of viewport width on mobile (~400px), full width on desktop
	$image_sizes = '(max-width: 991px) 33vw, (max-width: 1200px) 300px, 400px';
	
	// DEBUG: Show image info (only for admins)
	if (current_user_can('administrator') && isset($_GET['debug_images'])) {
		$image_meta = wp_get_attachment_metadata($image_id);
		echo '<!-- DEBUG GRAFICO: ID=' . $image_id . ', URL=' . $image_url . ', Srcset=' . ($image_srcset ?: 'EMPTY') . ', Meta=' . print_r($image_meta, true) . ' -->';
	}
}

// Tracking data
$m_phase = isset($phase) ? $phase : '';
$m_unlocked = isset($unlocked) ? $unlocked : 'true';
?>

<div class="module module-grafico module-size-<?php echo esc_attr($size); ?> module-color-<?php echo esc_attr($color); ?>" data-module-type="graphic" data-phase="<?php echo esc_attr($m_phase); ?>" data-unlocked="<?php echo esc_attr($m_unlocked); ?>">
	<?php if ($image_url): ?>
		<div class="module-image">
			<?php if (current_user_can('administrator') && isset($_GET['debug_images'])): ?>
				<div style="background: yellow; padding: 10px; margin-bottom: 10px; font-size: 12px; color: black;">
					<strong>DEBUG GRAFICO:</strong><br>
					ID: <?php echo $image_id ?: 'NO ID'; ?><br>
					URL: <?php echo esc_html($image_url); ?><br>
					Srcset: <?php echo $image_srcset ? esc_html($image_srcset) : 'EMPTY'; ?><br>
					Sizes: <?php echo esc_html($image_sizes); ?><br>
					Dimensions: <?php echo $image_width . 'x' . $image_height; ?>
				</div>
			<?php endif; ?>
			<img
				src="<?php echo esc_url($image_url); ?>"
				<?php if ($image_srcset): ?>
					srcset="<?php echo esc_attr($image_srcset); ?>"
					sizes="<?php echo esc_attr($image_sizes); ?>"
				<?php endif; ?>
				<?php if ($image_width && $image_height): ?>
					width="<?php echo esc_attr($image_width); ?>"
					height="<?php echo esc_attr($image_height); ?>"
				<?php endif; ?>
				alt="<?php echo esc_attr($desc ? $desc : __('Gráfico', 'okisam')); ?>"
				loading="lazy"
			>
		</div>
	<?php endif; ?>
	
	<div class="module-content">
		<?php if ($desc): ?>
			<p class="graphic-description"><?php echo esc_html($desc); ?></p>
		<?php endif; ?>
		
		<?php if ($source): ?>
			<p class="graphic-source"><small><?php echo esc_html($source); ?></small></p>
		<?php endif; ?>
	</div>
</div>
