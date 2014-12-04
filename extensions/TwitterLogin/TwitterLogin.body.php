<?php
/**
 * TwitterLogin.body.php
 * Written by David Raison, based on the guideline published by Dave Challis at http://blogs.ecs.soton.ac.uk/webteam/2010/04/13/254/
 * @license: LGPL (GNU Lesser General Public License) http://www.gnu.org/licenses/lgpl.html
 *
 * @file TwitterLogin.body.php
 * @ingroup TwitterLogin
 *
 * @author David Raison
 *
 * Uses the twitter oauth library by Abraham Williams from https://github.com/abraham/twitteroauth
 *
 */

class TwitterSigninUI {
	/**
	 * Add a sign in with Twitter button but only when a user is not logged in
	 */
	public function efAddSigninButton( &$out, &$skin ) {
		global $wgUser, $wgExtensionAssetsPath, $wgScriptPath;
	
		if ( !$wgUser->isLoggedIn() ) {
			$link = SpecialPage::getTitleFor( 'TwitterLogin', 'redirect' )->getLinkUrl(); 
			$out->addInlineScript('$j(document).ready(function(){
				$j("#pt-anonlogin, #pt-login").after(\'<li id="pt-twittersignin">'
				.'<a href="' . $link  . '">'
				.'<img src="' . $wgExtensionAssetsPath . '/TwitterLogin/'
				.'images/sign-in-with-twitter-d.png" width="120px"/></a></li>\');
			})');
		}
		return true;
	}
}
