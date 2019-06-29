<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User authorization page template
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   template
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */
?><!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Авторизация</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link type="text/css" rel="stylesheet" href="/assets/components/zebra/css/flat/zebra_dialog.min.css" />
        <link type="text/css" rel="stylesheet" href="/assets/css/style.css" />
    </head>
    <body>
        <div class="wrapper">
            <div class="login-form">
                <h1 class="center uppercase">Авторизация</h1>
                <p class="center">Портал обращений граждан</p>
                <div class="box-content">
                    <button type="button" class="btn btn-xs btn-primary full-width">Авторизация через ЕСИА</button>
                    <div class="hr"></div>
                    <div class="center" style="margin-top: 30px;border-top: 1px solid #D7D8DB;padding-top: 20px;">Или войдите с помощью других сервисов</div>
                    <!--
                    <div class="form-buttons data-form">
                        <dl class="flt-lbl-box">
                            <dt>Email</dt>
                            <dd>
                                <input type="text" name="login_email" value="" class="ui-inputfield flt-lbl-inp flt_lbl_inp" />
                            </dd>
                        </dl>
                        <dl class="flt-lbl-box">
                            <dt>Пароль</dt>
                            <dd>
                                <input type="password" name="login_passw" value="" class="ui-inputfield flt-lbl-inp flt_lbl_inp" />
                            </dd>
                        </dl>
                        <button type="button" class="btn btn-xs btn-success full-width" onclick="App.Methods.Login();">Войти</button>
                        <br><br>
                        <p><a href="/recovery" title="Восстановление пароля">Я забыл свой пароль!</a></p>
                        <p class="no-margin"><a href="/registration" title="Регистрация на сайте">Нет аккаунта? Зарегистрируйтесь!</a></p>
                    </div>
                    -->
                </div>
            </div>
        </div>
        <script type="text/javascript" src="/assets/js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="/assets/js/float-labels.js"></script>
        <script type="text/javascript" src="/assets/js/application.js"></script>
        <script>
            $(document).on('keypress',function(e) {
                if (e.which == 13) {
                    App.Methods.Login();
                }
            });
        </script>
    </body>
</html>
<?php

/* End of file login.php */
/* Location: /application/views/login.php */ 
