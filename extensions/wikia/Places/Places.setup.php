<?php

/**
 * Places
 *
 * Provides <place> and <places> parser hooks and Special:Places
 *
 * @author Jakub Kurcek <jakub at wikia-inc.com>
 * @author Maciej Brencz <macbre at wikia-inc.com>
 * @copyright Copyright (C) 2011 Jakub Kurcek, Wikia Inc.
 * @copyright Copyright (C) 2011 Maciej Brencz, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Places',
	'version' => '2.2',
	'author' => array(
		'Maciej Brencz',
		'Jakub Kurcek' ),
	'descriptionmsg' => 'places-desc',
	'url' => 'https://github.com/Wikia/app/blob/dev/extensions/wikia/Places/README.md'
);

$dir = dirname( __FILE__ );

/**
 * classes
 */

$wgAutoloadClasses['PlacesHooks'] =  $dir . '/PlacesHooks.class.php';
$wgAutoloadClasses['PlacesParserHookHandler'] =  $dir . '/PlacesParserHookHandler.class.php';
$wgAutoloadClasses['WikiaApiPlaces'] =  $dir . '/WikiaApiPlaces.class.php';

/**
 * controllers
 */

$wgAutoloadClasses['PlacesController'] =  $dir . '/PlacesController.class.php';
$wgAutoloadClasses['PlacesCategoryController'] =  $dir . '/PlacesCategoryController.class.php';
$wgAutoloadClasses['PlacesEditorController'] =  $dir . '/PlacesEditorController.class.php';
$wgAutoloadClasses['PlacesSpecialController'] =  $dir . '/PlacesSpecialController.class.php';
$wgAutoloadClasses['NearbySpecialController'] =  $dir . '/NearbySpecialController.class.php';

$wgSpecialPages['Places'] = 'PlacesSpecialController';
$wgSpecialPages['Nearby'] = 'NearbySpecialController';

/**
 * models
 */

$wgAutoloadClasses['PlacesModel'] =  $dir . '/models/PlacesModel.class.php';
$wgAutoloadClasses['PlaceModel'] =  $dir . '/models/PlaceModel.class.php';
$wgAutoloadClasses['PlaceStorage'] =  $dir . '/models/PlaceStorage.class.php';
$wgAutoloadClasses['PlaceCategory'] =  $dir . '/models/PlaceCategory.class.php';

/**
 * hooks
 */

$wgHooks['ParserFirstCallInit'][] = 'PlacesHooks::onParserFirstCallInit';
$wgHooks['BeforePageDisplay'][] = 'PlacesHooks::onBeforePageDisplay';
$wgHooks['ArticleSaveComplete'][] = 'PlacesHooks::onArticleSaveComplete';
$wgHooks['RTEUseDefaultPlaceholder'][] = 'PlacesHooks::onRTEUseDefaultPlaceholder';
$wgHooks['OutputPageBeforeHTML'][] = 'PlacesHooks::onOutputPageBeforeHTML';
$wgHooks['PageHeaderIndexExtraButtons'][] = 'PlacesHooks::onPageHeaderIndexExtraButtons';
$wgHooks['EditPage::showEditForm:initial'][] = 'PlacesHooks::onShowEditForm';

// for later
// $wgHooks['OutputPageMakeCategoryLinks'][] = 'PlacesHooks::onOutputPageMakeCategoryLinks';

/**
 * API module
 */
$wgAPIModules['places'] = 'WikiaApiPlaces';

/**
 * messages
 */
$wgExtensionMessagesFiles['Places'] = $dir . '/Places.i18n.php';
$wgExtensionMessagesFiles['PlacesAliases'] = $dir . '/Places.alias.php';

JSMessages::registerPackage('Places', array(
	'places-toolbar-button-*',
	'places-editor-*',
	'ok',
));

JSMessages::registerPackage('PlacesEditPageButton', array( 'places-toolbar-button-tooltip' ) );
JSMessages::registerPackage('PlacesGeoLocationModal', array( 'places-geolocation-modal-*' ) );

/**
 * Resources Loader module
 */
$wgResourceModules['ext.wikia.Nearby'] = [
	'scripts' => [
		'js/SpecialNearby.js',
	],
	'styles' => [
		'css/SpecialNearby.css'
	],
	'dependencies' => [
		'mediawiki.api'
	],
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/Places'
];
