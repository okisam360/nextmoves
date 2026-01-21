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

$image_url = is_array($image) ? $image['url'] : $image;
?>

<div class="module module-grafico module-size-<?php echo esc_attr($size); ?> module-color-<?php echo esc_attr($color); ?>">
	<?php if ($image_url): ?>
		<div class="module-image" style="background-image: url('<?php echo esc_url($image_url); ?>');"></div>
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
