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
WF::build('App')->registerClass('DummyExtension', $dir . 'DummyExtension.class.php');
WF::build('App')->registerClass('DummyExtensionSpecialPageController', $dir . 'DummyExtensionSpecialPageController.class.php');

/**
 * hooks
 */
WF::build('App')->registerHook('OutputPageBeforeHTML', 'DummyExtension', 'onOutputPageBeforeHTML', array( 'foo' => 1, 'bar' => null ) );

/**
 * controllers
 */
WF::build('App')->registerClass('DummyExtensionController', $dir . 'DummyExtensionController.class.php');

/**
 * special pages
 */
WF::build('App')->registerSpecialPage('DummyExtension', 'DummyExtensionSpecialPageController');

/**
 * setup functions
 */
//WF::build('App')->registerExtensionFunction('wfDummyExtensionInit');

function wfDummyExtensionInit() {
	// place extension init stuff heere
}
