<?php
/*
 * TODO Test the whole thing, make it safe.
 * TODO OPTIONAL Make it NS-specific
 */

class FlagPage extends SpecialPage {
	function __construct() {
		parent::__construct( 'FlagPage' );
		wfLoadExtensionMessages( 'FlagPage' );
	}
 
	/*
	 * First function to be called. Calls different functions depending on what information is given:
	 * selection() if page is set
	 * preview() if page and template are set
	 * submit() if it was a POST-Request
	 * returns error if no page was specified
	 * 
	 * @param $par String: pagetitle in Special:FlagPage/pagetitle
	 */
	function execute( $par ) {
		global $wgRequest, $wgOut, $wgTitle;
		$this->setHeaders();
		$page = $wgRequest->getText( 'page' );
		# $page is set via subtitle (Special:FlagPage/pagetitle)
		if ( isset( $par ) )
			$page = $par;
 		$template = $wgRequest->getText( 'template' );
		$token = $wgRequest->getText( 'token', '' );
		if ( $page!='' ) # $page defined?
		{
			if ( $template!='' ) # $template defined?
			{
				if ( $wgRequest->wasPosted() ) { # already submitted
					$this->submit( $page, $template, $token );
				}
				else { # template selected, but not yet previewed and confirmed
					$this->preview($page, $template);
				}
			}
			else {
				$this->selection( $page );
				
			}
		}
		else # no page has been defined
		{
			$wgOut->showErrorPage('flagpage-nopageselectedtitle','flagpage-nopageselected');
		}
	}

	/*
	 * Parses 'MediaWiki:Flagarticle-templatelist' with replaceLinks() and normal mediawiki parser
	 * Shows a selection of different templates (which are defined in the above message)
	 * 
	 * @param $page String: title of the page that needs to be edited
	 */
	function selection( $page ) {
		global $wgOut;
		$templatelist = new Article( Title::newFromText( 'flagpage-templatelist', NS_MEDIAWIKI ) );
		$templatelistcontent = $templatelist->fetchContent();
		if ( $templatelistcontent=="" ) # empty config list
		{
			$wgOut->showErrorPage( 'flagpage-emptylisttitle','flagpage-emptylist' );
		}
		$templatelistcontent = $this->replaceLinks( $page, $templatelistcontent );
		$wgOut->addWikiText( '<div class="plainlinks">' . $templatelistcontent . '</div>' );
	}
	
	/*
	 * Small parser that provides an easier way of using 'MediaWiki:Flagarticle-templatelist'
	 * 
	 * @param $page String: title of the page that needs to be edited
	 * @param $wikitext String: content of 'MediaWiki:Flagarticle-templatelist' that needs to be parsed
	 * @return $wikitext String: parsed content
	 */
	function replaceLinks( $page, $wikitext ) {
		global $wgOut;
		$wikitext = str_replace("|", "}} ", $wikitext);
		$wikitext = str_replace("[[", "[{{fullurl:Special:FlagPage|page=" . $page . "&template=" , $wikitext);		// FIXME: something like wfMsgForContent() for aliases is needed to use the local name of Special:FlagPage
		$wikitext = str_replace("]]", "]", $wikitext);
		return $wikitext;
	}
	
	/*
	 * Preview the template before actually saving the page. Is called when the user specified one of several predifined templates
	 * Provides a HTML form for submitting the confirmation. An edit token is included to prevent (possibly malicious) external POST request.
	 * 
	 * @param $page String: title of the page that needs to be edited
	 * @param $template String: title of the selected template
	 */
	function preview( $page, $template ) {
		// TODO: set $wgTitle / PAGENAME
		global $wgOut, $wgUser;
		$wgOut->addWikiText( wfMsg( 'flagpage-preview' ) );
		$wgOut->addWikiText('<div class="flagpage-preview" style="background-color:#F5F5F5; border:1px solid #AAAAAA; padding:0 0.8em 0.3em 0.5em;"> {{' . $template . "}}</div>");
		$token = $wgUser->editToken();
		// TODO what a mess! tidy up the html code
		$s = Xml::openElement( 'form', array( 'method' => 'post', 'action' => $this->getTitle()->getLocalURL(), 'id' => 'mw-flagpage-form' ) ) .
		Xml::openElement( 'p' ) .
		Xml::tags( 'label', null, wfMsg( 'flagpage-confirmsave' ) ) .
		Xml::hidden( 'page', $page ) .
		Xml::hidden( 'template', $template ) .
		Xml::hidden( 'token', $token ) .
		Xml::submitButton( wfMsg( 'flagpage-submitbutton' ) ) ."\n" .
		Xml::closeElement( 'p' ) . "\n" .
		Xml::closeElement( 'form' ) . "\n";
		$wgOut->addHTML($s);
	}
	
	/*
	 * Function that is called after the user confirms the change.
	 * Checks for the token and insertes the template. If the token is wrong or the article doesn't exist, preview() is shown
	 * 
	 * @param $page String: title of the page that needs to be edited
	 * @param $template String: title of the selected template
	 * @param $token String: token that is included in the html form in preview()
	 */
	function submit( $page, $template, $token ) {
		global $wgOut, $wgUser;
		if ( !$wgUser->matchEditToken( $token ) ) { # Wrong Edit token. Show preview page
			$this->preview( $page, $template );
			return;
		}
		$id = Title::newFromText( $page )->getArticleId();
		if ($id==0) { # Page does not exist. Show preview page
			$wgOut->addWikiMsg( 'flagpage-nonexistent', $page );
			$this->preview( $page, $template );
			return;
		}
		$article = Article::newFromId( $id );
		$text = "{{" . $template . "}}\n\n" . $article->getRawText();
		$summary = wfMsg( 'flagpage-summary', $template );
		$article->doEdit( $text, $summary, EDIT_UPDATE, $id );
		$wgOut->addWikiMsg( 'flagpage-success', $template, $page, $id ); // FIXME Broken link without oldid
	// TODO Add nice way to undo changes (copy HTML Forms of EditPage.php)
	}
}
