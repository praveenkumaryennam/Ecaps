<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['post_controller'] = array(
        'class'    => 'Checksession',
        'function' => 'is_valid_session',
        'filename' => 'Checksession.php',
        'filepath' => 'hooks',
        'params'   => []//array('beer', 'wine', 'snacks')
);

$hook['pre_controller'] = array(
        'class'    => 'Checksession',
        'function' => 'is_valid_ip',
        'filename' => 'Checksession.php',
        'filepath' => 'hooks',
        'params'   => []//array('beer', 'wine', 'snacks')
);