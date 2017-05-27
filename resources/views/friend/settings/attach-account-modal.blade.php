<div class="modal-dialog">
  <div class="modal-content">
    <form action="{{ action('FriendController@postAttachAccount', $friendId) }}" method="POST" id="addFriendSocialForm" class="form" data-redirect="{{ url()->current() }}">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">{{ _('Додати соціальну мережу') }}</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="friend_id" value="5"> 
        <input type="hidden" name="customer_id" value="1"> 
        <div class="form-group">
          <label class="control-label" for="selectUserSocial">{{ 'Шлюз' }}</label>
          <select name="provider" class="form-control js-select-social" id="selectUserSocial">
            @foreach(config('socials') as $social => $data)
              <option value="{{ $social }}">{{ array_get($data, 'title') }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label class="control-label" for="socialAccountUrl">{{ 'Посилання' }}</label>
          <input type="text" class="form-control" id="socialAccountUrl" name="url" placeholder="{{ _('Введіть посилання на сторінку користувача') }}">
        </div>
        <div class="form-group">
          <label for="description" class="control-label">Опис</label>
          <textarea name="description" class="form-control" rows="3" id="description"></textarea>
          <span class="help-block">Короткий опис  до аккаунту користувача</span>
        </div>
        <script type="text/template" class="js-select-social-template">
          <span><img src="vendor/.png" class="img-flag" /> </span>
        </script>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{_('Скасувати')}}</button>
        <button type="submit" class="btn btn-primary">{{_('Додати')}}</button>
      </div>
    </form>
  </div>
</div>

