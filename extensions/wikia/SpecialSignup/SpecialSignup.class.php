<?php

class Signup extends SpecialPage {
	function __construct() {
		parent::__construct('Signup');
	}

	function execute() {
		global $wgRequest, $wgHooks, $wgOut;
		$this->setHeaders();

		if( session_id() == '' ) {
			wfSetupSession();
		}
		$wgHooks['MakeGlobalVariablesScript'][] = 'wfSpecialUserloginSetupVars';
		$form = new ExtendedLoginForm( $wgRequest );
		$form->execute();
	}	

	static function TrackingOnSuccess (&$out) {
		if( isset( $_SESSION['Signup_AccountLoggedIn'] ) || !empty($_GET['loggedinok']) ) {
			$out->addScript('<script type="text/javascript">WET.byStr(\'signupActions/signup/login/success\');</script>');
			unset( $_SESSION['Signup_AccountLoggedIn'] );
		}
		return true;
	}
}

class ExtendedLoginForm extends LoginForm {
	var $mPasswordSending;
	
	// give data about password sending
        function execute() {
                if ( !is_null( $this->mCookieCheck ) ) {
                        $this->onCookieRedirectCheck( $this->mCookieCheck );
                        return;
                } else if( $this->mPosted ) {
                        if( $this->mCreateaccount ) {
                                return $this->addNewAccount();
                        } else if ( $this->mCreateaccountMail ) {
                                return $this->addNewAccountMailPassword();
                        } else if ( $this->mMailmypassword ) {
				$this->mPasswordSending = true;
                                return $this->mailPassword();
                        } else if ( ( 'submitlogin' == $this->mAction ) || $this->mLoginattempt ) {
                                return $this->processLogin();
                        }
                }
                $this->mainLoginForm( '' );
        }

        function successfulLogin() {
                global $wgUser, $wgOut;

                # Run any hooks; display injected HTML if any, else redirect
                $injected_html = '';
                wfRunHooks('UserLoginComplete', array(&$wgUser, &$injected_html));

                if( $injected_html !== '' ) {
                        $this->displaySuccessfulLogin( 'loginsuccess', $injected_html );
                } else {
                        $titleObj = Title::newFromText( $this->mReturnTo );
                        if ( !$titleObj instanceof Title ) {
                                $titleObj = Title::newMainPage();
                        }
			// if not session, then redirect + more
			if( session_id() != '' ) {
                                $_SESSION['Signup_AccountLoggedIn'] = 'created';
                        	$wgOut->redirect( $titleObj->getFullURL( $this->mReturnToQuery ) );
                        } else {
                        	$wgOut->redirect( $titleObj->getFullURL( array( $this->mReturnToQuery, 'loggedinok=1' ) ) );
                        }

                }
        }

