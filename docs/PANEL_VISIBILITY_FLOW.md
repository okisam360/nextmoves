# Panel Visibility Logic - Visual Flow

## System Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                    WordPress Admin                           │
│  ┌──────────────────────────────────────────────────────┐  │
│  │  Marketing Team Creates Panel                        │  │
│  │  - Sets panel_date                                   │  │
│  │  - Sets panel_q1_unlock_date (activation date)       │  │
│  │  - Sets panel_q2_unlock_date                         │  │
│  │  - Adds Q1 content modules                           │  │
│  │  - Adds Q2 content modules                           │  │
│  │  - Publishes                                         │  │
│  └──────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│              Daily Cron Job (Automatic)                      │
│  ┌──────────────────────────────────────────────────────┐  │
│  │  okisam_update_panel_statuses()                      │  │
│  │                                                       │  │
│  │  1. Check if final phase → Skip if yes              │  │
│  │  2. Get all panels ordered by date                   │  │
│  │  3. Find latest panel with Q1 date ≤ today          │  │
│  │  4. Set that panel to 'activo'                       │  │
│  │  5. Set all other panels to 'oculto'                │  │
│  └──────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│                 Frontend (front-page.php)                    │
│  ┌──────────────────────────────────────────────────────┐  │
│  │  Is Final Phase?                                     │  │
│  │    YES → Show all panels                             │  │
│  │    NO  → Show only active panel                      │  │
│  │                                                       │  │
│  │  For active panel:                                   │  │
│  │    - Show header                                     │  │
│  │    - Show Q1 if unlocked (date ≤ today)             │  │
│  │    - Show Q2 if unlocked (date ≤ today)             │  │
│  └──────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
```

## Timeline Example

### Scenario: Three Panels Throughout the Year

```
January          February         March            December (Final Phase)
│                │                │                │
│  Panel A       │  Panel B       │  Panel C       │  All Panels
│  Q1: Jan 15    │  Q1: Feb 15    │  Q1: Mar 15    │  Visible
│  Q2: Jan 25    │  Q2: Feb 25    │  Q2: Mar 25    │
│                │                │                │
▼                ▼                ▼                ▼

┌─────────────────────────────────────────────────────────────────┐
│ Jan 1-14: No active panel                                        │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│ Jan 15-24: Panel A active, only Q1 visible                      │
│            Previous: none                                        │
│            Panel B & C hidden                                    │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│ Jan 25-Feb 14: Panel A active, Q1 + Q2 visible                  │
│                Panel B & C hidden                                │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│ Feb 15-24: Panel B active, only Q1 visible                      │
│            Panel A deactivated (hidden from DOM)                 │
│            Panel C hidden                                        │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│ Feb 25-Mar 14: Panel B active, Q1 + Q2 visible                  │
│                Panel A & C hidden                                │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│ Mar 15-24: Panel C active, only Q1 visible                      │
│            Panel A & B deactivated (hidden from DOM)             │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│ Mar 25-Nov 30: Panel C active, Q1 + Q2 visible                  │
│                Panel A & B hidden                                │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│ Dec 1-31: FINAL PHASE                                            │
│           All panels visible (A, B, C)                           │
│           All Q1 & Q2 content visible                            │
│           Users can review entire year                           │
└─────────────────────────────────────────────────────────────────┘
```

## State Diagram

```
                    ┌──────────────┐
                    │  Panel       │
                    │  Created     │
                    └──────┬───────┘
                           │
                           │ Q1 unlock date not reached
                           ▼
                    ┌──────────────┐
                    │  Status:     │
             ┌──────│  'oculto'    │◄─────────┐
             │      │  (Hidden)    │          │
             │      └──────┬───────┘          │
             │             │                   │
             │             │ Q1 unlock date    │ Next panel
             │             │ reached           │ Q1 date reached
             │             ▼                   │
             │      ┌──────────────┐          │
             │      │  Status:     │          │
             │      │  'activo'    │──────────┘
             │      │  (Active)    │
             │      └──────┬───────┘
             │             │
             │             │ In Final Phase?
             │             │
             │      ┌──────┴───────┐
             │      │              │
             │   NO │              │ YES
             │      │              │
             │      ▼              ▼
             │  Stay Active    All Panels
             │                 Visible
             │
             └─────────────────────────────────┐
                                               │
                                               ▼
                                        Next panel
                                        activates
