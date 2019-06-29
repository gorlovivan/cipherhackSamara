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
            <section class="fullmap">
                <div class="overlay"></div>
                <div class="wrapper center">
                    <h2>Карта обращений граждан</h2>
                    <h3>Все обращения активных граждан можно посмотреть на интерактивной карте Оренбургской области</h3>
                    <div><a href="/map" title="Карта обращений граждан">Перейти на карту обращений <i class="fa fa-arrow-right" aria-hidden="true"></i></a></div>
                </div>
            </section>
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
                <div class="card-grid">
                    <?php foreach($points as $point): ?>
                    <?php include VIEWPATH . 'items/point.php'; ?>
                    <?php endforeach; ?>
                </div>
                <div class="clear"></div>
                <div class="pagination"><?= $pages ?></div>
                <?php endif; ?>
            </section>
        </main>
        <?php include_once VIEWPATH . 'sections/footer.inc.php'; ?>
    </body>
</html>
<?php

/* End of file points.php */
/* Location: /application/views/points.php */ 