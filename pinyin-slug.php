<?php
/*
Plugin Name: PinYin Slug
Plugin URI: https://github.com/sy-records/pinyin-slug
Description: Replace Chinese UTF-8 character into Pin Yin character from a post slugs to improve SEO.
Version: 2.0.0
Author: 沈唁
Author URI: https://qq52o.me
License: GPL3
*/

/*
Copyright William Long 2007

Licensed under the terms of the GPL version 3, see:
http://www.gnu.org/licenses/gpl.txt

Provided without warranty, including any implied warrant of merchantability or fitness for purpose.
*/
if (!defined('ABSPATH')) {
	exit;
}

require_once 'sdk/vendor/autoload.php';

use Composer\InstalledVersions;
use Overtrue\Pinyin\Pinyin;

add_filter('name_save_pre', 'pinyin_slugs', 0);

function pinyin_slugs($slug) {
    // We don't want to change an existing slug
	if ($slug) return $slug;

	$prettyVersion = InstalledVersions::getPrettyVersion('overtrue/pinyin');
	if ($prettyVersion >= 5) {
		$pinyin = Pinyin::permalink($_POST['post_title']);
	} else {
		$pinyin = (new Pinyin())->permalink($_POST['post_title']);
	}

	if (empty($pinyin)) {
		return $slug;
	}

	return sanitize_title($pinyin);
}
?>
