<?php

require_once dirname(__FILE__) . '/vendor/autoload.php';

use Jumbojett\OpenIDConnectClient;

/** 
 * Plugin declaration
 * extends MantisPlugin
 * Plugin that implements login with OpenID Connect
 */

class OidcLoginPlugin extends MantisPlugin
{
  function register()
  {
    $this->name = 'OpenID Connect Login';
    $this->description = 'Login with OpenID Connect';
    $this->page = 'config';

    $this->version = '1.0';
    $this->requires = array(
      'MantisCore' => '2.0.0',
    );

    $this->author = 'Simone Albano';
    $this->contact = 's.albano@sinapsys.it';
    $this->url = 'https://drjest.dev';
  }

  function hooks()
  {
    return array(
      'EVENT_LAYOUT_RESOURCES' => 'scripts',
      'EVENT_CORE_READY' => 'copy_oidc_file'
    );
  }

  function copy_oidc_file()
  {
    global $g_absolute_path;
    ini_set("display_errors", "1");
    error_reporting(E_ALL);

    $oidc_file = $g_absolute_path . 'oidc.html';
    $src_file = dirname(__FILE__) . '/files/oidc.html';

    if (!file_exists($oidc_file)) {
      @copy($src_file, $oidc_file);
    }
  }

  function scripts()
  {
    echo '<script id="oidcLoginScript" data-url="' . plugin_page('login') . '" type="text/javascript" src="' . plugin_file('OidcLogin.js') . '"></script>';
  }

  function login()
  {
    global $g_path;

    $oidc = new OpenIDConnectClient(
      plugin_config_get('discover_url'),
      plugin_config_get('client_id'),
      plugin_config_get('client_secret')
    );

    $redirect_uri = $g_path . 'oidc.html';

    $oidc->setRedirectURL($redirect_uri);

    try {
      $oidc->authenticate();
    } catch (Exception $e) {
      echo $e->getMessage();
      die();
    }
    $sub = $oidc->requestUserInfo(plugin_config_get('username_claim'));
    $email = $oidc->requestUserInfo('email');

    $this->create_or_login_user($sub, $email);
  }

  function create_or_login_user($username, $email)
  {
    $user_id = user_get_id_by_name($username);
    if (!$user_id) {
      $user_id = user_create($username, auth_generate_random_password(), $email);
    }

    auth_login_user($user_id);

    $t_redirect_url = config_get_global('default_home_page');
    if (ON == config_get_global('redirect_delay')) {
      $t_redirect_url .= '?delay=' . config_get_global('redirect_delay_interval');
    }

    header('Location: ' . $t_redirect_url);
  }
}
