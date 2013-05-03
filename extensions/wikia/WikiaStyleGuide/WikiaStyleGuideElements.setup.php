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
$wgAutoloadClasses['WikiaStyleGuideDropdownController'] =  $dir . 'WikiaStyleGuideDropdownController.class.php';
$wgAutoloadClasses['WikiaStyleGuideFormController'] =  $dir . 'WikiaStyleGuideFormController.class.php';
$wgAutoloadClasses['WikiaStyleGuideTooltipIconController'] =  $dir . 'WikiaStyleGuideTooltipIconController.class.php';
$wgAutoloadClasses['WikiaStyleGuideFormHelper'] =  $dir . 'WikiaStyleGuideFormHelper.class.php';

// i18n
$app->registerExtensionMessageFile('WikiaStyleGuideElements', $dir . 'WikiaStyleGuideElements.i18n.php');

// js messages registration
JSMessages::registerPackage('WikiaStyleGuideDropdown', array('wikiastyleguide-dropdown-*'));