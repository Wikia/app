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
$wgAutoloadClasses['AuthImageSpecialPageController'] =  $dir . 'AuthImageSpecialPageController.class.php';

/**
 * special pages
 */
$wgSpecialPages['AuthImage'] = 'AuthImageSpecialPageController';
