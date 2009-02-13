<?php

/**
 * Special page allows users to register votes for a particular
 * option in a predefined list
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * Please see the LICENCE file for terms of use and redistribution
 */
 
if( defined( 'MEDIAWIKI' ) ) {

	$wgAutoloadClasses['SpecialVote'] = dirname( __FILE__ ) . '/Vote.page.php';
	$wgSpecialPages['Vote'] = 'SpecialVote';
	$wgExtensionFunctions[] = 'efVote';
	$wgExtensionCredits['specialpage'][] = array(
			'name' => 'Vote',
			'author' => 'Rob Church / gcardinal',
			'description' => 'Lottery added my gcardinal. Modified for pvxwiki.',
	);
	
	/**
	 * Users who can vote
	 */
	$wgGroupPermissions['user']['vote'] = false;
	/**
	 * Users who can view vote results
	 */
	$wgGroupPermissions['bureaucrat']['voteadmin'] = false;
	
	/**
	 * Extension setup function
	 */
	function efVote() {
		global $wgMessageCache, $wgHooks;
		require_once( dirname( __FILE__ ) . '/Vote.i18n.php' );
		foreach( efVoteMessages() as $lang => $messages )
			$wgMessageCache->addMessages( $messages, $lang );
		$wgHooks['SkinTemplateSetupPageCss'][] = 'efVoteCss';
	}
	
	/**
	 * Add extra CSS to the skin
	 */
	function efVoteCss( &$css ) {
		global $wgTitle;
		if( $wgTitle->isSpecial( 'Vote' ) ) {
			$file = dirname( __FILE__ ) . '/Vote.css';
			$css .= "/*<![CDATA[*/\n" . htmlspecialchars( file_get_contents( $file ) ) . "\n/*]]>*/";
		}
		return true;
	}


} else {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	exit( 1 ) ;
}

?>