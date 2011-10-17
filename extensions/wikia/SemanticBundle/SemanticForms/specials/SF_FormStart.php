<?php
/**
 * Displays a form for entering the title of a page, which then redirects
 * to the form for creating/editing the page.
 *
 * @author Yaron Koren
 * @author Jeffrey Stuckman
 * @file
 * @ingroup SF
 */

/**
 * @ingroup SFSpecialPages
 */
class SFFormStart extends SpecialPage {

	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct( 'FormStart' );
		SFUtils::loadMessages();
	}

	function execute( $query ) {
		global $wgOut, $wgRequest;

		$this->setHeaders();

		SFUtils::loadMessages();
		$form_name = $wgRequest->getVal( 'form' );
		$target_namespace = $wgRequest->getVal( 'namespace' );
		$super_page = $wgRequest->getVal( 'super_page' );
		$params = $wgRequest->getVal( 'params' );

		// If the query string did not contain a form name, try the URL
		if ( ! $form_name ) {
			$queryparts = explode( '/', $query, 2 );
			$form_name = isset( $queryparts[0] ) ? $queryparts[0] : '';
			// If a target was specified, it means we should
			// redirect to 'FormEdit' for this target page.
			if ( isset( $queryparts[1] ) ) {
				$target_name = $queryparts[1];
				$this->doRedirect( $form_name, $target_name, $params );
			}

			// Get namespace from the URL, if it's there.
			if ( $namespace_label_loc = strpos( $form_name, "/Namespace:" ) ) {
				$target_namespace = substr( $form_name, $namespace_label_loc + 11 );
				$form_name = substr( $form_name, 0, $namespace_label_loc );
			}
		}

		// Remove forbidden characters from the form name.
		$forbidden_chars = array( '"', "'", '<', '>', '{', '}', '(', ')', '[', ']', '=' );
		$form_name = str_replace( $forbidden_chars, "", $form_name );

		// Get title of form.
		$form_title = Title::makeTitleSafe( SF_NS_FORM, $form_name );

		// Handle submission of this form.
		$form_submitted = $wgRequest->getCheck( 'page_name' );
		if ( $form_submitted ) {
			$page_name = $wgRequest->getVal( 'page_name' );
			// This form can be used to create a sub-page for an
			// existing page
			if ( $super_page != '' )
			{
				$page_name = "$super_page/$page_name";
			}
			if ( $page_name != '' ) {
				// Append the namespace prefix to the page name,
				// if this namespace was not already entered.
				if ( strpos( $page_name, $target_namespace . ':' ) === false && $target_namespace != '' )
					$page_name = $target_namespace . ':' . $page_name;
				// If there was no page title, it's probably an
				// invalid page name, containing forbidden
				// characters - in that case, display an error
				// message.
				$page_title = Title::newFromText( $page_name );
				if ( !$page_title ) {
					$wgOut->addHTML( htmlspecialchars( wfMsg( 'sf_formstart_badtitle', $page_name ) ) );
					return;
				} else {
					$this->doRedirect( $form_name, $page_name, $params );
					return;
				}
			}
		}

		if ( ( ! $form_title || ! $form_title->exists() ) && ( $form_name != '' ) ) {
			$text = Xml::element( 'p', null, wfMsg( 'sf_formstart_badform', SFUtils::linkText( SF_NS_FORM, $form_name ) ) ) . "\n";
		} else {
			if ( $form_name == '' ) {
				$description = htmlspecialchars( wfMsg( 'sf_formstart_noform_docu', $form_name ) );
			}
			else {
				$description = htmlspecialchars( wfMsg( 'sf_formstart_docu', $form_name ) );
			}
				
			$text = <<<END
	<form action="" method="post">
	<p>$description</p>
	<p><input type="text" size="40" name="page_name" />

END;
			// If no form was specified, display a dropdown letting
			// the user choose the form.
			if ( $form_name == '' )
				$text .= SFUtils::formDropdownHTML();

			$text .= "\t</p>\n";
			$text .= SFFormUtils::hiddenFieldHTML( 'namespace', $target_namespace );
			$text .= SFFormUtils::hiddenFieldHTML( 'super_page', $super_page );
			$text .= SFFormUtils::hiddenFieldHTML( 'params', $params );
			$text .= "\t" . Xml::element( 'input', array( 'type' => 'submit', 'value' => wfMsg( 'sf_formstart_createoredit' ) ) ) . "\n";
			$text .= "\t</form>\n";
		}
		$wgOut->addHTML( $text );
	}

	function doRedirect( $form_name, $page_name, $params ) {
		global $wgOut;

		$page_title = Title::newFromText( $page_name );
		if ( $page_title->exists() ) {
			// It exists - see if page is a redirect; if
			// it is, edit the target page instead.
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
			$default_forms = SFFormLinker::getDefaultFormsForPage( $page_title );
			if ( count( $default_forms ) > 0 )
				$default_form_name = $default_forms[0];
			else
				$default_form_name = null;
			if ( $form_name == $default_form_name ) {
				$redirect_url = $page_title->getLocalURL( 'action=formedit' );
			} else {
				$fe = SpecialPage::getPage( 'FormEdit' );
				$redirect_url = $fe->getTitle()->getFullURL() . "/" . $form_name . "/" . SFUtils::titleURLString( $page_title );
			}
		} else {
			$fe = SpecialPage::getPage( 'FormEdit' );
			$redirect_url = $fe->getTitle()->getFullURL() . "/" . $form_name . "/" . SFUtils::titleURLString( $page_title );
			// Of all the request values, send on to 'FormEdit'
			// only 'preload' and specific form fields - we can
			// identify the latter because they show up as arrays.
			foreach ( $_REQUEST as $key => $val ) {
				if ( is_array( $val ) ) {
					$template_name = urlencode( $key );
					foreach ( $val as $field_name => $value ) {
						$field_name = urlencode( $field_name );
						$value = urlencode( $value );
						$redirect_url .= ( strpos( $redirect_url, "?" ) > - 1 ) ? '&' : '?';
						$redirect_url .= $template_name . '[' . $field_name . ']=' . $value;
					}
				} elseif ( $key == 'preload' ) {
					$redirect_url .= ( strpos( $redirect_url, "?" ) > - 1 ) ? '&' : '?';
					$redirect_url .= "$key=$val";
				}
			}
		}

		if ( $params != '' ) {
			$redirect_url .= ( strpos( $redirect_url, "?" ) > - 1 ) ? '&' : '?';
			$redirect_url .= $params;
		}

		$wgOut->setArticleBodyOnly( true );
		// Show "loading" animated image while people wait for the
		// redirect.
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
