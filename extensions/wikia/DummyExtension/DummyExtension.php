<?php
/**
 * Dummy Extension
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
 *
 */

$dir = dirname(__FILE__) . '/';

/**
 * classes
 */
F::build('App')->registerClass('DummyExtension', $dir . 'DummyExtension.class.php');
F::build('App')->registerClass('DummyExtensionSpecialPageController', $dir . 'DummyExtensionSpecialPageController.class.php');

/**
 * hooks
 */
F::build('App')->registerHook('OutputPageBeforeHTML', 'DummyExtension', 'onOutputPageBeforeHTML');

/**
 * controllers
 */
F::build('App')->registerClass('DummyExtensionController', $dir . 'DummyExtensionController.class.php');

/**
 * special pages
 */
F::build('App')->registerSpecialPage('DummyExtension', 'DummyExtensionSpecialPageController');

/**
 * setup functions
 */
//WF::build('App')->registerExtensionFunction('wfDummyExtensionInit');

function wfDummyExtensionInit() {
	// place extension init stuff heere
}
