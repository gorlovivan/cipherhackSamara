<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Users page template
 *
 * @package    codeigniter
 * @subpackage project
 * @category   template
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */

include_once VIEWPATH . 'sections/header.inc.php';

?>      <main class="wrapper">
            <div class="box-content">
                <div id="loader" style="display: block">
                    <div class="cssload-dot"></div>
                    <div class="cssload-dot"></div>
                    <div class="cssload-dot"></div>
                    <div class="cssload-dot"></div>
                    <div class="cssload-dot"></div>
                    <div class="cssload-dot"></div>
                    <div class="cssload-dot"></div>
                    <div class="cssload-dot"></div>
                </div>
                <section>
                    <h2>Управление пользователями</h2>
                    <div class="row">
                        <div class="col-xs-8">
                            <a href="javascript:void(0);" data-role="refresh" title="Обновить страницу" class="btn btn-primary"><i class="fa fa-refresh"></i></a>
                            <a href="javascript:void(0);" data-role="create" title="Добавить пользователя" class="btn btn-success"><i class="fa fa-plus"></i> Добавить</a>
                            <a href="javascript:void(0);" data-role="adverts" title="Посмотреть объявления пользователя" class="btn btn-primary disabled"><i class="fa fa-info-circle"></i> Объявления</a>
                            <a href="javascript:void(0);" data-role="deactivate" title="Отключить пользователя" class="btn btn-danger disabled"><i class="fa fa-user-times"></i> Отключить</a>
                        </div>
                        <div class="col-xs-4 align-right">
                            <select class="toolbar" id="filter-role">
                                <option value="0">- Все роли пользователей -</option>
                                <option value="<?= ROLE_USER ?>">Пользователь</option>
                                <option value="<?= ROLE_MODERATOR ?>">Модератор</option>
                                <option value="<?= ROLE_ADMIN ?>">Администратор</option>
                            </select>
                        </div>
                    </div>
                    <table id="user-table" class="display" style="display: none;" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Email адрес</th>
                                <th>Имя пользователя</th>
                                <th>AD</th>
                                <th>Роль пользователя</th>
                                <th>Дата регистрации</th>
                                <th>Авторизация</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Email адрес</th>
                                <th>Имя пользователя</th>
                                <th>AD</th>
                                <th>Роль пользователя</th>
                                <th>Дата регистрации</th>
                                <th>Авторизация</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        <?php if ( ! empty($users)) : ?>
                            <?php foreach ($users as $val): ?>
                            <tr data-id="<?= $val->user_id ?>" class="<?= ( ! $val->user_active ? 'deactive' : '') ?>">
                                <td><?= (int) $val->user_lastlogin ?></td>
                                <td><?= (int) $val->user_role ?></td>
                                <td><?= $val->user_email ?></td>
                                <td><?= $val->user_name ?></td>
                                <td class="center"><?= $val->advert_count ?></td>
                                <td class="center"><span class="alert small alert-<?= convert_user_roles($val->user_role)['code'] ?>"><?= convert_user_roles($val->user_role)['text'] ?></span></td>
                                <td class="center"><?= formatdate((int) $val->user_created) ?></td>
                                <td class="center"><?= formatdate((int) $val->user_lastlogin) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </section>
            </div>
        </main>
        <?php include_once VIEWPATH . 'sections/footer.inc.php'; ?>
        <link rel="stylesheet" type="text/css" href="/assets/components/datatables/datatables.min.css"/>
        <link type="text/css" rel="stylesheet" href="/assets/css/selectric.css" />

        <script type="text/javascript" src="/assets/js/application.js"></script>
        <script type="text/javascript" src="/assets/js/jquery.selectric.min.js"></script>
        <script type="text/javascript" src="/assets/components/datatables/datatables.min.js"></script>
        <script type="text/javascript" src="/assets/components/datatables/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="/assets/components/datatables/buttons.flash.min.js"></script>
        <script type="text/javascript" src="/assets/components/datatables/jszip.min.js"></script>
        <script type="text/javascript" src="/assets/components/datatables/pdfmake.min.js"></script>
        <script type="text/javascript" src="/assets/components/datatables/vfs_fonts.js"></script>
        <script type="text/javascript" src="/assets/components/datatables/buttons.html5.min.js"></script>
        <script type="text/javascript" src="/assets/components/datatables/buttons.print.min.js"></script>
        <script type="text/javascript">
        $(document).ready(function() {
            var current_id, deactive;

            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    if (settings.sTableId !== 'user-table') {
                        return true;
                    }

                    var role = parseInt($('#filter-role').val(), 10 );

                    if ((role == 0 || role == data[0])) {
                        return true;
                    }

                    return false;
                }
            );


            var table = $('#user-table').DataTable({
                stateSave: true,
                pageLength: 25,
                columnDefs: [
                    {
                        targets: [ 0 ],
                        visible: false,
                        searchable: true
                    }
                ],
                initComplete: function(settings, json) {
                    App.Methods.Loader.Remove();
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

            $('#user-table tbody').on('click', 'tr', function () {
                current_id = $(this).attr('data-id');
                deactive   = $(this).hasClass('deactive');
                var btn_adv  = $('a[data-role=adverts]'),
                    btn_dea  = $('a[data-role=deactivate]');

                if ( ! deactive) {
                    btn_dea.html('<i class="fa fa-user-times"></i> Отключить');
                } else {
                    btn_dea.html('<i class="fa fa-user"></i> Включить');
                }

                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                    $(btn_adv).addClass('disabled');
                    $(btn_dea).addClass('disabled');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    $(btn_adv).removeClass('disabled');
                    $(btn_dea).removeClass('disabled');
                }
            });

            $('#user-table tbody').on('dblclick', 'tr', function () {
                $('a[data-role=adverts]').click();
                //var win = window.open('/view/id/' + $(this).attr('data-id'), '_blank');
                //win.focus();
            });

            $('a[data-role=refresh]').click(function() {
                location.reload();
            });

            $('a[data-role=create]').click(function() {
                $.getJSON('/users/create/', function(data) {
                    new $.Zebra_Dialog(data.content, {
                        width: 1000,
                        type: 'FALSE',
                        buttons: [
                            {caption: 'Сохранить', callback: function() {App.Methods.CreateUser()}},
                            {caption: 'Закрыть', callback: function() {}}
                        ]
                    });
                });
            });

            $('a[data-role=adverts]').click(function() {
                if ( ! current_id) {
                    return ;
                }

                $.getJSON('/users/adverts/' + current_id, function(data) {
                    new $.Zebra_Dialog(data.content, {
                        width: 1000,
                        type: 'FALSE',
                        buttons: [
                            {caption: 'Закрыть', callback: function() {}}
                        ]
                    });
                });
            });

            $('a[data-role=deactivate]').click(function() {
                if ( ! current_id) {
                    return ;
                }

                if (App.Methods.Confirm(( ! deactive ? 'Отключить' : 'Включить') + ' пользователя?')) {
                    $.getJSON('/users/deactivate/' + current_id + '/' + deactive, function(data) {
                        if (data.state == true) {
                            if ( ! deactive) {
                                $('[data-id="' + current_id + '"]').addClass('deactive');
                            } else {
                                $('[data-id="' + current_id + '"]').removeClass('deactive');
                            }
                        } else {
                            App.Methods.Alert(data.text);
                        }
                    });
                }
            });

            $('#filter-role').change(function() {table.draw();});
            $('#user-table').fadeIn();
            $('select').selectric();
        });
        </script>
    </body>
</html>
<?php

/* End of file users.php */
/* Location: /application/views/users.php */
