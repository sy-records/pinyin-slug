<?php
/*
Plugin Name: PinYin Slug
Plugin URI: http://www.williamlong.info/archives/1027.html
Description: Replace Chinese UTF-8 character into Pin Yin  character from a post slugs to improve SEO.
Version: 1.0.0
Author: William Long
Author URI: http://www.williamlong.info
License: GPL2
Text Domain: pingyin-slug
*/

/*
Copyright William Long 2007

Licensed under the terms of the GPL version 2, see:
http://www.gnu.org/licenses/gpl.txt

Provided without warranty, inluding any implied warrant of merchantability or fitness for purpose.
*/

add_filter('name_save_pre', 'pinyin_slugs', 0);

function pinyin_slugs($slug) {
    // We don't want to change an existing slug
	if ($slug) return $slug;

	global $wpdb;

	require("class.Chinese.php");
	$codeTablesDir = dirname(__FILE__)."/config/";
	// Replace post title
	$title = $_POST['post_title'];
	$chs = new Chinese("UTF8","GB2312", $title,$codeTablesDir);
	$title = $chs->ConvertIT();	
	$chs = new Chinese("GB2312","PinYin",$title,$codeTablesDir);
	$title = $chs->ConvertIT();	
	$title = str_replace(" ","",$title);

	return sanitize_title($title);
}

?>
