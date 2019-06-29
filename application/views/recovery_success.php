<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Recovery password success page template
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   template
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */
?><!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Изменение пароля</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link type="text/css" rel="stylesheet" href="/assets/components/zebra/css/flat/zebra_dialog.min.css" />
        <link type="text/css" rel="stylesheet" href="/assets/css/style.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/blockadblock/3.2.1/blockadblock.js" integrity="sha256-uaQssnQX0rh7jVmDZVVmcxo4CJ1eMHNenpMQCOpZxjQ=" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="wrapper">
            <div class="login-form">
                <h1 class="center uppercase">Восстановление пароля</h1>
                <p class="center">Сервис размещения рекламных объявлений</p>
                <h5 class="alert alert-danger" id="block-adb-enabled" style="display: none;">Пожалуйста, добавьте сайт <b>reklama.media56.ru</b> в исключения блокировщика рекламы (AdBlock). Без этого работа с сайтом, увы, будет невозможна :(</h5>
                <script> function adBlockDetected() {$('#block-adb-enabled').show();} if (typeof blockAdBlock === 'undefined') {adBlockDetected();} else {blockAdBlock.setOption({ debug: false });blockAdBlock.onDetected(adBlockDetected);}</script>
                <br><br>
                <div class="box-content">
                    <div class="form-buttons data-form">
                        Ваш пароль был успешно изменен. В целях безопасности новые данные для авторизации были отправлены на ваш email адрес. Пожалуйста, проверьте свою почту через пару минут.<br>Важно! Никому не сообщайте свои данные для авторизации.
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php

/* End of file login.php */
/* Location: /application/views/login.php */ 
