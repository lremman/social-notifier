$('.message a').click(function(){
   $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
});

var showErrors = function ($form, data) {
	_.each(data, function (data, name){
		$form.find('[name=' + name + ']').addClass('has-errors');
	});
};

var clearErrors = function ($form) {
	$form.find('input').removeClass('has-errors');
};

var SendRegister = function($form){
	$('.login-page .register-form').on('click', '#confirm', function (e) {
		e.preventDefault();
		var $form = $(this).closest('form');
		window.ContentLoader.loadData($form.attr('action'), {
			data: $form.serialize(),
			method: $form.attr('method'),
			before: function () {
				clearErrors($form);
			},
			success:function(data){
				if (data.authorized) {
					window.location.href = data.redirect_url;
	 			}
			},
			error: function(data){
				showErrors($form, data);
				window.UpdateCsrfToken();
			}
		});
	});
};

var prepareConfirmForm = function($form){
	$form.find('input,#register').hide();
	$form.find('[name=code],#confirm').show();
};

$('.login-page .register-form').on('click', '#register', function (e) {
	e.preventDefault();
	var $form = $(this).closest('form');
	window.ContentLoader.loadData($form.data('confirm-sms'), {
		data: $form.serialize(),
		method: $form.attr('method'),
		before: function(){
			clearErrors($form);
		},
		success:function(data){
			if (data.sent) {
				prepareConfirmForm($form);
				SendRegister($form);
			}
			window.UpdateCsrfToken();
		},
		error:function(data){
			showErrors($form, data);
			window.UpdateCsrfToken();
		}
	});

});

$('.login-page .login-form').on('click', '#login', function (e) {
	e.preventDefault();
	var $form = $(this).closest('form');
	window.ContentLoader.loadData($form.attr('action'), {
		data: $form.serialize(),
		method: $form.attr('method'),
		before: function(){
			clearErrors($form);
		},
		success:function(data){
			if (data.authorized) {
				window.location.href = data.redirect_url;
 			} else {
 				$form.find('input').addClass('has-errors');
 			}
		},
		error:function(data){
			showErrors($form, data);
			window.UpdateCsrfToken();
		}
	});
});