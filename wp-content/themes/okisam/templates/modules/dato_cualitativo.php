<?php
/**
 * Module: Dato Cualitativo
 * Displays a qualitative data module
 */

$value = isset($module['data_value']) ? $module['data_value'] : '';
$label = isset($module['data_label']) ? $module['data_label'] : '';
$note = isset($module['data_note']) ? $module['data_note'] : '';
$color = isset($module['data_color']) ? $module['data_color'] : 'default';
$size = isset($module['data_size']) ? $module['data_size'] : 'medium';
?>

<div class="module module-dato-cualitativo module-size-<?php echo esc_attr($size); ?> module-color-<?php echo esc_attr($color); ?>">
	<div class="module-content">
		<?php if ($value): ?>
			<div class="data-value"><?php echo esc_html($value); ?></div>
		<?php endif; ?>
		
		<?php if ($label): ?>
			<p class="data-label"><?php echo esc_html($label); ?></p>
		<?php endif; ?>
		
		<?php if ($note): ?>
			<p class="data-note"><small><?php echo esc_html($note); ?></small></p>
		<?php endif; ?>
	</div>
</div>
