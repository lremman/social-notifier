@extends('service.app')

@section('content')
      <!-- Buttons
      ================================================== -->
      <div class="container">
        <div class="page-header">
          <div class="row">
            <div class="col-lg-12">
              <h2>Особистий профіль</h2>
            </div>
          </div>
        </div>

        <div class="bs-component">
          <form method="POST" action="{{ action('ProfileController@postEditProfile') }}" class="form-horizontal">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group @if($errors->has('name')) has-error @endif">
              <label for="inputName" class="col-lg-2 control-label">Ім'я</label>
              <div class="col-lg-10">
                <input type="text" name="name" value="{{ array_get($old, 'name') }}" class="form-control" id="inputName" placeholder="Ім'я">
              </div>
            </div>

            <div class="form-group @if($errors->has('telephone')) has-error @endif">
              <label for="inputTelephone" class="col-lg-2 control-label">Телефон</label>
              <div class="col-lg-10">
                <input type="text" name="telephone" value="{{ array_get($old, 'telephone') }}" class="form-control" id="inputTelephone" placeholder="Телефон">
              </div>
            </div>

            <div class="form-group">
              <label for="setupViber" class="col-lg-2 control-label">Viber <i class="fa fa-phone-square"></i></label>
              <div class="col-lg-10">
                <input type="text" value="{{ $viberData ? _('Аккаунт налаштовано: ') . $viberData->name : _('Аккаунт Viber не налаштовано. Клікніть для налаштування') }}" class="form-control" id="setupViber" placeholder="Телефон" readonly @if(!$viberData) data-toggle="modal" data-target="#addViberForm" @endif>
              </div>
            </div>

            <div class="form-group">
              <div class="col-lg-10 col-lg-offset-2">
                <button type="submit" class="btn btn-primary">Зберегти</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="modal fade in" id="addViberForm" role="dialog">
        @if(!$viberData)
          @include('profile.attach-viber-modal')
        @endif
      </div>
@endsection