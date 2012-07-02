<?php

if ( !defined( 'MEDIAWIKI' ) )
	die();

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'Semantic ACL',
	'author'         => array( 'Andrew Garrett' ),
	'descriptionmsg' => 'sacl-desc',
	'url' 		 => 'https://www.mediawiki.org/wiki/Extension:SemanticACL',
);

$wgExtensionMessagesFiles['SemanticACL'] = dirname(__FILE__) . '/SemanticACL.i18n.php';

$wgHooks['userCan'][] = 'saclGetPermissionErrors';
$wgHooks['smwInitProperties'][] = 'saclInitProperties';

$wgGroupPermissions['sysop']['sacl-exempt'] = true;

// Initialise predefined properties
function saclInitProperties() {
	// Read restriction properties
	SMWDIProperty::registerProperty( '___VISIBLE', '_str',
					wfMsgForContent('sacl-property-visibility') );
	SMWDIProperty::registerProperty( '___VISIBLE_WL_GROUP', '_str',
					wfMsgForContent('sacl-property-visibility-wl-group') );
	SMWDIProperty::registerProperty( '___VISIBLE_WL_USER', '_wpg',
					wfMsgForContent('sacl-property-visibility-wl-user') );

	SMWDIProperty::registerPropertyAlias( '___VISIBLE', 'Visible to' );
	SMWDIProperty::registerPropertyAlias( '___VISIBLE_WL_GROUP', 'Visible to group' );
	SMWDIProperty::registerPropertyAlias( '___VISIBLE_WL_USER', 'Visible to user' );
					
	// Write restriction properties
	SMWDIProperty::registerProperty( '___EDITABLE', '_str',
					wfMsgForContent('sacl-property-editable') );
	SMWDIProperty::registerProperty( '___EDITABLE_WL_GROUP', '_str',
					wfMsgForContent('sacl-property-editable-wl-group') );
	SMWDIProperty::registerProperty( '___EDITABLE_WL_USER', '_wpg',
					wfMsgForContent('sacl-property-editable-wl-user') );
	
	SMWDIProperty::registerPropertyAlias( '___EDITABLE_BY', 'Editable by' );
	SMWDIProperty::registerPropertyAlias( '___EDITABLE_WL_GROUP', 'Editable by group' );
	SMWDIProperty::registerPropertyAlias( '___EDITABLE_WL_USER', 'Editable by user' );
					
	return true;
}


function saclGetPermissionErrors( $title, $user, $action, &$result ) {

	// Failsafe: Some users are exempt from Semantic ACLs
	if ( $user->isAllowed( 'sacl-exempt' ) ) {
		return true;
	}

	$store = smwfGetStore();
	$subject = SMWDIWikiPage::newFromTitle( $title );
	
	// The prefix for the whitelisted group and user properties
	// Either ___VISIBLE or ___EDITABLE
	$prefix = '';
	
	if ( $action == 'read' ) {
		$prefix = '___VISIBLE';
	} else {
		$type_property = 'Editable by';
		$prefix = '___EDITABLE';
	}
	
	$property = new SMWDIProperty($prefix);
	$aclTypes = $store->getPropertyValues( $subject, $property );
	
	foreach( $aclTypes as $valueObj ) {
		$value = strtolower($valueObj->getString());
		
		if ( $value == 'users' ) {
			if ( $user->isAnon() ) {
				$result = false;
				return false;
			}
		} elseif ( $value == 'whitelist' ) {
			$isWhitelisted = false;
			
			$groupProperty = new SMWDIProperty( "{$prefix}_WL_GROUP" );
			$userProperty = new SMWDIProperty( "{$prefix}_WL_USER" );
			$whitelistValues = $store->getPropertyValues( $subject, $groupProperty );
			
			foreach( $whitelistValues as $whitelistValue ) {
				$group = strtolower($whitelistValue->getString());
				
				if ( in_array( $group, $user->getEffectiveGroups() ) ) {
					$isWhitelisted = true;
					break;
				}
			}
			
			$whitelistValues = $store->getPropertyValues( $subject, $userProperty );
			
			foreach( $whitelistValues as $whitelistValue ) {
				$title = $whitelistValue->getTitle();
				
				if ( $title->equals( $user->getUserPage() ) ) {
					$isWhitelisted = true;
				}
			}
			
			if ( ! $isWhitelisted ) {
				$result = false;
				return false;
			}
		} elseif ( $value == 'public' ) {
			return true;
		}
	}
	
	return true;
}
