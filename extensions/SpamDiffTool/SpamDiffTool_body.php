<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

class SpecialSpamDiffTool extends UnlistedSpecialPage {

	function __construct() {
		parent::__construct( 'SpamDiffTool' );
	}

	function execute( $par ) {
		global $wgRequest, $wgContLang, $wgOut, $wgUser,
			$wgScript, $wgSpamBlacklistArticle;

		

		$this->setHeaders();

		// can the user even edit this?
		$sb = Title::newFromText( $wgSpamBlacklistArticle );
		if ( !$sb->userCan( 'edit' ) ) {
			$wgOut->addWikiMsg( 'spamdifftool_cantedit' );
			return;
		}

		$this->outputHeader();

		$title = Title::newFromText( $wgRequest->getVal( 'target' ) );
		$diff = $wgRequest->getVal( 'diff2' );
		$rcid = $wgRequest->getVal( 'rcid' );
		$rdfrom = $wgRequest->getVal( 'rdfrom' );

		// do the processing
		if ( $wgRequest->wasPosted() ) {
			if ( $wgRequest->getCheck( 'confirm' ) ) {
				$a = new Article( $sb );
				$text = '';
				$insert = true;
				// make sure this page exists
				if ( $sb->getArticleID() > 0 ) {
					$text = $a->getContent();
					$insert = false;
				}

				// insert the before the <pre> at the bottom  if there is one
				$i = strrpos( $text, '</pre>' );
				if ( $i !== false ) {
					$text = substr( $text, 0, $i )
							. $wgRequest->getVal( 'newurls' )
							. "\n" . substr( $text, $i );
				} else {  
					$text .= "\n" . $wgRequest->getVal( 'newurls' );
				}
				$a->doEdit( $text, wfMsgForContent( 'spamdifftool_summary' ), EDIT_DEFER_UPDATES | EDIT_AUTOSUMMARY );
				$returnto = $wgRequest->getVal( 'returnto' );
				if ( $returnto != null && $returnto != '' )
					$wgOut->redirect( $wgScript . "?" . urldecode( $returnto ) );
				return;
			}
			$vals = $wgRequest->getValues();
			$text = ''; 
			foreach ( $vals as $key => $value ) {
				if ( strpos( $key, 'http://' ) === 0 ) {
					$url = str_replace( '%2E', '.', $key );
					if ( $value == 'none' ) continue;
					switch ( $value ) {
						case 'domain':
							$url = str_replace( 'http://', '', $url );
							$url = preg_replace( '/(.*[^\/])*\/.*/', '$1', $url ); // trim everything after the slash
							$k = explode( '\.', $url );
							$url = $k[sizeof($k) - 2] . '.' . $k[sizeof($k) - 1];
							$url = str_replace( '.', '\.', $url ); // escape the periods
							break;
						case 'subdomain':
							$url = str_replace( 'http://', '', $url );
							$url = str_replace( '.', '\.', $url ); // escape the periods
							$url = preg_replace( '/^([^\/]*)\/.*/', '$1', $url ); // trim everything after the slash
							break;
						case 'dir':
							$url = str_replace( 'http://', '', $url );
							$url = str_replace( '.', '\.', $url ); // escape the periods
							$url = str_replace( '/', '\/', $url ); // escape the slashes
							break;
					}
					$text .= "$url\n";
				}
			}
			if ( trim( $text ) == '' ) {
				$wgOut->addHTML( wfMsg( 'spamdifftool_notext', $wgScript . "?" . urldecode( $wgRequest->getVal( 'returnto' ) ) ) );
				return;
			}
			$wgOut->addHTML(
				Xml::openElement( 'form', array( 'method' => 'post' ) ) . "\n" .
				Html::Hidden( 'confirm', 'true' ) .
				Html::Hidden( 'newurls', $text ) .
				Html::Hidden( 'returnto', $wgRequest->getVal( 'returnto' ) ) . "\n" .
				wfMsg( 'spamdifftool_confirm',
					'http://www.mediawiki.org/w/index.php?title=Extension_talk:SpamDiffTool&action=edit&section=new' ) .
				"\n<pre>$text</pre>\n" .
				Xml::closeElement( 'table' ) . "\n" .
				Xml::submitButton( wfMsg( 'spamdifftool_submit_buttom' ) ) . "\n" .
				Xml::closeElement( 'form' )
			);
			return;
		}

		if ( !$title ) {
			$wgOut->addWikiMsg( 'spamdifftool-no-title' );
			return;
		}

		if ( !is_null( $diff ) ) {
			# Get the last edit not by this guy
			$current = Revision::newFromTitle( $title );
			$dbw = wfGetDB( DB_MASTER );
			$user = intval( $current->getUser() );
			$user_text = $dbw->addQuotes( $current->getUserText() );
			$s = $dbw->selectRow( 'revision',
				//array( 'min(rev_id)', 'rev_timestamp' ),
				array( 'min(rev_id) as rev_id' ),
				array(
					'rev_page' => $current->getPage(),
					"rev_user <> {$user} OR rev_user_text <> {$user_text}",
					$diff != "" ? "rev_id <  $diff" : '1 = 1', // sure - why not!
				), __METHOD__,
				array(
					'USE INDEX' => 'page_timestamp',
					'ORDER BY'  => 'rev_timestamp DESC' )
				);
			if ( $s ) {
				// set oldid
				$oldid = $s->rev_id;
			}

			// new diff object to extract the revision texts
			if ( $rcid != '' ) {
				$de = new DifferenceEngine( $title, $oldid, $diff, $rcid );
			} else {
				$de = new DifferenceEngine( $title, $oldid, $diff);
			}

			$de->loadText();
			$otext = $de->mOldtext;
			$ntext = $de->mNewtext;
			$ota = explode( "\n", $wgContLang->segmentForDiff( $otext ) );
			$nta = explode( "\n", $wgContLang->segmentForDiff( $ntext ) );
			$diffs = new Diff( $ota, $nta );

			// iterate over the edits and get all of the changed text
			$text = '';
			foreach ( $diffs->edits as $edit ) {
				if ( $edit->type != 'copy' ) {
					$text .= implode( "\n", $edit->closing ) . "\n";
				}
			}
		} else {
			$a = new Article( $title );
			$text = $a->getContent( true );
		}

		$matches = array();
		$preg = "/http:\/\/[^] \n'\"]*/";
		preg_match_all( $preg, $text, $matches );

		if ( !count( $matches[0] ) ) {
			$wgOut->addHTML( wfMsg( 'spamdifftool_no_urls_detected', $wgScript . "?" . urldecode( $wgRequest->getVal( 'returnto' ) ) ) );
			return;
		}

		$wgOut->addWikiMsg( 'spamdifftool_urls_detected' );
		$wgOut->addInlineStyle( 'td.spam-url-row { border: 1px solid #ccc; }' );

		$wgOut->addHTML(
			Xml::openElement( 'form', array( 'method' => 'post' ) ) . "\n" .
			Html::Hidden( 'returnto', $wgRequest->getVal( 'returnto' ) ) . "\n" .
			Xml::openElement( 'table', array( 'cellpadding' => 5, 'width' => '100%' ) ) . "\n"
		);

		$urls = array();
		foreach ( $matches as $match ) {
			foreach ( $match as $url ) {
				if ( isset( $urls[$url] ) ) continue; // avoid dupes
				$urls[$url] = true;
				$name = htmlspecialchars( str_replace( ".", "%2E", $url ) );
				$wgOut->addHTML(
					Xml::tags( 'tr', array(),
						Xml::tags( 'td', array( 'class' => 'spam-url-row' ),
							"<b>$url</b><br />" . wfMsgHtml( 'spamdifftool_block' ) . "&#160;&#160;" .
							Xml::radioLabel( wfMsg( 'spamdifftool_option_domain'), $name, 'domain', '{$name}-domain', true ) . "\n" .
							Xml::radioLabel( wfMsg( 'spamdifftool_option_subdomain' ), $name, 'subdomain', '{$name}-subdomain' ) . "\n" .
							Xml::radioLabel( wfMsg( 'spamdifftool_option_directory' ), $name, 'dir', '{$name}-dir' ) . "\n" .
							Xml::radioLabel( wfMsg( 'spamdifftool_option_none' ), $name, 'none', '{$name}-none' ) . "\n"
						)
					)
				);
			}
		}

		$wgOut->addHTML(
			Xml::closeElement( 'table' ) . "\n" .
			Xml::submitButton( wfMsg( 'spamdifftool_submit_buttom' ) ) . "\n" .
			Xml::closeElement( 'form' )
		);
	}
}


