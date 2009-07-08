<?php
/*
 * Author: Inez Korczynski (inez@wikia.com)
 */
if(!defined('MEDIAWIKI')) {
	exit(1);
}

$MF = array();

$MF['quartz_js']['type'] = 'js';
$MF['quartz_js']['target'] = 'quartz/js/allinone.js';

$MF['quartz_css']['type'] = 'css';
$MF['quartz_css']['target'] = 'quartz/css/allinone.css';

$MF['monobook_js']['type'] = 'js';
$MF['monobook_js']['target'] = 'monobook/allinone.js';

$MF['monaco_loggedin_js']['type'] = 'js';
$MF['monaco_loggedin_js']['target'] = 'monaco/js/allinone_loggedin.js';

$MF['monaco_non_loggedin_js']['type'] = 'js';
$MF['monaco_non_loggedin_js']['target'] = 'monaco/js/allinone_non_loggedin.js';

$MF['monaco_css']['type'] = 'css';
$MF['monaco_css']['target'] = 'monaco/css/allinone.css';

/* LeanMonaco */
$MF['awesome_loggedin_js']['type'] = 'js';
$MF['awesome_loggedin_js']['target'] = 'monaco2/js/allinone_loggedin.js';

$MF['awesome_non_loggedin_js']['type'] = 'js';
$MF['awesome_non_loggedin_js']['target'] = 'monaco2/js/allinone_non_loggedin.js';

$MF['awesome_css']['type'] = 'css';
$MF['awesome_css']['target'] = 'monaco2/css/allinone.css';
