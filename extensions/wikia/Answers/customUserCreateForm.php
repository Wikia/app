<?php
/**
 * Replace the standard user create form with a custom form 
 *
 * Installation: Create a folder named customUserCreateForm in your extension folder.
 * Create a new file named customUserCreateForm.php in the above folder and paste this code into the file.
 * Create a folder named templates inside the customUserCreateForm folder you created above
 * Make a copy of includes/templates/UserLogin.php in extensions/customUserCreateForm/templates/
 * Rename the copy of UserLogin.php to customUserlogin.php
 * Within the new customUserlogin.php file rename UsercreateTemplate class to customUsercreateTemplate.
 * Edit customUsercreateTemplate class as you require.
 * Add the line below to the bottom of your LocalSettings.php file.
 * Decide if you do not wish to allow non-Sysops to create user accounts via E-mail 
 * and delete the highlighted lines of code if so.
 * 
 * require_once($IP."/extensions/customUserCreateForm/customUserCreateForm.php");
 *
 * @author Matthew Vickery
 * @version 1.0
 */
 
#$wgHooks['UserCreateForm'][] = 'customUserCreateForm';
 
function customUserCreateForm($template) {
 
		// include the request global so we can grab the return page from it
		global $wgRequest ; 
 
		// grab the return to page if this exists
		$mReturnTo = $wgRequest->getVal( 'returnto' );
 
		// Grab data from the existing template before we destory it when creating a new template
		$tempData = $template->data ;
 
		// include our custom create account template
		include( 'templates/customUserRegistration.php' );
 
		// create a new template object using the custom template
		$template = new customUsercreateTemplate();
		$q = 'action=submitlogin&type=signup';
		$linkq = 'type=login';
		$linkmsg = 'gotaccount';
 
		// if there is a return to page adjust relevant links
		if ( !empty( $mReturnTo ) ) {
			$returnto = '&returnto=' . wfUrlencode( $mReturnTo );
			$q .= $returnto;
			$linkq .= $returnto;
		}
 
		// add the old template data to the new template
		foreach ($tempData as $key => $value) {
			$template->set( $key, $value ) ;
		}
 
		/* * *
		 * SPECIAL CASE
		 * ------------
		 * The following two lines of code allow non-Sysops to create accounts via E-mail
		 * This is functionality I want to implement on my Wiki
		 * Remove these lines if you want only Sysops to create accounts via E-mail
		 * (Sysops only is the default MediaWiki configuration)
		 * * * * * * */
		//global $wgEnableEmail ; 
		//$template->set( 'createemail', $wgEnableEmail );
 
		// unset the temporary data var
		unset ($tempData) ;
 
		return true ;
}
 
$wgExtensionCredits['other'][] = array(
        'name'        => 'customUserCreateForm',
        'version'     => '0.1',
        'author'      => 'Matthew Vickery',
        'url'         => 'http://www.mediawiki.org/wiki/Extension:CustomUserCreateForm',
        'description' => 'Replace the standard user create form with a custom form'
);

