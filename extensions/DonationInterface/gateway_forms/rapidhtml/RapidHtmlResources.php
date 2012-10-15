<?php
/**
 * For defining RapidHtml ResourceLoader resourcses
 *
 * This file is included in DonationInterface/payflowpro_gateway.php
 */

$wgDonationInterfaceRapidHtmlRemoteExtPath = 'DonationInterface/gateway_forms/rapidhtml';
$wgPayflowRapidHtmlRemoteExtPath = 'DonationInterface/payflowpro_gateway/forms';
$wgGlobalCollectRapidHtmlRemoteExtPath = 'DonationInterface/globalcollect_gateway/forms';

/**
 * LIGHTBOX
 */
// RapidHtml lightbox form resources
$wgResourceModules[ 'pfp.form.rapidhtml.lightbox' ] = array(
	'scripts' => array(
		'js/lightbox1.js',
	),
	'styles' => array(
		'css/lightbox1.css',
	),
	'dependencies' => array(
		'jquery.ui.widget',
		'jquery.ui.mouse',
		'jquery.ui.position',
		'jquery.ui.draggable',
		'jquery.ui.resizable',
		'jquery.ui.button',
		'jquery.ui.dialog',
		'ext.donationInterface.errorMessages',
	),
	'messages' => array(
		'donate_interface-cc-button',
		'donate_interface-ccdc-button',
		'donate_interface-paypal-button',
	),
	'localBasePath' => dirname( __FILE__ ).'/../../payflowpro_gateway/forms',
	'remoteExtPath' => $wgPayflowRapidHtmlRemoteExtPath,
);

/**
 * webitects
 */
$wgResourceModules[ 'di.form.rapidhtml.webitects' ] = array(
	'styles' => array(
		'css/lp1.css',
		'css/webitects.css',
	),
	'scripts' => '',
	'dependencies' => 'jquery.ui.accordion',
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => $wgDonationInterfaceRapidHtmlRemoteExtPath,
);
$wgResourceModules[ 'di.form.rapidhtml.webitects.ie6' ] = array(
	'styles' => 'css/webitects.ie6.css',
	'scripts' => '',
	'dependencies' => 'di.form.rapidhtml.webitects',
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => $wgDonationInterfaceRapidHtmlRemoteExtPath,
);
$wgResourceModules[ 'di.form.rapidhtml.webitects.2nd' ] = array(
	'styles' => 'css/webitects2nd.css',
	'dependencies' => 'di.form.rapidhtml.webitects',
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => $wgDonationInterfaceRapidHtmlRemoteExtPath,
);

// GlobalCollect
$wgResourceModules[ 'gc.form.rapidhtml.webitects' ] = array(
	'styles' => '',
	'scripts' => array(
		'js/webitects.js',
		#'js/webitects.accordian.js',
	),
	'dependencies' => 'di.form.rapidhtml.webitects',
	'localBasePath' => dirname( __FILE__ ).'/../../globalcollect_gateway/forms',
	'remoteExtPath' => $wgGlobalCollectRapidHtmlRemoteExtPath,
);
$wgResourceModules[ 'gc.form.rapidhtml.webitects.ie6' ] = array(
	'dependencies' => array(
		'di.form.rapidhtml.webitects.ie6',
		'gc.form.rapidhtml.webitects'
	),
	'localBasePath' => dirname( __FILE__ ).'/../../globalcollect_gateway/forms',
	'remoteExtPath' => $wgGlobalCollectRapidHtmlRemoteExtPath,
);
$wgResourceModules[ 'gc.form.rapidhtml.webitects.1st' ] = array(
	'styles' => '',
	'scripts' => 'js/webitects_2_3step.js',
	'dependencies' => array(
		'gc.form.rapidhtml.webitects',
	),
	'localBasePath' => dirname( __FILE__ ).'/../../globalcollect_gateway/forms',
	'remoteExtPath' => $wgGlobalCollectRapidHtmlRemoteExtPath,
);
$wgResourceModules[ 'gc.form.rapidhtml.webitects.2nd' ] = array(
	'styles' => '',
	'scripts' => 'js/webitects2nd.js',
	'dependencies' => array(
		'gc.form.rapidhtml.webitects',
		'di.form.rapidhtml.webitects.2nd'
	),
	'localBasePath' => dirname( __FILE__ ).'/../../globalcollect_gateway/forms',
	'remoteExtPath' => $wgGlobalCollectRapidHtmlRemoteExtPath,
);
$wgResourceModules[ 'gc.form.rapidhtml.webitects.2nd.US' ] = array(
	'styles' => '',
	'scripts' => 'js/webitects2nd-US.js',
	'dependencies' => array(
		'gc.form.rapidhtml.webitects',
		'di.form.rapidhtml.webitects.2nd'
	),
	'localBasePath' => dirname( __FILE__ ).'/../../globalcollect_gateway/forms',
	'remoteExtPath' => $wgGlobalCollectRapidHtmlRemoteExtPath,
);
$wgResourceModules[ 'gc.form.rapidhtml.webitects.bt' ] = array(
	'styles' => '',
//	'scripts' => 'js/webitects.bt.js',
	'dependencies' => array(
		'gc.form.rapidhtml.webitects.2nd',
		#'gc.form.core.validate'
	),
	'localBasePath' => dirname( __FILE__ ).'/../../globalcollect_gateway/forms',
	'remoteExtPath' => $wgGlobalCollectRapidHtmlRemoteExtPath,
);
$wgResourceModules[ 'gc.form.rapidhtml.webitects.dd' ] = array(
	'styles' => '',
	'scripts' => 'js/webitects.bt.js',
	'dependencies' => 'gc.form.rapidhtml.webitects.2nd',
	'localBasePath' => dirname( __FILE__ ).'/../../globalcollect_gateway/forms',
	'remoteExtPath' => $wgGlobalCollectRapidHtmlRemoteExtPath,
);
$wgResourceModules[ 'gc.form.rapidhtml.cc' ] = array(
	'styles' => 'css/gc.cc.css',
	'scripts' => array(
        'js/gc.js',
        'js/gc.cc.js'
    ),
	'dependencies' => array( 'di.form.core.validate' ),
	'localBasePath' => dirname( __FILE__ ).'/../../globalcollect_gateway/forms',
	'remoteExtPath' => $wgGlobalCollectRapidHtmlRemoteExtPath,
);


