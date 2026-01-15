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

// Check if Q1 should be unlocked
$is_q1_unlocked = okisam_should_q1_be_unlocked($panel_id);

// Get Q1 flexible content
$q1_modules = get_field('panel_q1', $panel_id);
$has_modules = $q1_modules && is_array($q1_modules) && count($q1_modules) > 0;

// Edge case: If Q1 is unlocked but has no cards, don't show anything (maintain previous panel)
if ($is_q1_unlocked && !$has_modules) {
	return;
}

// If locked and has no modules, also don't show (nothing to preview)
if (!$is_q1_unlocked && !$has_modules) {
	return;
}

// Determine container class based on lock status
$container_class = $is_q1_unlocked ? 'q1-container' : 'q1-container locked';

// Get unlock date for locked message
$q1_unlock_date = okisam_get_q_unlock_date($panel_id, 'panel_q1_unlock_day');
$unlock_date_formatted = okisam_format_unlock_date($q1_unlock_date);
?>

<div class="p-20 <?php echo esc_attr($container_class); ?>">
	<?php if (!$is_q1_unlocked): ?>
		<div class="locked-overlay">
			<div class="locked-message">
				<h3>🔒 Contenido Bloqueado</h3>
				<p>Esta quincena se desbloqueará el <?php echo esc_html($unlock_date_formatted); ?></p>
			</div>
		</div>
	<?php endif; ?>

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
