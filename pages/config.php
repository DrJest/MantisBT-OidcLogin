<?php
layout_page_header();
layout_page_begin();

$t_discover_url = plugin_config_get('discover_url');
$t_client_id = plugin_config_get('client_id');
$t_client_secret = plugin_config_get('client_secret');
$t_redirect_uri = $g_path . 'oidc.html';
$t_username_claim = plugin_config_get('username_claim');

?>

<form action="<?php echo plugin_page('config_update') ?>" method="post" style="padding: 12px;">
  <?php echo form_security_field('plugin_OidcLogin_config_update') ?>
  <div class="form-group">
    <label for="discover_url">Discover URL</label>
    <input type="text" class="form-control" name="discover_url" id="discover_url" placeholder="Discover URL" value="<?php echo string_attribute($t_discover_url); ?>" />
  </div>
  <div class="form-group">
    <label for="client_id">Client ID</label>
    <input type="text" class="form-control" name="client_id" id="client_id" placeholder="Client ID" value="<?php echo string_attribute($t_client_id); ?>" />
  </div>
  <div class="form-group">
    <label for="client_secret">Client Secret</label>
    <input type="text" class="form-control" name="client_secret" id="client_secret" placeholder="Client Secret" value="<?php echo string_attribute($t_client_secret); ?>" />
  </div>
  <div class="form-group">
    <label for="username_claim">Username Claim</label>
    <input type="text" class="form-control" name="username_claim" id="username_claim" placeholder="Username Claim" value="<?php echo string_attribute($t_username_claim); ?>" />
  </div>
  <div class="form-group">
    <label for="scope">Auth Mode</label>
    <select class="form-control" name="auth_mode" id="auth_mode">
      <option value="basic" <?php echo plugin_config_get('auth_mode') == 'basic' ? 'selected' : ''; ?>>Basic</option>
      <option value="pkce" <?php echo plugin_config_get('auth_mode') == 'pkce' ? 'selected' : ''; ?>>PKCE</option>
    </select>
  </div>
  <div class="form-group">
    <label for="redirect_uri">Redirect URI</label>
    <div class="input-group">
      <input type="text" class="form-control" id="redirect_uri" placeholder="Redirect URI" value="<?php echo string_attribute($t_redirect_uri); ?>" readonly />
      <div class="input-group-addon">
        <span class="glyphicon glyphicon-copy c-pointer" aria-hidden="true" id="redirect_uri_copy"></span>
      </div>
    </div>
  </div>
  <br>
  <input type="submit" class="btn btn-primary" />
  <input type="submit" name="reset" value="Reset" class="btn btn-default" />
</form>

<style>
  .glyphicon-copy {
    color: #337ab7;
  }

  .c-pointer {
    cursor: pointer;
  }
</style>

<?php
layout_page_end();
