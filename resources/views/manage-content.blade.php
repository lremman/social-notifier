@extends('service.app')

@section('content')

    <div class="bs-docs-section">
        <div class="page-header">
          <div class="row">
            <div class="col-lg-12">
              <h1 id="buttons">Новий пост</h1>
            </div>
          </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            {{ Form::open(['action' => 'BlogController@postAddArticle']) }}
                <div class="form-group">
                    {{Form::label('title', 'Название')}}
                    {{Form::text('title',null,['class' => 'form-control', 'placeholder'=>'Название'])}}
                </div>
                <div class="form-group">
                    {{Form::label('body', 'Содержание')}}
                    {{Form::textarea('body',null,['class' => 'form-control', 'placeholder'=>'Описание', 'id' => 'blog-body'])}}
                </div>
                <div class="form-group">
                    {{Form::submit('Добавить',['class' => 'btn btn-primary btn-sm'])}} 
                </div>
             
            {{ Form::close() }} 
        </div>
    </div>

    @section('user-js')

        <script type="text/javascript">
            $(document).ready(function() {
                $('#blog-body').summernote({
                  height:300,
                });
            });
        </script>

    @endsection


    @section('footer')

    @endsection

@endsection
