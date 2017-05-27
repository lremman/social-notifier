@extends('service.app')

@section('content')
    <!-- Buttons
    ================================================== -->
    <div class="container">

        <div class="page-header">
          <div class="row">
            <div class="col-lg-12">
              <h2 id="buttons"><a href="{{ action('FriendController@getList') }}">Друзі</a> / {{ $friend->first_name }} {{ $friend->last_name }}</h2>
            </div>
          </div>
        </div>

        <div class="bs-component">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-right">
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#socialSettings">
                        <i class="fa fa-plus"></i>
                        <span>Додати аккаунт</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="bs-component">&nbsp;</div>

        <div class="bs-component">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th width="30"></th>
                        <th width="60"></th>
                        <th>{{ _('Ім\'я') }}</th>
                        <th>{{ _('Прізвище') }}</th>
                        <th>{{ _('Короткий опис') }}</th>
                        <th>{{ _('Сповіщення') }}</th>
                        <th width="100"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($accounts as $account)
                        @php 
                            $config = config('socials.' . $account->provider); 
                        @endphp
                        <tr>
                            <td>
                                <i class="{{ $config['icon_class'] }}">
                            </td>
                            <td>
                                <img src="{{ $account->remote_image }}" width="50" height="50">
                            </td>
                            <td>{{ $account->remote_first_name }}</td>
                            <td>{{ $account->remote_last_name }}</td>
                            <td>{{ $account->description }}</td>
                            <td>
                                @foreach($events[$account->remote_id] as $event)
                                    <span class="badge"><i class="{{ $event['icon'] }}"></i> {{ $event['title'] }} </span> <br>
                                @endforeach
                            </td>
                            <td>
                                <button 
                                    type="button" 
                                    class="btn btn-link eventsSetupButton" 
                                    data-url="{{ action('FriendController@getModalEvents', [
                                        'friendId' => $friendId,
                                        'provider' => $account->provider,
                                        'remote_id' => $account->remote_id,
                                    ]) }}"
                                >
                                    <i class="fa fa-edit"></i> <br> налаштувати
                                </button>
                            </td>
                        </tr>
                    @endforeach
                  </tbody>

            </table> 
        </div>
    </div>
    <div class="modal fade in" id="socialSettings" role="dialog">
        @include('friend.settings.attach-account-modal')
    </div>
    <div class="modal fade" id="eventsSetupModal" role="dialog">
        @include('friend.settings.attach-account-modal')
    </div>
@endsection
