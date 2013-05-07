<?php
/**
 * WikiaStyleGuideElements
 *
 * @author Hyun Lim, Kyle Florence
 *
 */

$dir = dirname(__FILE__) . '/';

// classes
$wgAutoloadClasses['WikiaStyleGuideDropdownController'] =  $dir . 'WikiaStyleGuideDropdownController.class.php';
$wgAutoloadClasses['WikiaStyleGuideFormController'] =  $dir . 'WikiaStyleGuideFormController.class.php';
$wgAutoloadClasses['WikiaStyleGuideTooltipIconController'] =  $dir . 'WikiaStyleGuideTooltipIconController.class.php';
$wgAutoloadClasses['WikiaStyleGuideFormHelper'] =  $dir . 'WikiaStyleGuideFormHelper.class.php';

// i18n
$wgExtensionMessagesFiles['WikiaStyleGuideElements'] = $dir . 'WikiaStyleGuideElements.i18n.php';

// js messages registration
JSMessages::registerPackage('WikiaStyleGuideDropdown', array('wikiastyleguide-dropdown-*'));