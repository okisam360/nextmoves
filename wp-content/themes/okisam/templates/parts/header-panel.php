<?php
/**
 * Header del Panel
 * Implementación inicial: usa imágenes estáticas y deja marcadores ACF como comentarios
 */
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
				<p class="h1-semibold">03</p>
				<p class="h4-regular">Informe 2026<br>Entrega de septiembre</p>
			</div>
		</div>
		<div class="panel-info">
			<div class="panel-info-content">
				<div class="panel-info-title">
					<?php // ACF: echo esc_html( get_field('panel_title') ); ?>
					<h1 class="display-xl-bold text-neutral-95"><?php /* the_field('panel_title'); */ echo 'IA, LA NUEVA REINA<br>DEL TABLERO'; ?></h1>
		
					<?php // ACF: echo esc_html( get_field('panel_subtitle') ); ?>
					<h2 class="h3-regular text-neutral-95"><?php /* the_field('panel_subtitle'); */ echo 'EL SALTO DEL CABALLO'; ?></h2>
				</div>
	
				<?php // ACF: echo wp_kses_post( get_field('panel_intro') ); ?>
				<p class="h4-regular text-neutral-95"><?php /* the_field('panel_intro'); */ echo 'Texto introductorio al tema en 3 o 4 lineas ese que llega torpedo benemeritaar quietooor a wan no te digo trigo por no llamarte Rodrigor. Condemor te va a hasé pupitaa llevame al sircoo quietooor.De la pradera hasta luego Lucas al ataquerl ese que llega torpedo benemeritaar quietooor a wan no te digo trigo por no llamarte Rodrigor. Condemor te va a '; ?></p>
			</div>
		</div>

		<div class="panel-image" style="background-image: url('<?php echo esc_url( $header_image ); ?>');" role="img" aria-label="Imagen del panel"></div>
	</div>

	<div class="panel-video" style="background-image: url('<?php echo esc_url( $video_bg ); ?>');">
		<div class="video-overlay"></div>
		<div class="video-card">
			<?php // ACF: the_field('panel_video_title'); ?>
			<h3 class="h2-bold title-video text-neutral-00"><?php /* the_field('panel_video_title'); */ echo 'Título del video'; ?></h3>

			<button class="video-play" aria-label="Reproducir video">
				<img src="<?php echo esc_url( $video_play ); ?>" alt="Play icon">
			</button>
		</div>
	</div>
</div>
