<?php
/**
 * AuthImage setup file
 *
 * @author Piotr 'MoLi' Molski <moli(at)wikia.com>
 *
 */

$app = F::app();
$dir = dirname(__FILE__) . '/';

/**
 * classes
 */
$app->registerClass('AuthImageSpecialPageController', $dir . 'AuthImageSpecialPageController.class.php');

/**
 * special pages
 */
$app->registerSpecialPage('AuthImage', 'AuthImageSpecialPageController');
