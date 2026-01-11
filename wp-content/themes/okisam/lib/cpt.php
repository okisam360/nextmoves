<?php
/**
 * Custom Post Types Registration
 */


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
                'value'   => 'active',
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
 * Get all panels for the current year ordered by date
 * @return array Array of panel post objects
 */
function okisam_get_all_panels() {
    $current_year = date('Y');
    $args = array(
        'post_type'      => 'panel',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'meta_query'     => array(
            array(
                'key'     => 'panel_date',
                'value'   => array($current_year . '-01-01', $current_year . '-12-31'),
                'compare' => 'BETWEEN',
                'type'    => 'DATE'
            )
        ),
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
 * Check if a date field has been reached
 * @param string $date_string The date to check
 * @return bool True if the date has been reached
 */
function okisam_check_unlock_date($date_string) {
    if (!$date_string) {
        return false;
    }

    $current_date = current_time('Y-m-d');
    $unlock_date = date('Y-m-d', strtotime($date_string));

    return $current_date >= $unlock_date;
}

/**
 * Check if a panel should be active based on dates
 * @param int $panel_id The panel ID to check
 * @return bool True if the panel should be active
 */
function okisam_should_panel_be_active($panel_id) {
    $q1_unlock_date = get_field('panel_q1_unlock_date', $panel_id);
    return okisam_check_unlock_date($q1_unlock_date);
}

/**
 * Check if Q1 should be unlocked for a panel
 * @param int $panel_id The panel ID to check
 * @return bool True if Q1 should be unlocked
 */
function okisam_should_q1_be_unlocked($panel_id) {
    $q1_unlock_date = get_field('panel_q1_unlock_date', $panel_id);
    return okisam_check_unlock_date($q1_unlock_date);
}

/**
 * Check if Q2 should be unlocked for a panel
 * @param int $panel_id The panel ID to check
 * @return bool True if Q2 should be unlocked
 */
function okisam_should_q2_be_unlocked($panel_id) {
    $q2_unlock_date = get_field('panel_q2_unlock_date', $panel_id);
    return okisam_check_unlock_date($q2_unlock_date);
}

/**
 * Format unlock date for display
 * @param string $date_string The date to format
 * @return string Formatted date or fallback text
 */
function okisam_format_unlock_date($date_string) {
    if (!$date_string) {
        return 'próximamente';
    }
    
    $unlock_timestamp = strtotime($date_string);
    if ($unlock_timestamp === false) {
        return 'próximamente';
    }
    
    return date_i18n('j \d\e F, Y', $unlock_timestamp);
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
    
    // First pass: find which panel should be active
    $panel_to_activate = null;
    foreach ($panels as $panel) {
        if (okisam_should_panel_be_active($panel->ID)) {
            $panel_to_activate = $panel;
            // Continue to find the latest panel that should be active
        }
    }
    
    // Second pass: update statuses
    foreach ($panels as $panel) {
        $current_status = get_field('panel_status', $panel->ID);
        
        if ($panel_to_activate && $panel->ID === $panel_to_activate->ID) {
            // This is the panel that should be active
            if ($current_status !== 'active') {
                update_field('panel_status', 'active', $panel->ID);
            }
        } else {
            // All other panels should be hidden
            if ($current_status !== 'hidden') {
                update_field('panel_status', 'hidden', $panel->ID);
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
 * Clear the cron job on theme switch
 */
function okisam_clear_panel_status_cron() {
    $timestamp = wp_next_scheduled('okisam_daily_panel_status_update');
    if ($timestamp) {
        wp_unschedule_event($timestamp, 'okisam_daily_panel_status_update');
    }
}
add_action('switch_theme', 'okisam_clear_panel_status_cron');
