<?php
// Remove WP Version
add_filter('the_generator', '__return_false');

// Remove Admin bar
show_admin_bar(false);

// Remove head tags
function guv_head_clean() {
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wp_generator');
  remove_action('wp_head', 'feed_links', 2);
  remove_action('wp_head', 'index_rel_link');
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'feed_links_extra', 3);
  remove_action('wp_head', 'start_post_rel_link', 10, 0);
  remove_action('wp_head', 'parent_post_rel_link', 10, 0);
  remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
  remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
  remove_action('wp_head', 'feed_links', 2);
  remove_action('wp_head', 'feed_links_extra', 3);
  remove_action('wp_head', 'print_emoji_detection_script', 7 );
  remove_action('wp_head', 'wp_oembed_add_discovery_links');
  remove_action('wp_head', 'wp_oembed_add_host_js');
  remove_action('wp_head', 'rest_output_link_wp_head', 10);
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_action('admin_print_styles', 'print_emoji_styles');
  remove_filter('the_content_feed', 'wp_staticize_emoji');
  remove_filter('comment_text_rss', 'wp_staticize_emoji');
  remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
  add_filter('use_default_gallery_style', '__return_false');
  add_filter('emoji_svg_url', '__return_false');
  add_action('wp_head', 'ob_start', 1, 0);
  add_action('wp_head', function () {
    $pattern = '/.*' . preg_quote(esc_url(get_feed_link('comments_' . get_default_feed())), '/') . '.*[\r\n]+/';
    echo preg_replace($pattern, '', ob_get_clean());
  }, 3, 0);
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action('wp_head', [$wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style']);
  }
}
add_action('init', 'guv_head_clean');
// Change tag style
function guv_tag_style($input) {
  preg_match_all("!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches);
  if (empty($matches[2])) {
    return $input;
  }
  $media = $matches[3][0] !== '' && $matches[3][0] !== 'all' ? ' media="' . $matches[3][0] . '"' : '';
  return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";
}
add_filter('style_loader_tag', 'guv_tag_style');
// Remove closing tags
function guv_remove_closing_tags($input) {
  return str_replace(' />', '>', $input);
}
add_filter('get_avatar', 'guv_remove_closing_tags');
add_filter('comment_id_fields', 'guv_remove_closing_tags');
add_filter('post_thumbnail_html', 'guv_remove_closing_tags');

// Change jquery callback

function change_jquery_cdn() { 
  $jquery_version = wp_scripts()->registered['jquery']->ver;
  wp_deregister_script('jquery');
  wp_register_script( 'jquery', get_template_directory_uri() .'/app/scripts/jquery.js', [], null, true );
  add_filter('script_loader_src', 'local_jquery_help', 10, 2);
}
add_action('wp_enqueue_scripts', 'change_jquery_cdn', 100);

// Local jquery callback
function local_jquery_help($path, $jquery_callback = null) {
  static $hel_jquery = false;
  if ($jquery_callback === 'jquery') {
    $hel_jquery = get_template_directory_uri() .'/app/scripts/jquery.js'; 
  }
  return $path;
}
add_action('wp_head','local_jquery_help');

// Move JS to footer
function enqueue_footer_js() {
  
  remove_action('wp_head', 'wp_print_scripts');
  remove_action('wp_head', 'wp_print_head_scripts', 9);
  remove_action('wp_head', 'wp_enqueue_scripts', 1);
}
add_action('wp_enqueue_scripts', 'enqueue_footer_js');

// Change tag script
function guv_tag_script($tag) {
  return preg_replace( "/ type=['\"]text\/(javascript)['\"]/", '', $tag );
}
add_filter('script_loader_tag', 'guv_tag_script');

// Remove updates
add_action('after_setup_theme','remove_core_updates');
function remove_core_updates() {
if(! current_user_can('update_core')){return;}
add_action('init', function($a){
  remove_action( 'init', 'wp_version_check' );
},2);
add_filter('pre_option_update_core','__return_null');
add_filter('pre_site_transient_update_core','__return_null');
}
remove_action('load-update-core.php','wp_update_plugins');
add_filter('pre_site_transient_update_plugins','__return_null');

//Remove Gutenberg Block Library CSS from loading on the frontend
function smartwp_remove_wp_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-block-style' ); // Remove WooCommerce block CSS
} 
add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100 );

