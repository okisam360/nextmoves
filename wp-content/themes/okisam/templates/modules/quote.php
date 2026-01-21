<?php
/**
 * Module: Quote
 * Displays a quote module
 */

$text = isset($module['quote_text']) ? $module['quote_text'] : '';
$author = isset($module['quote_author']) ? $module['quote_author'] : '';
$source = isset($module['quote_source']) ? $module['quote_source'] : '';
$color = isset($module['quote_color']) ? $module['quote_color'] : 'default';
$size = isset($module['quote_size']) ? $module['quote_size'] : '1x1';

// Check if there's no attribution
$has_attribution = !empty($author) || !empty($source);
$no_attribution_class = $has_attribution ? '' : 'no-attribution';
?>

<div class="module module-quote module-size-<?php echo esc_attr($size); ?> module-color-<?php echo esc_attr($color); ?> <?php echo esc_attr($no_attribution_class); ?>">
	<div class="module-content">
		<?php if ($text): ?>
			<blockquote class="quote-text">
				<?php echo esc_html($text); ?>
			</blockquote>
		<?php endif; ?>
		
		<?php if ($has_attribution): ?>
			<div class="quote-attribution">
				<?php if ($author): ?>
					<p class="quote-author"><?php echo esc_html($author); ?></p>
				<?php endif; ?>
				
				<?php if ($source): ?>
					<p class="quote-source"><?php echo esc_html($source); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</div>
