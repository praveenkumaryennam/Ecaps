<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$active_group = 'default';
$query_builder = TRUE;
$ci = &get_instance();
$db['default'] = array(
	'dsn'	=> '',
	'hostname' => $ci->config->item('host'),
	'username' => $ci->config->item('user'),
	'password' => $ci->config->item('password'),
	'database' => $ci->config->item('database'),
	'dbdriver' => 'mysqli',
	'dbprefix' => 'rpd_',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => 'application/cache',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);


$db['sdb'] = array(
	'dsn'	=> '',
	'hostname' => $ci->config->item('shost'),
	'username' => $ci->config->item('suser'),
	'database' => $ci->config->item('sdatabase'),
	'password' => $ci->config->item('spassword'),
	'dbdriver' => 'mysqli',
	'dbprefix' => 'rpd_',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
