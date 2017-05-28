<div class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <a href="{{ action('TimelineController@getTimeline') }}" class="navbar-brand">SocialNotifier</a>
      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div class="navbar-collapse collapse" id="navbar-main">
      <ul class="nav navbar-nav">
        <li>
          <a href="{{ action('FriendController@getList') }}">{{ _('Мої дузі') }}</a>
        </li>
        <li>
          <a href="{{ action('ProfileController@editProfile') }}">{{ _('Мій профіль') }}</a>
        </li>
      </ul>

      <ul class="nav navbar-nav navbar-right">

          <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="download">
                {{ auth()->user() ? auth()->user()->name : 'Увійти' }} 

                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" aria-labelledby="download">
              <li><a href="{{ action('TimelineController@getTimeline') }}">{{ _('Стрічка оновлень') }}</a></li>
                  <li><a href="{{ action('FriendController@getList') }}">{{ _('Налаштувати дузів') }}</a></li>
                  <li><a href="{{ action('ProfileController@editProfile') }}">{{ _('Редагувати профіль') }}</a></li>
                  <li class="divider"></li>
                  <li><a href="{{ action('Auth\LoginController@getLogout') }}">{{ _('Вихід') }}</a></li>
              </ul>
          </li>
      </ul>

    </div>
  </div>
</div>