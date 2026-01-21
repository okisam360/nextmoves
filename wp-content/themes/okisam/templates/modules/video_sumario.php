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

$thumb_url = is_array($thumb) ? $thumb['url'] : $thumb;
?>

<div class="module module-video-sumario module-size-<?php echo esc_attr($size); ?>">
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
		
		<?php if ($url): ?>
			<a href="<?php echo esc_url($url); ?>" class="video-play-link" target="_blank" rel="noopener">
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
