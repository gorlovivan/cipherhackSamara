<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Point create dialog form template
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   template
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */

?>
<div class="create-point-form">
    <div class="form-group">
        <select id="point-category" name="item_category">
            <?php foreach ($category as $val): ?>
            <option value="<?= $val->item_id ?>"><?= $val->item_name ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <select id="point-subcategory" class="disabled" name="item_subcategory">
            <option>- выберите категорию -</option>
        </select>
    </div>
    <div class="button-group">
        <a href="javascript:void(0)" class="btn btn-success disabled" data-role="savepoint" title=""><i class="fa fa-check"></i> Сохранить</a> 
        <a href="javascript:void(0)" class="btn btn-warning" data-role="cancelpoint" title="">Отмена</a>
    </div>
</div>
<?php

/* End of file create.php */
/* Location: /application/views/dialog/create.php */ 