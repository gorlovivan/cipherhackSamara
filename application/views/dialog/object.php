<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Map point info template
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   template
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */

$status = convert_status($point->item_status);

?>
<div class="point-map-info">
    <a href="/points/id/<?= $point->item_id ?>" target="_blank" class="point-photo">
        <span class="alert alert-<?= $status['code'] ?>"><?= $status['text'] ?></span>
        <?php
            $photo = $point->item_filename ? explode('.', $point->item_filename) : '/assets/img/nophoto.png';
            $photo = (is_array($photo) ? '/uploads/' . $point->item_id . '/' . $photo[0] . '_thumb.' . $photo[1] : '/assets/img/nophoto.png');
        ?>
        <img src="<?= $photo ?>" alt="<?= $point->item_name ?>" class="photo" />
    </a>
    <h2>
        <a href="/points/id/<?= $point->item_id ?>" target="_blank"><?= $point->item_name ?></a>
    </h2>
</div>
<?php

/* End of file object.php */
/* Location: /application/views/dialog/object.php */ 