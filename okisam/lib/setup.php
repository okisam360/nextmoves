<?php

namespace Roots\Sage\Setup;
use Roots\Sage\Assets;

// Theme setup
function setup() {
  add_theme_support('title-tag');
  add_theme_support('custom-fields');
  add_theme_support('post-thumbnails'); 
  add_theme_support('comments'); 
  add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);
  add_theme_support('html5', ['caption', 'search-form' /*, 'comment-form', 'comment-list'*/]);
  register_nav_menus( [ 'navbar' => 'Navbar',  'footer' => 'Footer' ] ); 
}
add_action('after_setup_theme', __NAMESPACE__ . '\\setup');

// Theme assets

function assets() {


  wp_enqueue_style(  'me',       get_template_directory_uri() . '/app/styles/me.css',   array(), null, false);
  wp_enqueue_style(  'font-sizes',       get_template_directory_uri() . '/app/styles/font-sizes.css',   array(), null, false);
  wp_enqueue_style(  'style',       get_template_directory_uri() . '/app/styles/style.css',   array(), null, false);
  wp_enqueue_script( 'jquery',      get_template_directory_uri() . '/app/scripts/jquery.js', array(), null, false );
  wp_enqueue_script( 'main',        get_template_directory_uri() . '/app/scripts/main.js',   array(), null, false );

}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100); 

