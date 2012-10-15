<?php
/**
 * WikiaStyleGuideElements
 *
 * @author Hyun Lim, Kyle Florence
 *
 */

$dir = dirname(__FILE__) . '/';
$app = F::app();

// classes
$app->registerClass('WikiaStyleGuideDropdownController', $dir . 'WikiaStyleGuideDropdownController.class.php');
$app->registerClass('WikiaStyleGuideFormController', $dir . 'WikiaStyleGuideFormController.class.php');
$app->registerClass('WikiaStyleGuideFormHelper', $dir . 'WikiaStyleGuideFormHelper.class.php');

// i18n
$app->registerExtensionMessageFile('WikiaStyleGuideElements', $dir . 'WikiaStyleGuideElements.i18n.php');

// js messages registration
F::build('JSMessages')->registerPackage('WikiaStyleGuideDropdown', array('wikiastyleguide-dropdown-*'));