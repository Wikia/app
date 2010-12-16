<?php
/**
 * DataCenter extension
 *
 * @file
 * @ingroup Extensions
 *
 * This file contains the main include file for the DataCenter
 * extension of MediaWiki.
 *
 * Usage: Add the following line in LocalSettings.php:
 * require_once( "$IP/extensions/DataCenter/DataCenter.php" );
 *
 * @author Trevor Parscal <tparscal@wikimedia.org>
 * @license GPL v2
 * @version 0.1.0
 */

// Check environment
if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This is a MediaWiki extension and cannot be run standalone.\n" );
	die( 1 );
}

/* Configuration */

// GoogleMaps API Key - to get one for your own installation, go to
// http://code.google.com/apis/maps/signup.XML
$egDataCenterGoogleMapsAPIKey =
	'ABQIAAAAo3BpqDgnwu31qtxQuWSXxhRfg0gREfvmgqiKvmq8TMsZGNFQPxRj0C9gpgXFOwUITevSg6mG9zBHCQ';

/* MediaWiki Integration */

// Credits
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'DataCenter',
	'version' => '0.1.0',
	'author' => 'Trevor Parscal',
	'url' => 'http://www.mediawiki.org/wiki/Extension:DataCenter',
	'description' => 'DataCenter Planning and Asset Tracking System',
	'descriptionmsg' => 'datacenter-desc',
);

// User permissions
$wgGroupPermissions['dc-viewer']['datacenter-view'] = true;
$wgGroupPermissions['dc-viewer']['datacenter-export'] = true;
$wgGroupPermissions['dc-admin']['datacenter-view'] = true;
$wgGroupPermissions['dc-admin']['datacenter-export'] = true;
$wgGroupPermissions['dc-admin']['datacenter-change'] = true;
$wgGroupPermissions['dc-admin']['datacenter-remove'] = true;

// Shortcut to this extension directory
$dir = dirname( __FILE__ ) . '/';

// Internationalization
$wgExtensionMessagesFiles['DataCenter'] = $dir . 'DataCenter.i18n.php';

// Ajax Hooks
$wgAjaxExportList[] = 'DataCenterAjax::getComponent';
$wgAjaxExportList[] = 'DataCenterAjax::getComponents';

// Spacial Pages
$wgSpecialPages['DataCenter'] = 'DataCenterPage';

