<?php

/**
 * File defining the settings for the Semantic Maps extension.
 * More info can be found at http://www.mediawiki.org/wiki/Extension:Semantic_Maps#Settings
 *
 *                          NOTICE:
 * Changing one of these settings can be done by copying or cutting it,
 * and placing it in LocalSettings.php, AFTER the inclusion of Semantic Maps.
 *
 * @file SM_Settings.php
 * @ingroup SemanticMaps
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}



# Mapping services configuration

	# Array of String. The default mapping service for each feature, which will be used when no valid service is provided by the user.
	# Each service needs to be enabled, if not, the first one from the available services will be taken.
	# Note: The default service needs to be available for the feature you set it for, since it's used as a fallback mechanism.
	$egMapsDefaultServices['qp'] = $egMapsDefaultService;
	$egMapsDefaultServices['fi'] = $egMapsDefaultService;
	
	

# Queries

	# Boolean. The default value for the forceshow parameter. Will force a map to be shown even when there are no query results
	# when set to true. This value will only be used when the user does not provide one.
	$smgQPForceShow = true;
	
	# Boolean. The default value for the showtitle parameter. Will hide the title in the marker pop-ups when set to true. 
	# This value will only be used when the user does not provide one.
	$smgQPShowTitle = true;

	# Boolean. The default value for the hidenamespace parameter. Will hide the namespace in the marker pop-ups when set to true.
	# This value will only be used when the user does not provide one.
	$smgQPHideNamespace = false;
	
	# String or false. Allows you to define the content and it's layout of marker pop-ups via a template.
	# This value will only be used when the user does not provide one.
	$smgQPTemplate = false;
	
	# Enum. The default output format of coordinates.
	# Possible values: Maps_COORDS_FLOAT, Maps_COORDS_DMS, Maps_COORDS_DM, Maps_COORDS_DD
	$smgQPCoodFormat = $egMapsCoordinateNotation;
	
	# Boolean. Indicates if coordinates should be outputted in directional notation by default.
	$smgQPCoodDirectional = $egMapsCoordinateDirectional;



# Forms

	$smgFIMulti = true;
	
	$smgFIFieldSize = 40;
	
	# Integer or string. The default width and height of maps in forms created by using Semantic Forms.
	# These values only be used when the user does not provide them.
	$smgFIWidth = 665;
	$smgFIHeight = $egMapsMapHeight;
	