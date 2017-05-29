@extends('service.app')

@section('content')
    <!-- Buttons
    ================================================== -->
    <div class="container">

        <div class="page-header">
          <div class="row">
            <div class="col-lg-12">
              <h2 id="buttons">Друзі</h2>
            </div>
          </div>
        </div>

        <div class="bs-component">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-right">
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#createFriendModal">
                        <i class="fa fa-plus"></i>
                        <span>Додати друга</span>
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
                        <th></th>
                        <th>Ім'я</th>
                        <th>Аккаунти</th>
                        <th width=50></th>
                    </tr>
                </thead>
                <tbody>
                    @if(!$friends->count())
                        <tr>
                            <td colspan="5" class="text-center">
                                У вашому профілі ще не створено жодного друга. <a href="#" data-toggle="modal" data-target="#createFriendModal">
                        Створити зараз
                        </a>?
                            </td>
                        </tr>
                    @endif
                    @foreach($friends as $friend)
                        <tr>
                            <td width="60">
                                @if($social = $friend->socials->first())
                                    <a href="{{ action('FriendController@getSettings', $friend->id) }}" class="btn btn-link">
                                        <img src="{{ $social->remote_image }}" width="50" height="50">
                                    </a>
                                @endif
                            </td>
                            <td>
                                <a href="{{ action('FriendController@getSettings', $friend->id) }}">
                                    {{ $friend->first_name }}
                                    {{ $friend->last_name }}
                                </a>
                            </td>
                            <td>
                                @php $socialsCount = 0; @endphp
                                @foreach($friend->socials as $social)
                                    @php $socialsCount++; @endphp
                                    <span class="label label-primary"><i class="{{ config('socials.' . $social->provider . '.icon_class') }}"></i> {{ config('socials.' . $social->provider . '.title') }}</span><br>
                                @endforeach
                                @if(!$socialsCount)
                                    Аккаунти не налаштовані. <a href="{{ action('FriendController@getSettings', $friend->id) }}">Налаштувати?
                                    </a>
                                @endif
                            </td>

                            <td>
                                <a href="{{ action('FriendController@getSettings', $friend->id) }}" class="btn btn-link"><i class="fa fa-edit"></i></a>
                            </td>
                           
                        </tr>
                    @endforeach
                </tbody>

            </table> 
        </div>
    </div>
    <div class="modal fade" id="createFriendModal" role="dialog">
        @include('friend.create-friend-modal')
    </div>
@endsection
