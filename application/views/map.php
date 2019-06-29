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
?>      <main class="map-page">
            <section>
                <div class="map-edit-overlay">
                    <p>Для добавления обращения, кликните кнопкой мыши на карте в необходимом месте</p>
                    <a href="javascript:void(0)" title="" data-role="map-cancel-edit">НАЖМИТЕ СЮДА ДЛЯ ОТМЕНЫ ДОБАВЛЕНИЯ ОБРАЩЕНИЯ</a>
                </div>
                <div class="map-box box-content">
                    <select id="point-status" name="point-status">
                        <option value="0">- все статусы обращений -</option>
                        <option value="15"<?= $status == 15 ? ' selected' : '' ?>>В работе</option>
                        <option value="20"<?= $status == 20 ? ' selected' : '' ?>>Выполнено</option>
                        <option value="40">Запланировано</option>
                    </select>
                    <br>
                    <div><a href="javascript:void(0);" title="" data-role="check-all">Показать все</a> | <a href="javascript:void(0);" title="" data-role="check-none">Скрыть все</a></div>
                    <ul class="category-list">
                        <?php foreach ($category as $val): ?>
                        <li>
                            <label>
                                <input type="checkbox" name="category[]" value="<?= $val->item_id ?>" checked> <img src="/assets/img/points/<?= $val->item_icon ?>" class="point" alt=""> <?= $val->item_name ?>
                            </label>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div id="globalmap"></div>
            </section>
        </main>
        <?php include_once VIEWPATH . 'sections/footer.inc.php'; ?>
        <style>
            footer {display: none}
        </style>
        <link type="text/css" rel="stylesheet" href="/assets/components/leaflet/css/leaflet.css" />
        <link type="text/css" rel="stylesheet" href="/assets/components/leaflet/css/control.draw.css" />
        <link type="text/css" rel="stylesheet" href="/assets/components/leaflet/css/control.measure.css" />
        <link type="text/css" rel="stylesheet" href="/assets/components/leaflet/css/control.geosearch.css" />
        <link type="text/css" rel="stylesheet" href="/assets/components/leaflet/css/custom.leaflet.css" />
        
        <script type="text/javascript" src="/assets/components/leaflet/leaflet.js"></script>
        <script type="text/javascript" src="/assets/components/leaflet/layer/layer.deferred.js"></script>
        <script type="text/javascript" src="/assets/components/leaflet/plugins/l.control.draw.js"></script>
        <script type="text/javascript" src="/assets/components/leaflet/plugins/l.control.measure.js"></script>
        
        <script type="text/javascript" src="/assets/js/app.maputils.js"></script>
        <script type="text/javascript" src="/assets/js/jquery.selectric.min.js"></script>
        
        <script>
            var page_url = 'map',
                latitude  = '51.7727',
                longitude = '55.0988',
                status    = <?= $status ?>;
            
            $(document).ready(function() {
                $('select').selectric();
                
                $("input[name='category[]']").change(function() {
                    checkbox = $(this);
                    if (checkbox.is(':checked')) {
                        MapUtils.Methods.showMapLayer($(this).val());
                    } else {
                        MapUtils.Methods.hideMapLayer($(this).val());
                    }
                });

                $(document).on("change", "#point-status", function() {
                    MapUtils.Methods.getGeoJson($(this).val());
                });
                
                // Инициализация карты
                MapUtils.Methods.InitMap();
                
                // Выключение режима редактирования
                $("[data-role='map-cancel-edit']").click(function() {
                    MapUtils.Methods.stopEditMode();
                });
                // АВТОМАТИЧЕСКОЕ ВКЛЮЧЕНИЕ режима редактирования
                if (window.location.hash.match(new RegExp('[#]create', 'i'))) {
                    MapUtils.Methods.startEditMode();
                    MapUtils.Var.mapObject.on('click', MapUtils.Methods.EditMode);
                }
                // ВКЛЮЧЕНИЕ режима редактирования
                $("[data-role='add-place']").click(function() {
                    MapUtils.Methods.startEditMode();
                    MapUtils.Var.mapObject.on('click', MapUtils.Methods.EditMode);
                });

                // ПОКАЗАТЬ \ СКРЫТЬ все отметки фильтра
                $("[data-role='check-none']").click(function() {
                    var checkboxes = $('.category-list').find(':checkbox');
                    checkboxes.prop('checked', false);
                    for (var i = 1; i < checkboxes.length; i++) {
                        MapUtils.Methods.hideMapLayer(checkboxes[i].defaultValue);
                    }
                });
                $("[data-role='check-all']").click(function() {
                    var checkboxes = $('.category-list').find(':checkbox');
                    checkboxes.prop('checked', true);
                    for (var i = 1; i < checkboxes.length; i++) {
                        MapUtils.Methods.showMapLayer(checkboxes[i].defaultValue);
                    }
                });
            });
        </script>
    </body>
</html>
<?php

/* End of file main.php */
/* Location: /application/views/main.php */ 