<?php
/**
 * Custom Post Types Registration
 */

// Register Panel CPT
function okisam_register_panel_cpt() {
    $labels = array(
        'name'               => 'Paneles',
        'singular_name'      => 'Panel',
        'menu_name'          => 'Paneles',
        'add_new'            => 'Añadir Panel',
        'add_new_item'       => 'Añadir nuevo Panel',
        'edit_item'          => 'Editar Panel',
        'new_item'           => 'Nuevo Panel',
        'view_item'          => 'Ver Panel',
        'search_items'       => 'Buscar Paneles',
        'not_found'          => 'No se encontraron paneles',
        'not_found_in_trash' => 'No se encontraron paneles en la papelera',
        'all_items'          => 'Todos los Paneles'
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'panel'),
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-calendar-alt',
        'supports'            => array('title', 'editor', 'thumbnail'),
        'show_in_rest'        => true,
    );

    register_post_type('panel', $args);
}
add_action('init', 'okisam_register_panel_cpt');

/**
 * Panel Management Utility Functions
 */

/**
 * Get the active panel
 * @return WP_Post|null The active panel post object or null
 */
function okisam_get_active_panel() {
    $args = array(
        'post_type'      => 'panel',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'meta_query'     => array(
            array(
                'key'     => 'panel_status',
                'value'   => 'activo',
                'compare' => '='
            )
        ),
        'orderby'        => 'date',
        'order'          => 'DESC'
    );

    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        return $query->posts[0];
    }
    
    return null;
}

/**
 * Get all panels ordered by date
 * @return array Array of panel post objects
 */
function okisam_get_all_panels() {
    $args = array(
        'post_type'      => 'panel',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'meta_value',
        'meta_key'       => 'panel_date',
        'order'          => 'ASC'
    );

    $query = new WP_Query($args);
    return $query->posts;
}

/**
 * Get the previous panel (relative to a given panel)
 * @param int $panel_id The current panel ID
 * @return WP_Post|null The previous panel post object or null
 */
function okisam_get_previous_panel($panel_id) {
    $current_panel = get_post($panel_id);
    if (!$current_panel) {
        return null;
    }

    $current_date = get_field('panel_date', $panel_id);
    if (!$current_date) {
        return null;
    }

    $args = array(
        'post_type'      => 'panel',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'meta_query'     => array(
            array(
                'key'     => 'panel_date',
                'value'   => $current_date,
                'compare' => '<',
                'type'    => 'DATE'
            )
        ),
        'orderby'        => 'meta_value',
        'meta_key'       => 'panel_date',
        'order'          => 'DESC'
    );

    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        return $query->posts[0];
    }
    
    return null;
}

/**
 * Get the next panel (relative to a given panel)
 * @param int $panel_id The current panel ID
 * @return WP_Post|null The next panel post object or null
 */
function okisam_get_next_panel($panel_id) {
    $current_panel = get_post($panel_id);
    if (!$current_panel) {
        return null;
    }

    $current_date = get_field('panel_date', $panel_id);
    if (!$current_date) {
        return null;
    }

    $args = array(
        'post_type'      => 'panel',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'meta_query'     => array(
            array(
                'key'     => 'panel_date',
                'value'   => $current_date,
                'compare' => '>',
                'type'    => 'DATE'
            )
        ),
        'orderby'        => 'meta_value',
        'meta_key'       => 'panel_date',
        'order'          => 'ASC'
    );

    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        return $query->posts[0];
    }
    
    return null;
}

/**
 * Check if we are in the final phase (T.16) where all panels should be visible
 * @return bool True if in final phase
 */
function okisam_is_final_phase() {
    // Get the option for final phase or check if it's December
    $final_phase = get_option('okisam_final_phase', false);
    
    // Alternative: check if we're in December (final phase)
    $current_month = date('n');
    if ($current_month == 12) {
        return true;
    }
    
    return $final_phase;
}

/**
 * Check if a panel should be active based on dates
 * @param int $panel_id The panel ID to check
 * @return bool True if the panel should be active
 */
function okisam_should_panel_be_active($panel_id) {
    $q1_unlock_date = get_field('panel_q1_unlock_date', $panel_id);
    
    if (!$q1_unlock_date) {
        return false;
    }

    $current_date = current_time('Y-m-d');
    $q1_date = date('Y-m-d', strtotime($q1_unlock_date));

    // Panel should be active if Q1 unlock date has passed
    return $current_date >= $q1_date;
}

/**
 * Check if Q1 should be unlocked for a panel
 * @param int $panel_id The panel ID to check
 * @return bool True if Q1 should be unlocked
 */
function okisam_should_q1_be_unlocked($panel_id) {
    $q1_unlock_date = get_field('panel_q1_unlock_date', $panel_id);
    
    if (!$q1_unlock_date) {
        return false;
    }

    $current_date = current_time('Y-m-d');
    $q1_date = date('Y-m-d', strtotime($q1_unlock_date));

    return $current_date >= $q1_date;
}

/**
 * Check if Q2 should be unlocked for a panel
 * @param int $panel_id The panel ID to check
 * @return bool True if Q2 should be unlocked
 */
function okisam_should_q2_be_unlocked($panel_id) {
    $q2_unlock_date = get_field('panel_q2_unlock_date', $panel_id);
    
    if (!$q2_unlock_date) {
        return false;
    }

    $current_date = current_time('Y-m-d');
    $q2_date = date('Y-m-d', strtotime($q2_unlock_date));

    return $current_date >= $q2_date;
}

/**
 * Update panel activation status
 * Run this daily via cron to check and update panel statuses
 */
function okisam_update_panel_statuses() {
    // Skip in final phase
    if (okisam_is_final_phase()) {
        return;
    }

    $panels = okisam_get_all_panels();
    $active_panel_found = false;
    $previous_active_id = null;

    foreach ($panels as $panel) {
        $should_be_active = okisam_should_panel_be_active($panel->ID);
        $current_status = get_field('panel_status', $panel->ID);

        if ($should_be_active && !$active_panel_found) {
            // This panel should be active
            if ($current_status !== 'activo') {
                // Deactivate the previous active panel
                if ($previous_active_id) {
                    update_field('panel_status', 'oculto', $previous_active_id);
                }
                
                // Activate this panel
                update_field('panel_status', 'activo', $panel->ID);
            }
            $active_panel_found = true;
        } else {
            // This panel should be hidden
            if ($current_status === 'activo') {
                $previous_active_id = $panel->ID;
            }
            if ($current_status !== 'oculto') {
                update_field('panel_status', 'oculto', $panel->ID);
            }
        }
    }
}

/**
 * Schedule daily cron job to update panel statuses
 */
function okisam_schedule_panel_status_update() {
    if (!wp_next_scheduled('okisam_daily_panel_status_update')) {
        wp_schedule_event(time(), 'daily', 'okisam_daily_panel_status_update');
    }
}
add_action('wp', 'okisam_schedule_panel_status_update');

/**
 * Hook the panel status update to the cron job
 */
add_action('okisam_daily_panel_status_update', 'okisam_update_panel_statuses');

/**
 * Clear the cron job on theme deactivation
 */
function okisam_clear_panel_status_cron() {
    $timestamp = wp_next_scheduled('okisam_daily_panel_status_update');
    if ($timestamp) {
        wp_unschedule_event($timestamp, 'okisam_daily_panel_status_update');
    }
}
register_deactivation_hook(__FILE__, 'okisam_clear_panel_status_cron');
