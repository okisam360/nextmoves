<?php
/**
 * Custom Post Types Registration
 */


/**
 * Panel mode helpers
 */
function okisam_get_panel_mode() {
    $mode = get_field('panel_mode', 'option');
    $mode = in_array($mode, ['history', 'yearly'], true) ? $mode : 'yearly';

    $history_timestamp = okisam_get_panel_history_mode_date();
    if ($mode === 'yearly' && $history_timestamp) {
        $now = current_time('timestamp');
        if ($now >= $history_timestamp) {
            // settear modo history por fecha automáticamente
            okisam_set_panel_mode('history');
            return 'history';
        }
    }

    return $mode;
}

function okisam_set_panel_mode($mode) {
    if (!in_array($mode, ['history', 'yearly'], true)) {
        return false;
    }

    return update_field('panel_mode', $mode, 'option');
}

function okisam_get_panel_history_mode_date() {
    $date_value = get_field('panel_date_history_mode', 'option');
    if (!$date_value) {
        return null;
    }

    // Accepts datetime strings like "Y-m-d H:i:s"; falls back to null on parse failure.
    $timestamp = strtotime($date_value);
    if ($timestamp === false) {
        return null;
    }

    return $timestamp;
}

/**
 * Panel Management Utility Functions
 */
function okisam_get_visible_panel()  {
    $current_panel = okisam_get_current_panel();
    // verificar que q1 tiene modulos antes de activar el panel, si tiene modulos activar y ocultar los otros, si no tiene buscar el panel anterior
    if ( $current_panel && okisam_check_panel_has_module( $current_panel->ID, 'panel_q1' ) ) {
        // hide all panels except active panel
        okisam_hide_all_panels_except( $current_panel->ID );
    }else {
        // buscar panel anterior con modulos en q1
        $previous_panel = okisam_get_previous_panel( $current_panel->ID );
        // activa el panel anterior con modulos, hasta que el siguiente panel tenga modulos en q1
        okisam_hide_all_panels_except( $previous_panel->ID );
    }
}


/**
 * Check if a panel has modules in a given Q field
 * @param int $panel_id The panel ID to check
 * @param string $q_field The ACF field name for the Q modules (e.g., 'panel_q1' or 'panel_q2')
 * @return bool True if the panel has modules in the specified Q field
 */
function okisam_check_panel_has_module( $panel_id, $q_field ) {
    $modules = get_field( $q_field, $panel_id );
    $has_modules = $modules && is_array( $modules ) && count( $modules ) > 0;
    return $has_modules;    
}

function okisam_hide_all_panels_except( $panel_id_to_exclude ) {
    $panels = okisam_get_all_panels();
    
    foreach ( $panels as $panel ) {
        if ( $panel->ID !== $panel_id_to_exclude ) {
            // Hide this panel
            update_field( 'panel_status', 'hidden', $panel->ID );
        } else {
            // Ensure the excluded panel is active
            update_field( 'panel_status', 'active', $panel->ID );
        }
    }
}