/*************************************************************
 *************************************************************
 *************************************************************/

// PayflowPro
$wgResourceModules[ 'pfp.form.rapidhtml.webitects' ] = array(
	'styles' => '',
	'scripts' => 'js/webitects_2_3step.js',
	'dependencies' => array(
		'di.form.rapidhtml.webitects',
		'di.form.core.validate'
	),
	'localBasePath' => dirname( __FILE__ ).'/../../payflowpro_gateway/forms',
	'remoteExtPath' => $wgPayflowRapidHtmlRemoteExtPath,
);
$wgResourceModules[ 'pfp.form.rapidhtml.webitects.2nd' ] = array(
	'styles' => '',
	'scripts' => 'js/webitects2nd.js',
	'dependencies' => array(
		'di.form.rapidhtml.webitects',
		'di.form.core.validate'
	),
	'localBasePath' => dirname( __FILE__ ).'/../../payflowpro_gateway/forms',
	'remoteExtPath' => $wgPayflowRapidHtmlRemoteExtPath,
);
$wgResourceModules[ 'pfp.form.rapidhtml.webitects.2nd.US' ] = array(
	'styles' => '',
	'scripts' => 'js/webitects2nd-US.js',
	'dependencies' => array(
		'pfp.form.rapidhtml.webitects',
		'di.form.core.validate'
	),
	'localBasePath' => dirname( __FILE__ ).'/../../payflowpro_gateway/forms',
	'remoteExtPath' => $wgPayflowRapidHtmlRemoteExtPath,
);
$wgResourceModules[ 'pfp.form.rapidhtml.webitects_2step' ] = array(
	'styles' => '',
	'scripts' => 'js/webitects_2_2step.js',
	'dependencies' => array(
		'di.form.rapidhtml.webitects.2nd',
		'di.form.core.validate'
	),
	'localBasePath' => dirname( __FILE__ ).'/../../payflowpro_gateway/forms',
	'remoteExtPath' => $wgPayflowRapidHtmlRemoteExtPath,
);
$wgResourceModules[ 'pfp.form.rapidhtml.webitects_2stepB' ] = array(
	'styles' => '',
	'scripts' => 'js/webitects_2_2stepB.js',
	'dependencies' => array(
		'di.form.core.validate',
		'di.form.rapidhtml.webitects'
	),
	'localBasePath' => dirname( __FILE__ ).'/../../payflowpro_gateway/forms',
	'remoteExtPath' => $wgPayflowRapidHtmlRemoteExtPath,
);
$wgResourceModules[ 'pfp.form.rapidhtml.webitects.ie6' ] = array(
	'dependencies' => array(
		'di.form.rapidhtml.webitects.ie6',
		'pfp.form.rapidhtml.webitects',	
	),
	'localBasePath' => dirname( __FILE__ ).'/../../payflowpro_gateway/forms',
	'remoteExtPath' => $wgPayflowRapidHtmlRemoteExtPath,
);

/**
 * globalcollect_test
 */
$wgResourceModules[ 'pfp.form.rapidhtml.globalcollect_test' ] = array(
	'dependencies' => 'pfp.form.TwoStepTwoColumnLetter3',
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => $wgPayflowRapidHtmlRemoteExtPath,
);
$wgResourceModules[ 'pfp.form.rapidhtml.globalcollect_test_2' ] = array(
	'scripts' => 'js/globalcollect_test_2.js',
	'dependencies' => 'pfp.form.rapidhtml.globalcollect_test',
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => $wgPayflowRapidHtmlRemoteExtPath,
);

/**
 * TwoStepTwoColumnLetter3 Deathmatch
 */
$wgResourceModules[ 'pfp.form.rapidhtml.TwoStepTwoColumnLetter3' ] = array(
	'styles' => 'css/TwoStepTwoColumnLetter3.css',
	'scripts' => 'js/TwoStepTwoColumnLetter3.js',
	'dependencies' => array( 'di.form.core.validate' ),
	'localBasePath' => dirname( __FILE__ ).'/../../payflowpro_gateway/forms',
	'remoteExtPath' => $wgPayflowRapidHtmlRemoteExtPath,
);
$wgResourceModules[ 'pfp.form.rapidhtml.TwoStepTwoColumnLetter3.orig' ] = array(
	'styles' => 'css/TwoStepTwoColumnLetter3-orig.css',
	'scripts' => 'js/TwoStepTwoColumnLetter3.js',
	'dependencies' => array( 'di.form.core.validate' ),
	'localBasePath' => dirname( __FILE__ ).'/../../payflowpro_gateway/forms',
	'remoteExtPath' => $wgPayflowRapidHtmlRemoteExtPath,
);

