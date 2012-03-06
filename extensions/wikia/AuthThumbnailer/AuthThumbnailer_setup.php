<?php
/**
 * Example Extension setup file
 *
 * @author Piotr 'MoLi' Molski <moli(at)wikia.com>
 *
 */

$app = F::app();
$dir = dirname(__FILE__) . '/';

/**
 * classes
 */
$app->registerClass('AuthThumbnailerSpecialPageController', $dir . 'AuthThumbnailerSpecialPageController.class.php');

/**
 * special pages
 */
$app->registerSpecialPage('AuthThumbnailer', 'AuthThumbnailerSpecialPageController');
