<?php

	/**
	* Template Name: Home
	*/

?>
<div class="front-page-container">
	<?php 
	// Check if we're in final phase (T.16) where all panels should be visible
	$is_final_phase = okisam_is_final_phase();
	
	if ($is_final_phase) {
		// Show all panels in final phase
		$panels = okisam_get_all_panels();
		foreach ($panels as $panel) {
			// Set global panel ID for template parts
			global $panel_id;
			$panel_id = $panel->ID;
			
			get_template_part('templates/parts/header-panel');
			get_template_part('templates/parts/q1');
			get_template_part('templates/parts/q2');
		}
	} else {
		// Show panel based on current date
		okisam_get_visible_panel();

		// Get the active panel
		$active_panel = okisam_get_active_panel();

		if ($active_panel) {

			// Set global panel ID for template parts
			global $panel_id;
			$panel_id = $active_panel->ID;
			
			get_template_part('templates/parts/header-panel');
			// Always show Q1 and Q2 - they will handle their own locked state display
			get_template_part('templates/parts/q1');
			get_template_part('templates/parts/q2');
		} else {
			
			// No active panel found - show default message
			echo '<div class="no-panel-message">';
			echo '<p>No hay panel activo en este momento.</p>';
			echo '</div>';
		}
	}
	?>
</div>