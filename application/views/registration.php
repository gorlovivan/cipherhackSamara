<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User registration page template
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   template
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */
?><!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Регистрация на сайте</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link type="text/css" rel="stylesheet" href="/assets/components/zebra/css/flat/zebra_dialog.min.css" />
        <link type="text/css" rel="stylesheet" href="/assets/css/style.css" />
    </head>
    <body>
        <div class="wrapper">
            <div class="registration-form">
                <h1 class="center uppercase">Регистрация на сайте</h1>
                <p class="center">Портал обращений граждан</p>
                <div class="box-content">
                    <div class="form-buttons data-form">
                        <dl class="flt-lbl-box">
                            <dt>Адрес электронной почты <span class="red">*</span></dt>
                            <dd>
                                <input type="text" name="user_email" value="" class="ui-inputfield flt-lbl-inp flt_lbl_inp" />
                            </dd>
                        </dl>
                        <dl class="flt-lbl-box">
                            <dt>Придумайте пароль <span class="red">*</span></dt>
                            <dd>
                                <input type="password" name="user_passw" value="" class="ui-inputfield flt-lbl-inp flt_lbl_inp" />
                            </dd>
                        </dl>
                        <dl class="flt-lbl-box">
                            <dt>Подтвердите ввод пароля <span class="red">*</span></dt>
                            <dd>
                                <input type="password" name="passw_confirm" value="" class="ui-inputfield flt-lbl-inp flt_lbl_inp" />
                            </dd>
                        </dl>
                        <dl class="flt-lbl-box">
                            <dt>Фамилия <span class="red">*</span></dt>
                            <dd>
                                <input type="text" name="user_lastname" value="" class="ui-inputfield flt-lbl-inp flt_lbl_inp" />
                            </dd>
                        </dl>
                        <dl class="flt-lbl-box">
                            <dt>Имя <span class="red">*</span></dt>
                            <dd>
                                <input type="text" name="user_firstname" value="" class="ui-inputfield flt-lbl-inp flt_lbl_inp" />
                            </dd>
                        </dl>
                        <dl class="flt-lbl-box">
                            <dt>Отчество</dt>
                            <dd>
                                <input type="text" name="user_midname" value="" class="ui-inputfield flt-lbl-inp flt_lbl_inp" />
                            </dd>
                        </dl>
                        <dl class="flt-lbl-box">
                            <dt>Номер телефона <span class="red">*</span></dt>
                            <dd>
                                <input type="text" name="user_phone" value="" class="ui-inputfield flt-lbl-inp flt_lbl_inp" />
                            </dd>
                        </dl>
                        <div class="small align-left">
                            <span class="red">*</span> Все поля являются обязательными для заполнения. Ввод недостоверного адреса электронной почты или контактного номера телефона может стать причиной отказа приема сообщения.
                        </div>
                        <br>
                        <div class="checkbox iagree align-left">
                            <input type="checkbox" name="iagree" value="1"> <label>Я соглашаюсь с условиями публичной оферты и политикой защиты персональных данных</label>
                        </div>
                        <br><br>
                        <button type="button" class="btn btn-xs btn-success full-width disabled" onclick="App.Methods.Registration();">Зарегистрироваться</button>
                        <br><br>
                        <p class="no-margin"><a href="/login" title="Авторизоваться на сайте">У меня уже есть аккаунт на сайте</a></p>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="/assets/js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="/assets/js/float-labels.js"></script>
        <script type="text/javascript" src="/assets/js/application.js"></script>
        <script>
            $(document).ready(function() {
                $('.checkbox').click(function() {$(this).find('input[type=checkbox]').trigger('click');});
                $('.iagree').click(function() {

                    if ($(this).find('input[type=checkbox]').is(':checked')) {
                        $('button[type="button"]').removeClass('disabled').removeProp('disabled');
                    } else {
                        $('button[type="button"]').addClass('disabled').prop('disabled', true);
                    }
                });
            });
        </script>
    </body>
</html>
<?php

/* End of file registration.php */
/* Location: /application/views/registration.php */ 
