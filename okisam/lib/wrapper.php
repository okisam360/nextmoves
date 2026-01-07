<?php
namespace Roots\Sage\Wrapper;
function template_path() { return SageWrapping::$main_template; }
function sidebar_path() { return new SageWrapping('templates/sidebar.php'); }
class SageWrapping {
  public static $main_template;
  public $slug;
  public $templates;
  public static $base;
  public function __construct($template = 'base.php') {
    $this->slug = basename($template, '.php');
    $this->templates = [$template];
    if (self::$base) {
      $str = substr($template, 0, -4);
      array_unshift($this->templates, sprintf($str . '-%s.php', self::$base));
    }
  }
  public function __toString() {
    $this->templates = apply_filters('sage/wrap_' . $this->slug, $this->templates);
    return locate_template($this->templates);
  }
  public static function wrap($main) {
    if (!is_string($main)) { return $main; }
    self::$main_template = $main;
    self::$base = basename(self::$main_template, '.php');
    if (self::$base === 'index') { self::$base = false; }
    return new SageWrapping();
  }
}
add_filter('template_include', [__NAMESPACE__ . '\\SageWrapping', 'wrap'], 109);