// Class Autoloading
$wgAutoloadClasses = array_merge( $wgAutoloadClasses, array(
	// Controllers/*
	'DataCenterControllerAssets' => $dir . 'Controllers/Assets.php',
	'DataCenterControllerFacilities' => $dir . 'Controllers/Facilities.php',
	'DataCenterControllerModels' => $dir . 'Controllers/Models.php',
	'DataCenterControllerOverview' => $dir . 'Controllers/Overview.php',
	'DataCenterControllerPlans' => $dir . 'Controllers/Plans.php',
	'DataCenterControllerSearch' => $dir . 'Controllers/Search.php',
	'DataCenterControllerSettings' => $dir . 'Controllers/Settings.php',
	// UI/Inputs/*
	'DataCenterInputBoolean' => $dir . 'UI/Inputs/Boolean.php',
	'DataCenterInputButton' => $dir . 'UI/Inputs/Button.php',
	'DataCenterInputList' => $dir . 'UI/Inputs/List.php',
	'DataCenterInputNumber' => $dir . 'UI/Inputs/Number.php',
	'DataCenterInputPosition' => $dir . 'UI/Inputs/Position.php',
	'DataCenterInputString' => $dir . 'UI/Inputs/String.php',
	'DataCenterInputTense' => $dir . 'UI/Inputs/Tense.php',
	'DataCenterInputText' => $dir . 'UI/Inputs/Text.php',
	// UI/Layouts/*
	'DataCenterLayoutColumns' => $dir . 'UI/Layouts/Columns.php',
	'DataCenterLayoutRows' => $dir . 'UI/Layouts/Rows.php',
	'DataCenterLayoutTabs' => $dir . 'UI/Layouts/Tabs.php',
	// UI/Widgets/*
	'DataCenterWidgetActions' => $dir . 'UI/Widgets/Actions.php',
	'DataCenterWidgetBody' => $dir . 'UI/Widgets/Body.php',
	'DataCenterWidgetDetails' => $dir . 'UI/Widgets/Details.php',
	'DataCenterWidgetExport' => $dir . 'UI/Widgets/Export.php',
	'DataCenterWidgetFieldLinks' => $dir . 'UI/Widgets/FieldLinks.php',
	'DataCenterWidgetForm' => $dir . 'UI/Widgets/Form.php',
	'DataCenterWidgetGallery' => $dir . 'UI/Widgets/Gallery.php',
	'DataCenterWidgetHeading' => $dir . 'UI/Widgets/Heading.php',
	'DataCenterWidgetHistory' => $dir . 'UI/Widgets/History.php',
	'DataCenterWidgetMap' => $dir . 'UI/Widgets/Map.php',
	'DataCenterWidgetModel' => $dir . 'UI/Widgets/Model.php',
	'DataCenterWidgetPlan' => $dir . 'UI/Widgets/Plan.php',
	'DataCenterWidgetSearch' => $dir . 'UI/Widgets/Search.php',
	'DataCenterWidgetSearchResults' => $dir . 'UI/Widgets/SearchResults.php',
	'DataCenterWidgetSpace' => $dir . 'UI/Widgets/Space.php',
	'DataCenterWidgetTable' => $dir . 'UI/Widgets/Table.php',
	// Views/Facilities/*
	'DataCenterViewFacilitiesLocation' => $dir . 'Views/Facilities/Location.php',
	'DataCenterViewFacilitiesSpace' => $dir . 'Views/Facilities/Space.php',
	// Views/Plans/*
	'DataCenterViewPlansObject' => $dir . 'Views/Plans/Object.php',
	'DataCenterViewPlansPlan' => $dir . 'Views/Plans/Plan.php',
	'DataCenterViewPlansRack' => $dir . 'Views/Plans/Rack.php',
	// Views/Settings/*
	'DataCenterViewSettingsField' => $dir . 'Views/Settings/Field.php',
	// Views/*
	'DataCenterViewAssets' => $dir . 'Views/Assets.php',
	'DataCenterViewFacilities' => $dir . 'Views/Facilities.php',
	'DataCenterViewModels' => $dir . 'Views/Models.php',
	'DataCenterViewOverview' => $dir . 'Views/Overview.php',
	'DataCenterViewPlans' => $dir . 'Views/Plans.php',
	'DataCenterViewSearch' => $dir . 'Views/Search.php',
	'DataCenterViewSettings' => $dir . 'Views/Settings.php',
	// DB
	'DataCenterDB' => $dir . 'DataCenter.db.php',
	'DataCenterDBRow' => $dir . 'DataCenter.db.php',
	'DataCenterDBComponent' => $dir . 'DataCenter.db.php',
	'DataCenterDBAsset' => $dir . 'DataCenter.db.php',
	'DataCenterDBModel' => $dir . 'DataCenter.db.php',
	'DataCenterDBAssetLink' => $dir . 'DataCenter.db.php',
	'DataCenterDBModelLink' => $dir . 'DataCenter.db.php',
	'DataCenterDBMetaFieldLink' => $dir . 'DataCenter.db.php',
	'DataCenterDBLocation' => $dir . 'DataCenter.db.php',
	'DataCenterDBSpace' => $dir . 'DataCenter.db.php',
	'DataCenterDBMetaField' => $dir . 'DataCenter.db.php',
	'DataCenterDBMetaValue' => $dir . 'DataCenter.db.php',
	'DataCenterDBChange' => $dir . 'DataCenter.db.php',
	'DataCenterDBPlan' => $dir . 'DataCenter.db.php',
	// Page
	'DataCenterPage' => $dir . 'DataCenter.page.php',
	'DataCenterView' => $dir . 'DataCenter.page.php',
	'DataCenterController' => $dir . 'DataCenter.page.php',
	// UI
	'DataCenterCss' => $dir . 'DataCenter.ui.php',
	'DataCenterJs' => $dir . 'DataCenter.ui.php',
	'DataCenterXml' => $dir . 'DataCenter.ui.php',
	'DataCenterRenderable' => $dir . 'DataCenter.ui.php',
	'DataCenterInput' => $dir . 'DataCenter.ui.php',
	'DataCenterLayout' => $dir . 'DataCenter.ui.php',
	'DataCenterWidget' => $dir . 'DataCenter.ui.php',
	'DataCenterUI' => $dir . 'DataCenter.ui.php',
) );

/**
 * About this project
 *
 * This project uses a model-view-controller paradigm throughout. This helps
 * to keep the database, user interface and data processing separated, which
 * among other things makes it possible to replace any one of them with a
 * new system which lends itself to a different goal more effectively. One such
 * adaptation that would be likely in the future might be a iPhone/iPod Touch
 * oriented user interface.
 *
 * Throughout the code, but most especially in the design and use of classes,
 * there is a vocabulary which is hopefully intuitive, but if nothing else
 * consistent. Below is a simple glossary denoting the project-specific meanings
 * of various terms.
 *
 * View: User interface
 * Controller: Data processing
 * DB: Data model
 * Component: Data of which changes are logged
 * Asset: Record of a physical item
 * Rack: Enclosure in which objects with a rack-unit form-factor may exist
 * Object: Rack-unit, module, desktop or portable piece of equipment
 * Port: Physical or virtual point of connection
 * Connection: Set of 2 ports which are connected to each other
 * Model: Description of a physical item
 * Plan: Arrangment of physical items
 * Facility: Physical location or space
 * Location: Geographical location which may have any number of spaces
 * Space: Basic 3 dimensional box which is representative of a room
 * Layout: Visual structure containing one or more rectangular areas
 * Widget: Visual representation of data
 * Input: Visual interactive control for modifying data
 * Renderable: Rectangular area of a UI
 */
