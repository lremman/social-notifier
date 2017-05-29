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
                        <th>{{ _('Опис') }}</th>
                        <th>{{ _('Сповіщення') }}</th>
                        <th width="50"></th>
                    </tr>
                </thead>
                <tbody>
                    @if(!$accounts->count())
                        <tr>
                            <td colspan="5" class="text-center">
                                До <a href="{{ action('FriendController@getSettings', $friend->id) }}">{{ $friend->first_name }} {{ $friend->last_name }}</a> ще не прикріплено жодного аккаунта. <a href="#" type="button" data-toggle="modal" data-target="#socialSettings">
                        Прикріпити зараз
                        </a>?
                            </td>
                        </tr>
                    @endif
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
                            <td>
                                {{ $account->remote_first_name }}
                                {{ $account->remote_last_name }}
                                {{ $account->description ? '-' : ''}}
                                {{ $account->description }}
                            </td>
                            <td>
                                @php $eventsCount = 0; @endphp
                                @foreach($events[$account->remote_id] as $event)
                                    @php $eventsCount++; @endphp
                                    <span class="badge"><i class="{{ $event['icon'] }}"></i> {{ $event['title'] }} </span> <br>
                                @endforeach
                                @if(!$eventsCount)
                                    Сповішення не налаштовані. <a 
                                    type="button"
                                    href="#" 
                                    class="eventsSetupButton text-primary" 
                                    data-url="{{ action('FriendController@getModalEvents', [
                                        'friendId' => $friendId,
                                        'provider' => $account->provider,
                                        'remote_id' => $account->remote_id,
                                    ]) }}"
                                >Налаштувати
                                </a>
                                ?
                                @endif
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
                                    <i class="fa fa-edit"></i>
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
