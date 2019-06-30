<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Point object template
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   template
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */

$status = convert_status($point->item_status);

?>
    <div class="card-item" data-name="<?= $point->item_id ?>">
        <div class="card-item-content">
            <div class="card-photo">
                <span class="like"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <?= rand(0, 12); ?> Подтвердили</span>
                <span class="alert alert-<?= $status['code'] ?>"><?= $status['text'] ?></span>
                <a href="/points/id/<?= $point->item_id ?>" title="<?= $point->item_name ?>">
                    <?php
                        $photo = $point->item_filename ? explode('.', $point->item_filename) : '/assets/img/nophoto.png';
                        $photo = (is_array($photo) ? '/uploads/' . $point->item_id . '/' . $photo[0] . '_thumb.' . $photo[1] : '/assets/img/nophoto.png');
                    ?>
                    <img src="<?= $photo ?>" alt="<?= $point->item_name ?>" class="photo" />
                </a>
                <a href="/map#c=<?= $point->item_latitude ?>,<?= $point->item_longitude ?>&z=16" class="item-icon" title="">
                    <img src="/assets/img/points/<?= $point->item_icon ?>" alt="" />
                </a>
            </div>
            <div class="card-block">
                <h3>
                    <a href="/points/id/<?= $point->item_id ?>" title="<?= $point->item_name ?>"><?= $point->item_name ?></a>
                </h3>
                <p class="datetime"><i class="fa fa-calendar" aria-hidden="true"></i> <?= formatdate((int) $point->item_timestamp) ?>&nbsp;&nbsp; &middot; &nbsp;&nbsp;<i class="fa fa-eye" aria-hidden="true"></i> <?= $point->item_views ?></p>
                <p class="address"><?= $point->item_address ?></p>
                <p class="description"><?= str_cut($point->item_message, 60) ?></p>
            </div>
        </div>
    </div>
<?php

/* End of file point.php */
/* Location: /application/views/items/point.php */ 