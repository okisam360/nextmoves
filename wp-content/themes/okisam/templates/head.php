<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php
  // Preload hero image (LCP) for front page - CRITICAL: Must be FIRST after meta tags
  if (is_front_page() && function_exists('okisam_get_active_panel')) {
      $active_panel = okisam_get_active_panel();
      if ($active_panel) {
          $panel_image = get_field('panel_image', $active_panel->ID);
          $theme_uri = get_template_directory_uri();
          
          // Handle different ACF return formats: array, URL string, or ID
          if (is_array($panel_image) && isset($panel_image['url'])) {
              $header_image = $panel_image['url'];
          } elseif (is_string($panel_image) && !empty($panel_image)) {
              $header_image = $panel_image;
          } else {
              $header_image = $theme_uri . '/app/images/tmp/e11a6642c6aa3136891018c085b974f1db587f0a.jpg';
          }
          
          if ($header_image) {
              echo '<link rel="preload" as="image" href="' . esc_url($header_image) . '" fetchpriority="high">' . "\n";
          }
      }
  }
  ?>
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
  <!-- Google Tag Manager - Loaded asynchronously to avoid blocking render -->
  <script>
  (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-PRG62JTP');
  </script>
  <!-- End Google Tag Manager -->
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_site_url(); ?>/app/images/favicon-16x16.png">
  
  <?php
  // Generate meta description
  $meta_description = '';
  $site_tagline = get_bloginfo('description'); // Get WordPress site tagline
  
  if (is_front_page()) {
      // For front page, use active panel info
      if (function_exists('okisam_get_active_panel')) {
          $active_panel = okisam_get_active_panel();
          if ($active_panel) {
              $panel_title = get_field('panel_title', $active_panel->ID);
              $panel_subtitle = get_field('panel_subtitle', $active_panel->ID);
              $panel_intro = get_field('panel_intro', $active_panel->ID);
              
              // Build description from available fields
              if ($panel_intro) {
                  $meta_description = wp_trim_words($panel_intro, 25, '...');
              } elseif ($panel_subtitle) {
                  $meta_description = $panel_subtitle;
              } elseif ($panel_title) {
                  $meta_description = $panel_title . ($site_tagline ? ' - ' . $site_tagline : '');
              }
          }
      }
      
      // Fallback if no panel
      if (empty($meta_description)) {
          $meta_description = $site_tagline ?: '';
      }
  } elseif (is_singular('panel')) {
      // For single panel pages
      $panel_title = get_field('panel_title');
      $panel_intro = get_field('panel_intro');
      
      if ($panel_intro) {
          $meta_description = wp_trim_words($panel_intro, 25, '...');
      } elseif ($panel_title) {
          $meta_description = $panel_title . ($site_tagline ? ' - ' . $site_tagline : '');
      } else {
          $meta_description = get_the_title() . ($site_tagline ? ' - ' . $site_tagline : '');
      }
  } else {
      // For other pages, use excerpt or default
      if (has_excerpt()) {
          $meta_description = wp_trim_words(get_the_excerpt(), 25, '...');
      } else {
          $meta_description = $site_tagline ?: '';
      }
  }
  
  // Output meta description
  if (!empty($meta_description)) {
      echo '<meta name="description" content="' . esc_attr($meta_description) . '">' . "\n";
  }
  
  // Ensure robots meta allows indexing (unless WordPress settings say otherwise)
  // WordPress will add noindex if "Discourage search engines" is checked in Settings > Reading
  // We just make sure we're not adding it ourselves
  ?>
  
  <?php wp_head(); ?>
  <!-- LoadCSS polyfill for async CSS loading -->
  <script>
  !function(e){"use strict";var t=function(t,n,o){var i,r=e.document,a=r.createElement("link");if(n)i=n;else{var l=(r.body||r.getElementsByTagName("head")[0]).childNodes;i=l[l.length-1]}var d=r.styleSheets;a.rel="stylesheet",a.href=t,a.media="only x",function e(t){if(r.body)return t();setTimeout(function(){e(t)})}(function(){i.parentNode.insertBefore(a,n?i:i.nextSibling)});var f=function(e){for(var t=a.href,n=d.length;n--;)if(d[n].href===t)return e();setTimeout(function(){f(e)})};return a.addEventListener&&a.addEventListener("load",function(){this.media=o||"all"}),a.onloadcssdefined=f,f(function(){a.media!==o&&(a.media=o||"all")}),a};"undefined"!=typeof exports?exports.loadCSS=t:e.loadCSS=t}("undefined"!=typeof global?global:this);
  </script>
</head>
