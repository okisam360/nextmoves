<?php
/**
 * Header del Panel
 * Implementación inicial: usa imágenes estáticas y deja marcadores ACF como comentarios
 */
$panel_id = 39; // ID del panel que quieres consultar
$theme_uri = get_template_directory_uri();
// Imágenes provistas por el cliente
$header_image = $theme_uri . '/app/images/tmp/e11a6642c6aa3136891018c085b974f1db587f0a.jpg';
$video_bg = $theme_uri . '/app/images/tmp/95044467b2e4e5101cfa5e345d4455db03865474.jpg';
$video_play = $theme_uri . '/app/icons/video-play.svg';
?>

<div class="panel-header ">
	<div class="panel-top bg-brand">
		<div class="panel-band text-neutral-00 bg-neutral-95"> 
			<div class="panel-band-content">
				<p class="h1-semibold"><?php the_field('panel_report_delivery', $panel_id); ?></p>
				<p class="h4-regular">Informe 2026<br>Entrega de septiembre</p>
			</div>
		</div>
		<div class="panel-info">
			<div class="panel-info-content">
				<div class="panel-info-title">
					<h1 class="display-xl-bold text-neutral-95"><?php the_field('panel_title', $panel_id); ?></h1>
		
					<h2 class="h3-regular text-neutral-95"><?php the_field('panel_subtitle', $panel_id); ?></h2>
				</div>
	
				<p class="h4-regular text-neutral-95"><?php the_field('panel_intro', $panel_id); ?></p>
			</div>
		</div>

		<div class="panel-image" style="background-image: url('<?php echo esc_url( $header_image ); ?>');" role="img" aria-label="Imagen del panel"></div>
	</div>

	<div class="panel-video" style="background-image: url('<?php echo esc_url( $video_bg ); ?>');">
		<div class="video-overlay"></div>
		<div class="video-card">
			<h3 class="h2-bold title-video text-neutral-00"><?php the_field('panel_video_title', $panel_id); ?></h3>

			<button class="video-play" aria-label="Reproducir video">
				<img src="<?php echo esc_url( $video_play ); ?>" alt="Play icon">
			</button>
		</div>
	</div>
</div>
