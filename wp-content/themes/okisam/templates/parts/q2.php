<?php
/**
 * Contenedor Q2
 * Displays Q2 content from ACF flexible content field
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

// Check if Q2 should be displayed
if (!okisam_should_q2_be_unlocked($panel_id)) {
	return;
}

// Get Q2 flexible content
$q2_modules = get_field('panel_q2', $panel_id);

if ($q2_modules && is_array($q2_modules) && count($q2_modules) > 0) {
	?>
	<div class="p-20 q2-container">
		<h2>Q2 - Segunda Quincena</h2>
		<div class="modules-grid">
			<?php
			foreach ($q2_modules as $module) {
				$layout = $module['acf_fc_layout'];
				
				// Include the appropriate module template based on layout type
				$module_template = locate_template('templates/modules/' . $layout . '.php');
				if ($module_template) {
					include $module_template;
				} else {
					// Fallback: display basic module info
					echo '<div class="module module-' . esc_attr($layout) . '">';
					echo '<p>Módulo: ' . esc_html($layout) . '</p>';
					echo '</div>';
				}
			}
			?>
		</div>
	</div>
	<?php
}
