<?php
/*
Plugin Name: KBoard 크로스 링크 스킨
Description: KBoard 크로스 링크 스킨입니다.
Version: 1.7
Author: 코스모스팜 - Cosmosfarm
Author URI: https://www.cosmosfarm.com/
*/

if(!defined('ABSPATH')) exit;

add_filter('kboard_skin_list', 'kboard_skin_list_wmc_attendee_list', 10, 1);
function kboard_skin_list_wmc_attendee_list($list){
	
	$skin = new stdClass();
	$skin->dir = dirname(__FILE__);
	$skin->url = plugins_url('', __FILE__);
	$skin->name = basename($skin->dir);
	
	$list[$skin->name] = $skin;
	
	return $list;
}