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
<div class="create-point-form data-form">
    <div class="form-group">
        <select id="point-category" name="item_category">
            <option>- выберите категорию -</option>
            <?php foreach ($category as $val): ?>
            <option value="<?= $val->item_id ?>"><?= $val->item_name ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
    <dl class="flt-lbl-box">
        <dt>Текст обращения<div class="hide-hint">Опишите суть проблемы</div></dt>
        <dd>
            <textarea name="item_message" id="message" rows="6" class="ui-inputfield flt-lbl-inp flt_lbl_inp"></textarea>
        </dd>
    </dl>
    </div>
    <div class="button-group">
        <a href="javascript:void(0)" class="btn btn-primary disabled" data-role="savepoint" title=""><i class="fa fa-check"></i> Сохранить</a> 
        <a href="javascript:void(0)" class="btn btn-warning" data-role="cancelpoint" title="">Отмена</a>
    </div>
</div>
<?php

/* End of file create.php */
/* Location: /application/views/dialog/create.php */ 