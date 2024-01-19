<?php
form_security_validate('plugin_OidcLogin_config_update');

$f_discover_url = gpc_get_string('discover_url');
$f_client_id = gpc_get_string('client_id');
$f_client_secret = gpc_get_string('client_secret');
$f_username_claim = gpc_get_string('username_claim');

$f_reset = gpc_get_bool('reset', false);

form_security_purge('plugin_OidcLogin_config_update');

if ($f_reset) {
  plugin_config_delete('discover_url');
  plugin_config_delete('client_id');
  plugin_config_delete('client_secret');
  plugin_config_delete('username_claim');
} else {
  plugin_config_set('discover_url', $f_discover_url);
  plugin_config_set('client_id', $f_client_id);
  plugin_config_set('client_secret', $f_client_secret);
  plugin_config_set('username_claim', $f_username_claim);
}

print_header_redirect(plugin_page('config', true));
