<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Point form page template
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   template
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */

include_once VIEWPATH . 'sections/header.inc.php';
?>      <main>
            <section class="wrapper">
                <div class="box corners shadow data-form">
                    <div class="box-content">
                        <form action="/form/point/<?= $data->item_id ?>" id="form-point" enctype="multipart/form-data" method="post">
                            <input type="hidden" name="item_latitude" id="latitude" value="<?= $data->item_latitude ?>">
                            <input type="hidden" name="item_longitude" id="longitude" value="<?= $data->item_longitude ?>">
                            <div class="form-group">
                                <select id="point-category" name="item_category" class="form-control">
                                    <?php foreach ($category as $val): ?>
                                    <option value="<?= $val->item_id ?>"<?= ($data->item_category == $val->item_id) ? " selected" : NULL ?>><?= $val->item_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <br>
                            <div class="form-group">
                                <select id="point-subcategory" name="item_subcategory" class="form-control">
                                    <?php foreach ($subcat as $val): ?>
                                    <option value="<?= $val->item_id ?>"<?= ($data->item_subcategory == $val->item_id) ? " selected" : NULL ?>><?= $val->item_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <br>
                            <dl class="flt-lbl-box button-inline">
                                <dt>Адрес</dt>
                                <dd>
                                    <input type="text" name="item_address" value="<?= $data->item_address ?>" class="ui-inputfield flt-lbl-inp flt_lbl_inp" />
                                    <a href="javascript:void(0)" class="btn btn-success" data-role="geocode" title=""><i class="fa fa-search"></i> Определить адрес</a>
                                </dd>
                            </dl>
                            <div id="placemap" style="width: 100%; height: 280px;"></div>
                            <br>
                            <dl class="flt-lbl-box">
                                <dt>Текст обращения<div class="hide-hint">Опишите суть проблемы</div></dt>
                                <dd>
                                    <textarea name="item_message" rows="6" class="ui-inputfield flt-lbl-inp flt_lbl_inp"><?= $data->item_message ?></textarea>
                                </dd>
                            </dl>
                        </form>
                        <div class="photo-container">
                            <?php if ( ! empty($photos) && is_array($photos)): ?>
                            <?php foreach ($photos as $photo): ?>
                                <?php
                                    $image = $photo->item_filename ? explode('.', $photo->item_filename) : '/assets/img/nophoto.png';
                                    $image = (is_array($image) ? '/uploads/' . $photo->item_point . '/' . $image[0] . '_thumb.' . $image[1] : '/assets/img/nophoto.png');
                                ?>
                                <div class="photo">
                                    <a href="javascript:void(0);" data-role="photo-remove" data-id="<?= $photo->item_id ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                                    <img src="<?= $image ?>" alt="" />
                                </div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <?php if (count($photos) < config_item('max_photo_upload')): ?>
                        <div id="drag-and-drop-zone" class="dm-uploader p-5">
                            <h3 class="mb-5 mt-5 text-muted">Для загрузки фотографий перетащите их в эту область</h3>
                            <div class="btn btn-primary btn-block mb-5">
                                <span>Или выберите их</span>
                                <input type="file" title='' />
                            </div>
                        </div>
                        <script type="text/html" id="files-template">
                            <li class="media">
                                <div class="media-body mb-1">
                                    <p class="mb-2">
                                        <strong>%%filename%%</strong> - Status: <span class="text-muted">Waiting</span>
                                    </p>
                                    <div class="progress mb-2">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <hr class="mt-1 mb-1" />
                                </div>
                            </li>
                        </script>
                        <?php endif; ?>

                    </div>
                </div>
                <div class="fright">
                    <a href="javascript://" class="btn btn-success" data-role="save"><i class="fa fa-check"></i> Сохранить</a> 
                    <a href="javascript://" class="btn btn-warning" data-role="cancel">Отмена</a>
                </div>
                <div class="clear"></div>
                <br>
                
            </section>
        </main>
        <?php include_once VIEWPATH . 'sections/footer.inc.php'; ?>
        <link type="text/css" rel="stylesheet" href="/assets/components/leaflet/css/leaflet.css" />
        <link type="text/css" rel="stylesheet" href="/assets/components/leaflet/css/custom.leaflet.css" />

        <script type="text/javascript" src="/assets/js/jquery.selectric.min.js"></script>
        <script type="text/javascript" src="/assets/js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="/assets/js/jquery.form.min.js"></script>

        <script type="text/javascript" src="/assets/components/leaflet/leaflet.js"></script>
        <script type="text/javascript" src="/assets/components/leaflet/layer/layer.deferred.js"></script>
        <script type="text/javascript" src="/assets/components/uploader/jquery.dm-uploader.min.js"></script>

        <script>
