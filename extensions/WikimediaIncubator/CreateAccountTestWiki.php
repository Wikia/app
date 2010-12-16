<?php
/*
* If URL parameters "testwikiproject" and "testwikicode" are set on page creation form, set them as user preference
* This can be used to work with my toolserver project (http://toolserver.org/~robin/?tool=proposewiki), so users don't *have* to change their preferences (automatically is always better :p)
*/
class AutoTestWiki {
	function onUserCreateForm( $template ) {
		global $wgRequest;
		$projectvalue = strtolower( $wgRequest->getVal( 'testwikiproject', '' ) );
		$codevalue = strtolower( $wgRequest->getVal( 'testwikicode', '' ) );
		if ( preg_match( '/[a-z][a-z][a-z]?/', $codevalue ) && in_array( $projectvalue, array( 'p', 'b', 't', 'q', 'n' ) ) ) {
			$template->set( 'header', '<input type="hidden" name="testwiki-project" value="' . $projectvalue . '" />
	<input type="hidden" name="testwiki-code" value="' . $codevalue . '" />
	' );
		}
		return true;
	}

	function onAddNewAccount( $user ) {
		global $wgRequest, $wmincPref;
		$getprojectvalue = $wgRequest->getVal( 'testwiki-project' );
		$getcodevalue = $wgRequest->getVal( 'testwiki-code' );
		if ( $getprojectvalue && $getcodevalue ) {
			$user->setOption( $wmincPref . '-project', $getprojectvalue );
			$user->setOption( $wmincPref . '-code', $getcodevalue );
			$user->saveSettings();
		}
		return true;
	}
}
