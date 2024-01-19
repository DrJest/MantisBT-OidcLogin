document.addEventListener('DOMContentLoaded', function () {
  console.log('OidcLogin.js');
  if (document.querySelector('.login-container')) {
    const loginButton = document.querySelector('.login-container input[type="submit"]');
    const script = document.querySelector('#oidcLoginScript');
    const oidcLoginUrl = script.getAttribute('data-url');
    const title = 'Entra con OIDC';
    const button = document.createElement('input');
    button.setAttribute('type', 'button');
    button.setAttribute('class', 'width-40 pull-left btn btn-success btn-inverse bigger-110');
    button.setAttribute('value', title);
    button.addEventListener('click', function () {
      location.href = oidcLoginUrl;
    });
    loginButton.parentNode.insertBefore(button, loginButton);
  }
  if (document.querySelector('#redirect_uri_copy')) {
    const redirectUriCopy = document.querySelector('#redirect_uri_copy');
    redirectUriCopy.addEventListener('click', function () {
      const redirectUri = document.querySelector('#redirect_uri');
      if (!navigator.clipboard) {
        redirectUri.select();
        document.execCommand('copy');
      }
      else {
        navigator.clipboard.writeText(redirectUri.value);
      }
    });
  }
});