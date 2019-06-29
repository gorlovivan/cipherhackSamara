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

$status = convert_status($point->item_status);

?>      <main class="point-page">
            <section class="wrapper">
                <div class="row">
                    <div class="col-md-8">
                        <h1 class="no-margin"><?= $point->item_name ?></h1>
                        <h3><?= $subcat[$point->item_subcategory]->item_name ?></h3>
                    </div>
                    <div class="col-md-4 align-right">
                        <br>
                        <script type="text/javascript" src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js" charset="utf-8"></script>
                        <script type="text/javascript" src="//yastatic.net/share2/share.js" charset="utf-8"></script>
                        <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,gplus,twitter" data-counter=""></div>
                    </div>
                </div>
                <div class="row point no-margin">
                    <div class="col-md-8" style="padding-right: 15px;">
                        <div class="box-content" style="padding: 0;">
                            <?php
                                $photo = $point->item_filename ? explode('.', $point->item_filename) : '/assets/img/nophoto.png';
                                $photo = (is_array($photo) ? '/uploads/' . $point->item_id . '/' . $photo[0] . '.' . $photo[1] : '/assets/img/nophoto.png');
                            ?>
                            <img src="<?= $photo ?>" alt="<?= $point->item_name ?>" class="photo" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box-content key-value-list">
                            <div class="key-value-item">
                                <div class="key">Статус</div>
                                <div class="value"><span class="alert alert-<?= $status['code'] ?>"><?= $status['text'] ?></span></div>
                            </div>
                            <div class="key-value-item">
                                <div class="key">Инициатор</div>
                                <div class="value"><?= $user->user_lastname ?> <?= $user->user_firstname ?></div>
                            </div>
                            <div class="key-value-item">
                                <div class="key">Создано</div>
                                <div class="value"><?= formatdate((int) $point->item_timestamp) ?></div>
                            </div>
                            <div class="key-value-item">
                                <div class="key">Просмотров</div>
                                <div class="value"><?= $point->item_views ?></div>
                            </div>
                        </div>
                        <div class="box-content"  style="padding: 0;">
                            <div id="placemap" style="width: 100%; height: 280px;"></div>
                        </div>
                    </div>
                </div>
                <div class="photo-container">
                    <?php if ( ! empty($media) && is_array($media) && count($media) > 1): ?>
                    <?php foreach ($media as $photo): ?>
                        <?php 
                            $image = explode('.', $photo->item_filename);
                        ?>
                        <div class="photo">
                            <a style="padding: 0;" data-lightbox="photos" href="/uploads/<?= $photo->item_point ?>/<?= $image[0] ?>.<?= $image[1] ?>" title=""><img src="/uploads/<?= $photo->item_point ?>/<?= $image[0] ?>_thumb.<?= $image[1] ?>" alt="" /></a>
                        </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="row no-margin">
                    <div class="col-md-8" style="padding-right: 15px;">
                        <div class="box-content">
                            <h3><?= $point->item_address ?></h3>
                            <p><?= $point->item_message ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box-content key-value-list">
                            <h3>История изменения статусов</h3>
                        <?php if ( ! empty($states) && is_array($states)): ?>
                        <?php foreach ($states as $item): ?>
                        <?php $tmp = convert_status($item->item_status) ?>
                            <div class="key-value-item">
                                <div class="key" style="width: 55%;"><span class="alert alert-<?= $tmp['code'] ?>"><?= $tmp['text'] ?></span></div>
                                <div class="value"><?= formatdate((int) $item->item_timestamp) ?></div>
                            </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <?php include_once VIEWPATH . 'sections/footer.inc.php'; ?>
        <link type="text/css" rel="stylesheet" href="/assets/css/lightbox.min.css" />
        <link type="text/css" rel="stylesheet" href="/assets/components/leaflet/css/leaflet.css" />
        <link type="text/css" rel="stylesheet" href="/assets/components/leaflet/css/custom.leaflet.css" />

        <script type="text/javascript" src="/assets/js/lightbox.min.js"></script>
        <script type="text/javascript" src="/assets/components/leaflet/leaflet.js"></script>
        <script type="text/javascript" src="/assets/components/leaflet/layer/layer.deferred.js"></script>
        <script>
            $(document).ready(function() {
                    var map = L.map('placemap', {
                        center: [<?= $point->item_latitude ?>,<?= $point->item_longitude ?>],
                        zoom: 13,
                    });

                    var placeIcon = L.icon({
                        iconUrl: '/assets/img/points/<?= $point->item_icon ?>',
                        iconSize: [35, 37],
                        iconAnchor: [17, 37],
                    });

                    var osm = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="http://openstreetmap.org">OpenStreetMap</a>'
                        });

                    POI = L.marker([<?= $point->item_latitude ?>,<?= $point->item_longitude ?>], {icon: placeIcon}).addTo(map);

                    map.addLayer(osm);
                    map.addControl(new L.Control.Layers({'OSM':osm}, {}));

            });
        </script>
    </body>
</html>
<?php

/* End of file points.php */
/* Location: /application/views/points.php */ 