<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Project main config
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   config
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */


/**
 * Site url
 * @var string
 */
$config['site_url'] = 'http://hakaton.miksrv.ru/';

/**
 * @var integer
 */
$config['point_list_per_page'] = 16;

/**
 * Max upload photo
 * @var integer
 */
$config['max_photo_upload'] = 10;

/**
 * The minimum word length, so that the word involved in the calculation
 */
$config['min_word_length'] = 3; // or FALSE

/**
 * Unique sequence for generating passwords
 */
define('UNIQSALT', '5eGjNmhf4xUiVmhyqAQMM8Z3w');

/**
 * Current version system
 */
define('VERSION', '1.0.0 <span class="alert small alert-primary">beta</span> 30.06.2019');
define('RES_VER', '1.0.0');

/**
 * POINT STATUSES
 */
define('STATUS_DRAFT',    0);  // Черновик - создан, но не заполнены поля
define('STATUS_CREATED',  5);  // Создан, все поля заполенны, отправляется
define('STATUS_SENT',     10); // Отправлен на backend, модерация
define('STATUS_INWORK',   15); // Зарегистрировано, в работе
define('STATUS_DONE',     20); // Выполнено
define('STATUS_REJECTED', 25); // Отклонено, не прошло модерацию
define('STATUS_DENIAL',   35); // Мотивированный отказ
define('STATUS_PLANNED',  40); // Запланировано
define('STATUS_DELETED',  50); // Удалено

/**
 * DATA TABLES
 */
define('DB_USERS',    'map_users');
define('DB_PHOTO',    'map_media');
define('DB_STATE',    'map_states');
define('DB_POINT',    'map_points');
define('DB_CATEGORY', 'map_category');
define('DB_SUBCAT',   'map_subcategory');