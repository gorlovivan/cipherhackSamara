/**
 * JS-скрипты, подключаемые на странцие профиля пользователя
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   javascript
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 * @version    1.2.0 (29.03.2017)
 */
$(document).ready(function() {
    $('#pagenav').onePageNav({
        currentClass: 'current',
        changeHash: true,
        scrollSpeed: 200,
        scrollThreshold: 0.5,
        filter: '',
        easing: 'swing',
    });

    $(document).scroll(function() {
        if ($(document).scrollTop() >= 180) {
            $('#pagenav').addClass('top');
        } else {
            $('#pagenav').removeClass('top');
        }
    });
    
    flatpickr(".flatpickr", {"locale": "ru", dateFormat: "d.m.Y"});
    $('.flatpickr').click(function() {
        $(this).parent().parent().addClass("flt-lbl-up");
    });
    $('select').selectric();

    $.validator.addMethod("valueNotEquals", function(value, element, arg) {return arg != value;}, "Вы должны выбрать одно из значений");

    
    // Функции удаления
    $('a[data-role="remove"]').click(function() {
        var mid    = $(this).attr('mid'),
            item   = $(this).attr('data-item'),
            parent = $(this).parent().parent();

        $('.form-response').show();
        if (confirm("Вы подтверждаете удаление?") === true) {
            $.getJSON("/profile/remove/" + item + "/" + mid, function(data) {
                $('.form-response').hide();
                parent.remove();
                $('html,body').animate({ scrollTop: 0 }, 'slow');
                $('#response').html('<span class="badge badge-' + data.code + '">' + data.text + '</span>');
            });
        }
    }); // $('a[data-role="remove"]').click(function()
    
    


    $('a[data-role="remove-relatives"]').click(function() {
        var mid    = $(this).attr('mid');
        var parent = $(this).parent().parent();

        $('.form-response').show();
        if (confirm("Вы подтверждаете удаление?") === true) {
            $.getJSON("/profile/remove/person/" + mid, function(data) {
                $('.form-response').hide();
                parent.remove();
                $('html,body').animate({ scrollTop: 0 }, 'slow');
                $('#response').html('<span class="badge badge-' + data.code + '">' + data.text + '</span>');
            });
        }
    });

    $('a[data-role="remove-transport"]').click(function() {
        var mid    = $(this).attr('mid');
        var parent = $(this).parent().parent();

        $('.form-response').show();
        if (confirm("Вы подтверждаете удаление?") === true) {
            $.getJSON("/profile/remove/transport/" + mid, function(data) {
                $('.form-response').hide();
                parent.remove();
                $('html,body').animate({ scrollTop: 0 }, 'slow');
                $('#response').html('<span class="badge badge-' + data.code + '">' + data.text + '</span>');
            });
        }
    });

    $('a[data-role="remove-estate"]').click(function() {
        var mid    = $(this).attr('mid');
        var parent = $(this).parent().parent();

        $('.form-response').show();
        if (confirm("Вы подтверждаете удаление?") === true) {
            $.getJSON("/profile/remove/estate/" + mid, function(data) {
                $('.form-response').hide();
                parent.remove();
                $('html,body').animate({ scrollTop: 0 }, 'slow');
                $('#response').html('<span class="badge badge-' + data.code + '">' + data.text + '</span>');
            });
        }
    });

    $('a[data-role="remove-estateuse"]').click(function() {
        var mid    = $(this).attr('mid');
        var parent = $(this).parent().parent();

        $('.form-response').show();
        if (confirm("Вы подтверждаете удаление?") === true) {
            $.getJSON("/profile/remove/estateuse/" + mid, function(data) {
                $('.form-response').hide();
                parent.remove();
                $('html,body').animate({ scrollTop: 0 }, 'slow');
                $('#response').html('<span class="badge badge-' + data.code + '">' + data.text + '</span>');
            });
        }
    });

    $('a[data-role="remove-transaction"]').click(function() {
        var mid    = $(this).attr('mid');
        var parent = $(this).parent().parent();

        $('.form-response').show();
        if (confirm("Вы подтверждаете удаление?") === true) {
            $.getJSON("/profile/remove/transaction/" + mid, function(data) {
                $('.form-response').hide();
                parent.remove();
                $('html,body').animate({ scrollTop: 0 }, 'slow');
                $('#response').html('<span class="badge badge-' + data.code + '">' + data.text + '</span>');
            });
        }
    });

    $('a[data-role="remove-credits"]').click(function() {
        var mid    = $(this).attr('mid');
        var parent = $(this).parent().parent();

        $('.form-response').show();
        if (confirm("Вы подтверждаете удаление?") === true) {
            $.getJSON("/profile/remove/credits/" + mid, function(data) {
                $('.form-response').hide();
                parent.remove();
                $('html,body').animate({ scrollTop: 0 }, 'slow');
                $('#response').html('<span class="badge badge-' + data.code + '">' + data.text + '</span>');
            });
        }
    });

    $('a[data-role="remove-organizations"]').click(function() {
        var mid    = $(this).attr('mid');
        var parent = $(this).parent().parent();

        $('.form-response').show();
        if (confirm("Вы подтверждаете удаление?") === true) {
            $.getJSON("/profile/remove/organizations/" + mid, function(data) {
                $('.form-response').hide();
                parent.remove();
                $('html,body').animate({ scrollTop: 0 }, 'slow');
                $('#response').html('<span class="badge badge-' + data.code + '">' + data.text + '</span>');
            });
        }
    });

    $('a[data-role="remove-obligations"]').click(function() {
        var mid    = $(this).attr('mid');
        var parent = $(this).parent().parent();

        $('.form-response').show();
        if (confirm("Вы подтверждаете удаление?") === true) {
            $.getJSON("/profile/remove/obligations/" + mid, function(data) {
                $('.form-response').hide();
                parent.remove();
                $('html,body').animate({ scrollTop: 0 }, 'slow');
                $('#response').html('<span class="badge badge-' + data.code + '">' + data.text + '</span>');
            });
        }
    });

    $('a[data-role="remove-securities"]').click(function() {
        var mid    = $(this).attr('mid');
        var parent = $(this).parent().parent();

        $('.form-response').show();
        if (confirm("Вы подтверждаете удаление?") === true) {
            $.getJSON("/profile/remove/securities/" + mid, function(data) {
                $('.form-response').hide();
                parent.remove();
                $('html,body').animate({ scrollTop: 0 }, 'slow');
                $('#response').html('<span class="badge badge-' + data.code + '">' + data.text + '</span>');
            });
        }
    });

    $('a[class="add"]').click(function() {
        var link = $(this).attr('href');
        var parent = $(this).parent().parent();

        location.href = link;
    });

    // Нажатие на кнопку "Сохранить"
    $("#form-profile").validate({
        rules: {
            //item_first_name: "required",
            //item_last_name: "required",
            //item_middle_name: "required",
            //item_birthdate: "required",
            item_address: "required",
        },
        messages: {
            //item_first_name: "Пожалуйста, укажите вашу фамилию",
            //item_last_name: "Пожалуйста, укажите ваше имя",
            //item_middle_name: "Пожалуйста, укажите ваше отчество",
            //item_birthdate: "Пожалуйста, укажите вашу дату рождения",
            item_address: "Укажите адрес вашей регистрации",
        },
        submitHandler: function(form) {
            $('.form-response').show();

            $(form).ajaxSubmit({
                dataType: "json",
                success: function(data) {
                    $('.form-response').hide();
                    $('html,body').animate({ scrollTop: 0 }, 'slow');
                    $('#response').html('<span class="badge badge-' + data.code + '">' + data.text + '</span>');
                }
            });
        },
    });
});