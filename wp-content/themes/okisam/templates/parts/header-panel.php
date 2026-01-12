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
$panel_video_title = get_field('panel_video_title', $panel_id);
$panel_video_thumbnail = get_field('panel_video_thumbnail', $panel_id);

// Fallback images if fields are empty
$header_image = $panel_image ? $panel_image['url'] : $theme_uri . '/app/images/tmp/e11a6642c6aa3136891018c085b974f1db587f0a.jpg';
$video_bg = $panel_video_thumbnail ? $panel_video_thumbnail['url'] : $theme_uri . '/app/images/tmp/95044467b2e4e5101cfa5e345d4455db03865474.jpg';
$video_play = $theme_uri . '/app/icons/video-play.svg';
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

		<div class="panel-image" style="background-image: url('<?php echo esc_url($header_image); ?>');" role="img" aria-label="Imagen del panel"></div>
	</div>

	<?php if ($panel_video_title || $panel_video_thumbnail): ?>
	<div class="panel-video" style="background-image: url('<?php echo esc_url($video_bg); ?>');">
		<div class="video-overlay"></div>
		<div class="video-card">
			<h3 class="h2-bold title-video text-neutral-00"><?php echo esc_html($panel_video_title ? $panel_video_title : ''); ?></h3>

			<button class="video-play" aria-label="Reproducir video">
				<img src="<?php echo esc_url($video_play); ?>" alt="Play icon">
			</button>
		</div>
	</div>
	<?php endif; ?>
</div>
