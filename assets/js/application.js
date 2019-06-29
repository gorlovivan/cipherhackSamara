/**
 * @package    codeigniter
 * @subpackage project
 * @category   javascript
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */
// APP CLASS

var App = App || {};

App.Var = {
    otherIncome: 0,
    SpendingJSON: [],
};

App.Methods = {
    /**
     * Define a $.cachedScript() method that allows fetching a cached script:
     */
    cachedScript: function(url, options) {
        options = $.extend( options || {}, {
            dataType: "script",
            cache: true,
            url: url
        });

        return jQuery.ajax(options);
    }, // cachedScript: function(url, options)
    /**
     * Show alert message
     * @param {string} message
     * @param {string} type
     * @returns void
     */
    Alert: function(message, type = 'confirmation') {
        return new $.Zebra_Dialog(message, {
            width: 600,
            type: type,
        });
    }, // Alert: function(message, type)
    /**
     * Show confirm message
     */
    Confirm: function(message) {
        
//        $.Zebra_Dialog(message, {
//            'type':     'question',
//            'title':    'Внимание',
//            'buttons':  [
//                {caption: 'Да', callback: function() {return true;}},
//                {caption: 'Нет', callback: function() {return false;}}
//            ]
//        });
        
        
        if (confirm(message)) {
            return true;
        } else {
            return false;
        }
    }, // Confirm: function(message)
    Loader: {
        Create: function(element) {
            $(element).append('<div id="loader"><div class="container"><div class="cssload-dot"></div><div class="cssload-dot"></div><div class="cssload-dot"></div><div class="cssload-dot"></div><div class="cssload-dot"></div><div class="cssload-dot"></div><div class="cssload-dot"></div><div class="cssload-dot"></div></div></div>');
            App.Methods.Loader.Show();
        },
        Remove: function() {
            $('#loader').remove();
        },
        Show: function() {
            $('#loader').show();
        },
        Hide: function() {
            $('#loader').hide();
        }
    },
    Login: function() {
        var login = $('input[name=login_email]').val(),
            passw = $('input[name=login_passw]').val();

        if ( ! login || ! passw) {
            return this.Alert('Для авторизации нужно ввести email адрес и пароль', 'error');
        }

        $.ajax({
            type: 'post',
            cache: false,
            url: '/login/auth',
            dataType: 'json',
            data: {login: login, passw: passw},
            beforeSend: function(xhr) {                
                App.Methods.Loader.Create('.box-content');
            },
            success: function(response) {
                if (response.state == false) {
                    App.Methods.Loader.Remove();
                    App.Methods.Alert(response.text, 'error');
                } else {
                    location.href = response.link;
                }
            }
        });
    }, // Login: function()
    /**
     * Registration form
     * @returns void
     */
    Registration: function() {
        var login    = $('input[name=user_email]').val(),
            passw    = $('input[name=user_passw]').val(),
            confirm  = $('input[name=passw_confirm]').val(),
            name     = $('input[name=user_firstname]').val(),
            lastname = $('input[name=user_lastname]').val(),
            midname  = $('input[name=user_midname]').val(),
            phone    = $('input[name=user_phone]').val();

        if ( ! login || ! passw || ! confirm || ! name || ! lastname || ! phone) {
            return this.Alert('Для регистрации на сайте нужно заполнить все поля на форме. Пожалуйста, проверьте правильность заполнения полей', 'error');
        }

        if (passw !== confirm) {
            $('input[name=user_passw]').val('');
            $('input[name=passw_confirm]').val('');
            return this.Alert('Введенные пароли не соответсвуют друг другу, попробуйте ввести пароль заново', 'error');
        }

        return this._SaveNewUser(login, passw, name, lastname, midname, phone);
    }, // Registration: function()
    /**
     * Redirect user to page
     * @param {string} url
     */
    Redirect: function(url) {
        location.href = url;
    }, // Redirect: function(url)
    /**
     * Create new user action
     */
    _SaveNewUser: function(login, passw, name, lastname, midname, phone, url = '/registration/create') {
        $.ajax({
            type: 'post',
            cache: false,
            url: url,
            dataType: 'json',
            data: {login: login, passw: passw, name: name, lastname: lastname, midname: midname, phone: phone},
            beforeSend: function(xhr) {                
                App.Methods.Loader.Create('.box-content');
            },
            success: function(response) {
                if (response.state == false) {
                    App.Methods.Loader.Remove();
                    App.Methods.Alert(response.text, 'error');
                } else {
                    location.href = response.link;
                }
            }
        });
    }, // _SaveNewUser: function(login, passw, name, lastname, midname, phone, url = '/registration/create')
}

App.Methods.cachedScript("/assets/components/zebra/zebra_dialog.min.js");

$(document).ready(function() {
    function mobile_menu_hide() {
        var menu = $('.mobile-menu'),
            left = $(menu).offset().left;

        $(menu).css({left:left}).animate({"left": (- menu.width()) + "px"}, "slow");
        $('.menu-overlay').hide();
    }
    function mobile_menu_show() {
        var menu = $('.mobile-menu'),
            left = $(menu).offset().left;

        $(menu).css({left:left}).animate({"left": "0px"}, "slow");
        $('.menu-overlay').show();
    }
    
    /**
     * Кнопка показа\скрытия меню в мобильной версии
     */
    var display_menu = false;
    $('.nav-toggle').on('click', function() {
        if (display_menu === true) {
            mobile_menu_hide();
            display_menu = false;
        } else if (display_menu === false) {
            mobile_menu_show();
            display_menu = true;
        }
    });
    $('.menu-overlay').on('click', function() {
        display_menu = false;
        mobile_menu_hide();
    });
});