```

## Function Call Flow

### Front Page Load

```
front-page.php
│
├─► okisam_is_final_phase()
│   │
│   ├─► YES → okisam_get_all_panels()
│   │         └─► Display all panels
│   │
│   └─► NO → okisam_get_active_panel()
│            │
│            ├─► header-panel.php
│            │   └─► get_field('panel_*', $panel_id)
│            │
│            ├─► okisam_should_q1_be_unlocked($panel_id)
│            │   │
│            │   ├─► YES → q1.php
│            │   │         └─► get_field('panel_q1', $panel_id)
│            │   │             └─► templates/modules/*.php
│            │   │
│            │   └─► NO → (Q1 not shown)
│            │
│            └─► okisam_should_q2_be_unlocked($panel_id)
│                │
│                ├─► YES → q2.php
│                │         └─► get_field('panel_q2', $panel_id)
│                │             └─► templates/modules/*.php
│                │
│                └─► NO → (Q2 not shown)
```

### Daily Cron Job

```
WordPress Cron
│
└─► okisam_daily_panel_status_update
    │
    └─► okisam_update_panel_statuses()
        │
        ├─► okisam_is_final_phase()
        │   │
        │   ├─► YES → Exit (no changes)
        │   │
        │   └─► NO → Continue
        │
        ├─► okisam_get_all_panels()
        │
        ├─► First Pass: Find which panel should be active
        │   └─► Loop through panels
        │       └─► okisam_should_panel_be_active($id)
        │           └─► okisam_check_unlock_date($q1_date)
        │
        └─► Second Pass: Update all statuses
            └─► Loop through panels
                ├─► If should be active
                │   └─► update_field('panel_status', 'activo')
                │
                └─► If should be hidden
                    └─► update_field('panel_status', 'oculto')
```

## Module Rendering Flow

```
Q1/Q2 Template
│
├─► get_field('panel_q1' or 'panel_q2')
│   │
│   └─► Returns array of modules:
│       [
│         ['acf_fc_layout' => 'video_sumario', ...],
│         ['acf_fc_layout' => 'quote', ...],
│         ['acf_fc_layout' => 'articulo', ...]
│       ]
│
└─► foreach module
    │
    ├─► Determine layout type
    │
    └─► locate_template('templates/modules/{layout}.php')
        │
        ├─► video_sumario.php
        ├─► video_entrevista.php
        ├─► quote.php
        ├─► grafico.php
        ├─► dato_cualitativo.php
        └─► articulo.php
            │
            └─► Render module HTML
                └─► esc_html(), esc_url(), esc_attr()
```

## Decision Tree for Panel Visibility

```
                    START: User visits front page
                              │
                              ▼
                    ┌──────────────────┐
                    │ Is Final Phase?  │
                    │ (December or     │
                    │  manual flag)    │
                    └─────┬────────────┘
                          │
              ┌───────────┴───────────┐
              │                       │
            YES                      NO
              │                       │
              ▼                       ▼
    ┌─────────────────┐    ┌──────────────────┐
    │ Show ALL panels │    │ Get active panel │
    │ with all Q1/Q2  │    │ (status=activo)  │
    └─────────────────┘    └────────┬─────────┘
                                    │
                          ┌─────────┴─────────┐
                          │                   │
                    Panel Found         No Active Panel
                          │                   │
                          ▼                   ▼
                 ┌─────────────────┐   ┌──────────────┐
                 │ Show header     │   │ Show message │
                 └────────┬────────┘   │ "No panel    │
                          │            │  active"     │
                          ▼            └──────────────┘
                 ┌─────────────────┐
                 │ Q1 unlocked?    │
                 └────────┬────────┘
                          │
              ┌───────────┴───────────┐
              │                       │
            YES                      NO
              │                       │
              ▼                       │
    ┌─────────────────┐              │
    │ Show Q1 modules │              │
    └────────┬────────┘              │
             │                       │
             └───────────┬───────────┘
                         │
                         ▼
                 ┌─────────────────┐
                 │ Q2 unlocked?    │
                 └────────┬────────┘
                          │
              ┌───────────┴───────────┐
              │                       │
            YES                      NO
              │                       │
              ▼                       │
    ┌─────────────────┐              │
    │ Show Q2 modules │              │
    └─────────────────┘              │
                                     │
                         ┌───────────┘
                         │
                         ▼
                       END
```
