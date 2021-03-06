<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>SocialNotifier</title>
  <link rel="stylesheet" type="text/css" href="{{ url('theme/auth/css/style.css') }}" />
  @include('parts.favicon')
  @include('parts.og')
</head>

<body>
<div class="login-page">

  
  <div class="form">

    <img src="{{ url('images/logo_mini.png') }}" width="150">
    <br><br>
    <form class="register-form" method="POST" action="{{ action('Auth\RegisterController@postRegister') }}" data-confirm-sms="{{ action('Auth\RegisterController@postSmsConfirmation') }}">
      <div class="form-group">
        <input type="text" name="name" placeholder="{{ _('Імя') }}"/>
      </div>
      <input type="text" name="telephone" placeholder="{{ _('Телефон') }}"/>
      <input type="password" name="password" placeholder="{{ _('Пароль') }}"/>
      <input type="password" name="password_confirmation" placeholder="{{ _('Повтор пароля') }}"/>
      <input type="text" hidden name="code" placeholder="{{ _('Код із смс') }}"/>
      <button type="submit" id="register" class="js-submit">{{ _('Зареєструватися') }}</button>
      <button type="submit" id="confirm" hidden class="js-submit">{{ _('Підтвердити') }}</button>
      <p class="message">{{ _('Вже зареєстровані') }}? <a href="#">{{ _('Увійти') }}</a></p>
    </form>

    <form class="login-form" method="POST" action="{{ action('Auth\LoginController@postLogin') }}">
      <div class="form-group">
    
      <input type="text" name="telephone" placeholder="{{ _('Телефон') }}"/>
      <input type="password" name="password" placeholder="{{ _('Пароль') }}"/>
      <button type="submit" id="login" class="js-submit">{{ _('Увійти') }}</button>
      <p class="message">{{ _('Не зареєстровані') }}? <a href="#">{{ _('Зареєструйтеся') }}</a></p>
    </form>
  </div>
</div>
  <script src="{{ url('js/jquery-3.1.1.min.js') }}"></script>
  <script>
    window.csrf_token = '{{ csrf_token() }}';
    window.csrf_token_url = '{{ action('ServiceController@getCsrfToken') }}';
  </script>
  <script src="{{ url('plugins/lodash.js') }}"></script>
  <script src="{{ url('js/service.js') }}"></script>
  <script src="{{ url('theme/auth/js/index.js') }}"></script>
</body>
</html>
