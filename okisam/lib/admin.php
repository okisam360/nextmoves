<?php

function admin_style() {
  wp_enqueue_style('admin-styles', get_stylesheet_directory_uri().'/app/styles/admin.css');
}
add_action('admin_enqueue_scripts', 'admin_style');

function didesweb_change_footer_admin () {echo 'Okisam theme &copy; 2022';}
add_filter('admin_footer_text', 'didesweb_change_footer_admin', 9999);

function didesweb_change_footer_version() {echo 'Okisam &reg;';}
add_filter( 'update_footer', 'didesweb_change_footer_version', 9999);

// Forzamos el escritorio a una sola columna
function so_screen_layout_columns( $columns ) {
    $columns['dashboard'] = 1;
    return $columns;
}
add_filter( 'screen_layout_columns', 'so_screen_layout_columns' );
function so_screen_layout_dashboard() {
    return 1;
}
add_filter( 'get_user_option_screen_layout_dashboard', 'so_screen_layout_dashboard' );

// Admin title tab
add_filter('admin_title', 'ddw_custom_admin_title', 10, 2);
function ddw_custom_admin_title($admin_title, $title) {
  return $title;
}

// Change names menu
add_action( 'admin_menu', 'ayudawp_renombra_menu_woo', 999 );
function ayudawp_renombra_menu_woo() {
    global $menu;

    // $wocommerce = the_array_search( 'Productos', $menu );
    // if( !$wocommerce ) return;
    // $menu[$wocommerce][0] = 'Cursos';

    // $contact = the_array_search( 'Contact', $menu );
    // if( !$contact ) return;
    // $menu[$contact][0] = 'Formularios';

    $blog = the_array_search( 'Entradas', $menu );
    if( !$blog ) return;
    $menu[$blog][0] = 'Blog';



}
function the_array_search( $find, $items ) {
  foreach( $items as $key => $value ) {
    $current_key = $key;
    if( $find === $value OR ( is_array( $value ) && the_array_search( $find, $value ) !== false ) ) {
        return $current_key;
      }
    }
    return false;
}

// Custom dashboard widget
function custom_dashboard_widget() { ?>
  <div style="padding-left: 25px; padding-right: 25px; padding-top: 15px; max-width: 1350px;"> 
    <h1>¡Bienvenido/a!</h1>
    <br>
    <p style="margin-top: 0 !important;">
      ¡Bienvenido/a a tu escritorio! Esta es la pantalla que verás cuando accedas a tu sitio, que te da acceso a todas las funciones de gestión del sitio.
    </p>
    <p style="margin-top: 0 !important;">
      El menú de navegación de la izquierda proporciona enlaces a todas las pantallas de administración, con elementos de submenú que aparecen al pasar el cursor sobre ellos. Puedes minimizar este menú para que sea una barra estrecha de iconos haciendo clic en la flecha del menú Cerrar en la parte inferior.
    </p>
    <p style="margin-top: 0 !important;">
      Los enlaces de la barra de herramientas de la parte superior de la pantalla conectan tu escritorio y tu sitio y proporcionan acceso a tu perfil e información importante.
    </p>
    <p style="margin-top: 0 !important;">
      Puedes usar los controles siguientes para organizar tu escritorio, de modo que se adapte a tu rutina de trabajo. Puedes hacer lo mismo en la mayoría de las secciones de administración.
      </p>
      <p style="margin-bottom: 0 !important;font-size: 18px;">Opciones de pantalla</p>
      <p style="margin-top: 0 !important;">
        Usa la pestaña de Opciones de pantalla para elegir qué cajas mostrar en cada sección.
      </p>
      <p style="margin-bottom: 0 !important;font-size: 18px;">Controles de caja</p>
      <p style="margin-top: 0 !important;">
      Haz clic en la barra de título de la caja para expandirla o contraerla. Algunas cajas añadidas por plugins puede que tengan contenido que configurar y mostrarán un enlace de «Configurar» en la barra de título si pasas el cursor sobre ella.
    </p>
    <p style="margin-bottom: 0 !important;font-size: 18px;">Condiciones de uso</p>
    <p style="margin-top: 0 !important;">
      Tu cuenta de usuario/a es personal e intransferible, por lo que el uso de la misma se encuentra bajo tu responsabilidad, tendrás que impedir el acceso de usuarios no autorizados, te recomendamos poner especial atención en el uso de contraseñas y seguridad en los equipos a tu disposición, así como implantar una política para mantener mesas de escritorio y monitores libres de cualquier información. De este modo, el riesgo de accesos no autorizados o deterioro de documentos, medios y recursos para el tratamiento de información quedará minimizado.. Recomendamos no compartirla con otras personas. No obstante, en caso de que lo necesites deberás solicitarlo por escrito de forma explícita al administrador del sistema. 
      Debes saber que si se detecta o sospecha que las actividades llevadas a cabo por tu cuenta de usuario comprometen la integridad y la seguridad de la información, el acceso será suspendido de forma temporal.
      Para poder reactivarlo tendrás que llevar a cabo las medidas necesarias requeridas por el administrador del sistema.
    </p>

    <br>

    <p> Bienvenido/a de nuevo a tu web, esperamos que disfrutes trabajando en ella. </p>
    <p>
      <cite>El equipo de desarrollo de Okisam</cite>
    </p>

    <br>

    <a href="https://okisam.com"><img src="<?php echo get_site_url(); ?>/app/images/logo-okisam-black.png" alt="Okisam"></a>

    <br>
    <br>
    <br>

    <br>
  </div>   
<?php } 
function add_custom_dashboard_widget() {
  wp_add_dashboard_widget('custom_dashboard_widget', 'Panel de administración', 'custom_dashboard_widget');
}
add_action('wp_dashboard_setup', 'add_custom_dashboard_widget');

function favicon4admin() {
echo '<link rel="Shortcut Icon" type="image/x-icon" href="' . get_bloginfo('wpurl') . '/app/images/favicon-32x32.png" />';
}
add_action( 'admin_head', 'favicon4admin' );