function didesweb_optimize_output($output) {
  if ( substr( ltrim( $output ), 0, 5) == '<?xml' ) { return ( $output ); }
  //if ( mb_detect_encoding($output, 'UTF-8', true) ) { $mod = '/u'; } else{ $mod = '/s'; }
  $mod = '/s';
  $output = str_replace(array (chr(13) . chr(10), chr(9)), array (chr(10), ''), $output);
  $output = str_replace(array ('<script', '/script>', '<pre', '/pre>', '<textarea', '/textarea>', '<style', '/style>'), array ('<script', '/script>', '<pre', '/pre>', '<textarea', '/textarea>', '<style', '/style>'), $output);
  $output = preg_replace(array ('/\>[^\S ]+' . $mod, '/[^\S ]+\<' . $mod, '/(\s)+' . $mod), array('>', '<', '\\1'), $output);
  $output = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->' . $mod, '', $output);
  if (strtolower( substr( ltrim( $output ), 0, 15 ) ) == '<!doctype html>' ) {
    $output = str_replace( ' />', '>', $output );
    $output = str_replace('> <' , '><', $output );
    //$output = str_replace( array( 'http://', 'https://' ), '//', $output );
  }
  return ($output);
}

function ddw_filter_path($content) {
    $name = explode('/themes/', $content);
    $theme_name = next($name);
    $current_path = '/wp-content/themes/' . $theme_name;
    $new_path = '';
    $content = str_replace($current_path, $new_path, $content);
    return $content;
}
if (!is_admin()) { 
  add_filter('bloginfo', 'ddw_filter_path');
}
function ddw_filter_autoptimize_path($content) {  
  $current_path = '/wp-content/cache/';
  $new_path = '/app/cache/';
  $content = str_replace($current_path, $new_path, $content);
  $current_path = '/wp-content/plugins/';
  $new_path = '/app/components/';
  $content = str_replace($current_path, $new_path, $content);
  if('on' !== get_option( 'autoptimize_css')){
    $name = explode('/themes/', get_template_directory());
    $theme_name = next($name);
    $current_path = '/wp-content/themes/' . $theme_name . '/app/styles';
    $new_path = '/app/styles';
    $content = str_replace($current_path, $new_path, $content);
  }
  if('on' !== get_option( 'autoptimize_js')){
    $name = explode('/themes/', get_template_directory());
    $theme_name = next($name);
    $current_path = '/wp-content/themes/' . $theme_name . '/app/scripts';
    $new_path = '/app/scripts';
    $content = str_replace($current_path, $new_path, $content);
  }
  return $content;
}
function ddw_filter_autoptimize_path_call($content){
  ob_start('ddw_filter_autoptimize_path');
}
if ( !is_admin() ) {
  //  if ( !( defined( 'WP_CLI' ) ) ) { add_action( 'init', 'ddw_filter_autoptimize_path_call', 1 ); }
}
add_filter( 'wp_get_attachment_image_src', 'filter_wp_get_attachment_image_src', 10, 4 ); 
function filter_wp_get_attachment_image_src( $image, $attachment_id, $size, $icon ) { 
    $image[0] = str_replace('wp-content/uploads/', 'app/uploads/', $image[0]);
    return $image; 
}; 
add_filter('wp_get_attachment_url', 'filter_wp_get_attachment_url');
function filter_wp_get_attachment_url($url) {
    return str_replace('wp-content/uploads/', 'app/uploads/', $url);
}
add_filter('wp_calculate_image_srcset', 'filter_wp_calculate_image_srcset', 10, 5 );
function filter_wp_calculate_image_srcset($sources, $size_array, $image_src, $image_meta, $attachment_id) {
    foreach($sources as &$source){
        $source["url"] = str_replace('wp-content/uploads/', 'app/uploads/', $source["url"]);
    }
    return $sources;
}

// Rewrite urls
function ddw_flush_rewrites() {
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}
add_action('admin_init', 'ddw_flush_rewrites');
function ddw_change_path($content) {
  $name = explode('/themes/', get_stylesheet_directory());
  $theme_name = next($name);
  global $wp_rewrite;
  $guv_new_non_wp_rules = array(
    'app/styles/(.*)'      => 'wp-content/themes/'. $theme_name . '/app/styles/$1',
    'app/scripts/(.*)'     => 'wp-content/themes/'. $theme_name . '/app/scripts/$1', 
    'app/fonts/(.*)'       => 'wp-content/themes/'. $theme_name . '/app/fonts/$1',
    'app/images/(.*)'      => 'wp-content/themes/' . $theme_name . '/app/images/$1',
    'app/cache/(.*)'       => 'wp-content/cache/$1',
    'app/components/(.*)'  => 'wp-content/plugins/$1',
    'app/uploads/(.*)'     => 'wp-content/uploads/$1'
  );
  $wp_rewrite->non_wp_rules += $guv_new_non_wp_rules;
}
add_action('generate_rewrite_rules', 'ddw_change_path');