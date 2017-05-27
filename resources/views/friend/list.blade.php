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
                        <th>Прізвище</th>
                        <th>Аккаунти</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($friends as $friend)
                        <tr>
                            <td width="60">
                                @if($social = $friend->socials->first())
                                    <img src="{{ $social->remote_image }}" width="50" height="50">
                                @endif
                            </td>
                            <td>
                                {{ $friend->first_name }}
                            </td>
                            <td>
                                {{ $friend->last_name }}
                            </td>
                            <td>
                                @foreach($friend->socials as $social)
                                    <i class="{{ config('socials.' . $social->provider . '.icon_class') }}"></i>
                                @endforeach
                            </td>

                            <td width="100">
                                <a href="{{ action('FriendController@getSettings', $friend->id) }}" class="btn btn-link"><i class="fa fa-edit"></i> <br> налаштувати</a>
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
