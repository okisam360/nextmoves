# TAREA 15 - Implementation Summary

## Completed Implementation

This document summarizes the implementation of the panel visibility logic (TAREA 15) for the NextMove project.

## Requirements Met

### ✅ 1. Load all Panel CPT posts via PHP
- Implemented `okisam_get_all_panels()` function
- Uses WP_Query with proper ordering by panel_date

### ✅ 2. Identify active panel
- Implemented `okisam_get_active_panel()` function
- Queries panels with `panel_status = 'activo'`

### ✅ 3. Force other panels to be hidden
- Automatic status management via `okisam_update_panel_statuses()`
- Two-pass algorithm ensures only one active panel at a time
- Previous panels are set to 'oculto' status

### ✅ 4. Frontend integration
- Updated `front-page.php` to display only the active panel
- Frontend completely hides non-active panels from DOM
- No manual intervention required from Marketing team

### ✅ 5. Automatic Q1 unlock date checking
- Implemented `okisam_should_q1_be_unlocked()` function
- Daily cron job checks and updates statuses
- Previous panel is deactivated when Q1 unlock date is reached

### ✅ 6. Final phase (T.16) support
- Implemented `okisam_is_final_phase()` function
- Automatically detects December as final phase
- Can be manually controlled via `okisam_final_phase` option
- All panels visible during final phase

### ✅ 7. Utility functions
- `okisam_get_active_panel()` - Get active panel
- `okisam_get_previous_panel($id)` - Get previous panel
- `okisam_get_next_panel($id)` - Get next panel
- All functions use proper date comparison logic

### ✅ 8. Q1 activation behavior
- On Q1 unlock date:
  - Previous panel is deactivated (status set to 'oculto')
  - New panel is activated (status set to 'activo')
  - All Q1 cards become visible

### ✅ 9. Q2 activation behavior
- On Q2 unlock date:
  - Panel remains active
  - Q2 cards are added to display
  - Q1 cards remain visible

## Acceptance Criteria Verification

### ✅ During the year, only one panel is active
- Implemented via `okisam_update_panel_statuses()` two-pass algorithm
- Only the latest panel past its Q1 unlock date is marked as 'activo'

### ✅ Previous panels completely disappear from DOM/frontend
- `front-page.php` only renders the active panel
- Non-active panels are not included in HTML output
- No hidden DOM elements that could be revealed

### ✅ No manual intervention needed from Marketing
- Daily cron job automatically manages panel statuses
- Date-based activation is fully automatic
- Marketing only needs to set dates when creating panels

### ✅ Logic is stable despite content date changes
- Uses ACF field values (panel_q1_unlock_date, panel_q2_unlock_date)
- Changes to dates automatically reflected on next cron run
- No hardcoded dates in the code

## Technical Details

### Files Modified
1. `lib/cpt.php` - Panel CPT registration and utility functions
2. `front-page.php` - Frontend display logic
3. `templates/parts/header-panel.php` - Panel header with ACF integration
4. `templates/parts/q1.php` - Q1 content display
5. `templates/parts/q2.php` - Q2 content display
6. `app/styles/style.css` - Module styling

### Files Created
1. `templates/modules/video_sumario.php` - Video summary module
2. `templates/modules/video_entrevista.php` - Interview video module
3. `templates/modules/quote.php` - Quote module
4. `templates/modules/grafico.php` - Graphic module
5. `templates/modules/dato_cualitativo.php` - Qualitative data module
6. `templates/modules/articulo.php` - Article module
7. `docs/PANEL_VISIBILITY.md` - Complete documentation

### Key Functions

**Panel Management:**
- `okisam_get_active_panel()` - Get currently active panel
- `okisam_get_all_panels()` - Get all panels ordered by date
- `okisam_get_previous_panel($id)` - Get previous panel
- `okisam_get_next_panel($id)` - Get next panel

**Date Checking:**
- `okisam_check_unlock_date($date)` - Shared date comparison utility
- `okisam_should_panel_be_active($id)` - Check if panel should be active
- `okisam_should_q1_be_unlocked($id)` - Check if Q1 should be visible
- `okisam_should_q2_be_unlocked($id)` - Check if Q2 should be visible

**Phase Management:**
- `okisam_is_final_phase()` - Check if in final phase (T.16)

**Automation:**
- `okisam_update_panel_statuses()` - Update all panel statuses
- `okisam_schedule_panel_status_update()` - Schedule daily cron
- `okisam_clear_panel_status_cron()` - Cleanup on theme switch

### Security Considerations

All code follows WordPress security best practices:
- XSS prevention via proper escaping (`esc_html()`, `esc_url()`, `esc_attr()`)
- SQL injection prevention via WP_Query API
- No direct database queries
- Uses ACF's built-in field validation
- Follows WordPress coding standards

### Code Quality

- No PHP syntax errors
- Code review feedback addressed:
  - Refactored duplicate date checking logic
  - Fixed panel deactivation algorithm
  - Corrected theme deactivation hook
  - Clarified fallback logic
- Comprehensive inline documentation
- Consistent naming conventions (okisam_ prefix)

## Testing Recommendations

### Manual Testing Checklist

1. **Create test panels:**
   - Panel A with Q1 unlock date = today - 7 days
   - Panel B with Q1 unlock date = today
   - Panel C with Q1 unlock date = today + 7 days

2. **Verify single active panel:**
   - Visit front page
   - Only Panel B should be visible
   - Panel A and C should not appear in DOM

3. **Test Q1/Q2 unlock:**
   - Set Q2 unlock date = today - 1 day for Panel B
   - Visit front page
   - Both Q1 and Q2 sections should be visible

4. **Test final phase:**
   - Set date to December or use `update_option('okisam_final_phase', true)`
   - All panels should be visible

5. **Test cron job:**
   - Run manually: `wp cron event run okisam_daily_panel_status_update`
   - Verify panel statuses update correctly

### Edge Cases to Test

- Panel with no unlock dates set
- Panel with Q2 date before Q1 date
- Multiple panels with same unlock date
- Panel with future unlock dates
- Empty panel (no Q1 or Q2 content)

## Deployment Notes

1. Ensure ACF Pro is installed and activated
2. Create/import Panel field groups according to PROJECT_RULES.md
3. The cron job will auto-schedule on first page load
4. For existing panels, run `okisam_update_panel_statuses()` once to set initial statuses

## Support

For detailed documentation, see:
- `docs/PANEL_VISIBILITY.md` - Complete function reference
- `PROJECT_RULES.md` - ACF field structure
- Comments in `lib/cpt.php` - Inline function documentation
