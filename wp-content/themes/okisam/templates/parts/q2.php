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

// Check if Q2 should be unlocked
$is_q2_unlocked = okisam_should_q2_be_unlocked($panel_id);

// Get Q2 flexible content
$q2_modules = get_field('panel_q2', $panel_id);
$has_modules = $q2_modules && is_array($q2_modules) && count($q2_modules) > 0;

// Edge case: If Q2 is unlocked but has no cards, don't show anything (maintain previous panel)
if ($is_q2_unlocked && !$has_modules) {
	return;
}

// If locked and has no modules, also don't show (nothing to preview)
if (!$is_q2_unlocked && !$has_modules) {
	return;
}

// Determine container class based on lock status
$container_class = $is_q2_unlocked ? 'q2-container' : 'q2-container locked';

// Get unlock date for locked message
$q2_unlock_date = get_field('panel_q2_unlock_date', $panel_id);
$unlock_date_formatted = okisam_format_unlock_date($q2_unlock_date);
?>

<div class="p-20 <?php echo esc_attr($container_class); ?>">
	<h2>Q2 - Segunda Quincena</h2>
	
	<?php if (!$is_q2_unlocked): ?>
		<div class="locked-message">
			<h3>🔒 Contenido Bloqueado</h3>
			<p>Esta quincena se desbloqueará el <?php echo esc_html($unlock_date_formatted); ?></p>
		</div>
	<?php endif; ?>
	
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
