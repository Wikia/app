<?php 
/*
 Copyright (c) 2009, Wikimedia Deutschland (Daniel Kinzler)
  All rights reserved.
 
  Redistribution and use in source and binary forms, with or without
  modification, are permitted provided that the following conditions are met:
      * Redistributions of source code must retain the above copyright
        notice, this list of conditions and the following disclaimer.
      * Redistributions in binary form must reproduce the above copyright
        notice, this list of conditions and the following disclaimer in the
        documentation and/or other materials provided with the distribution.
      * Neither the name of Wikimedia Deutschland nor the
        names of its contributors may be used to endorse or promote products
        derived from this software without specific prior written permission.
 
  THIS SOFTWARE IS PROVIDED BY WIKIMEDIA DEUTSCHLAND ''AS IS'' AND ANY
  EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
  WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
  DISCLAIMED. IN NO EVENT SHALL WIKIMEDIA DEUTSCHLAND BE LIABLE FOR ANY
  DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
  (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
  LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
  ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
  (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
  SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

 NOTE: This software is not released as a product. It was written primarily for
 Wikimedia Deutschland's own use, and is made public as is, in the hope it may
 be useful. Wikimedia Deutschland may at any time discontinue developing or
 supporting this software. There is no guarantee any new versions or even fixes
 for security issues will be released.
*/

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "IPAuth.\n" );
	die( 1 );
}

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'IPAuth',
	'author' => 'Daniel Kinzler for Wikimedia Deutschland',
	'url' => 'http://mediawiki.org/wiki/Extension:IPAuth',
	'description' => 'Automatic login from fixed IPs',
	'descriptionmsg' => 'ipauth-desc',
);

$root = dirname( __FILE__ );
$wgExtensionMessagesFiles['IPAuth'] = $root . '/IPAuth.i18n.php';
$wgIPAuthUsers = array(  );
# $wgIPAuthUsers = array( "127.0.0.1" => "LocalUser" );

$wgHooks['UserLoadAfterLoadFromSession'][] = 'ipAuthUserLoadAfterLoadFromSession';

function ipAuthUserLoadAfterLoadFromSession( $user ) {
	global $wgIPAuthUsers;

	if ( $user->isLoggedIn() ) {
		return true;
	}

	$ip = wfGetIP();
	if ( isset( $wgIPAuthUsers[ $ip ] ) ) {
		$name = $wgIPAuthUsers[ $ip ];

		$xuser = User::newFromName( $name );

		if ( $xuser->getID() == 0 ) {
			wfDebug( "User $name assigned to IP $ip does not exist!\n" );
		} else {
			# HACK: force user data reload by assigning members directly
			$user->mId = $xuser->mId;
			$user->mName = $xuser->mName;
			$user->loadFromId();

			wfDebug( "User $name assigned to IP $ip logged in.\n" );

			if ( !isset( $_SESSION['wsUserID'] ) ) {
				wfDebug( "Setting up a session for $name assigned to IP $ip logged in.\n" );
				wfSetupSession();
				$_SESSION['wsToken'] = "IP:$ip";
				$_SESSION['wsUserName'] = $name;
				$user->setCookies();
			}
		}
	}
	
	return true;
}

