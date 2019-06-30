<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Header page tempate
 *
 * @package    codeigniter
 * @subpackage project
 * @category   template
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */
?><!DOCTYPE html>
<html>
    <head>
        <title><?= $title ?></title>
        <meta http-equiv="pragma" content="no-cache" />
        <meta http-equiv="cache-control" content="no-cache, must-revalidate" />
        <meta http-equiv="cache-control" content="no-store, post-check=0, pre-check=0" />
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="" />
        <meta name="robots" content="none" />
        <meta name="content-language" content="ru" />
        <link type="text/css" rel="stylesheet" href="/assets/css/flatpickr.min.css" />
        <link type="text/css" rel="stylesheet" href="/assets/css/font-awesome.min.css" />
        <link type="text/css" rel="stylesheet" href="/assets/components/zebra/css/flat/zebra_dialog.min.css" />
        <link type="text/css" rel="stylesheet" href="/assets/css/selectric.css" />
        <link type="text/css" rel="stylesheet" href="/assets/css/style.css?v=<?= RES_VER ?>" />
    </head>
        <body class="ru is-desktop ">
            <header>
                <div class="wrapper">
                    <menu class="mobile-menu">
                        <ul>
                            <?php if ($this->auth->is_login()): ?>
                            <li>
                                <a href="/points/list/<?= $user->user_id ?>" data-jq-dropdown="#dropdown-user" data-horizontal-offset="-9" title="<?= $user->user_lastname ?> <?= $user->user_firstname ?>">
                                    <?= $user->user_lastname ?> <?= $user->user_firstname ?> <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                </a>
                            </li>
                                    <li>
                                        <a href="/points/list/?user=<?= $user->user_id ?>" <?= ($this->uri->segment(1) == 'points' && $this->auth->get_user_id() == $this->input->get('user')) ? 'class="active"' : NULL ?> title="">Мои заявки</a>
                                    </li>
                            <?php else: ?>
                            <li><a href="/login/" rel="nofollow" title="Авторизироваться на сайте">Войти</a></li>
                            <?php endif; ?>
                            <li>
                                <a href="/" <?= $this->uri->segment(1) == 'map' ? 'class="active"' : NULL ?> title="">Районы</a>
                            </li>
                            <li>
                                <a href="/points/list" <?= ($this->uri->segment(1) == 'points' && $this->uri->segment(2) == 'list' && ! $this->input->get('user')) ? 'class="active"' : NULL ?> title="">Обращения</a>
                            </li>
                                    <li>
                                        <a href="/uk/" <?= ($this->uri->segment(1) == 'uk') ? 'class="active"' : NULL ?> title="">Рейтинг</a>
                                    </li>
                            <?= $this->auth->is_login() == TRUE ? '<li class="menu-divider"></li><li><a href="/logout/">Выход</a></li>' : '' ?>
                        </ul>
                    </menu>
                    <div class="menu-overlay"></div>
                    <div class="row desktop-menu">
                        <div class="col-md-10">
                            <a href="javascript:void(0)" class="nav-toggle" title=""><i class="fa fa-bars"></i></a>
                            <a href="/" class="logo" title="Портал обращений граждан">
                                <img src="/assets/img/logo2.png" alt="" />
                            </a>
                            <nav class="main">
                                <ul>
                                    <li>
                                        <a href="/" <?= $this->uri->segment(1) == 'map' ? 'class="active"' : NULL ?> title="">Районы</a>
                                    </li>
                                    <li>
                                        <a href="/points/list" <?= ($this->uri->segment(1) == 'points' && $this->uri->segment(2) == 'list' && ! $this->input->get('user')) ? 'class="active"' : NULL ?> title="">Обращения</a>
                                    </li>
                                    <?php if ($this->auth->is_login()): ?>
                                    <li>
                                        <a href="/points/list/?user=<?= $user->user_id ?>" <?= ($this->uri->segment(1) == 'points' && $this->auth->get_user_id() == $this->input->get('user')) ? 'class="active"' : NULL ?> title="">Мои заявки</a>
                                    </li>
                                    <?php endif; ?>
                                    <li>
                                        <a href="/uk/" <?= ($this->uri->segment(1) == 'uk') ? 'class="active"' : NULL ?> title="">Рейтинг</a>
                                    </li>
                                    <li> 
                                        <button class="btn btn-success" data-role='add-place' onclick="location.href='/<?= $this->auth->is_login() ? 'map#create' : 'login' ?>'">Создать обращение</button>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="col-md-2 align-right">
                            <nav class="main">
                                <ul>
                                    <li>
                                        <?php if ($this->auth->is_login()): ?>
                                        <a href="/points/list/?user=<?= $user->user_id ?>" data-jq-dropdown="#dropdown-user" data-horizontal-offset="-9" title="<?= $user->user_lastname ?> <?= $user->user_firstname ?>">
                                            <?= $user->user_lastname ?> <?= $user->user_firstname ?> <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                        </a>
                                        <div id="dropdown-user" class="jq-dropdown jq-dropdown-tip jq-dropdown-anchor-right jq-dropdown-relative">
                                            <ul class="jq-dropdown-menu">
                                                <li><a href="/points/list/?user=<?= $user->user_id ?>" title="Мои обращения">Мои обращения</a></li>
                                                <li class="dropdown-divider"></li>
                                                <li><a href="/logout" title="Выйти из системы">Выход</a></li>
                                            </ul>
                                        </div>
                                        <?php else: ?>
                                        <a href="/login" title="Войти" class="login">Войти</a>
                                        <?php endif; ?>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </header>
<?php

/* End of file header.inc.php */
/* Location: /application/views/sections/header.inc.php */
