<div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">{{ _('Прикріпити аккаунт Viber') }} <i class="fa fa-phone-square"></i></h4>
      </div>
      <div class="modal-body">
        <p>
          Ваш аккаунт Viber не налаштовано.<br> Для налаштування виконайте наступні 
          кроки:
          <ol>
            <li>Віднайдіть публічний аккаунт <strong>SocialNonifier</strong> в списку публічних аккаунтів Viber</li>
            <li>Підпишіться на публічний аккаунт</li>
            <li>Перейдіть у розділ "Повідомлення", та відправте приватне повідомлення нашому роботу, з текстом, який вказаний нижче.</li>
          </ol>
        </p>
        <hr>
        <p>
          Текст повідомлення: <strong>subscribe:{{ $viberCode }}</strong>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{_('Скасувати')}}</button>
        <a href="{{ action('ProfileController@editProfile') }}" class="btn btn-primary">{{_('ОК')}}</a>
      </div>
  </div>
</div>