<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Main page template
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   template
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */

include_once VIEWPATH . 'sections/header.inc.php';
?>      <main>
            <section class="wrapper wellcome">
                <div class="text">
                    <h1>Активный гражданин</h1>
                    <h2>Помоги своему региону стать лучше</h2>
                    <p>Обнаружил проблемное место на дороге? ЖКХ плохо выполняет свою работу? Опиши суть проблемы, приложи фотографию проблемного места и укажи его на карте - заявка готова!</p>
                    <p>Хочешь принять участие в важных решениях, касаемых твоего региона? Хочешь менять свой регион к лучшему? Тогда прояви инициативу!</p>
                    <br />
                    <button class="btn btn-success" data-role='add-place' onclick="location.href='/<?= $this->auth->is_login() ? 'map#create' : 'login' ?>'">Создать обращение</button>
                </div>
            </section>
            <section class="statistics">
                <div class="row main-stat wrapper">
                    <div class="col-md-1 no-margin">&nbsp;</div>
                    <div class="col-md-2 no-margin">
                        <div><i class="fa fa-user-o" aria-hidden="true"></i></div>
                        <div class="number"><?= $count_user ?></div>
                        <p>пользователей</p>
                    </div>
                    <div class="col-md-2 no-margin">
                        <div><i class="fa fa-map-marker" aria-hidden="true"></i></div>
                        <div class="number"><a href="/map" title=""><?= $count_point ?></a></div>
                        <p>создано обращений</p>
                    </div>
                    <div class="col-md-2 no-margin">
                        <div><i class="fa fa-wrench" aria-hidden="true"></i></div>
                        <div class="number"><a href="/map?status=<?= STATUS_INWORK ?>" title=""><?= $count_process ?></a></div>
                        <p>обращений в работе</p>
                    </div>
                    <div class="col-md-2 no-margin">
                        <div><i class="fa fa-check" aria-hidden="true"></i></div>
                        <div class="number"><a href="/map?status=<?= STATUS_DONE ?>" title=""><?= $count_done ?></a></div>
                        <p>выполнено обращений</p>
                    </div>
                    <div class="col-md-2 no-margin">
                        <div><i class="fa fa-picture-o" aria-hidden="true"></i></div>
                        <div class="number"><?= $count_photo ?></div>
                        <p>загружено фотографий</p>
                    </div>
                    <div class="col-md-1 no-margin">&nbsp;</div>
                </div>
            </section>
            <section class="wrapper">
                <div class="header">
                    <h2>Последние активности в обращениях</h2>
                    <p>В течении двух дней сообщение проходит обработку на портале и рассматривается профильным ведомством</p>
                </div>
                <?php if ( ! empty($points)):  ?>
                <div class="card-grid">
                    <?php foreach($points as $point): ?>
                    <?php include VIEWPATH . 'items/point.php'; ?>
                    <?php endforeach; ?>
                </div>
                <div class="clear"></div>
                <?php endif; ?>
                <br><br>
                <div class="center"><a href="/points/list" title="Все обращения граждан">Смотреть все обращения граждан <i class="fa fa-arrow-right" aria-hidden="true"></i></a></div>
            </section>
        </main>
        <?php include_once VIEWPATH . 'sections/footer.inc.php'; ?>
    </body>
</html>
<?php

/* End of file main.php */
/* Location: /application/views/main.php */ 