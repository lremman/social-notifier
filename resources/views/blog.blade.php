@extends('service.app')

@section('content')

  @foreach($posts as $post)
      <!-- Buttons
      ================================================== -->
      <div class="bs-docs-section">
        <div class="page-header">
          <div class="row">
            <div class="col-lg-12">
              <h1>{{ $post->title }}</h1>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            {!! $post->body !!}
          </div>
        </div>
      </div>
  @endforeach
@endsection