function okisam_get_current_panel() {
    $args = array(
        'post_type'      => 'panel',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'meta_query'     => array(
            array(
                'key'     => 'panel_date',
                'value'   => array(
                    date('Y-m-01'), // Primer día del mes actual
                    date('Y-m-t')   // Último día del mes actual
                ),
                'compare' => 'BETWEEN',
                'type'    => 'DATE'
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
};

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
 * Get all panels for the current year ordered by date
 * @return array Array of panel post objects
 */

function okisam_get_all_panels_current_year() {
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
        'order'          => 'DESC'
    );

    $query = new WP_Query($args);
    return $query->posts;
}

/**
 * Get panels batch for lazy loading
 * @param int $page The page number
 * @param int $per_page Number of panels per page
 * @return WP_Query
 */
function okisam_get_panels_batch($page = 1, $per_page = 3) {
    $current_year = date('Y');
    $args = array(
        'post_type'      => 'panel',
        'posts_per_page' => $per_page,
        'paged'          => $page,
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
        'order'          => 'DESC'
    );

    return new WP_Query($args);
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
 * Check if we are in history mode
 * @return bool True if in history mode
 */

function okisam_is_history_mode() {
    $panel_mode = okisam_get_panel_mode();

    if ($panel_mode === 'history') {
        return true;
    }

    if ($panel_mode === 'yearly') {
        $current_month = date('n');
        if ($current_month == 12) {
            return true;
        }
    }

    return false;
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

    $current_time = current_time('Y-m-d H:i:s');
    $timestamp = strtotime($date_string);
    if ($timestamp === false) {
        return false;
    }

    $unlock_time = date('Y-m-d H:i:s', $timestamp);
    // print_r($current_time);
    return $current_time >= $unlock_time;
}

/**
 * Check if a panel should be active based on dates
 * @param int $panel_id The panel ID to check
 * @return bool True if the panel should be active
 */
function okisam_should_panel_be_active($panel_id) {
    return okisam_should_q1_be_unlocked($panel_id);
}

/**
 * Get the full unlock date string for a given Q
 * @param int $panel_id The panel ID
 * @param string $q_field The ACF field name for the unlock day
 * @return string|null The full unlock date string (Y-m-d H:i:s) or null
 */
function okisam_get_q_unlock_date($panel_id, $q_field) {
    $unlock_day = get_field($q_field, $panel_id);
    $panel_date = get_field('panel_date', $panel_id);

    if (!$unlock_day || !$panel_date) {
        return null;
    }

    $q_time_field = str_replace('_day', '_time', $q_field);
    $unlock_time = get_field($q_time_field, $panel_id) ?: '00:00:00';

    $panel_year = date('Y', strtotime($panel_date));
    $panel_month = date('m', strtotime($panel_date));
    
    return sprintf('%s-%s-%02d %s', $panel_year, $panel_month, intval($unlock_day), $unlock_time);
}

/**
 * Check if a given Q unlock should be unlocked for a panel
 * @param int $panel_id The panel ID to check
 * @param string $q_field The ACF field name for the unlock day (e.g., 'panel_q1_unlock_day')
 * @return bool True if the Q should be unlocked
 */
function okisam_should_q_be_unlocked($panel_id, $q_field) {
    $unlock_datetime = okisam_get_q_unlock_date($panel_id, $q_field);

    if (!$unlock_datetime) {
        return false;
    }
    
    return okisam_check_unlock_date($unlock_datetime);
}


/**
 * Check if Q1 should be unlocked for a panel
 * @param int $panel_id The panel ID to check
 * @return bool True if Q1 should be unlocked
 */
function okisam_should_q1_be_unlocked($panel_id) {
    return okisam_should_q_be_unlocked($panel_id, 'panel_q1_unlock_day');
}

/**
 * Check if Q2 should be unlocked for a panel
 * @param int $panel_id The panel ID to check
 * @return bool True if Q2 should be unlocked
 */
function okisam_should_q2_be_unlocked($panel_id) {
    return okisam_should_q_be_unlocked($panel_id, 'panel_q2_unlock_day');
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
    
    $current_year = date('Y');
    $unlock_year = date('Y', $unlock_timestamp);
    
    $format = 'j \d\e F';
    if ($unlock_year !== $current_year) {
        $format .= ', Y';
    }

    // Add time if it's not midnight
    if (date('H:i:s', $unlock_timestamp) !== '00:00:00') {
        $format .= ' \a \l\a\s H:i';
    }
    
    return date_i18n($format, $unlock_timestamp);
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

/**
 * REST API endpoint to read/update panel mode.
 */
function okisam_register_panel_mode_rest_routes() {
    register_rest_route('okisam/v1', '/panel-mode', [
        [
            'methods'             => WP_REST_Server::READABLE,
            'permission_callback' => '__return_true',
            'callback'            => function () {
                return [
                    'panel_mode' => okisam_get_panel_mode(),
                ];
            },
        ],
        [
            'methods'             => WP_REST_Server::EDITABLE,
            'permission_callback' => function () {
                return current_user_can('manage_options');
            },
            'args'                => [
                'panel_mode' => [
                    'required' => true,
                    'type'     => 'string',
                    'enum'     => ['history', 'yearly'],
                ],
            ],
            'callback'            => function (WP_REST_Request $request) {
                $mode = $request->get_param('panel_mode');
                okisam_set_panel_mode($mode);

                return [
                    'panel_mode' => okisam_get_panel_mode(),
                ];
            },
        ],
    ]);

    register_rest_route('okisam/v1', '/history-panels', [
        [
            'methods'             => WP_REST_Server::READABLE,
            'permission_callback' => '__return_true',
            'args'                => [
                'page' => [
                    'default'           => 1,
                    'sanitize_callback' => 'absint',
                ],
            ],
            'callback'            => function (WP_REST_Request $request) {
                $page = $request->get_param('page');
                $query = okisam_get_panels_batch($page);
                
                if (!$query->have_posts()) {
                    return new WP_REST_Response([
                        'html'     => '',
                        'has_more' => false,
                    ], 200);
                }

                ob_start();
                while ($query->have_posts()) {
                    $query->the_post();
                    global $panel_id;
                    $panel_id = get_the_ID();
                    
                    get_template_part('templates/parts/header-panel');
                    get_template_part('templates/parts/q1');
                    get_template_part('templates/parts/q2');
                }
                wp_reset_postdata();
                $html = ob_get_clean();

                return new WP_REST_Response([
                    'html'     => $html,
                    'has_more' => $page < $query->max_num_pages,
                    'max_pages' => $query->max_num_pages,
                ], 200);
            },
        ],
    ]);
}
add_action('rest_api_init', 'okisam_register_panel_mode_rest_routes');
