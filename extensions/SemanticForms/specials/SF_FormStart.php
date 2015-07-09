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
	}

	function execute( $query ) {
		$this->setHeaders();

		$out = $this->getOutput();
		$req = $this->getRequest();

		$form_name = $req->getVal( 'form' );
		$target_namespace = $req->getVal( 'namespace' );
		$super_page = $req->getVal( 'super_page' );
		$params = $req->getVal( 'params' );

		// If the query string did not contain a form name, try the URL.
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

		// Get title of form.
		$form_title = Title::makeTitleSafe( SF_NS_FORM, $form_name );

		// Handle submission of this form.
		$form_submitted = $req->getCheck( 'page_name' );
		if ( $form_submitted ) {
			$page_name = $req->getVal( 'page_name' );
			// This form can be used to create a sub-page for an
			// existing page
			if ( !is_null( $super_page ) && $super_page !== '' ) {
				$page_name = "$super_page/$page_name";
			}

			if ( $page_name !== '' ) {
				// Append the namespace prefix to the page name,
				// if this namespace was not already entered.
				if ( strpos( $page_name, $target_namespace . ':' ) === false && !is_null( $target_namespace ) )
					$page_name = $target_namespace . ':' . $page_name;
				// If there was no page title, it's probably an
				// invalid page name, containing forbidden
				// characters - in that case, display an error
				// message.
				$page_title = Title::newFromText( $page_name );
				if ( !$page_title ) {
					$out->addHTML( wfMessage( 'sf_formstart_badtitle', $page_name )->escaped() );
					return;
				} else {
					$this->doRedirect( $form_name, $page_name, $params );
					return;
				}
			}
		}

		if ( ( !$form_title || !$form_title->exists() ) && ( $form_name !== '' ) ) {
			$text = Html::rawElement( 'p', array( 'class' => 'error' ), wfMessage( 'sf_formstart_badform', SFUtils::linkText( SF_NS_FORM, $form_name ) )->parse() ) . "\n";
		} else {
			if ( $form_name === '' ) {
				$description = wfMessage( 'sf_formstart_noform_docu', $form_name )->escaped();
			}
			else {
				$description = wfMessage( 'sf_formstart_docu', $form_name )->escaped();
			}

			$text = <<<END
	<form action="" method="post">
	<p>$description</p>
	<p><input type="text" size="40" name="page_name" />

END;
			// If no form was specified, display a dropdown letting
			// the user choose the form.
			if ( $form_name === '' )
				$text .= SFUtils::formDropdownHTML();

			$text .= "\t</p>\n";
			$text .= Html::hidden( 'namespace', $target_namespace );
			$text .= Html::hidden( 'super_page', $super_page );
			$text .= Html::hidden( 'params', $params );
			$text .= "\n\t" . Html::input( null, wfMessage( 'sf_formstart_createoredit' )->text(), 'submit' ) . "\n";
			$text .= "\t</form>\n";
		}
		$out->addHTML( $text );
	}

	/**
	 * Helper function - returns a URL that includes Special:FormEdit.
	 */
	static function getFormEditURL( $formName, $targetName) {
		$fe = SpecialPageFactory::getPage( 'FormEdit' );
		// Special handling for forms whose name contains a slash.
		if ( strpos( $formName, '/' ) !== false ) {
			return $fe->getTitle()->getLocalURL( array( 'form' => $formName, 'target' => $targetName ) );
		}
		return $fe->getTitle( "$formName/$targetName" )->getLocalURL();
	}

	function doRedirect( $form_name, $page_name, $params ) {
		$out = $this->getOutput();

		$page_title = Title::newFromText( $page_name );
		if ( $page_title->exists() ) {
			// It exists - see if page is a redirect; if
			// it is, edit the target page instead.
			$article = new Article( $page_title, 0 );
			$article->loadContent();
			$redirect_title = Title::newFromRedirect( $article->fetchContent() );
			if ( $redirect_title != null ) {
				$page_title = $redirect_title;
				$page_name = SFUtils::titleURLString( $redirect_title );
			}
			// HACK - if this is the default form for
			// this page, send to the regular 'formedit'
			// tab page; otherwise, send to the 'Special:FormEdit'
			// page, with the form name hardcoded.
			// Is this logic necessary? Or should we just
			// out-guess the user and always send to the
			// standard form-edit page, with the 'correct' form?
			$default_forms = SFFormLinker::getDefaultFormsForPage( $page_title );
			if ( count( $default_forms ) > 0 ) {
				$default_form_name = $default_forms[0];
			} else {
				$default_form_name = null;
			}
			if ( $form_name == $default_form_name ) {
				$redirect_url = $page_title->getLocalURL( 'action=formedit' );
			} else {
				$redirect_url = self::getFormEditURL( $form_name, $page_name );
			}
		} else {
			$redirect_url = self::getFormEditURL( $form_name, $page_name );
			// Of all the request values, send on to 'FormEdit'
			// only 'preload' and specific form fields - we can
			// identify the latter because they show up as arrays.
			foreach ( $_REQUEST as $key => $val ) {
				if ( is_array( $val ) ) {
					$redirect_url .= ( strpos( $redirect_url, '?' ) > - 1 ) ? '&' : '?';
					// Re-add the key (i.e. the template
					// name), so we can make a nice query
					// string snippet out of the whole
					// thing.
					$wrapperArray = array( $key => $val );
					$redirect_url .= urldecode( http_build_query( $wrapperArray ) );
				} elseif ( $key == 'preload' ) {
					$redirect_url .= ( strpos( $redirect_url, '?' ) > - 1 ) ? '&' : '?';
					$redirect_url .= "$key=$val";
				}
			}
		}

		if ( !is_null( $params ) && $params !== '' ) {
			$redirect_url .= ( strpos( $redirect_url, '?' ) > - 1 ) ? '&' : '?';
			$redirect_url .= $params;
		}

		$out->setArticleBodyOnly( true );

		// Show "loading" animated image while people wait for the
		// redirect.
		global $sfgScriptPath;
		$text = "\t" . Html::rawElement( 'p', array( 'style' => "position: absolute; left: 45%; top: 45%;" ), Html::element( 'img', array( 'src' => "$sfgScriptPath/skins/loading.gif" ) ) );
		$text .= "\t" . Html::element( 'meta', array( 'http-equiv' => 'refresh', 'content' => "0; url=$redirect_url" ) );
		$out->addHTML( $text );
		return;
	}

}
