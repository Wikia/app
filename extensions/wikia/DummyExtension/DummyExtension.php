<?php
/**
 * Dummy Extension
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
 *
 */

$dir = dirname(__FILE__) . '/';

/**
 * DummyExtension specific stuff
 */

/**
 * setup functions
 */
WF::build('App')->registerExtensionFunction('wfDummyExtensionInit');

function wfDummyExtensionInit() {
	$dir = dirname(__FILE__) . '/';

	/**
	 * classes
	 */
	WF::build('App')->registerClass('DummyExtension', $dir . 'DummyExtension.class.php');

	/**
	 * hooks
	 */
	WF::build('App')->registerHook('OutputPageBeforeHTML', 'DummyExtension', 'onOutputPageBeforeHTML', array( 'foo' => 1, 'bar' => null ) );

	/**
	 * controllers
	 */
	WF::build('App')->registerClass('DummyExtensionController', $dir . 'DummyExtensionController.class.php');
}
