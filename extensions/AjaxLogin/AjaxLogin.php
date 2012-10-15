<?php
/**
 * AjaxLogin extension - allows users to log in through an AJAX pop-up box
 *
 * @file
 * @ingroup Extensions
 * @version 2.2.1
 * @author Inez Korczyński <korczynski(at)gmail(dot)com>
 * @author Jack Phoenix <jack@countervandalism.net>
 * @author Ryan Schmidt <skizzerz@shoutwiki.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point.\n" );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'AjaxLogin',
	'version' => '2.2.1',
	'author' => array( 'Inez Korczyński', 'Jack Phoenix', 'Ryan Schmidt' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:AjaxLogin',
	'descriptionmsg' => 'ajaxlogin-desc',
);

// Array of skins for which AjaxLogin is enabled.
// Key is: 'skinname' => (true or false)
$wgEnableAjaxLogin = array(
	'monobook' => true,
	'vector' => true
);

// Autoload AjaxLogin API interface
$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['ApiAjaxLogin'] = $dir . 'ApiAjaxLogin.php';
$wgAPIModules['ajaxlogin'] = 'ApiAjaxLogin';

// Internationalization file
$wgExtensionMessagesFiles['AjaxLogin'] = $dir . 'AjaxLogin.i18n.php';

// Hook things up
$wgHooks['BeforePageDisplay'][] = 'AjaxLoginJS';
$wgHooks['SkinAfterContent'][] = 'GetAjaxLoginForm';
$wgHooks['ResourceLoaderGetConfigVars'][] = 'efAddAjaxLoginVariables';

/**
 * Adds required JavaScript & CSS files to the HTML output of a page if AjaxLogin is enabled
 *
 * @param $out OutputPage object
 * @return true
 */
function AjaxLoginJS( OutputPage $out ) {
	global $wgEnableAjaxLogin, $wgScriptPath;

	# Don't load anything if AjaxLogin isn't enabled or if we're on login page
	if ( !isset( $wgEnableAjaxLogin ) || $out->getTitle()->isSpecial( 'Userlogin' ) ) {
		return true;
	}

	// Our custom CSS
	$out->addExtensionStyle( $wgScriptPath . '/extensions/AjaxLogin/AjaxLogin.css' );
	// jQuery and JQModal scripts
	$out->includeJQuery();
	$out->addScriptFile( $wgScriptPath . '/extensions/AjaxLogin/jqModal.js' );
	$out->addScriptFile( $wgScriptPath . '/extensions/AjaxLogin/AjaxLogin.js' );

	return true;
}

/**
 * Adds the required JavaScript variables inside the <head> tags of the page
 * if AjaxLogin is enabled and the current page is not an article page.
 *
 * @param $vars Variables to be added
 * @return true
 */
function efAddAjaxLoginVariables( $vars ) {
	global $wgEnableAjaxLogin;

	$vars['wgEnableAjaxLogin'] = ( is_array( $wgEnableAjaxLogin ) ) ? in_array( $vars['skin'], $wgEnableAjaxLogin ) : false;
	if ( $vars['wgIsArticle'] == false && $vars['wgEnableAjaxLogin'] ) {
		$vars['ajaxLogin1'] = wfMsg( 'ajaxLogin1' );
		$vars['ajaxLogin2'] = wfMsg( 'ajaxLogin2' );
	}

	return true;
}

/**
 * Adds the AjaxLogin form to the skin output for anonymous users on non-login
 * pages
 *
 * @param $data The data, AjaxLogin form in this case, to be added to the HTML output of a page
 * @return true
 */
function GetAjaxLoginForm( &$data, $skin = null ) {
	global $wgAuth, $wgEnableEmail, $wgOut, $wgUser;
	global $wgEnableAjaxLogin;
	if( is_null( $skin ) ) {
		global $wgTitle;
		$userlogincheck = $wgTitle->getNamespace() != 8 && $wgTitle->getDBkey() != 'Userlogin';
	} else {
		$userlogincheck = $skin->getTitle()->getNamespace() != 8 && !$skin->getTitle()->isSpecial( 'Userlogin' );
	}
	if( isset( $wgEnableAjaxLogin ) && $wgUser->isAnon() && $userlogincheck ) {
		$titleObj = SpecialPage::getTitleFor( 'Userlogin' );
		$link = $titleObj->getLocalURL( 'type=signup' );
		$wgOut->addHTML( '<!--[if lt IE 9]><style type="text/css">#userloginRound { width: 350px !important; }</style><![endif]-->
	<div id="userloginRound" class="roundedDiv jqmWindow">
	<b class="xtop"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b></b>
	<div class="r_boxContent">
		<div>
			<div id="wpClose"><a href="#" tabindex="108"><span>X</span></a></div>
			<div class="boxHeader color1">' . wfMsg( 'login' ) . '</div>
		</div>
		<form action="" method="post" name="userajaxloginform" id="userajaxloginform">
			<div id="wpError"></div>
			<label>' . wfMsg( 'loginprompt' ) . '</label><br /><br />
			<label for="wpName1">' . wfMsg( 'yourname' ) . '</label><br />
			<input type="text" class="loginText" name="wpName" id="wpName1" tabindex="101" size="20" /><br />
			<label for="wpPassword1">' . wfMsg( 'yourpassword' ) . '</label><br />
			<input type="password" class="loginPassword" name="wpPassword" id="wpPassword1" tabindex="102" size="20" /><br />
			<div id="ajaxLoginRememberMe">
				<input type="checkbox" name="wpRemember" tabindex="104" value="1" id="wpRemember1"' . ( $wgUser->getOption( 'rememberpassword' ) ? ' checked="checked"' : '' ) . ' />
				<label for="wpRemember1">' . wfMsg( 'remembermypassword' ) . '</label><br />
			</div>
			<input type="submit" name="wpLoginattempt" id="wpLoginattempt" tabindex="105" value="' . wfMsg( 'login' ) . '" />' . "\n"
		);
		if ( $wgEnableEmail && $wgAuth->allowPasswordChange() ) {
			$wgOut->addHTML( "\t\t\t" . '<br /><input type="submit" name="wpMailmypassword" id="wpMailmypassword" tabindex="106" value="' . wfMsg( 'mailmypassword' ) . '" />' . "\n\t\t\t" );
		}
		// Originally this used core message 'nologinlink' but it wouldn't work too well for Finnish, so I changed it. --Jack Phoenix
		$wgOut->addHTML(
			'<br /><a id="wpAjaxRegister" tabindex="107" href="' . htmlspecialchars( $link ) . '">' . wfMsg( 'ajaxlogin-create' ) . '</a>
		</form>
	</div>
	<b class="xbottom"><b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></b>
	</div>' . "\n"
		);
	}
	return true;
}
