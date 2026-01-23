<head>
  <script>
    window.dataLayer = window.dataLayer || [];
    <?php
    $panel_name = '';
    $panel_mode = (function_exists('okisam_get_panel_mode')) ? okisam_get_panel_mode() : '';

    if (is_front_page()) {
        if (function_exists('okisam_is_history_mode') && okisam_is_history_mode()) {
            $panel_name = 'ALL';
        } elseif (function_exists('okisam_get_active_panel')) {
            $active_panel = okisam_get_active_panel();
            $panel_name = ($active_panel) ? get_the_title($active_panel->ID) : '';
        }
    } elseif (is_singular('panel')) {
        $panel_name = get_the_title();
    }

    if ($panel_name) :
    ?>
    window.dataLayer.push({
      'event': 'panel_view',
      'panel_name': '<?php echo esc_js($panel_name); ?>',
      'panel_mode': '<?php echo esc_js($panel_mode); ?>'
    });
    <?php endif; ?>
  </script>
  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-PRG62JTP');</script>
  <!-- End Google Tag Manager -->
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_site_url(); ?>/app/images/favicon-16x16.png">
  <?php wp_head(); ?>
</head>
