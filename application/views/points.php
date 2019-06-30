<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Points page list template
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   template
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */

include_once VIEWPATH . 'sections/header.inc.php';
?>      <main>
            <?php if (empty($author) || ! isset($author->user_id)): ?>
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
            <section class="fullmap">
                <div class="overlay"></div>
                <div class="wrapper center">
                    <h2>Карта обращений граждан</h2>
                    <h3>Все обращения активных граждан можно посмотреть на интерактивной карте Оренбургской области</h3>
                    <div><a href="/map" title="Карта обращений граждан">Перейти на карту обращений <i class="fa fa-arrow-right" aria-hidden="true"></i></a></div>
                </div>
            </section>
            <?php endif; ?>
            <section class="wrapper">
                <div class="header">
                    <?php if ( ! empty($author) && isset($author->user_id)): ?>
                        <h2><?= $author->user_lastname ?> <?= $author->user_firstname ?></h2>
                        <p>Все добавленные обращения активного гражданина</p>
                    <?php else: ?>
                        <h2>Все обращения граждан</h2>
                        <p>В течении двух дней сообщение проходит обработку на портале и рассматривается профильным ведомством</p>
                    <?php endif; ?>
                </div>
                <?php if ( ! empty($points)):  ?>
                <div class="points-filter">
                    <select id="point-category" style="width: auto" name="item_category">
                        <option>- категория обращений -</option>
                        <?php foreach ($category as $val): ?>
                        <option value="<?= $val->item_id ?>"><?= $val->item_name ?></option>
                        <?php endforeach; ?>
                    </select><select id="point-category" style="width: auto" name="item_category">
                        <option>- статусы обращений -</option>
                    </select><select id="point-category" style="width: auto" name="item_category">
                        <option>- управляющая компания -</option>
                    </select><select id="point-category" style="width: auto" name="item_category">
                        <option>- сортировка результатов -</option>
                    </select>
                </div>
                <div class="card-grid">
                    <?php foreach($points as $point): ?>
                    <?php include VIEWPATH . 'items/point.php'; ?>
                    <?php endforeach; ?>
                </div>
                <div class="clear"></div>
                <div class="pagination"><?= $pages ?></div>
                <?php else: ?>
                <div style="margin: 60px 0; text-align: center; min-height:200px;">Пользователь еще не добавил ни одной проблемы</div>
                <?php endif; ?>
            </section>
        </main>
        <?php include_once VIEWPATH . 'sections/footer.inc.php'; ?>
        <script type="text/javascript" src="/assets/js/jquery.selectric.min.js"></script>
        <script>
            $(document).ready(function() {
                $('select').selectric();
            });
        </script>
    </body>
</html>
<?php

/* End of file points.php */
/* Location: /application/views/points.php */ 