	// extended to allow to cater better for things here
	// and - to serve a CLEANER template, without login
	// also to serve tracking
        function mainLoginForm( $msg, $msgtype = 'error' ) {
                global $wgUser, $wgOut, $wgAllowRealName, $wgEnableEmail;
                global $wgCookiePrefix, $wgLoginLanguageSelector;
                global $wgAuth, $wgEmailConfirmToEdit, $wgCookieExpiration;

                $titleObj = SpecialPage::getTitleFor( 'Userlogin' );
 
		 		if (!$this->mPosted) {
		 			$this->mType = null;
		 		} 
		// this is tracking
                if( ('' != $msg) && ('error' == $msgtype) ) { // we have an error
			if('login' != $this->mType) { //signup error
                        	$wgOut->addScript('<script type="text/javascript">WET.byStr(\'signupActions/signup/createaccount/failure\');</script>');
			} else { // login error
				if( !$this->mPasswordSending ) {
	                        	$wgOut->addScript('<script type="text/javascript">WET.byStr(\'signupActions/signup/login/failure\');</script>');
				} else {
	                        	$wgOut->addScript('<script type="text/javascript">WET.byStr(\'signupActions/signup/emailpassword/failure\');</script>');
				}
			}
		} else {
			if( $this->mPasswordSending ) {
	                        $wgOut->addScript('<script type="text/javascript">WET.byStr(\'signupActions/signup/emailpassword/success\');</script>');				
			}			                	
		}

                if ( $this->mType == 'signup' ) {
                        // Block signup here if in readonly. Keeps user from
                        // going through the process (filling out data, etc)
                        // and being informed later.
                        if ( wfReadOnly() ) {
                                $wgOut->readOnlyPage();
                                return;
                        } elseif ( $wgUser->isBlockedFromCreateAccount() ) {
                                $this->userBlockedMessage();
                                return;
                        } elseif ( count( $permErrors = $titleObj->getUserPermissionsErrors( 'createaccount', $wgUser, true ) )>0 ) {
                                $wgOut->showPermissionsErrorPage( $permErrors, 'createaccount' );
                                return;
                        }
                }

                if ( '' == $this->mName ) {
                        if ( $wgUser->isLoggedIn() ) {
                                $this->mName = $wgUser->getName();
                        } else {
                                $this->mName = isset( $_COOKIE[$wgCookiePrefix.'UserName'] ) ? $_COOKIE[$wgCookiePrefix.'UserName'] : null;
                        }
                }

                $titleObj = SpecialPage::getTitleFor( 'Signup' );

		// use a different template, we'll have a few additional variables that won't make sense for normal form
		$template = new SignupTemplate();
		$q = 'action=submitlogin&type=signup';
		$q2 = 'action=submitlogin&type=login';
		$linkq = 'type=login';
		$linkmsg = 'gotaccount';

		// ADi: marketing opt-in/out checkbox added
		$template->addInputItem( 'wpMarketingOptIn', 1, 'checkbox', 'tog-marketingallowed');

                if ( !empty( $this->mReturnTo ) ) {
                        $returnto = '&returnto=' . wfUrlencode( $this->mReturnTo );
                        if ( !empty( $this->mReturnToQuery ) )
                                $returnto .= '&returntoquery=' .
                                        wfUrlencode( $this->mReturnToQuery );
                        $q .= $returnto;
                        $linkq .= $returnto;
                        $q2 .= $returnto;
                }

                # Pass any language selection on to the mode switch link
                if( $wgLoginLanguageSelector && $this->mLanguage )
                        $linkq .= '&uselang=' . $this->mLanguage;

                $link = '<a href="' . htmlspecialchars ( $titleObj->getLocalUrl( $linkq ) ) . '">';
                $link .= wfMsgHtml( $linkmsg . 'link' ); # Calling either 'gotaccountlink' or 'nologinlink'
                $link .= '</a>';

                # Don't show a "create account" link if the user can't
                if( $this->showCreateOrLoginLink( $wgUser ) )
                        $template->set( 'link', wfMsgHtml( $linkmsg, $link ) );
                else
                        $template->set( 'link', '' );

                $template->set( 'header', '' );
                $template->set( 'name', $this->mName );
                $template->set( 'password', $this->mPassword );
                $template->set( 'retype', $this->mRetype );
                $template->set( 'actiontype', $this->mType );		

                $template->set( 'email', $this->mEmail );
                $template->set( 'realname', $this->mRealName );
                $template->set( 'domain', $this->mDomain );

                $template->set( 'actioncreate', $titleObj->getLocalUrl( $q ) );
                $template->set( 'actionlogin', $titleObj->getLocalUrl( $q2 ) );

                $template->set( 'message', $msg );
                $template->set( 'messagetype', $msgtype );
                $template->set( 'createemail', $wgEnableEmail && $wgUser->isLoggedIn() );
                $template->set( 'userealname', $wgAllowRealName );
                $template->set( 'useemail', $wgEnableEmail );
                $template->set( 'emailrequired', $wgEmailConfirmToEdit );
                $template->set( 'canreset', $wgAuth->allowPasswordChange() );
                $template->set( 'canremember', ( $wgCookieExpiration > 0 ) );
                $template->set( 'remember', $wgUser->getOption( 'rememberpassword' ) or $this->mRemember  );

                $template->set( 'birthyear', $this->wpBirthYear );
                $template->set( 'birthmonth', $this->wpBirthMonth );
                $template->set( 'birthday', $this->wpBirthDay );

                # Prepare language selection links as needed
                if( $wgLoginLanguageSelector ) {
                        $template->set( 'languages', $this->makeLanguageSelector() );
                        if( $this->mLanguage )
                                $template->set( 'uselang', $this->mLanguage );
                }

                // Give authentication and captcha plugins a chance to modify the form
                $wgAuth->modifyUITemplate( $template );
		wfRunHooks( 'UserCreateForm', array( &$template ) );

                $wgOut->setPageTitle( wfMsg( 'userlogin' ) );
                $wgOut->setRobotPolicy( 'noindex,nofollow' );
                $wgOut->setArticleRelated( false );
                $wgOut->disallowUserJs();  // just in case...
                $wgOut->addTemplate( $template );
       }
}


