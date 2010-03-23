<?php
/**
 * Displays a form for entering the title of a page, which then redirects
 * to the form for creating/editing the page.
 *
 * @author Yaron Koren
 * @author Jeffrey Stuckman
 */
if ( !defined( 'MEDIAWIKI' ) ) die();

class SFFormStart extends SpecialPage {

	/**
	 * Constructor
	 */
	function SFFormStart() {
		SpecialPage::SpecialPage( 'FormStart' );
		wfLoadExtensionMessages( 'SemanticForms' );
	}

	function execute( $query ) {
		global $wgOut, $wgRequest, $sfgScriptPath;

		$this->setHeaders();

		wfLoadExtensionMessages( 'SemanticForms' );
		$form_name = $wgRequest->getVal( 'form' );
		$target_namespace = $wgRequest->getVal( 'namespace' );
		$super_page = $wgRequest->getVal( 'super_page' );
		$params = $wgRequest->getVal( 'params' );

		// if query string did not contain form name, try the URL
		if ( ! $form_name ) {
			$queryparts = explode( '/', $query, 2 );
			$form_name = isset( $queryparts[0] ) ? $queryparts[0] : '';
			// if a target was specified, it means we should
			// redirect to 'FormEdit' for this target page
			if ( isset( $queryparts[1] ) ) {
				$target_name = $queryparts[1];
				SFFormStart::doRedirect( $form_name, $target_name, $params );
			}

			// get namespace from  the URL, if it's there
			if ( $namespace_label_loc = strpos( $form_name, "/Namespace:" ) ) {
				$target_namespace = substr( $form_name, $namespace_label_loc + 11 );
				$form_name = substr( $form_name, 0, $namespace_label_loc );
			}
		}

		// remove forbidden characters from form name
		$forbidden_chars = array( '"', "'", '<', '>', '{', '}', '(', ')', '[', ']', '=' );
		$form_name = str_replace( $forbidden_chars, "", $form_name );

		// get title of form
		$form_title = Title::makeTitleSafe( SF_NS_FORM, $form_name );

		// handle submission
		$form_submitted = $wgRequest->getCheck( 'page_name' );
		if ( $form_submitted ) {
			$page_name = $wgRequest->getVal( 'page_name' );
			// This form can be used to create a sub-page for an
			// existing page
			if ( '' != $super_page )
			{
				$page_name = "$super_page/$page_name";
			}
			if ( '' != $page_name ) {
				// Append the namespace prefix to the page name,
				// if a namespace was not already entered.
				if ( strpos( $page_name, ":" ) === false && $target_namespace != '' )
					$page_name = $target_namespace . ":" . $page_name;
				// find out whether this page already exists,
				// and send user to the appropriate form
				$page_title = Title::newFromText( $page_name );
				if ( ! $page_title ) {
					// if there was no page title, it's
					// probably an invalid page name,
					// containing forbidden characters
					$error_msg = wfMsg( 'sf_formstart_badtitle', $page_name );
					$wgOut->addHTML( $error_msg );
					return;
				} else {
					SFFormStart::doRedirect( $form_name, $page_name, $params );
					return;
				}
			}
		}

		if ( ( ! $form_title || ! $form_title->exists() ) && ( $form_name != '' ) ) {
			$text = '<p>' . wfMsg( 'sf_formstart_badform', SFUtils::linkText( SF_NS_FORM, $form_name ) ) . ".</p>\n";
		} else {
			if ( $form_name == '' )
				$description = wfMsg( 'sf_formstart_noform_docu', $form_name );
			else
				$description = wfMsg( 'sf_formstart_docu', $form_name );
			$button_text = wfMsg( 'sf_formstart_createoredit' );
			$text = <<<END
	<form action="" method="post">
	<p>$description</p>
	<p><input type="text" size="40" name="page_name">

END;
			// if no form was specified, display a dropdown letting
			// the user choose the form
			if ( $form_name == '' )
				$text .= SFUtils::formDropdownHTML();

			$hidden_target_namespace = htmlspecialchars( $target_namespace );
			$hidden_super_page = htmlspecialchars( $super_page );
			$hidden_params = htmlspecialchars( $params );

			$text .= <<<END
	</p>
	<input type="hidden" name="namespace" value="$hidden_target_namespace">
	<input type="hidden" name="super_page" value="$hidden_super_page">
	<input type="hidden" name="params" value="$hidden_params">
	<input type="Submit" value="$button_text">
	</form>

END;
		}
		$wgOut->addHTML( $text );
	}

	function doRedirect( $form_name, $page_name, $params ) {
		global $wgOut;

		$page_title = Title::newFromText( $page_name );
		if ( $page_title->exists() ) {
			// it exists - see if page is a redirect; if
			// it is, edit the target page instead
			$article = new Article( $page_title );
			$article->loadContent();
			$redirect_title = Title::newFromRedirect( $article->fetchContent() );
			if ( $redirect_title != null ) {
				$page_title = $redirect_title;
			}
			// HACK - if this is the default form for
			// this page, send to the regular 'formedit'
			// tab page; otherwise, send to the 'Special:EditData'
			// page, with the form name hardcoded.
			// Is this logic necessary? Or should we just
			// out-guess the user and always send to the
			// standard form-edit page, with the 'correct' form?
			$default_forms = SFLinkUtils::getFormsForArticle( $article );
			if ( count( $default_forms ) > 0 )
				$default_form_name = $default_forms[0];
			else
				$default_form_name = null;
			if ( $form_name == $default_form_name ) {
				$redirect_url = $page_title->getLocalURL( 'action=formedit' );
			} else {
				$fe = SpecialPage::getPage( 'FormEdit' );
				$redirect_url = $fe->getTitle()->getFullURL() . "/" . $form_name . "/" . SFLinkUtils::titleURLString( $page_title );
			}
		} else {
			$fe = SpecialPage::getPage( 'FormEdit' );
			$redirect_url = $fe->getTitle()->getFullURL() . "/" . $form_name . "/" . SFLinkUtils::titleURLString( $page_title );
			// of all the request values, send on to 'FormEdit'
			// only 'preload' and specific form fields - we can
			// tell the latter because they show up as arrays
			foreach ( $_REQUEST as $key => $val ) {
				if ( is_array( $val ) ) {
					$template_name = $key;
					foreach ( $val as $field_name => $value ) {
						$redirect_url .= ( strpos( $redirect_url, "?" ) > - 1 ) ? '&' : '?';
						$redirect_url .= $template_name . '[' . $field_name . ']=' . $value;
					}
				} elseif ( $key == 'preload' ) {
					$redirect_url .= ( strpos( $redirect_url, "?" ) > - 1 ) ? '&' : '?';
					$redirect_url .= "$key=$val";
				}
			}
		}

		if ( '' != $params ) {
			$redirect_url .= ( strpos( $redirect_url, "?" ) > - 1 ) ? '&' : '?';
			$redirect_url .= $params;
		}

		$wgOut->setArticleBodyOnly( true );
		// show "loading" animated image while people wait for the redirect
		global $sfgScriptPath;
		$text = "<p style=\"position: absolute; left: 45%; top: 45%;\"><img src=\"$sfgScriptPath/skins/loading.gif\" /></p>\n";
		$text .= <<<END
		<script type="text/javascript">
		window.onload = function() {
			window.location="$redirect_url";
		}
		</script>

END;
		$wgOut->addHTML( $text );
		return;
	}

}
