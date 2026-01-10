<?php
/**
 * Contenedor Q1
 * Displays Q1 content from ACF flexible content field
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

// Check if Q1 should be displayed
if (!okisam_should_q1_be_unlocked($panel_id)) {
	return;
}

// Get Q1 flexible content
$q1_modules = get_field('panel_q1', $panel_id);

if ($q1_modules && is_array($q1_modules) && count($q1_modules) > 0) {
	?>
	<div class="p-20 q1-container">
		<h2>Q1 - Primera Quincena</h2>
		<div class="modules-grid">
			<?php
			foreach ($q1_modules as $module) {
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
