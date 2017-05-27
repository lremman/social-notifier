<!DOCTYPE HTML>

<html>

<head>
	<title>Your Website</title>
	<link rel="stylesheet" type="text/css" href="{{ url('theme/bootstrap.min.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ url('plugins/font-awesome-4.7.0/css/font-awesome.min.css') }}" />

	<link rel="stylesheet" type="text/css" href="{{ url('plugins/summernote/summernote.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('css/login-form.css') }}" />

</head>

<body>

	<div class="container">
	<div class="login">
		<h4>Вхід</h4>
			<hr>
			{{ Form::open(['action' => 'Auth\RegisterController@postRegister']) }}
				<input type="name" class="form-control name" name="name" placeholder="Введіть ім*я">
				<input type="email" class="form-control email" name="email" placeholder="Введіть email">
				<input type="password" class="form-control password" name="password" placeholder="Введіть пароль">
				<input type="password" class="form-control password" name="password_confirmation" placeholder="Повторити пароль">
				<button class="btn btn-block btn-lg btn-success submit" type="submit">Реєстрація</button>
			{{ Form::close() }}
	</div>
</div>
</body>

</html>
