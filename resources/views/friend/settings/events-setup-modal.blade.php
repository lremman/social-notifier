<div class="modal-dialog">
  <div class="modal-content">
    <form action="{{ action('FriendController@saveModalEvents', [
        'friendId' => $friendId,
        'provider' => $provider,
        'remoteId' => $remoteId,
      ]) }}" method="POST" id="setupFriendEventsForm" class="form" data-redirect="{{ url()->current() }}">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">{{ _('Налаштування сповіщень') }} <i class="{{ config('socials.' . $provider . '.icon_class') }}"></i></h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="friend_id" value="5"> 
        <input type="hidden" name="customer_id" value="1"> 
        @foreach($options as $morph => $option_data)
          <div class="form-group">
              <div class="checkbox">
                <label>
                  <input name="events[]" value="{{ $morph }}" type="checkbox" {{ $allowedEvents->contains($morph) ? 'checked' : '' }} {{ $option_data['ability'] ? '' : 'disabled' }} > <i class="{{ $option_data['icon'] }} "></i> {{ $option_data['title'] }}
                </label>
              </div>
          </div>
        @endforeach
        <hr>
        <div class="form-group">
            <div class="checkbox">
              <label>
                <input name="allow_sms" type="checkbox" {{ $allowSms ? 'checked' : '' }} > Сповіщувати задопомогою СМС
              </label>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{_('Скасувати')}}</button>
        <button type="submit" class="btn btn-primary">{{_('Зберегти')}}</button>
      </div>
    </form>
  </div>
</div>