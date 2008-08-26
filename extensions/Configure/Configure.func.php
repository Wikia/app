<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Functions for Configure extension
 *
 * @file
 * @author Alexandre Emsenhuber
 * @license GPLv2 or higher
 * @ingroup Extensions
 */

/**
 * Ajax function to create checkboxes for a new group in $wgGroupPermissions
 *
 * @param $group String: new group name
 * @return either <err#> if group already exist or html fragment
 */
function efConfigureAjax( $group ){
	global $wgUser, $wgGroupPermissions;
	if( !$wgUser->isAllowed( 'configure-all' ) ){
		return '<err#>';
	}
	if( isset( $wgGroupPermissions[$group] ) ){
		$html = '<err#>';
	} else {
		if( is_callable( array( 'User', 'getAllRights' ) ) ){ // 1.13 +
			$all = User::getAllRights();
		} else {
			$all = array();
			foreach( $wgGroupPermissions as $rights )
				$all = array_merge( $all, array_keys( $rights ) );
			$all = array_unique( $all );
		}
		$row = '<div style="-moz-column-count:2"><ul>';
		foreach( $all as $right ){
			$id = Sanitizer::escapeId( 'wpwgGroupPermissions-'.$group.'-'.$right );
			$desc = ( is_callable( array( 'User', 'getRightDescription' ) ) ) ?
				User::getRightDescription( $right ) :
				$right;
			$row .= '<li>'.Xml::checkLabel( $desc, $id, $id ) . "</li>\n";
		}
		$row .= '</ul></div>';
		$groupName = User::getGroupName( $group );
		// Firefox seems to not like that :(
		$html = str_replace( '&nbsp;', ' ', $row );
	}
	return $html;
}

/**
 * Initalize the settings stored in a serialized file.
 * This have to be done before the end of LocalSettings.php but is in a function
 * because administrators might configure some settings between the moment where
 * the file is loaded and the execution of these function.
 * Settings are not filled only if they doesn't exists because of a security
 * hole if the register_globals feature of PHP is enabled.
 *
 * @param $wiki String
 */
function efConfigureSetup( $wiki = 'default' ){
	global $wgConf, $wgConfigureFilesPath;

	# Create the new configuration object...
	$oldConf = $wgConf;
	require_once( dirname( __FILE__ ) . '/Configure.obj.php' );
	$wgConf = new WebConfiguration( $wiki, $wgConfigureFilesPath );

	# Copy the existing settings...
	$wgConf->suffixes = $oldConf->suffixes;
	$wgConf->wikis = $oldConf->wikis;
	$wgConf->settings = $oldConf->settings;
	$wgConf->localVHosts = $oldConf->localVHosts;

	# Load the new configuration, and fill in the settings
	$wgConf->initialise();
	$wgConf->extract();
}

/**
 * Function that loads the messages in $wgMessageCache, it is used for backward
 * compatibility with 1.10 and older versions
 */
function efConfigureLoadMessages(){
	if( function_exists( 'wfLoadExtensionMessages' ) ){
		wfLoadExtensionMessages( 'Configure' );
	} else {
		global $wgMessageCache;
		require( dirname( __FILE__ ) . '/Configure.i18n.php' );
		foreach( $messages as $lang => $messages ){
			$wgMessageCache->addMessages( $messages, $lang );
		}
	}
}

/**
 * Loads special pages aliases, for backward compatibility with < 1.13
 */
function efConfigureLoadAliases( &$spAliases, $code ){
	require( dirname( __FILE__ ) . '/Configure.alias.php' );
	do {
		if( isset( $aliases[$code] ) ){
			foreach( $aliases[$code] as $can => $aliasArr ){
				foreach( $aliasArr as $alias )
					$spAliases[$can][] = str_replace( ' ', '_', $alias );
			}
		}
	} while( $code = Language::getFallbackFor( $code ) );
	return true;
}
