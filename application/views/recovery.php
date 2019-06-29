<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User recovery password page template
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   template
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */
?><!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Восстановление пароля</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link type="text/css" rel="stylesheet" href="/assets/components/zebra/css/flat/zebra_dialog.min.css" />
        <link type="text/css" rel="stylesheet" href="/assets/css/style.css" />
    </head>
    <body>
        <div class="wrapper">
            <div class="login-form">
                <h1 class="center uppercase">Восстановление пароля</h1>
                <p class="center">Портал обращений граждан</p>
                <div class="box-content">
                    <p>Для восстановления пароля укажите email адрес, который вы использовали при регистрации</p>
                    <div class="form-buttons data-form">
                        <dl class="flt-lbl-box">
                            <dt>E-mail адрес</dt>
                            <dd>
                                <input type="text" name="user_email" value="" class="ui-inputfield flt-lbl-inp flt_lbl_inp" />
                            </dd>
                        </dl>
                        <button type="button" class="btn btn-xs btn-success full-width" data-role="recovery">Восстановить</button>
                        <br><br>
                        <p><a href="/login" title="Регистрация на сайте">Я вспомнил пароль!</a></p>
                        <p class="no-margin"><a href="/registration" title="Регистрация на сайте">Нет аккаунта? Зарегистрируйтесь!</a></p>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="/assets/js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="/assets/js/float-labels.js"></script>
        <script type="text/javascript" src="/assets/js/application.js"></script>
        <script>
        $(document).ready(function() {
            $('[data-role=recovery]').click(function() {
                var email = $('input[name=user_email]').val();

                if (validateEmail(email)) {
                    App.Methods.Loader.Create('.box-content');

                    $.getJSON('/recovery/send/?email=' + email, function(data) {
                        App.Methods.Alert(data.text, (data.state == false ? 'error' : 'confirmation'));
                        App.Methods.Loader.Remove();

                        if (data.state == true) {
                            $('[name="user_email"]').addClass('disabled');
                            $('[data-role="recovery"]').addClass('disabled');
                        }
                    });
                } else {
                    return App.Methods.Alert('Для восстановления укажите свой настоящий email адрес, который использовался при регистрации', 'error');
                }
            });

            function validateEmail(email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(String(email).toLowerCase());
            }
        });
        </script>
    </body>
</html>
<?php

/* End of file login.php */
/* Location: /application/views/login.php */ 
