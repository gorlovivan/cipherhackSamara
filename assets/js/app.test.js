/**
 * @package    codeigniter
 * @subpackage project
 * @category   javascript
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */

// Глобальное пространство имён
var MapUtils = MapUtils || {};

/*
 * Массив слоев для карты
 * @type object
 */
MapUtils.layers = {
    /*
     * Карта OpenStreetMap
     * @type object
     */
    osm: {
        name: "OSM",
        js: [],
        init: function() {
            return new L.TileLayer('//{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: 'Map data &copy; <a href="//openstreetmap.org">OpenStreetMap</a>'
            });
        }
    },
    /*
     * Карта OpenCycleMap
     * @type object
     */
    ocm: {
        name: "OCM",
        js: [],
        init: function() {
            return new L.TileLayer('//{s}.tile.opencyclemap.org/cycle/{z}/{x}/{y}.png', {
                attribution: 'Map data &copy; <a href="//opencyclemap.org">OpenCycleMap</a>'
            });
        }
    },
    /*
     * Спутник Google
     * @type object
     */
    gsat: {
        name: "Google",
        js: [
            "/assets/components/leaflet/layer/tile/google.js",
            "//maps.google.com/maps/api/js?v=3.2&sensor=false&callback=L.Google.asyncInitialize"
        ],
        init: function() {
            return new L.Google();
        }
    },
    /*
     * Спутник Яндекс
     * @type object
     */
    ysat: {
        name: "Yandex",
        js: [
            "/assets/components/leaflet/layer/tile/yandex.js",
            "//api-maps.yandex.ru/2.1/?load=Map&lang=ru_RU"
        ],
        init: function() {
            return new L.Yandex("satellite");
        }
    },
    /*
     * Народная карта Яндекс
     * @type object
     */
    nyak: {
        name: "Карта Яндекс", js: [
            "/assets/components/leaflet/layer/tile/yandex.js",
            "//api-maps.yandex.ru/2.1/?load=Map&lang=ru_RU"
        ],
        init: function() {
            return new L.Yandex("publicMap");
        }
    },
    /*
     * OpenTopoMap
     * @type object
     */
    otp: {
        name: "OpenTopoMap",
        js: [],
        init: function() {
            return new L.TileLayer('//{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
                attribution: 'Map data &copy; <a href="//opentopomap.org">OpenTopoMap</a>'
            });
        }
    },
    /*
     * Оверлей карты с пробками Яндекса (не работает)
     * @type object
     */
    traffic: {
        name: "Пробки",
        js: [
            "/assets/components/leaflet/layer/tile/yandex.js",
            "//api-maps.yandex.ru/2.1/?load=Map&lang=ru_RU"
        ],
        init: function() {
            return new L.Yandex("null", {
                traffic: true,
                opacity: 0.8,
                overlay: true
            });
        },
        overlay: true
    },
    /*
     * Оверлей карты высот
     * @type object
     */
    hillmap: {
        name: "Рельеф",
        js: [],
        init: function() {
            return new L.TileLayer('//{s}.tiles.wmflabs.org/hillshading/{z}/{x}/{y}.png', {
                attribution: 'Hillshading: SRTM3 v2 (<a href="//www2.jpl.nasa.gov/srtm/">NASA</a>)',
                opacity: 1,
            });
        }
    },
}
// Стандартные свойста
MapUtils.Var = {
    mapObject: '', // объект карты
    mapContainer: 'globalmap', // ID контейнера карты
    mapEditMode: false, // Режим редактирования карты
    layergroups: [], // Группы слоев карты,
    formTemplate: '', // Переменная шаблона формы создания точки
    layerDraw: new L.FeatureGroup()
};
MapUtils.Methods = {
    /**
     * Создание объекта карты
     * @returns object
     */
    InitMap: function() {
	/*
	* L.TileLayer.Rosreestr
	*/
	+function() {
            var addTileUrlMixin = function(BaseClass) {
            return BaseClass.extend({
                options: {
                    tileSize: 1024
                },

                getTileUrl: function (tilePoint) {
                    map = this._map,
                        crs = map.options.crs,
                        tileSize = this.options.tileSize,
                        nwPoint = tilePoint.multiplyBy(tileSize),
                        sePoint = nwPoint.add([tileSize, tileSize]);

                    var nw = crs.project(map.unproject(nwPoint, tilePoint.z)),
                        se = crs.project(map.unproject(sePoint, tilePoint.z)),
                        bbox = [nw.x, se.y, se.x, nw.y].join(',');

                    return L.Util.template(this._url, L.extend({
                        s: this._getSubdomain(tilePoint),
                        bbox: bbox
                    }, this.options));
                }
            })
            };

            var addInteractionMixin = function(BaseClass) {
            return BaseClass.extend({
                onAdd: function (map) {
                    L.TileLayer.prototype.onAdd.call(this, map);
                    if (this.options.clickable) {
                        L.DomUtil.addClass(this._container, 'leaflet-clickable-raster-layer');
                        if (this._needInitInteraction) {
                            this._initInteraction();
                            this._needInitInteraction = false;
                        }
                    }
                },
                _needInitInteraction: true,

                _initInteraction: function () {
                    var div = this._container,
                        events = ['dblclick', 'click', 'mousedown', 'mouseover', 'mouseout', 'contextmenu'];

                    for (var i = 0; i < events.length; i++) {
                        L.DomEvent.on(div, events[i], this._fireMouseEvent, this);
                    }
                },
                _fireMouseEvent: function (e) {
                    map = this._map;
                    if (map.dragging && map.dragging.moved()) { return; }

                    var containerPoint = map.mouseEventToContainerPoint(e),
                        layerPoint = map.containerPointToLayerPoint(containerPoint),
                        latlng = map.layerPointToLatLng(layerPoint);

                    this.fire(e.type, {
                        latlng: latlng,
                        layerPoint: layerPoint,
                        containerPoint: containerPoint,
                        originalEvent: e
                    });
                }
            })
            };
            L.TileLayer.Rosreestr = addTileUrlMixin(L.TileLayer);

            L.tileLayer.Rosreestr = function (url, options) {
            if (options.clickable) {
                L.TileLayer.Rosreestr = addInteractionMixin(L.TileLayer.Rosreestr);
            }
            return new L.TileLayer.Rosreestr(url, options);
            };
	}();
        
        var hashtype   = MapUtils.Methods.getHashParam('t'),
            hashcenter = MapUtils.Methods.getHashParam('c'),
            hashzoom   = MapUtils.Methods.getHashParam('z');
    
	//var kadastr    = L.tileLayer.Rosreestr('http://{s}.pkk5.rosreestr.ru/arcgis/rest/services/Cadastre/Cadastre/MapServer/export?dpi=96&transparent=true&format=png32&bbox={bbox}&size=1024,1024&bboxSR=102100&imageSR=102100&f=image', {
	var kadastr    = L.tileLayer.Rosreestr('https://{s}pkk5.rosreestr.ru/arcgis/rest/services/Cadastre/Cadastre/MapServer/export?layers=show%3A0%2C1%2C2%2C4%2C5%2C6%2C7%2C8%2C9%2C10%2C11%2C12%2C13%2C14%2C15%2C16%2C17%2C18%2C19%2C20%2C23%2C24%2C29%2C30%2C31%2C32%2C33%2C34%2C35%2C38%2C39&dpi=96&format=PNG32&bbox={bbox}&bboxSR=102100&imageSR=102100&size=1024%2C1024&transparent=true&f=image', {
	    tileSize: 1024,
	    clickable: true,
	    attribution: 'Кадастровая карта',
            subdomains: ['a', 'b', 'c', 'd'],
            opacity: .7,
	});

        MapUtils.Var.mapObject = L.map(MapUtils.Var.mapContainer, {
            center: (hashcenter ? hashcenter.split(',') : [latitude, longitude]),
            zoom: (hashzoom ? hashzoom : 13),
            /*minZoom: 8, 
            maxZoom: 17,*/
        });
        
        L.Icon.Default.imagePath = '/assets/components/leaflet/images/';

        var osm  = new L.DeferredLayer(MapUtils.layers.osm),
            ocm  = new L.DeferredLayer(MapUtils.layers.ocm),
            otp  = new L.DeferredLayer(MapUtils.layers.otp),
            bing = new L.DeferredLayer(MapUtils.layers.bingsat),
            gsat = new L.DeferredLayer(MapUtils.layers.gsat),
            ysat = new L.DeferredLayer(MapUtils.layers.ysat),
            nyak = new L.DeferredLayer(MapUtils.layers.nyak),
            hmap = new L.DeferredLayer(MapUtils.layers.hillmap);

        MapUtils.Var.mapObject.addLayer(osm);
        MapUtils.Var.mapObject.addControl(new L.Control.Layers({
            'Open Street Map': osm, 
            'Open Cycle Map' : ocm, 
            'Open Topo Map'  : otp, 
            'Карты Яндекс'   : nyak, 
            //'Спутник Bing' : bing,
            'Спутник Google' : gsat, 
            'Спутник Яндекс' : ysat
        }, {
            'Рельеф местности': hmap,
            'Кадастровая карта': kadastr,
        }, {
            collapsed: true
        }));

        MapUtils.Var.mapObject.addControl(new L.Control.measureControl());
        MapUtils.Var.mapObject.addControl(new L.Control.Draw({
            draw: {
                position: 'topleft',
                polygon: true,
                polyline: {
                    metric: true,
                    shapeOptions: {
                        color: 'blue',
                        weight: 4
                    }
                },
                circle: false,
                rectangle: false,
            },
            edit: {
                featureGroup: MapUtils.Var.layerDraw
            }
        }));

        MapUtils.Var.mapObject.on('draw:created', MapUtils.Methods.eventDrawCreated);

        // Получить geoJson объекты
        MapUtils.Methods.getGeoJson((typeof status != 'undefined' && status) ? status : null);

        $('#' + MapUtils.Var.mapContainer).height(
            $(window).height() - $('header').height() - 1
        );
//        $('#' + MapUtils.Var.mapContainer).width(
//            $(window).width() - $('#sidebarmap').width()
//        );

        // Обновление размеров карты
        MapUtils.Var.mapObject.invalidateSize();

        // Добавление события загрузки слоя на карту
        MapUtils.Var.mapObject.on('overlayadd', this.eventOverlayAdd);

        // Добавление события перемещение по карте
        MapUtils.Var.mapObject.on('moveend', this.eventMoveEnd);
    }, // InitMap: function()
    /**
     * Обновление данных при окончании рисования объектов
     * @param object e
     * @returns void
     */
    eventDrawCreated: function(e) {
        var type  = e.layerType,
            layer = e.layer;

        if (type === 'polygon') {
            MapUtils.Var.layerDraw.clearLayers();
            MapUtils.Var.layerDraw.addLayer(e.layer);
        }

        var shapes = [];
        shapes = {
            "type": "FeatureCollection",
            "features": []
        };
        
        MapUtils.Var.layerDraw.eachLayer(function (layer) {
            shapes["features"].push(MapUtils.Methods.geojson_line(layer));
        });

console.log(JSON.stringify(shapes));

        MapUtils.Var.layerDraw.addLayer(layer);
    }, // eventDrawCreated: function(e)
    /**
     * Преобразование объека polyline в geojson string
     * @return string
     */
    geojson_line: function(o) {
        var temp_coords = [];
        $.each(o.getLatLngs(), function(index,value) {
            for (var i = 0; i < value.length; i++) {
                temp_coords.push([value[i].lng.toPrecision(7), value[i].lat.toPrecision(7)]);
            }
        });
        
        result = {
            "type": "Feature",
            "geometry": {
                "type": "Polygon",
                "coordinates": temp_coords
            },
        };
        
        return result;
    }, // geojson_line: function(o)
    /**
     * Обращение к серверу и загрузка geoJson объектов
     * @returns void
     */
    getGeoJson: function(status = '') {
        // Очищяем только маркеры
        MapUtils.Var.mapObject.eachLayer(function (layer) {
            if (layer.options.pane === 'markerPane') {
                MapUtils.Var.mapObject.removeLayer(layer);
            }
        });
        
        jQuery.getJSON('/' + page_url + '/get_geojson?status=' + status, function(json) {
            L.geoJson(json, {
                pointToLayer: function(feature, latlng) {
                    var smallIcon = L.icon({
                        iconSize: [20, 23],
                        iconAnchor: [10, 23],
                        iconUrl: feature.options.iconImageHref
                    });
                    return L.marker(latlng, {icon: smallIcon, title: feature.properties.hintContent});
                },
                onEachFeature: function (feature, featureLayer) {
                    var lg = MapUtils.Var.layergroups[feature.properties.objectType];

                    if (lg === undefined) {
                        lg = new L.layerGroup();
                        //add the layer to the map
                        lg.addTo(MapUtils.Var.mapObject);
                        //store layer
                        MapUtils.Var.layergroups[feature.properties.objectType] = lg;
                    }
                    lg.addLayer(featureLayer);

                    featureLayer.bindPopup(function (layer) {
                        return $.ajax({
                            url: '/' + page_url + '/get_info/' + layer.feature.properties.objectid, 
                            async: false,
                            type: "GET",
                        }).responseText;
                    });
                }
            });
        });
    }, // getGeoJson: function()
    /**
     * Установить параметры карты (координаты центра и зум) в зависимости
     * от параметров хеша адресной строки
     * @returns void
     */
    setMapState: function() {
        var hashtype = MapUtils.Methods.getHashParam('t'),
            hashcenter = MapUtils.Methods.getHashParam('c'),
            hashzoom = MapUtils.Methods.getHashParam('z');
        //if (hashtype) {
        //    MapUtils.Var.mapObject.setType('yandex#' + hashType);
        //}
        if (hashzoom) {
            MapUtils.Var.mapObject.setZoom(hashzoom);
        }
        if (hashcenter) {
            MapUtils.Var.mapObject.panTo(hashcenter.split(','));
        }
    }, // setMapState: function()
    /**
     * Режим добавления новых объектов на карту
     * @param object e
     * @returns void
     */
    EditMode: function(e) {
        if (MapUtils.Var.mapEditMode == false)
            return;
        
        var popup = L.popup({minWidth: 300, closeButton: false}).setLatLng([e.latlng.lat, e.latlng.lng]);
        
        // Загрузка шаблона формы создания метки
        popup.setContent(function() {
            if ( ! MapUtils.Var.formTemplate) {
                    MapUtils.Var.formTemplate = $.ajax({
                        url: '/' + page_url + '/get_create_form', 
                        async: false,
                        type: "GET",
                    }).responseText;
                    return MapUtils.Var.formTemplate;
            } else {
                return MapUtils.Var.formTemplate;
            }
        }).openOn(MapUtils.Var.mapObject);
        
        $('select').selectric();
        
        // Обработка события нажатия на кнопку сохранения
        $("[data-role='savepoint']").click(function() {

            $("[data-role='cancelpoint']").attr('disabled', true);
            $(this).attr('disabled', true);
            $(this).children().removeClass("fa-check").addClass("fa-spinner fa-spin");

            var category  = $('#point-category').val(),
                message   = $('#message').val(),
                latitude  = e.latlng.lat.toPrecision(8),
                longitude = e.latlng.lng.toPrecision(8);

            if ( ! category || ! message || ! latitude || ! longitude) {
                $("[data-role='cancelpoint']").attr('disabled', false);
                $(this).attr('disabled', false);
                $(this).children().removeClass("fa-spinner fa-spin").addClass("fa-check");
                App.Methods.Alert('Заполнены не все обязательные поля - укажите название, описание и попробуйте заново');
                
                return ;
            }

            // Отправляем данные
            jQuery.post(
                '/' + page_url + '/create',
                {
                    category: category,
                    message: message,
                    latitude: latitude,
                    longitude: longitude
                },
                function(data) {
                    if (data.code == 'luck') {
                        window.location.href = '/form/point/' + data.item;
                    } else {
                        $(this).attr('disabled', false);
                        $(this).children().removeClass("fa-spinner fa-spin").addClass("fa-check");
                        App.Methods.Alert(data.text);
                    }
                },
                "json"
            );

            // Выключаем режим редактирования
            MapUtils.Methods.stopEditMode();
        });
        /*
         * Нажатие на кнопку "Отмена" - выходит из режима редактора
         */
        $("[data-role='cancelpoint']").click(function() {
            popup._close();
        });

        // Изменение выбора выпадающих списков категории \ подкатегории
        $(document).on("change", "#point-category", function() {
            jQuery.getJSON('/' + page_url + '/get_subcategory/' + $(this).val(), function(json) {
                $('#point-subcategory').text('').removeClass('disabled');
                $("[data-role='savepoint']").removeClass('disabled');
                $.each(json.data, function(key, value) {
                    $('#point-subcategory').append($("<option></option>").attr("value", value.item_id).text(value.item_name)); 
                });

                $('select').selectric();
            });
        });
    }, // EditMode: function(e)
    /**
     * Установить хеш адресной строки параметрами состояния карты
     * @returns void
     */
    getMapState: function() {
        var coords = MapUtils.Var.mapObject.getCenter(),
            params = [
            //'t=' + map.getType().split('#')[1],
            'c=' + [
                coords.lat.toPrecision(6),
                coords.lng.toPrecision(6)].join(','),
            'z=' + MapUtils.Var.mapObject.getZoom()
        ];

        window.location.hash = params.join('&');
    }, // getMapState: function()
    /**
     * Получить параметр хеша адресной строки
     * @param string name
     * @param object location
     * @returns {MapUtils.Methods.getHashParam.res|Array|Boolean}
     */
    getHashParam: function(name, location) {
        location = location || window.location.hash;
        var res = location.match(new RegExp('[#&]' + name + '=([^&]*)', 'i'));
        return (res && res[1] ? res[1] : false);
    }, // getHashParam: function(name, location)
    /**
     * Показать слой карты
     * @param integer id
     * @returns void
     */
    showMapLayer: function(id) {
        var lg = MapUtils.Var.layergroups[id];
        if (typeof lg !== "undefined")
            MapUtils.Var.mapObject.addLayer(lg);
    }, // showMapLayer: function(id)
    /**
     * Скрыть слой карты
     * @param integer id
     * @returns void
     */
    hideMapLayer: function(id) {
        var lg = MapUtils.Var.layergroups[id];
        if (typeof lg !== "undefined")
            MapUtils.Var.mapObject.removeLayer(lg);
    }, // hideMapLayer: function(id)
    /**
     * Показать боковую панель
     * @param object e
     * @returns void
     */
    showSidebar: function(e) {
        e.children('i').removeClass('fa-chevron-right').addClass('fa-chevron-left');
        $(e).parent().animate({"left":"0px"}, "fast").addClass('visible');
        $('#' + MapUtils.Var.mapContainer).width($(window).width() - ($(e).parent().width())).css("left", $(e).parent().width() + "px");
        MapUtils.Var.mapObject.invalidateSize();
    }, // showSidebar: function(e)
    /**
     * Скрыть боковую панель
     * @param object e
     * @returns void
     */
    hideSidebar: function(e) {
        e.children('i').removeClass('fa-chevron-left').addClass('fa-chevron-right');
        $(e).parent().animate({"left":"-" + ($(e).parent().width() - $(e).width()) + "px"}, "fast").removeClass('visible');
        $('#' + MapUtils.Var.mapContainer).width($(window).width() - $(e).width()).css("left", $(e).width() + "px");
        MapUtils.Var.mapObject.invalidateSize();
    }, // hideSidebar: function(e)
    /**
     * Включить режим добавления нового объекта
     * @returns void
     */
    startEditMode: function() {
        $('.map-edit-overlay').show();
        $('.leaflet-container').css('cursor','crosshair');
        MapUtils.Var.mapEditMode = true;
    }, // startEditMode: function()
    /**
     * Выключить режим добавления
     * @returns void
     */
    stopEditMode: function() {
        $('.map-edit-overlay').hide();
        $('.leaflet-container').css('cursor','');
        MapUtils.Var.mapEditMode = false;
    }, // stopEditMode: function()
    /**
     * Событие, возникающее при перемещении карты
     * @param {type} e
     * @returns {undefined}
     */
    eventMoveEnd: function(e) {
        var bounds = MapUtils.Var.mapObject.getBounds();
    }, // eventMoveEnd: function(e)
};