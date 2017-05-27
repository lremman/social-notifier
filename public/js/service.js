window.UpdateCsrfToken = function () {
    $.getJSON(window.csrf_token_url, function( data ) {
        window.csrf_token = data._token;
        console.log('Token successfully updated: ' + window.csrf_token);
    });
};

window.ContentLoader = {

    loadHtml: function(url, $parentObject, options) {

        if(!options) {
            options = {};
        }

        var settings = _.merge({

            success:function(data){
                if (options.position == 'bottom') {
                    $parentObject.append(data);
                } else if (options.position == 'top') {
                    $parentObject.prepend(data);
                } else {
                    $parentObject.html(data);
                }
            },
            error: function(data){
                // console.log('error');
            },
            before: function(){
                // console.log('before');
            },
            after: function(){
                // console.log('after');
            }

        }, options);
        var content = ContentLoader.loadCustom(url, settings);
    },

    loadData: function(url, options) {

        if(!options) {
            options = {};
        }

        var settings = _.merge({
            dataType: 'json',
            success:function(data){
                // console.log('success', data);
            },
            error: function(data){
                // console.log('error', data);
            },
            before: function(){
                // console.log('before');
            },
            after: function(){
                // console.log('after');
            }
        }, options);
        var content = ContentLoader.loadCustom(url, settings);
    },

    loadCustom: function(url, options) {

        if(!options) {
            options = {};
        }

        $.ajaxSetup({
            headers:
            { 'X-CSRF-TOKEN': window.csrf_token }
        });

        var settings = _.merge({
            url: url,
            data: {},
            method: 'GET',
            dataType: 'html',
            success: function(){},
            error: function(){},
            before: function(){},
            after: function(){}
        }, options);

        var request = $.ajax({
            url: settings.url,
            method: settings.method,
            data: settings.data,
            dataType: settings.dataType,
            beforeSend: function(){
                settings.before();
            },
            complete: function() {
                settings.after();
            }
        }).done(function( data ) {
            settings.success(data);
        })
        .fail(function( data) {
            settings.error(data.responseJSON, data.status);
        });

    }
};

var clearErrors = function ($form) {
    $form.find('input').removeClass('has-errors');
};

var showErrors = function ($form, data) {
    _.each(data, function (data, name){
        $form.find('[name=' + name + ']').addClass('has-errors');
    });
};

$('#addFriendSocialForm').on('submit', function (e) {
    e.preventDefault();
    var $form = $(this);
    window.ContentLoader.loadData($form.attr('action'), {
        data: $form.serialize(),
        method: $form.attr('method'),
        before: function(){
            clearErrors($form);
        },
        success:function(data){
            console.log($form.data('redirect'));
            window.location.href = $form.data('redirect');
        },
        error:function(data){
            showErrors($form, data);
            window.UpdateCsrfToken();
        }
    });
});

$('.eventsSetupButton').on('click', function(){

    var url = $(this).data('url');
    var $modalContent = $('#eventsSetupModal');

    window.ContentLoader.loadHtml(url, $modalContent, {
        success: function(data){
            $modalContent.html(data);
            $modalContent.modal('show');

        }
    });
});

$('body').on('submit', '#setupFriendEventsForm', function (e) {
    e.preventDefault();
    var $form = $(this);
    window.ContentLoader.loadData($form.attr('action'), {
        data: $form.serialize(),
        method: $form.attr('method'),
        before: function(){
            clearErrors($form);
        },
        success:function(data){
            window.location.href = data.redirect_url;
        },
        error:function(data){
            showErrors($form, data);
            window.UpdateCsrfToken();
        }
    });
});

$('#createFriendForm').on('submit', function (e) {
    e.preventDefault();
    var $form = $(this);
    window.ContentLoader.loadData($form.attr('action'), {
        data: $form.serialize(),
        method: $form.attr('method'),
        before: function(){
            clearErrors($form);
        },
        success:function(data){
            window.location.href = $form.data('redirect');
        },
        error:function(data){
            showErrors($form, data);
            window.UpdateCsrfToken();
        }
    });
});


