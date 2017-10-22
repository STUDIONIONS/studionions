<?php
if(!isset($autoloader)){
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: /");
	exit();
}
$drl = __DIR__."/studionions";

function autolodaer_studionions($class) {
	static $classes = null;
	if ($classes === null) {
		$classes = array(
			"Studionions\\Plugins" => "/studionions/plugins/studionions.plugins.php"
		);
	}
	if (isset($classes[$class])) {
		require_once dirname(__FILE__) . $classes[$class];
	}
}
spl_autoload_register('autolodaer_studionions', true);