<?php
/**
 * Dummy Extension
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
 *
 */

$dir = dirname(__FILE__) . '/';

/**
 * ------------------------------------------------------------------------------------------------------
 * @todo move all content of extension includes/ folder to includes/wikia
 */
$wgAutoloadClasses['WF'] = $dir . 'includes/WikiaFactory.class.php';
$wgAutoloadClasses['WikiaApp'] = $dir . 'includes/WikiaApp.class.php';
$wgAutoloadClasses['WikiaHookHandler'] = $dir . 'includes/WikiaHookHandler.class.php';
$wgAutoloadClasses['IWikiaHookHandler'] = $dir . 'includes/IWikiaHookHandler.interface.php';
$wgAutoloadClasses['WikiaHookDispatcher'] = $dir . 'includes/WikiaHookDispatcher.class.php';
$wgAutoloadClasses['WikiaRegistry'] = $dir . 'includes/WikiaRegistry.class.php';
$wgAutoloadClasses['WikiaGlobalsRegistry'] = $dir . 'includes/WikiaGlobalsRegistry.class.php';
$wgAutoloadClasses['WikiaLocalRegistry'] = $dir . 'includes/WikiaLocalRegistry.class.php';
$wgAutoloadClasses['WikiaCompositeRegistry'] = $dir . 'includes/WikiaCompositeRegistry.class.php';

/**
 * @todo move to global configuration
 */
WF::setInstance( 'App', new WikiaApp() );
/**
 * ------------------------------------------------------------------------------------------------------
 */



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
}