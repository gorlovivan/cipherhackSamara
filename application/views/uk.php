<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * UK raiting template
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   template
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */

include_once VIEWPATH . 'sections/header.inc.php';
?>      
    <div class="demo-overlay2" style="display: none"></div>
    <div class="demo-modal2" style="display: none">
        <div class="box-content data-form">
            <h2>ТСЖ «1 Советский»</h2>
            <div class="key-value-list">
                            <div class="key-value-item">
                                <div class="key">Домов</div>
                                <div class="value">10</div>
                            </div>
                            <div class="key-value-item">
                                <div class="key">Адрес</div>
                                <div class="value">ул. Рощинская, д. 37, п. офис 4</div>
                            </div>
                            <div class="key-value-item">
                                <div class="key">Телефоны</div>
                                <div class="value"><a href="tel:89138813883">8 (913) 881-38-83</a></div>
                            </div>
                            <div class="key-value-item">
                                <div class="key">Email</div>
                                <div class="value"><a href="maito:tzz1.oren@mail.ya">tzz1.oren@mail.ya</a></div>
                            </div>
                            <div class="key-value-item">
                                <div class="key">Веб-сайт</div>
                                <div class="value"><a href="#">tzz1-orenburg.ya</a></div>
                            </div>
                            <div class="key-value-item">
                                <div class="key">ИНН</div>
                                <div class="value">5601208190</div>
                            </div>
                            <div class="key-value-item">
                                <div class="key">ОГРН</div>
                                <div class="value">1111961755509</div>
                            </div>
                            <div class="key-value-item">
                                <div class="key">Всего обращений</div>
                                <div class="value">15</div>
                            </div>
                            <div class="key-value-item">
                                <div class="key">Выполнено</div>
                                <div class="value">13</div>
                            </div>
                            <div class="key-value-item">
                                <div class="key">Просрочено</div>
                                <div class="value">4</div>
                            </div>
                            <div class="key-value-item">
                                <div class="key">Оценка</div>
                                <div class="value raiting">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                </div>
                            </div>
            </div>
                <div class="align-right">
                    <br>
                    <a href="javascript:void(0);" data-role="history" onclick="$('.demo-overlay2,.demo-modal2').hide();" title="История изменений" class="btn btn-primary disabled"><i class="fa fa-history" aria-hidden="true"></i> История</a>
                    <a href="javascript:void(0);" data-role="edit" onclick="$('.demo-overlay2,.demo-modal2').hide();" title="Править УК" class="btn btn-warning disabled"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Правка</a>
                    <a href="javascript://" class="btn btn-warning" onclick="$('.demo-overlay2,.demo-modal2').hide();" data-role="cancel">Отмена</a>
                </div>
        </div>
    </div>
        <main>
            <section class="wrapper">
                <div class="box-content">
                    <div class="table-toolbar">
                        <a href="javascript:void(0);" data-role="refresh" title="Обновить страницу" class="btn btn-primary"><i class="fa fa-refresh" aria-hidden="true"></i> Обновить</a>
                        <a href="javascript:void(0);" data-role="create" title="Добавить УК" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Добавить</a>
                        <a href="javascript:void(0);" data-role="edit" title="Править УК" class="btn btn-warning disabled"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Правка</a>
                        <a href="javascript:void(0);" data-role="history" title="История изменений" class="btn btn-primary disabled"><i class="fa fa-history" aria-hidden="true"></i> История</a>
                        <a href="javascript:void(0);" onclick="$('.demo-overlay2,.demo-modal2').show();" data-role="info" title="Подробная информация о УК" class="btn btn-primary disabled"><i class="fa fa-info" aria-hidden="true"></i> Информация</a>
                    </div>
                    <table id="example" class="datatable" style="width:100%">
                        <thead>
                            <tr>
                                <th>Название УК</th>
                                <th>Адрес</th>
                                <th>Телефон</th>
                                <th>ОГРН</th>
                                <th>Обращений</th>
                                <th>Выполнено</th>
                                <th>Оценка</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr data-id="1">
                                <td>УК «АСН СТАТУС»</td>
                                <td>ул. Пирогова, д. 15, к. 1, п. 501</td>
                                <td>22-12-15</td>
                                <td class="center">1048375625022</td>
                                <td class="center">15</td>
                                <td class="center">10</td>
                                <td class="center raiting">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                </td>
                            </tr>
                            <tr data-id="2">
                                <td>ТСЖ «(Вид)»</td>
                                <td>пр-кт. 25 Октября, д. 65а</td>
                                <td>7 (981) 790-81-72</td>
                                <td class="center">1158991192469</td>
                                <td class="center">7</td>
                                <td class="center">7</td>
                                <td class="center raiting">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                </td>
                            </tr>
                            <tr data-id="3">
                                <td>УК «(МР Сервис)»</td>
                                <td>пр-кт. Ленина, д. 23, п. 1002</td>
                                <td>8 (4932) 93-83-06</td>
                                <td class="center">5174283924018</td>
                                <td class="center">21</td>
                                <td class="center">20</td>
                                <td class="center raiting">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </td>
                            </tr>
                            <tr data-id="3">
                                <td>ТСЖ «Альянс-2001»</td>
                                <td>пр-кт. Текстильщиков, д. 67</td>
                                <td>8 (4942) 31-74-57</td>
                                <td class="center">1031799269644</td>
                                <td class="center">9</td>
                                <td class="center">2</td>
                                <td class="center raiting">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                </td>
                            </tr>
                            <tr data-id="4">
                                <td>УК «Жилстроймастер»</td>
                                <td>ул. Молодежная, д. 35</td>
                                <td>8 (961) 012-00-01</td>
                                <td class="center">1043198067054</td>
                                <td class="center">4</td>
                                <td class="center">3</td>
                                <td class="center raiting">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                </td>
                            </tr>
                            <tr data-id="5">
                                <td>УК «ЖИЛОЙ ФОНД»</td>
                                <td>ул. Пушкина, д. 109, п. 2</td>
                                <td>8 (918) 416-30-11</td>
                                <td class="center">1087563202440</td>
                                <td class="center">9</td>
                                <td class="center">9</td>
                                <td class="center raiting">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                </td>
                            </tr>
                            <tr data-id="6">
                                <td>УК «Пестрецы»</td>
                                <td>ул. Центральная, д. 18</td>
                                <td>8 (937) 520-52-05</td>
                                <td class="center">5151290839101</td>
                                <td class="center">21</td>
                                <td class="center">10</td>
                                <td class="center raiting">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                </td>
                            </tr>
                            <tr data-id="7">
                                <td>УК «Прогресс»</td>
                                <td>ул. Горная, д. 1, к. А</td>
                                <td>8 (4242) 23-94-90</td>
                                <td class="center">1104309233522</td>
                                <td class="center">10</td>
                                <td class="center">7</td>
                                <td class="center raiting">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                </td>
                            </tr>
                            <tr data-id="8">
                                <td>УК «Управление домами»</td>
                                <td>ул. Некрасова, д. 17</td>
                                <td>8 (81665) 457-43</td>
                                <td class="center">5134643246800</td>
                                <td class="center">14</td>
                                <td class="center">10</td>
                                <td class="center raiting">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                </td>
                            </tr>
                            <tr data-id="9">
                                <td>УК «1 ГОРОДСКАЯ УК»</td>
                                <td>ул. Нижегородская, д. 7А, п. 9</td>
                                <td>8 (83147) 772-95</td>
                                <td class="center">5066282799853</td>
                                <td class="center">16</td>
                                <td class="center">12</td>
                                <td class="center raiting">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                </td>
                            </tr>
                            <tr data-id="10">
                                <td>ТСЖ «1 Советский»</td>
                                <td>ул. Рощинская, д. 37, п. офис 4</td>
                                <td>8 (913) 881-38-83</td>
                                <td class="center">1111961755509</td>
                                <td class="center">15</td>
                                <td class="center">13</td>
                                <td class="center raiting">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Название УК</th>
                                <th>Адрес</th>
                                <th>Телефон</th>
                                <th>ОГРН</th>
                                <th>Обращений</th>
                                <th>Выполнено</th>
                                <th>Оценка</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </section>
        </main>
        <?php include_once VIEWPATH . 'sections/footer.inc.php'; ?>
        <link type="text/css" rel="stylesheet" href="/assets/components/datatables/datatables.min.css" />
        <script type="text/javascript" src="/assets/components/datatables/datatables.min.js"></script>
        <script type="text/javascript" src="/assets/components/datatables/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="/assets/components/datatables/buttons.flash.min.js"></script>
        <script type="text/javascript" src="/assets/components/datatables/jszip.min.js"></script>
        <script type="text/javascript" src="/assets/components/datatables/pdfmake.min.js"></script>
        <script type="text/javascript" src="/assets/components/datatables/vfs_fonts.js"></script>
        <script type="text/javascript" src="/assets/components/datatables/buttons.html5.min.js"></script>
        <script type="text/javascript" src="/assets/components/datatables/buttons.print.min.js"></script>
        
        <script>
            $(document).ready(function() {               
            var current_id,
                table = $('.datatable').DataTable({
                    stateSave: false,
                    pageLength: 25,
                    initComplete: function(settings, json) {

                    },
                    order: [
                        [ 0, 'asc' ]
                    ],
                    dom: 'Bfrtip',
                    lengthMenu: [[10, 25, 50, 100, -1],[ '10 записей', '25 записей', '50 записей', '100 записей', 'Показать все']],
                    buttons: ['pageLength', {extend: 'csv', text: 'CSV'}, 'excel', 'pdf', {extend: 'print', text: '<i class="fa fa-print" aria-hidden="true"></i>'}],
                    language: {
                        url: "/assets/components/datatables/datatables.ru.json",
                        buttons: {pageLength: {_: "Показать %d записей", '-1': "Показать все"}}
                    }
                });
                
                $('.datatable tbody').on('click', 'tr', function () {
                    current_id = $(this).attr('data-id');
                    var btn1 = $('a[data-role=edit]'),
                        btn2 = $('a[data-role=history]'),
                        btn3 = $('a[data-role=info]');

                    if ($(this).hasClass('selected')) {
                        $(this).removeClass('selected');
                        $(btn1).addClass('disabled');
                        $(btn2).addClass('disabled');
                        $(btn3).addClass('disabled');
                    } else {
                        table.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                        $(btn1).removeClass('disabled');
                        $(btn2).removeClass('disabled');
                        $(btn3).removeClass('disabled');
                    }
                });
                
                $('a[data-role=refresh]').click(function() {
                    location.reload();
                });
                
            });
        </script>
    </body>
</html>
<?php

/* End of file uk.php */
/* Location: /application/views/uk.php */ 