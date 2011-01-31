<?php

/**
 * File defining the settings for the Semantic Maps extension.
 * More info can be found at http://www.mediawiki.org/wiki/Extension:Semantic_Maps#Settings
 *
 *                          NOTICE:
 * Changing one of these settings can be done by copieng or cutting it,
 * and placing it in LocalSettings.php, AFTER the inclusion of Semantic Maps.
 *
 * @file SM_Settings.php
 * @ingroup SemanticMaps
 *
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}



# Features configuration

	# (named) Array of String. This array contains the available features for Maps.
	# Commenting out the inclusion of any feature will make Maps completely ignore it, and so improve performance.
	
		# Query printers
		include_once $smgDir . 'includes/queryprinters/SM_QueryPrinters.php';
		# Form imputs
		include_once $smgDir . 'includes/forminputs/SM_FormInputs.php'; 



# Mapping services configuration

	# Include the mapping services that should be loaded into Semantic Maps. 
	# Commenting or removing a mapping service will cause Semantic Maps to completely ignore it, and so improve performance.
	# Google Maps API v2
	include_once $smgDir . 'includes/services/GoogleMaps/SM_GoogleMaps.php';
	# OpenLayers API
	include_once $smgDir . 'includes/services/OpenLayers/SM_OpenLayers.php';
	# Yahoo! Maps API
	include_once $smgDir . 'includes/services/YahooMaps/SM_YahooMaps.php';

	# Array of String. The default mapping service for each feature, which will be used when no valid service is provided by the user.
	# Each service needs to be enabled, if not, the first one from the available services will be taken.
	# Note: The default service needs to be available for the feature you set it for, since it's used as a fallback mechanism.
	$egMapsDefaultServices['qp'] = $egMapsDefaultService;
	$egMapsDefaultServices['fi'] = $egMapsDefaultService;
	
	

# General

	# Boolean. Indicates if spatial extensions should be used for coordinate storage.
	# Spatial extensions significantly speed up querying, but are not present by default on postgres databases.
	# If this value is false, coordinates will be stored in 2 float fields.
	# You are unlikely to need to change this setting, so don't unless you know what you are doing!
	$smgUseSpatialExtensions = false; // TODO: $wgDBtype != 'postgres';
	
	
	
# Queries

	# Boolean. The default value for the forceshow parameter. Will force a map to be shown even when there are no query results
	# when set to true. This value will only be used when the user does not provide one.
	$smgQPForceShow = false;
	
	# Boolean. The default value for the showtitle parameter. Will hide the title in the marker pop-ups when set to true. 
	# This value will only be used when the user does not provide one.
	$smgQPShowTitle = true;
	
	# String or false. Allows you to define the content and it's layout of marker pop-ups via a template.
	# This value will only be used when the user does not provide one.
	$smgQPTemplate = false;
	
	# Enum. The default output format of coordinates.
	# Possible values: Maps_COORDS_FLOAT, Maps_COORDS_DMS, Maps_COORDS_DM, Maps_COORDS_DD
	$smgQPCoodFormat = $egMapsCoordinateNotation;
	
	# Boolean. Indicates if coordinates should be outputted in directional notation by default.
	$smgQPCoodDirectional = $egMapsCoordinateDirectional;



# Forms

	# Integer or string. The default width and height of maps in forms created by using Semantic Forms.
	# These values only be used when the user does not provide them.
	$smgFIWidth = 665;
	$smgFIHeight = $egMapsMapHeight;