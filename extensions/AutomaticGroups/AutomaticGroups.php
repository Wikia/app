<?php

/**
 * Extension provides convenient configuration of additional
 * effective user rights and groups based on a user's account
 * age and edit count
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */
if( defined( 'MEDIAWIKI' ) ) {

	$wgExtensionCredits['other'][] = array(
		'name'           => 'Automatic Groups',
		'author'         => 'Rob Church',
		'url'            => 'http://www.mediawiki.org/wiki/Extension:Automatic_Groups',
		'description'    => 'Convenient configuration of user rights and group membership based on user account age and edit count',
		'descriptionmsg' => 'automaticgroups-desc'
	);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['automaticgroups'] = $dir . 'AutomaticGroups.i18n.php';	

	/**
	 * Register hook callbacks
	 */
	$wgHooks['UserEffectiveGroups'][] = 'efAutomaticGroups';
	$wgHooks['UserGetRights'][] = 'efAutomaticRights';
	
	/**
	 * Automatic group configuration
	 *
	 * Index is the group being assigned, with a second array
	 * of account properties; acceptable keys are 'age' and 'edits'
	 *
	 * See README for more information and examples
	 */
	$wgAutomaticGroups = array();
	
	/**
	 * Automatic rights configuration; same format as $wgAutomaticGroups
	 */
	$wgAutomaticRights = array();
	
	/**
	 * Hook effective groups assignment
	 *
	 * @param User $user User to add automatic groups to
	 * @param array $groups Group list to be modified
	 * @return bool
	 */
	function efAutomaticGroups( $user, &$groups ) {
		global $wgAutomaticGroups;
		wfLoadExtensionMessages( 'automaticgroups' );
		$groups = array_merge(
			$groups,
			efCalculateAutomaticRights( $user, $wgAutomaticGroups )
		);
		return true;
	}

	/**
	 * Hook effective rights assignment
	 *
	 * @param User $user User to add automatic groups to
	 * @param array $rights Rights list to be modified
	 * @return bool
	 */
	function efAutomaticRights( $user, &$rights ) {
		global $wgAutomaticRights;
		$rights = array_merge(
			$rights,
			efCalculateAutomaticRights( $user, $wgAutomaticRights )
		);
		return true;
	}
	
	/**
	 * Calculate automatic rights or group membership
	 * using the supplied criteria
	 *
	 * @param User $user User to get rights/groups for
	 * @param array $criteria Criteria map
	 * @return array
	 */
	function efCalculateAutomaticRights( $user, $criteria ) {
		$attributes = array();
		$age = time() - wfTimestampOrNull( TS_UNIX, $user->getRegistration() );
		foreach( $criteria as $attribute => $criterion ) {
			if( isset( $criterion['age'] ) && $age < $criterion['age'] )
				continue;
			if( isset( $criterion['edits'] ) && $user->getEditCount() < $criterion['edits'] )
				continue;
			# User qualifies for this attribute
			$attributes[] = $attribute;
		}
		return $attributes;
	}
	
} else {
	echo( "This file is an extension to MediaWiki and cannot be used standalone.\n" );
	exit( 1 );
}
