# Panel Visibility Logic - Documentation

## Overview

This implementation provides automatic panel visibility management for the NextMove project. Only the active panel is displayed on the front page, with automatic activation/deactivation based on configured unlock dates.

## Features

### 1. Automatic Panel Management
- **Single Active Panel**: Only one panel is visible at a time (except during final phase T.16)
- **Date-Based Activation**: Panels automatically activate when their Q1 unlock date is reached
- **Previous Panel Deactivation**: When a new panel activates, the previous one is automatically hidden
- **Daily Checks**: A cron job runs daily to update panel statuses

### 2. Quarter-Based Content Display (Q1/Q2)
- **Q1 Unlock**: When the Q1 unlock date is reached, Q1 content becomes visible
- **Q2 Unlock**: When the Q2 unlock date is reached, Q2 content is added (Q1 remains visible)
- **Progressive Disclosure**: Content is revealed progressively based on unlock dates

### 3. Final Phase Mode (T.16)
- **All Panels Visible**: During the final phase (typically December), all panels become visible
- **Historical View**: Users can see all panels from the entire year

## Functions

### Panel Utility Functions

#### `okisam_get_active_panel()`
Returns the currently active panel post object.

```php
$active_panel = okisam_get_active_panel();
if ($active_panel) {
    echo $active_panel->post_title;
}
```

#### `okisam_get_previous_panel($panel_id)`
Returns the panel that comes before the specified panel (by date).

```php
$previous = okisam_get_previous_panel($current_panel_id);
```

#### `okisam_get_next_panel($panel_id)`
Returns the panel that comes after the specified panel (by date).

```php
$next = okisam_get_next_panel($current_panel_id);
```

#### `okisam_get_all_panels()`
Returns all published panels ordered by date.

```php
$all_panels = okisam_get_all_panels();
```

### Date Check Functions

#### `okisam_should_panel_be_active($panel_id)`
Checks if a panel should be active based on its Q1 unlock date.

```php
if (okisam_should_panel_be_active($panel_id)) {
    // Panel should be active
}
```

#### `okisam_should_q1_be_unlocked($panel_id)`
Checks if Q1 content should be visible.

```php
if (okisam_should_q1_be_unlocked($panel_id)) {
    // Show Q1 content
}
```

#### `okisam_should_q2_be_unlocked($panel_id)`
Checks if Q2 content should be visible.

```php
if (okisam_should_q2_be_unlocked($panel_id)) {
    // Show Q2 content
}
```

#### `okisam_is_final_phase()`
Checks if we're in the final phase where all panels should be visible.

```php
if (okisam_is_final_phase()) {
    // Show all panels
}
```

### Administrative Functions

#### `okisam_update_panel_statuses()`
Manually trigger the panel status update process. This is normally run automatically via cron.

```php
okisam_update_panel_statuses();
```

## Panel Custom Post Type

The Panel CPT is registered with the following configuration:

- **Slug**: `panel`
- **Public**: Yes
- **Hierarchical**: No
- **Menu Icon**: dashicons-calendar-alt
- **REST API**: Enabled

### Required ACF Fields

Each panel should have the following ACF fields configured:

1. **panel_status** (Select): Status of the panel (activo/oculto)
2. **panel_date** (Date Picker): Date of the panel
3. **panel_title** (Text): Panel title
4. **panel_subtitle** (Text): Panel subtitle
5. **panel_intro** (Textarea): Introductory text
6. **panel_image** (Image): Header image
7. **panel_report_delivery** (Text): Report delivery information
8. **panel_video_title** (Text): Video section title
9. **panel_video_thumbnail** (Image): Video thumbnail
10. **panel_q1_unlock_date** (Date Picker): Q1 unlock date
11. **panel_q1** (Flexible Content): Q1 content modules
12. **panel_q2_unlock_date** (Date Picker): Q2 unlock date
13. **panel_q2** (Flexible Content): Q2 content modules

## Module Types

The following module types are supported in Q1 and Q2 flexible content fields:

1. **video_sumario**: Summary video module
2. **video_entrevista**: Interview video module
3. **quote**: Quote/citation module
4. **grafico**: Graphic/chart module
5. **dato_cualitativo**: Qualitative data module
6. **articulo**: Article module

Each module has its own template file in `templates/modules/`.

## Front Page Template

The front-page.php template handles the display logic:

1. Checks if we're in final phase
2. If yes: displays all panels
3. If no: displays only the active panel with appropriate Q1/Q2 sections

## Cron Job

A daily cron job (`okisam_daily_panel_status_update`) runs to:
- Check all panels for date-based activation
- Activate panels when their Q1 unlock date is reached
- Deactivate previous panels when a new one activates
- Skip updates during final phase

## Final Phase Configuration

The final phase can be configured in two ways:

1. **Option**: Set `okisam_final_phase` option to `true`
   ```php
   update_option('okisam_final_phase', true);
   ```

2. **Automatic**: The system automatically enters final phase in December

## Usage Example

### Creating a New Panel

1. Create a new Panel post in WordPress
2. Set the panel date
3. Configure Q1 unlock date (when panel should become active)
4. Configure Q2 unlock date (when second half should unlock)
5. Add content modules to Q1 and Q2 flexible content fields
6. Publish the panel

The panel will automatically activate on the configured Q1 unlock date.

### Manual Status Override

If you need to manually control panel visibility:

```php
// Activate a specific panel
update_field('panel_status', 'activo', $panel_id);

// Hide a panel
update_field('panel_status', 'oculto', $panel_id);
```

## Troubleshooting

### Panel Not Showing
- Check that the panel_q1_unlock_date is set and in the past
- Verify panel_status field is set to 'activo'
- Ensure the panel is published
- Check that we're not in final phase unintentionally

### Q1/Q2 Not Displaying
- Verify unlock dates are set correctly
- Check that flexible content fields have content
- Ensure module templates exist in templates/modules/

### Cron Not Running
- Check WordPress cron is functioning: `wp cron event list`
- Manually trigger: `wp cron event run okisam_daily_panel_status_update`
- Verify cron is scheduled: `wp_next_scheduled('okisam_daily_panel_status_update')`

## Development Notes

- All panel-related functions are prefixed with `okisam_` to avoid conflicts
- The system is designed to work without manual intervention from Marketing team
- Date comparisons use WordPress `current_time()` to respect timezone settings
- Module templates can be customized in `templates/modules/` directory