function ui_add_log(message, color)
{
  var d = new Date();

  var dateString = (('0' + d.getHours())).slice(-2) + ':' +
    (('0' + d.getMinutes())).slice(-2) + ':' +
    (('0' + d.getSeconds())).slice(-2);

  color = (typeof color === 'undefined' ? 'muted' : color);

  var template = $('#debug-template').text();
  template = template.replace('%%date%%', dateString);
  template = template.replace('%%message%%', message);
  template = template.replace('%%color%%', color);
  
  $('#debug').find('li.empty').fadeOut(); // remove the 'no messages yet'
  $('#debug').prepend(template);
}

// Creates a new file and add it to our list
function ui_multi_add_file(id, file)
{
  var template = $('#files-template').text();
  template = template.replace('%%filename%%', file.name);

  template = $(template);
  template.prop('id', 'uploaderFile' + id);
  template.data('file-id', id);

  $('#files').find('li.empty').fadeOut(); // remove the 'no files yet'
  $('#files').prepend(template);
}

// Changes the status messages on our list
function ui_multi_update_file_status(id, status, message)
{
  $('#uploaderFile' + id).find('span').html(message).prop('class', 'status text-' + status);
}

// Updates a file progress, depending on the parameters it may animate it or change the color.
function ui_multi_update_file_progress(id, percent, color, active)
{
  color = (typeof color === 'undefined' ? false : color);
  active = (typeof active === 'undefined' ? true : active);

  var bar = $('#uploaderFile' + id).find('div.progress-bar');

  bar.width(percent + '%').attr('aria-valuenow', percent);
  bar.toggleClass('progress-bar-striped progress-bar-animated', active);

  if (percent === 0){
    bar.html('');
  } else {
    bar.html(percent + '%');
  }

  if (color !== false){
    bar.removeClass('bg-success bg-info bg-warning bg-danger');
    bar.addClass('bg-' + color);
  }
}
            
            
            
            
            function initMap() {
                var map = L.map('placemap', {
                    center: [$('#latitude').val(),$('#longitude').val()],
                    zoom: 13,
                });

                var placeIcon = L.icon({
                    iconUrl: '/assets/img/points/<?= $data->item_icon ?>',
                    iconSize: [35, 37],
                    iconAnchor: [17, 37],
                });

                var osm = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="http://openstreetmap.org">OpenStreetMap</a>'
                    });

                POI = L.marker([$('#latitude').val(),$('#longitude').val()], {icon: placeIcon,draggable:'true'}).addTo(map);

                map.addLayer(osm);
                map.addControl(new L.Control.Layers({'OSM':osm}, {}));

                POI.on('dragend', function(event) {
                    var position = event.target.getLatLng();

                    $('#latitude').val(position.lat.toPrecision(8));
                    $('#longitude').val(position.lng.toPrecision(8));
                });
            }
            
            $(document).ready(function() {
  $('#drag-and-drop-zone').dmUploader({ //
    url: '/form/upload/<?= $data->item_id ?>',
    maxFileSize: 8000000, // 8 Megs 
    onDragEnter: function(){
      // Happens when dragging something over the DnD area
      this.addClass('active');
    },
    onDragLeave: function(){
      // Happens when dragging something OUT of the DnD area
      this.removeClass('active');
    },
    onInit: function(){
      // Plugin is ready to use
      ui_add_log('Penguin initialized :)', 'info');
    },
    onComplete: function(){
      // All files in the queue are processed (success or error)
      ui_add_log('All pending tranfers finished');
      
    },
    onNewFile: function(id, file){
      // When a new file is added using the file selector or the DnD area
      ui_add_log('New file added #' + id);
      ui_multi_add_file(id, file);
    },
    onBeforeUpload: function(id){
      // about tho start uploading a file
      ui_add_log('Starting the upload of #' + id);
      ui_multi_update_file_status(id, 'uploading', 'Uploading...');
      ui_multi_update_file_progress(id, 0, '', true);
    },
    onUploadCanceled: function(id) {
      // Happens when a file is directly canceled by the user.
      ui_multi_update_file_status(id, 'warning', 'Canceled by User');
      ui_multi_update_file_progress(id, 0, 'warning', false);
    },
    onUploadProgress: function(id, percent){
      // Updating file progress
      ui_multi_update_file_progress(id, percent);
    },
    onUploadSuccess: function(id, data){
      // A file was successfully uploaded
      ui_add_log('Server Response for file #' + id + ': ' + JSON.stringify(data));
      ui_add_log('Upload of file #' + id + ' COMPLETED', 'success');
      ui_multi_update_file_status(id, 'success', 'Upload Complete');
      ui_multi_update_file_progress(id, 100, 'success', false);
      
      var obj = JSON.parse(data);
      
        if (obj.code == 'luck') {
            $(".photo-container").append('<div class="photo"><a href="javascript:void(0);" data-role="photo-remove" data-id="' + obj.id + '"><i class="fa fa-times" aria-hidden="true"></i></a><img src="' + obj.image + '" alt="" /></div>');
        } else {
            App.Methods.Alert(obj.text);
        }
    },
    onUploadError: function(id, xhr, status, message){
      ui_multi_update_file_status(id, 'danger', message);
      ui_multi_update_file_progress(id, 0, 'danger', false);  
    },
    onFallbackMode: function(){
      // When the browser doesn't support this plugin :(
      ui_add_log('Plugin cant be used here, running Fallback callback', 'danger');
    },
    onFileSizeError: function(file){
      ui_add_log('File \'' + file.name + '\' cannot be added: size excess limit', 'danger');
    }
  });
  
        // Изменение выбора выпадающих списков категории \ подкатегории
        $(document).on("click", "[data-role='photo-remove']", function() {
            var photo_id = $(this).attr('data-id'),
                container = $(this).parent();

            if (App.Methods.Confirm('Удалить фотографию?')) {
                jQuery.getJSON('/form/photo_remove/' + photo_id, function(json) {
                    if (json.code == 'luck') {
                        container.remove();
                    } else {
                        App.Methods.Alert(json.text);
                    }
                });
            }
        });
  
                
                $('select').selectric();

                initMap();

        // Изменение выбора выпадающих списков категории \ подкатегории
        $(document).on("change", "#point-category", function() {
            jQuery.getJSON('/' + page_url + '/get_subcategory/' + $(this).val(), function(json) {
                $('#point-subcategory').text('').removeClass('disabled');
                $.each(json.data, function(key, value) {
                    $('#point-subcategory').append($("<option></option>").attr("value", value.item_id).text(value.item_name)); 
                });
                
                $('select').selectric();
            });
        });

                $("[data-role='geocode']").click(function() {
                    var lat = $('#latitude').val();
                    var lon = $('#longitude').val();

                    $('input[name="item_address"]').addClass('ui-autocomplete-loading');

                    if (lat == '' || lon == '') return ;

                    $(this).prop('disabled', true);

                    $.getJSON('/form/geocode?lat=' + lat + '&lon=' + lon, function(json) {
                        $('input[name="item_address"]').removeClass('ui-autocomplete-loading');
                        console.log('json', json);
                        if (json.code == 'luck') {
                            alert('Адрес определен');
                            $('input[name="item_address"]').val(json.address);
                        }
                    });
                });
                
                
    $("#form-point").validate({
        rules: {
            item_message: {required: true},
            item_address: {required: true},
            item_latitude: {required: true},
            item_longitude: {required: true},
        },
        messages: {
            item_message: {required: "Введите описание проблемы"},
            item_address: {required: "Укажите адрес"},
            item_latitude: {required: "Задайте координаты интересного места"},
            item_longitude: {required: "Задайте координаты интересного места"},
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                dataType: "json",
                beforeSubmit: function() {
                    $("a[data-role='cancel']").attr('disabled', true);
                    $("a[data-role='save']").attr('disabled', true);
                    $("a[data-role='save']").children().removeClass("fa-check").addClass("fa-spinner fa-spin");
                    return;
                },
                success: function(data) {
                    if (data.code == 'luck') {
                        window.location = '/points/id/' + data.item;
                    } else {
                        $("a[data-role='cancel']").attr('disabled', false);
                        $("a[data-role='save']").attr('disabled', false);
                        $("a[data-role='save']").children().removeClass("fa-spinner fa-spin").addClass("fa-check");
                        alert(data.text);
                    }
                }
            });
        },
        invalidHandler: function(event, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {
                var message = errors == 1
                        ? 'Вы пропустили 1 одно поле. Исправьте ошибку'
                        : 'Вы пропустили несколько полей (' + errors + '). Исправьте ошибки';
                var test = {code: "error", text: message};
                alert(test.text);
            } else {
                //$('.alert').fadeOut();
            }
        },
    });

    $("a[data-role='save']").click(function() {
        $('#form-point').submit();
    });

    $("a[data-role='cancel']").click(function() {
        $('#form-point').resetForm();
    });
    
                
            });
        </script>
    </body>
</html>
<?php

/* End of file main.php */
/* Location: /application/views/main.php */ 