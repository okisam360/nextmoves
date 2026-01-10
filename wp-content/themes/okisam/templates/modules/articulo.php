<?php
/**
 * Module: Artículo
 * Displays an article module
 */

$title = isset($module['article_title']) ? $module['article_title'] : '';
$excerpt = isset($module['article_excerpt']) ? $module['article_excerpt'] : '';
$content = isset($module['article_content']) ? $module['article_content'] : '';
$image = isset($module['article_image']) ? $module['article_image'] : '';
$color = isset($module['article_color']) ? $module['article_color'] : 'default';

$image_url = is_array($image) ? $image['url'] : $image;
?>

<div class="module module-articulo module-color-<?php echo esc_attr($color); ?>">
	<?php if ($image_url): ?>
		<div class="module-image">
			<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>">
		</div>
	<?php endif; ?>
	
	<div class="module-content">
		<?php if ($title): ?>
			<h3 class="article-title"><?php echo esc_html($title); ?></h3>
		<?php endif; ?>
		
		<?php if ($excerpt): ?>
			<p class="article-excerpt"><?php echo esc_html($excerpt); ?></p>
		<?php endif; ?>
		
		<?php if ($content): ?>
			<div class="article-content">
				<?php echo wp_kses_post($content); ?>
			</div>
		<?php endif; ?>
	</div>
</div>
