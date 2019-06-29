<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Footer page tempate
 * 
 * @package    codeigniter
 * @subpackage project
 * @category   template
 * @author     Mikhail Topchilo (Mik™) <miksrv.ru> <miksoft.tm@gmail.com>
 */
?>          <footer>
                <div class="row wrapper">
                    <div class="col-xs-3">
                        <nav class="footer">
                            <ul>
                                <li>
                                    <a href="/" title="">Главная</a>
                                </li>
                                <li>
                                    <a href="/map" title="">Карта</a>
                                </li>
                                <li>
                                    <a href="/points/list" title="">Обращения</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-xs-9 align-left">
                        <p>Все права защищены &copy; <?= date('Y'); ?>, Версия <?= VERSION ?></p>
                    </div>
                </div>
            </footer>
            <script type="text/javascript" src="/assets/js/jquery-3.3.1.min.js"></script>
            <script type="text/javascript" src="/assets/js/jquery.dropdown.min.js"></script>
            <script type="text/javascript" src="/assets/js/float-labels.js"></script>
            <script type="text/javascript" src="/assets/js/application.js"></script>
<?php

/* End of file footer.inc.php */
/* Location: /application/views/sections/footer.inc.php */ 