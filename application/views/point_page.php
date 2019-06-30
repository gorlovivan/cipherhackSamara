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

?>      
    <div class="demo-overlay" style="display: none"></div>
    <div class="demo-modal" style="display: none">
        <div class="box-content data-form">
            <h2>Изменение статуса</h2>
            <select>
                <option>В работе</option>
                <option>Выполнено</option>
                <option>Отклонено</option>
                <option>Запланировано</option>
                <option>Мотивированный отказ</option>
            </select>
            <br>
            <dl class="flt-lbl-box">
                <dt>Описание</dt>
                <dd>
                    <textarea name="item_message" rows="3" class="ui-inputfield flt-lbl-inp flt_lbl_inp"></textarea>
                </dd>
            </dl>
                        <div id="drag-and-drop-zone" class="dm-uploader p-5">
                            <h3 class="mb-5 mt-5 text-muted">Перетащите файлы в эту область</h3>
                            <div class="btn btn-primary btn-block mb-5">
                                <span>Или выберите их</span>
                                <input type="file" title='' />
                            </div>
                        </div>
                <div class="align-right">
                    <br>
                    <a href="javascript://" class="btn btn-primary" onclick="$('.demo-overlay,.demo-modal').hide();" data-role="save"><i class="fa fa-check"></i> Сохранить</a> 
                    <a href="javascript://" class="btn btn-warning" onclick="$('.demo-overlay,.demo-modal').hide();" data-role="cancel">Отмена</a>
                </div>
        </div>
    </div>
    <div class="demo-overlay2" style="display: none"></div>
    <div class="demo-modal2" style="display: none">
        <div class="box-content data-form">
            <h2>Делегирование заявки</h2>
            <select id="point-category" name="item_category">
                <option>- выберите категорию -</option>
                <?php foreach ($category as $val): ?>
                <option value="<?= $val->item_id ?>"><?= $val->item_name ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <select>
                <option value="0">- управляющая компания -</option>
                <option>УК «ЦЖКУ»</option>
                <option>УК «ГУЖФ»</option>
                <option>УК «ПИК-Комфорт»</option>
                <option>УК «ЮНИ-ДОМ»</option>
                <option>УК «Текстильщики»</option>
            </select>
            <br>
            <div class="key-value-list">
                            <div class="key-value-item">
                                <div class="key">Название</div>
                                <div class="value">УК «ПИК-Комфорт»</div>
                            </div>
                            <div class="key-value-item">
                                <div class="key">Домов</div>
                                <div class="value">32</div>
                            </div>
                            <div class="key-value-item">
                                <div class="key">Адрес</div>
                                <div class="value">ул. Спартаковская, д. 2Б</div>
                            </div>
                            <div class="key-value-item">
                                <div class="key">Телефоны</div>
                                <div class="value"><a href="tel:+79263148764">8 (926) 314-87-64</a></div>
                            </div>
                            <div class="key-value-item">
                                <div class="key">Email</div>
                                <div class="value"><a href="maito:pikcomfor@mail.ya">pikcomfor@mail.ya</a></div>
                            </div>
                            <div class="key-value-item">
                                <div class="key">Веб-сайт</div>
                                <div class="value"><a href="#">pik-komfort.ya</a></div>
                            </div>
                            <div class="key-value-item">
                                <div class="key">ИНН</div>
                                <div class="value">7701208190</div>
                            </div>
                            <div class="key-value-item">
                                <div class="key">ОГРН</div>
                                <div class="value">1027700082266</div>
                            </div>
            </div>
                <div class="align-right">
                    <br>
                    <a href="javascript://" class="btn btn-primary" onclick="$('.demo-overlay2,.demo-modal2').hide();" data-role="save"><i class="fa fa-check"></i> Сохранить</a> 
                    <a href="javascript://" class="btn btn-warning" onclick="$('.demo-overlay2,.demo-modal2').hide();" data-role="cancel">Отмена</a>
                </div>
        </div>
    </div>
    <main class="point-page">
            <section class="wrapper">
                <div class="row">
                    <div class="col-md-6">
                        <h1 class="no-margin"><?= $point->item_name ?></h1>
                        <h3><?= $point->item_address ?></h3>
                    </div>
                    <div class="col-md-6 align-right">
                        <?php if ( ! isset($_GET['admin'])): ?>
                        <br>
                        <script type="text/javascript" src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js" charset="utf-8"></script>
                        <script type="text/javascript" src="//yastatic.net/share2/share.js" charset="utf-8"></script>
                        <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,gplus,twitter" data-counter=""></div>
                        
                        <span class="like-point"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <?= rand(0, 12); ?> Подтвердили</span>
                        <?php else: ?>
                        <br>
                        <a href="#" onclick="$('.demo-overlay,.demo-modal').show();" class="btn btn-primary"><i class="fa fa-refresh" aria-hidden="true"></i> Изменить статус</a> 
                        <a href="#" onclick="$('.demo-overlay2,.demo-modal2').show();" class="btn btn-primary"><i class="fa fa-user-o" aria-hidden="true"></i> Ответственный</a> 
                        <a href="#" onclick="$('.demo-overlay,.demo-modal').show();" class="btn btn-warning"><i class="fa fa-hourglass" aria-hidden="true"></i> История</a> 
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row point no-margin">
                    <div class="col-md-8" style="padding-right: 15px;">
                        <div class="box-content" style="padding: 0;">
                            <?php
                                $photo = $point->item_filename ? explode('.', $point->item_filename) : '/assets/img/nophoto.png';
                                $photo = (is_array($photo) ? '/uploads/' . $point->item_id . '/' . $photo[0] . '.' . $photo[1] : '/assets/img/nophoto.png');
                            ?>
                            <img src="<?= $photo ?>" alt="<?= $point->item_name ?>" <?= isset($_GET['admin']) ? 'style="height: 624px"' : '' ?> class="photo" />
                        </div>
                    </div>
                    <div class="col-md-4" style="padding-right: 0;">
                        <?php if (isset($_GET['admin'])): ?>
                        <div class="box-content key-value-list">
                            <h3>Исполнитель</h3>
                            <div class="key-value-item">
                                <div class="key">Название</div>
                                <div class="value">УК «ПИК-Комфорт»</div>
                            </div>
                            <div class="key-value-item">
                                <div class="key">Домов</div>
                                <div class="value">32</div>
                            </div>
                            <div class="key-value-item">
                                <div class="key">Адрес</div>
                                <div class="value">ул. Спартаковская, д. 2Б</div>
                            </div>
                            <div class="key-value-item">
                                <div class="key">Телефоны</div>
                                <div class="value"><a href="tel:+79263148764">8 (926) 314-87-64</a></div>
                            </div>
                            <div class="key-value-item">
                                <div class="key">Email</div>
                                <div class="value"><a href="maito:pikcomfor@mail.ya">pikcomfor@mail.ya</a></div>
                            </div>
                            <div class="key-value-item">
                                <div class="key">Веб-сайт</div>
                                <div class="value"><a href="#">pik-komfort.ya</a></div>
                            </div>
                            <div class="key-value-item">
                                <div class="key">ИНН</div>
                                <div class="value">7701208190</div>
                            </div>
                            <div class="key-value-item">
                                <div class="key">ОГРН</div>
                                <div class="value">1027700082266</div>
                            </div>
                        </div>
                        <?php endif; ?>
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
                        <?php if ( ! isset($_GET['admin'])): ?>
                        <div class="box-content"  style="padding: 0;">
                            <div id="placemap" style="width: 100%; height: 280px;"></div>
                        </div>
                        <?php endif; ?>
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
                        <?php if (isset($_GET['admin'])): ?>
                        <div class="box-content"  style="padding: 0;">
                            <div id="placemap" style="width: 100%; height: 280px;"></div>
                        </div>
                        <?php endif; ?>
                <div class="row no-margin">
                    <div class="col-md-8" style="padding-right: 15px;">
                        <div class="box-content">
                            <p><?= $point->item_message ?></p>
                        </div>
                    </div>
                    <div class="col-md-4" style="padding-right: 0;">
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
        <script type="text/javascript" src="/assets/js/jquery.selectric.min.js"></script>
        <script>
            $(document).ready(function() {
                $('select').selectric();
                
                    var map = L.map('placemap', {
                        center: [<?= $point->item_latitude ?>,<?= $point->item_longitude ?>],
                        zoom: 13,
                    });

                    var placeIcon = L.icon({
                        iconUrl: '/assets/img/points/<?= $point->item_icon ?>',
                        iconSize: [20, 23],
                        iconAnchor: [10, 23],
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