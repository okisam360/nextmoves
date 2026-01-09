<?php
$sage_includes = [
  'lib/assets.php',
  'lib/setup.php',
  'lib/wrapper.php',
  'lib/admin.php',
  'lib/login.php',
  'lib/images.php',   
  'lib/globals.php', 
  'lib/cpt.php', 
  'lib/security.php',
  'lib/optimize.php'
];
foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf( 'Error locating %s for inclusion' , $file), E_USER_ERROR);
  }
  require_once $filepath;
}
unset($file, $filepath);

