@extends('service.app')

@section('content')
      <!-- Buttons
      ================================================== -->
      <div class="container">
        <div class="page-header">
          <div class="row">
            <div class="col-lg-12">
              <h2 id="buttons">Стрічка оновлень</h2>
            </div>
          </div>
        </div>

        @foreach($daysTimelines as $days => $dayTimelines)

          @if($days == 0)

            <div class="row">
              <div class="col-lg-12">
                <div class="page-header">
                  <h5 id="containers">Сьогодні</h5>
                </div>
              </div>
            </div>

          @elseif($firstTimeline = $dayTimelines->first())
            <div class="row">
              <div class="col-lg-12">
                <div class="page-header">
                  <h5 id="containers">{{ $firstTimeline->created_at->format('d.m.Y') }}</h5>
                </div>
              </div>
            </div>
          @endif

          @foreach($dayTimelines as $dayTimeline)
            <div class="row">
              <div class="col-md-8">
                <div class="text-center">
                  <div class="bs-component">
                      <div class="alert alert-dismissible alert-success">
                        <div class="text-left">
                          <button type="button" class="close" data-dismiss="alert">×</button>
                          <table class="table">
                            <tbody>
                            <tr>
                              <td width="50"><img src="{{ $dayTimeline->avatar_image }}" width="40" height="40"></td>
                              <td ><h4><a class="alert-link" href="#">SocialNotifier</a>&nbsp;|&nbsp;{{ $dayTimeline->created_at->format('H:i') }}&nbsp;|&nbsp;<i class="{{ config('socials.' . $dayTimeline->provider . '.icon_class')}}"></i></h4></td>
                            </tr>
                            </tbody>
                          </table>
                          <p>{!! $dayTimeline->description !!}</p>
                        </div>
                        @if($dayTimeline->attached_photo)
                          <br>
                          <img class="img-fluid" src="{{ $dayTimeline->attached_photo }}" width="100% \ 9">
                          <br><br>
                        @endif
                      </div>
                  </div>
                </div>
              </div>
            </div>
          @if($dayTimeline->provider == 'notifier')
          @else
            <div class="row">
              <div class="col-md-8">
                <div class="text-center">
                  <div class="bs-component">
                      <div class="alert alert-dismissible alert-info">
                        <div class="text-left">
                          <button type="button" class="close" data-dismiss="alert">×</button>
                          <table class="table">
                            <tbody>
                            <tr>
                              <td width="50"><img src="{{ $dayTimeline->avatar_image }}" width="40" height="40"></td>
                              <td ><h4><a class="alert-link" href="#">{{ data_get($dayTimeline, 'friend.first_name') }}&nbsp;{{ data_get($dayTimeline, 'friend.last_name') }}</a>&nbsp;|&nbsp;{{ $dayTimeline->created_at->format('H:i') }}&nbsp;|&nbsp;<i class="{{ config('socials.' . $dayTimeline->provider . '.icon_class')}}"></i></h4></td>
                            </tr>
                            </tbody>
                          </table>
                          <p>{!! $dayTimeline->description !!}</p>
                        </div>
                        @if($dayTimeline->attached_photo)
                          <br>
                          <img class="img-fluid" src="{{ $dayTimeline->attached_photo }}" width="100% \ 9">
                          <br><br>
                        @endif
                      </div>
                  </div>
                </div>
              </div>
            </div>
          @endif
          @endforeach

        @endforeach

@endsection
