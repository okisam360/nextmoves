<?php
// Personalizar login
add_filter( 'sanitize_user', function( $sanitized_user, $raw_user, $strict ) {
    if ( $raw_user != '' ) {
        return $sanitized_user;
    }
    if ( ! empty ( $_REQUEST['action'] ) && $_REQUEST['action'] === 'register' && is_email( $_POST['user_email'] ) ) {
        return $_POST['user_email'];
    }
    return $sanitized_user;
}, 10, 3 );
add_filter( 'validate_username', function( $valid, $username ) {
    if ( $valid ) {
        return $valid;
    }
    if ( ! empty ( $_REQUEST['action'] ) && $_REQUEST['action'] === 'register' && is_email( $_POST['user_email'] ) ) {
        return true;
    }
    return is_email( $username );
}, 10, 2 );

// Personalizar login
function my_custom_login_page_css() {
  echo "<style>#login h1 {
      background-repeat: no-repeat;
      background-position: 10%;
      background-size: 200px;
      height: 70px;
      margin-top: 90px;
    }</style>";
  echo '
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
      $(function(){
        $("#user_login").prop("type", "email");
        $("#user_login").prop("required", true);
        $("#user_login").prop("placeholder", "Email");
        $("#user_pass").prop("placeholder", "Password");
        $("#user_pass").prop("required", true);

        $("#user_login").change(function() {
            $("#user_email").val($(this).val());
        });
      });
    </script>
      <style>
      body {
        background-color: #fff !important;
        font-family: Roboto, sans-serif;
        font-size: 14px;
        color: #555555;
      }
      .aviso {
        border: 1px solid #999;
        font-size: 12px;
        width: 450px;
        max-width: 80%;
        margin-top: 30px;
        margin-left: auto;
        margin-right: auto;
        padding: 10px 20px;
        color: #777;
        word-wrap: break-word;
      }
      p {
          margin-bottom: 30px;
          word-wrap: break-word;
      }
      p#nav {
        display: none;
      }
      #login h1 a {
      text-transform: uppercase;
      color: #555;
      text-decoration: none;
      letter-spacing: 2px;
      font-weight: 300;
      margin-bottom: 50px;
      width: 126px;
      background-image: none !important;
      height: auto;
      text-indent: unset;
      width: max-content;
      pointer-events: none;
      }
      input[type=text], input[type=search], input[type=radio], input[type=tel], input[type=time], input[type=url], input[type=week], input[type=password], input[type=color], input[type=date], input[type=datetime], input[type=datetime-local], input[type=email], input[type=month], input[type=number], select, textarea {
          border-width: 0px 0px 1px 0px;
          box-shadow: none;
          border-color: #000;
          background: #fff !important;
          outline: none;
          width: 100%;
          font-size: 14px !important;
      }

      ::-webkit-input-placeholder { color: #999999; font-size: 15px; transition: all .3s ease;}
      :-moz-placeholder { color: #999999; opacity: 1; font-size: 15px; transition: all .3s ease;}
      ::-moz-placeholder { color: #999999; opacity: 1; font-size: 15px; transition: all .3s ease;}
      :-ms-input-placeholder { color: #999999; font-size: 15px; transition: all .3s ease;}
      ::-ms-input-placeholder { color: #999999; font-size: 15px; transition: all .3s ease;}

      input:focus::-webkit-input-placeholder { color: #bbbbbb; font-size: 14px}
      input:focus:-moz-placeholder { color: #bbbbbb; font-size: 14px}
      input:focus::-moz-placeholder { color: #bbbbbb; font-size: 14px}
      input:focus:-ms-input-placeholder { color: #bbbbbb; font-size: 14px}
      .wp-core-ui .button-primary {
        margin-top: 0px;
        font-size: 11px;
        letter-spacing: 1px;
        padding: 1px 32px !important;
          background: #fff;
          border: 1px solid #D82A34;
          color: #D82A34;
          box-shadow: none;
          text-decoration: none;
          text-shadow: none;
          border-radius: 1px;
          transition: all .7s ease;
          font-weight: 700;
          letter-spacing: 1px;
          font-size: 12px;
          text-transform: uppercase;
          line-height: 0px !important;
      }
      p.forgetmenot {
          margin-top: 11px;
      }
      .wp-core-ui .button-primary.active, .wp-core-ui .button-primary.active:focus, .wp-core-ui .button-primary.active:hover, .wp-core-ui .button-primary:active,
      .wp-core-ui .button-primary.focus, .wp-core-ui .button-primary.hover, .wp-core-ui .button-primary:focus, .wp-core-ui .button-primary:hover{
          background: #D82A34;
          cursor: pointer;
          border-color: #D82A34;
          box-shadow: none;
          color: #fff;
          text-decoration: none;
          text-shadow: none;
          outline: none;
      }
      input[type=text], input[type=search], input[type=email], input[type=radio], input[type=tel], input[type=time], input[type=url], input[type=week], input[type=password], input[type=color], input[type=date], input[type=datetime], input[type=datetime-local], input[type=email], input[type=month], input[type=number], select, textarea {
          transition: all .4s ease;
          outline: none !important;
      }
      input[type=text]:focus, input[type=search]:focus, input[type=radio]:focus, input[type=tel]:focus, input[type=time]:focus, input[type=url]:focus, input[type=week]:focus, input[type=password]:focus, input[type=color]:focus, input[type=date]:focus, input[type=datetime]:focus, input[type=datetime-local]:focus, input[type=email]:focus, input[type=month]:focus, input[type=number]:focus, select:focus, textarea:focus {
          box-shadow: none;
          border-color: #999999;
      }
      input[type=checkbox] {
        outline: none !important;
        box-shadow: none !important;
      }
      .login form {
        box-shadow: none !important;
        background: #fff !important;
        border: 0px solid transparent;
        margin-top: 50px;
      }
      input[type=text]:focus,
      input[type=password]:focus {
          outline: none !important;
          box-shadow: none !important;
          border-width: 0px 0px 1px 0px;
          border-color: #999999;
      }
      #backtoblog {
          display: none;
      }
      .login #backtoblog a:hover, .login #nav a:hover, .login h1 a:hover {
          color: #D82A34;
      }
      .login #login_error {
          border-left-color: transparent !important;
      }
      .login #login_error, .login .message {
          border-left: 0px solid transparent !important;
          border-left-color: transparent !important;
          padding: 0px;
          margin-left: 0;
          margin-bottom: 0px;
          background-color: transparent !important;
          -webkit-box-shadow: 0 !important;
          box-shadow: 0 !important;
      }
      #login {
        width: 400px;
        max-width: 100%;
        margin-left: auto;
        margin-right: auto;
      }
      input#user_login, input#user_pass {
          height: 30px;
          position: relative;
          margin-top: -25px;
          display: block;
          margin-bottom: 50px;
          position: relative;
          border: none;
          border-radius: 0;
          padding-left: 0;
          border-bottom: 1px solid #999;
      }
      label[for=user_login], label[for=user_pass] {
        color: transparent;
        width: 100%
      }
      .wp-core-ui .button-secondary {
          color: #D82A34 !important;
          outline: none !important;
          box-shadow: none !important;
          border: none !important;
      }
      input[type=checkbox] {
          appearance:none;
          -moz-appearance:none;
          -webkit-appearance:none;
          border: 1px solid #b3b3b3;
          width: 17px;
          height: 17px;
          border-radius: 1px;
          outline: none !important;
          box-shadow: none !important;
          padding: 1px 1px !important;
          margin: 0 5px !important;
          vertical-align: -4px;
          background: #fff !important;
      }
      input[type=checkbox]:focus {
        border-color: #b3b3b3 !important;
      }
      input[type=checkbox]:checked:before {
        background: #D82A34;
        content: "" !important;
        appearance: none;
        -moz-appearance: none;
        -webkit-appearance: none;
        border: 1px solid #D82A34;
        width: 7px;
        height: 7px;
        border-radius: 1px;
        outline: none !important;
        box-shadow: none;
        padding: 0 !important;
        margin: 2px !important;
      }
      p.submit {
          margin-left: 0px;
      }
      p.message {
        margin-top: 35px;
      }
      .privacy-policy-page-link, .language-switcher {
        display: none;
      }
      #registerform label[for="user_email"],
      input#user_email {
        display:none !important;
      }
      .message.register {
        text-align:center;
        box-shadow: unset;
      }
  </style>';
}
add_action('login_head', 'my_custom_login_page_css');
function my_custom_login_url() {
return get_site_url();
}
add_filter( 'login_headerurl', 'my_custom_login_url' );
function my_custom_login_url_title() {
return '<img style="display:block;" src="' .get_site_url() . '/app/images/logo-okisam-black.png">';
}
add_filter( 'login_headertext', 'my_custom_login_url_title' );
function custom_login_title( $login_title ) {
return str_replace(array( ' &lsaquo;', ' &#8212; WordPress'), array( ' ', ' '),$login_title );
}
add_filter( 'login_title', 'custom_login_title' );