<?php
/**
 * Module: Video Entrevista
 * Displays an interview video module
 */

$title = isset($module['video_entrevista_title']) ? $module['video_entrevista_title'] : '';
$url = isset($module['video_entrevista_url']) ? $module['video_entrevista_url'] : '';
$thumb = isset($module['video_entrevista_thumb']) ? $module['video_entrevista_thumb'] : '';
$person_role = isset($module['video_entrevista_person_role']) ? $module['video_entrevista_person_role'] : '';
$size = isset($module['video_entrevista_size']) ? $module['video_entrevista_size'] : '1x1';

$thumb_url = is_array($thumb) ? $thumb['url'] : $thumb;
?>

<div class="module module-video-entrevista module-size-<?php echo esc_attr($size); ?>">
	<?php if ($thumb_url): ?>
		<div class="module-thumbnail" style="background-image: url('<?php echo esc_url($thumb_url); ?>');">
			<?php if ($url): ?>
				<a href="#" class="video-play-link js-video-modal-trigger" data-video-url="<?php echo esc_url($url); ?>" rel="noopener">
					<span class="play-icon">▶</span>
				</a>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	
	<div class="module-content">
		<?php if ($title): ?>
			<h3 class="module-title"><?php echo esc_html($title); ?></h3>
		<?php endif; ?>
		
		<?php if ($person_role): ?>
			<p class="module-person-role"><?php echo esc_html($person_role); ?></p>
		<?php endif; ?>
	</div>
</div>
