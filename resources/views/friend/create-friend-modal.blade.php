<div class="modal-dialog">
  <div class="modal-content">
    <form action="#" method="POST" id="createFriendForm" class="form" data-redirect="{{ url()->current() }}">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">{{ _('Додати нового друга') }}</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label class="control-label" for="firstName">{{ 'Ім\'я' }}</label>
          <input type="text" class="form-control" id="firstName" name="first_name" placeholder="{{ _('Введіть ім\'я друга') }}">
        </div>
        <div class="form-group">
          <label class="control-label" for="lastName">{{ 'Прізвище' }}</label>
          <input type="text" class="form-control" id="lastName" name="last_name" placeholder="{{ _('Введіть прізвище друга') }}">
        </divя
        <div class="form-group">
          <label for="description" class="control-label">Опис</label>
          <textarea name="description" class="form-control" rows="3" id="description"></textarea>
          <span class="help-block">Короткий опис до профілю друга</span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{_('Скасувати')}}</button>
        <button type="submit" class="btn btn-primary">{{_('Додати')}}</button>
      </div>
    </form>
  </div>
</div>