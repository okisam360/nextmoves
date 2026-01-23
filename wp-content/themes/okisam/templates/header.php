<?php
$active_panel = okisam_get_active_panel();
$remaining_seconds = -1;
$show_countdown = false;

if ($active_panel) {
	if (!okisam_should_q2_be_unlocked($active_panel->ID)) {
		// Q2 is still locked - Show countdown to Q2
		$unlock_date = okisam_get_q_unlock_date($active_panel->ID, 'panel_q2_unlock_day');
		if ($unlock_date) {
			$remaining_seconds = strtotime($unlock_date) - current_time('timestamp');
			$show_countdown = ($remaining_seconds > 0);
		}
	}
	// Note: If Q2 is already unlocked, we don't show the countdown to the next panel yet 
	// as per requirement (only show if Q2 is blocked in the current month).
}
?>
<header class="hero-header ta-c">
	<div class="box mx-a px-15">
		<h1 class="c-white mb-30">¡Bienvenidx a nuestro Tablero de Marketing Industrial!</h1>
		<p class="c-white mb-45 mx-a" style="opacity: 0.9; line-height: 1.5;">
			Un informe vivo de 12 entregas quincenales en el que, como cada año, te mostramos como está la foto del sector industrial en cuanto a comunicación y marketing digital se refiere.
		</p>

		<?php if ($show_countdown): ?>
		<div class="countdown-container mt-50">
			<p class="h3-regular c-white mb-35">Nuevo contenido en:</p>
			
			<div class="countdown-timer js-countdown jc-c" data-remaining="<?php echo esc_attr($remaining_seconds); ?>">
				<div class="countdown-item text-brand">
					<span class="h2-bold" data-days>00</span>
					<span class="body-s-regular countdown-label">Días</span>
				</div>
				<div class="h3-regular countdown-separator text-brand">:</div>
				<div class="countdown-item text-brand">
					<span class="h2-bold" data-hours>00</span>
					<span class="body-s-regular countdown-label">Horas</span>
				</div>
				<div class="h3-regular countdown-separator text-brand">:</div>
				<div class="countdown-item text-brand">
					<span class="h2-bold" data-mins>00</span>
					<span class="body-s-regular countdown-label">Mins</span>
				</div>
				<div class="h3-regular countdown-separator text-brand">:</div>
				<div class="countdown-item text-brand">
					<span class="h2-bold" data-secs>00</span>
					<span class="body-s-regular countdown-label">Secs</span>
				</div>
			</div>
		</div>

		<div class="mt-55">
			<a href="#newsletter" class="btn-orange" data-cta="subscription">Suscríbete ya</a>
		</div>
		<?php endif; ?>
	</div>
</header>

