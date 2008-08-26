<?php

/*
 * Collection Extension for MediaWiki
 *
 * Copyright (C) 2008, PediaPress GmbH
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */


require_once( 'StreamFile.php' );

class Collection extends SpecialPage {
	var $mPODPartners = array(
		'pediapress' => array(
			'name' => 'PediaPress',
			'logourl' => 'http://pediapress.com/resources/images/logo-32x32.png',
			'url' => 'http://pediapress.com/',
			'posturl' => 'http://pediapress.com/api/collections/',
		),
	);

	public function __construct() {
		SpecialPage::SpecialPage( "Collection" );
	}

	function getDescription() {
		return wfMsg( 'coll-collection' );
	}

	function execute( $par ) {
		global $wgOut;
		global $wgRequest;
		global $wgUser;
		global $wgJsMimeType;
		global $wgScriptPath;
		global $wgStyleVersion;
		global $wgCommunityCollectionNamespace;
		global $wgCollectionMaxArticles;
		global $wgCollectionVersion;

		wfLoadExtensionMessages( 'Collection' );

		if ( $par == 'add_article/' ) {
			if ( self::countArticles() >= $wgCollectionMaxArticles ) {
				$this->limitExceeded();
				return;
			}
			$title_url = $wgRequest->getVal( 'arttitle', '' );
			$oldid = $wgRequest->getInt( 'oldid', 0 );
			$title = Title::newFromURL( $title_url );
			$this->addArticle( $title, $oldid );
			if ( $oldid == 0 ) {
				$redirectURL = $title->getFullURL();
			} else {
				$redirectURL = $title->getFullURL( 'oldid=' . $oldid );
			}
			$title->invalidateCache();
			$wgOut->redirect( $redirectURL );
			return;
		} else if ( $par == 'remove_article/' ) {
			$title_url = $wgRequest->getVal( 'arttitle', '' );
			$oldid = $wgRequest->getInt( 'oldid', 0 );
			$title = Title::newFromURL( $title_url );
			$this->removeArticle( $title, $oldid );
			if ( $oldid == 0 ) {
				$redirectURL = $title->getFullURL();
			} else {
				$redirectURL = $title->getFullURL( 'oldid=' . $oldid );
			}
			$title->invalidateCache();
			$wgOut->redirect( $redirectURL );
			return;
		} else if ( $par == 'add_category/' ) {
			$title = Title::makeTitleSafe( NS_CATEGORY, $wgRequest->getVal( 'cattitle', '' ) );
			if ( $this->addCategory( $title ) ) {
				$this->limitExceeded();
				return;
			} else {
				$wgOut->redirect( $title->getFullURL() );
			}
			$title->invalidateCache();
			return;
		} else if ( $par == 'load_collection/' ) {
			$title = Title::newFromText( $wgRequest->getVal( 'colltitle', '' ) );
			if ( $wgRequest->getVal( 'cancel' ) ) {
				$wgOut->redirect( $title->getFullURL() );
				return;
			}
			if ( !self::countArticles()
				 || $wgRequest->getVal( 'overwrite' )
				 || $wgRequest->getVal( 'append' ) ) {
				$collection = $this->loadCollection( $title, $wgRequest->getVal( 'append' ) );
				if ( $collection ) {
					if( session_id() == '' ) {
						wfSetupSession();
					}
					$_SESSION['wsCollection'] = $collection;
					$wgOut->redirect( SkinTemplate::makeSpecialUrl( 'Collection' ) );
				}
				return;
			}
			$this->outputLoadOverwrite( $title );
			return;
		} else if ( $par == 'save_collection/' ) {
			$title = $wgRequest->getVal( 'saveTitle', '' );
			if ( $title ) {
				$_SESSION['wsCollection']['title'] = $title;
			}
			$subtitle = $wgRequest->getVal( 'saveSubitle', '' );
			if ( $subtitle ) {
				$_SESSION['wsCollection']['subtitle'] = $subtitle;
			}
			$collTitle = $wgRequest->getVal( 'colltitle' );
			if ( $wgRequest->getVal( 'overwrite' ) && !empty( $collTitle ) ) {;
				$title = Title::newFromText( $collTitle );
				$this->saveCollection( $title, $overwrite=true );
				$wgOut->redirect( $title->getFullURL() );
				return;
			}
			$collType = $wgRequest->getVal( 'colltype' );
			$overwrite = $wgRequest->getBool( 'overwrite' );
			$saveCalled = false;
			if ( $collType == 'personal' ) {
				$userPageTitle = $wgUser->getUserPage()->getPrefixedText();
				$name = $wgRequest->getVal( 'pcollname', '' );
				if ( !empty( $name ) ) {
					$title = Title::newFromText( $userPageTitle . '/' . wfMsgForContent( 'coll-collections' ) . '/' . $name );
					$saveCalled = true;
					$saved = $this->saveCollection( $title, $overwrite );
				}
			} else if ( $collType == 'community' ) {
				$name = $wgRequest->getVal( 'ccollname', '' );
				if ( !empty( $name ) ) {
					$title = Title::makeTitle( $wgCommunityCollectionNamespace, wfMsgForContent( 'coll-collections' ) . '/' . $name );
					$saveCalled = true;
					$saved = $this->saveCollection( $title, $overwrite );
				}
			}

			if ( !$saveCalled) {
				$wgOut->redirect( SkinTemplate::makeSpecialUrl( 'Collection' ) );
			} else if ( $saved ) {
				$wgOut->redirect( $title->getFullURL() );
			} else {
				$this->outputSaveOverwrite( $title );
			}
			return;
		} else if ( $par == 'render/' ) {
			$title = $wgRequest->getVal( 'downloadTitle', '' );
			if ( $title ) {
				$_SESSION['wsCollection']['title'] = $title;
			}
			$subtitle = $wgRequest->getVal( 'downloadSubtitle', '' );
			if ( $subtitle ) {
				$_SESSION['wsCollection']['subtitle'] = $subtitle;
			}
			return $this->renderCollection(
				$_SESSION['wsCollection'],
				Title::makeTitle( NS_SPECIAL, 'Collection' ),
				$wgRequest->getVal( 'writer', '' )
			);
		} else if ( $par == 'rendering/' ) {
			return $this->rendering();
		} else if ( $par == 'download/' ) {
			return $this->download();
		} else if ( $par == 'render_article/' ) {
			$title = Title::newFromText( $wgRequest->getVal( 'arttitle', '' ) );
			$oldid = $wgRequest->getInt( 'oldid', 0 );
			return $this->renderArticle( $title, $oldid, $wgRequest->getVal( 'writer', 'rl' ) );
		} else if ( $par == 'render_collection/' ) {
			$title = Title::newFromText( $wgRequest->getVal( 'colltitle', '' ) );
			$collection = $this->loadCollection( $title );
			if ( $collection ) {
				$this->renderCollection( $collection, $title, $wgRequest->getVal( 'writer', 'rl' ) );
			}
		} else if ( $par == 'post_zip/' ) {
			$partner = $wgRequest->getVal( 'partner', '' );
			return $this->postZIP( $partner );
		}

		$this->setHeaders();
		$wgOut->addScript( "<script type=\"$wgJsMimeType\" src=\"$wgScriptPath/extensions/Collection/collection/json2.js?$wgStyleVersion&$wgCollectionVersion\"></script>" );
		$wgOut->addScript( "<script type=\"$wgJsMimeType\" src=\"$wgScriptPath/extensions/Collection/collection/collection.js?$wgStyleVersion&$wgCollectionVersion\"></script>" );
		$wgOut->addInlineScript( "var wgCollectionVersion = \"$wgCollectionVersion\";" );
		$this->outputBookSection();
		$this->outputDownloadSection();
		$this->outputSaveSection();
		$this->outputIntro();
		$this->outputArticleList();
	}

	static function countArticles() {
		if ( isset( $_SESSION['wsCollection'] ) ) {
			$collection = $_SESSION['wsCollection'];
		} else {
			return 0;
		}

		$count = 0;
		foreach ( $collection['items'] as $item ) {
			if ( $item['type'] == 'article') {
				$count++;
			}
		}
		return $count;
	}

	static function findArticle( $title, $oldid=0 ) {
		if ( isset( $_SESSION['wsCollection'] ) ) {
			$collection = $_SESSION['wsCollection'];
		} else {
			return -1;
		}

		foreach ( $collection['items'] as $index => $item ) {
			if ( $item['type'] == 'article' && $item['title'] == $title) {
				if ( $oldid ) {
					if ( $item['revision'] == strval( $oldid ) ) {
						return $index;
					}
				} else {
					if ( $item['revision'] == $item['latest'] ) {
						return $index;
					}
				}
			}
		}
		return -1;
	}

	function addArticle( $title, $oldid=0 ) {
		$article = new Article( $title, $oldid );
		$latest = $article->getLatest();

		if ( $oldid == 0 ) {
			$oldid = $latest;
		}

		$index = self::findArticle( $title->getPrefixedText(), $oldid );
		if ( $index != -1 ) {
			return;
		}

		if( session_id() == '' ) {
			wfSetupSession();
		}

		if ( isset( $_SESSION['wsCollection'] ) ) {
			$collection = $_SESSION['wsCollection'];
		} else {
			$collection = array(
				'title' => '',
				'subtitle' => '',
				'items' => array(),
			);
		}

		$revision = Revision::newFromTitle( $title, $oldid );
		$collection['items'][] = array(
			'type' => 'article',
			'content-type' => 'text/x-wiki',
			'title' => $title->getPrefixedText(),
			'revision' => strval( $oldid ),
			'latest' => strval( $latest ),
			'timestamp' => wfTimestamp( TS_UNIX, $revision->mTimestamp ),
			'url' => $title->getFullURL(),
		);

		$_SESSION['wsCollection'] = $collection;
	}

	function removeArticle( $title, $oldid=0 ) {
		if ( isset( $_SESSION['wsCollection'] ) ) {
			$collection = $_SESSION['wsCollection'];
		} else {
			return;
		}
		$index = self::findArticle( $title->getPrefixedText(), $oldid );
		if ( $index != -1 ) {
			array_splice( $collection['items'], $index, 1 );
		}
		$_SESSION['wsCollection'] = $collection;
	}

	function addCategory( $title ) {
		global $wgOut;
		global $wgCollectionMaxArticles;

		$limit = $wgCollectionMaxArticles - self::countArticles();
		if ( $limit <= 0 ) {
			$this->limitExceeded();
			return;
		}
		$db = wfGetDB( DB_SLAVE );
		$tables = array( 'page', 'categorylinks' );
		$fields = array( 'cl_from', 'cl_sortkey', 'page_namespace', 'page_title' );
		$options = array(
			'USE INDEX' => 'cl_sortkey',
			'ORDER BY' => 'cl_sortkey',
			'LIMIT' => $limit + 1,
		);
		$where = array(
			'cl_from=page_id',
			'cl_to' => $title->getDBKey(),
			'page_namespace' => NS_MAIN,
		);
		$res = $db->select( $tables, $fields, $where, __METHOD__, $options );
		$members = array();
		$count = 0;
		$limitExceeded = false;
		while ( $row = $db->fetchObject( $res ) ) {
			if ( ++$count > $limit ) {
				$limitExceeded = true;
				break;
			}
			$articleTitle = Title::makeTitle( $row->page_namespace, $row->page_title );
			if ( $this->findArticle( $articleTitle ) == -1 ) {
				$this->addArticle( $articleTitle );
			}
		}
		$db->freeResult( $res );
		return $limitExceeded;
	}

	function limitExceeded() {
		global $wgOut;

		$wgOut->showErrorPage( 'limit_exceeded_title', 'limit_exceeded_text' );
	}

	function loadCollection( $title, $append=false ) {
		if ( is_null( $title ) ) {
			$wgOut->showErrorPage( 'notitle_title', 'notitle_msg' );
			return;
		}

		$article = new Article( $title );
		if ( !$article->exists() ) {
			$wgOut->showErrorPage( 'notfound_title', 'notfound_msg' );
			return false;
		}

		if ( !$append || !isset($_SESSION['wsCollection'] ) ) {
			$collection = array(
				'title' => '',
				'subtitle' => '',
			);
			$items = array();
		} else {
			$collection = $_SESSION['wsCollection'];
			$items = $collection['items'];
		}

		foreach( preg_split( '/[\r\n]+/', $article->getContent() ) as $line ) {
			$line = trim( $line );
			if ( !$append && preg_match( '/^== (.*) ==$/', $line, $match) ) {
				$collection['title'] = $match[ 1 ];
			} else if ( !$append && preg_match( '/^=== (.*) ===$/', $line, $match) ) {
				$collection['subtitle'] = $match[ 1 ];
			} else if ($line{ 0 } == ';') { // chapter
				$items[] = array(
					'type' => 'chapter',
					'title' => trim( substr( $line, 1 ) ),
				);
			} else if ( $line{ 0 } == ':' ) { // article
				$articleTitle = trim( substr( $line, 1 ) );
				if ( preg_match( '/\[\[:?(.*?)(\|(.*?))?\]\]/', $articleTitle, $match ) ) {
					$articleTitle = $match[1];
					$displayTitle = $match[3];
				}
				$articleTitle = Title::makeTitleSafe( NS_MAIN, $articleTitle );
				if( is_null( $articleTitle ) ) {
					continue;
				}

				$article = new Article( $articleTitle );
				if ( !$article->exists() ) {
					continue;
				}
				$revision = Revision::newFromTitle( $articleTitle, $article->getOldID() );
				$latest = $article->getLatest();
				$oldid = $article->getOldID();
				if ( !$oldid ) {
					$oldid = $latest;
				}
				$d = array(
					'type' => 'article',
					'content-type' => 'text/x-wiki',
					'title' => $articleTitle->getPrefixedText(),
					'latest' => $latest,
					'revision' => $oldid,
					'timestamp' => wfTimestamp( TS_UNIX, $revsision->mTimestamp ),
					'url' => $articleTitle->getFullURL(),
				);
				if ( $displayTitle ) {
					$d['displaytitle'] = $displayTitle;
				}
				$items[] = $d;
			}
		}
		$collection['items'] = $items;
		return $collection;
	}

	function saveCollection( $title, $forceOverwrite=false ) {
		$article = new Article( $title );
		if ( $article->exists() && !$forceOverwrite ) {
			return false;
		}
		$articleText = '';
		$collection = $_SESSION['wsCollection'];
		if( $collection['title'] ) {
			$articleText .= '== ' . $collection['title'] . " ==\n";
		}
		if ( $collection['subtitle'] ) {
			$articleText .= '=== ' . $collection['subtitle'] . " ===\n";
		}
		if ( !empty( $collection['items'] ) ) {
			foreach ( $collection['items'] as $item ) {
				if ( $item['type'] == 'chapter' ) {
					$articleText .= ';' . $item['title'] . "\n";
				} else if ( $item['type'] == 'article' ) {
					$articleText .= ":[[" . $item['title'];
					if ( $item['displaytitle'] ) {
						$articleText .= "|" . $item['displaytitle'];
					}
					$articleText .= "]]\n";
				}
			}
		}
		$catTitle = Title::makeTitle( NS_CATEGORY, wfMsgForContent( 'coll-collections' ) );
		if ( !is_null( $catTitle ) ) {
			$articleText .= "\n[[" . $catTitle->getPrefixedText() . "]]\n";
		}

		$article->doEdit( $articleText, '', EDIT_FORCE_BOT );
		return true;
	}
	
	function getLicenseInfos() {
		global $wgLicenseName;
		global $wgLicenseURL;
		global $wgRightsIcon;
		global $wgRightsPage;
		global $wgRightsText;
		global $wgRightsUrl;
		
		$licenseInfo = array(
			"type" => "license",
		);
		
		if ( $wgLicenseName ) {
			$licenseInfo['name'] = $wgLicenseName;
		} else {
			$licenseInfo['name'] = wfMsgForContent( 'coll-license' );
		}
		
		if ( $wgLicenseURL ) {
			$licenseInfo['mw_license_url'] = $wgLicenseURL;
		} else {
			$licenseInfo['mw_rights_icon'] = $wgRightsIcon;
			$licenseInfo['mw_rights_page'] = $wgRightsPage;
			$licenseInfo['mw_rights_url'] = $wgRightsUrl;
			$licenseInfo['mw_rights_text'] = $wgRightsText;
		}
		
		return array( $licenseInfo );
	}

	function buildJSONCollection( $collection ) {
		$result = array(
			'type' => 'collection',
			'licenses' => $this->getLicenseInfos()
		);
		
		if ( isset( $collection['title'] ) ) {
			$result['title'] = $collection['title'];
		}
		if ( isset( $collection['subtitle'] ) ) {
			$result['subtitle'] = $collection['subtitle'];
		}

		$items = array();
		$currentChapter = null;
		foreach ( $collection['items'] as $item ) {
			if ( $item['type'] == 'article' ) {
				if ( is_null( $currentChapter ) ) {
					$items[] = $item;
				} else {
					$currentChapter['items'][] = $item;
				}
			} else if ( $item['type'] == 'chapter' ) {
				if ( !is_null( $currentChapter ) ) {
					$items[] = $currentChapter;
				}
				$currentChapter = $item;
			}
		}
		if ( !is_null( $currentChapter ) ) {
			$items[] = $currentChapter;
		}

		$result['items'] = $items;

		$json = new Services_JSON();
		return $json->encode( $result );
	}
	
	function renderCollection( $collection, $referrer, $writer ) {
		global $wgOut;
		global $wgPDFTemplateBlacklist;
		global $wgServer;
		global $wgScriptPath;
		
		if ( !$writer ) {
			$writer = 'rl';
		}
		
		$response = self::pdfServerCommand( 'render', array(
			'metabook' => $this->buildJSONCollection( $collection ),
			'base_url' => $wgServer . $wgScriptPath,
			'template_blacklist' => $wgPDFTemplateBlacklist,
			'writer' => $writer,
		) );
		
		if ( !$response ) {
			return;
		}
		
		$redirect = SkinTemplate::makeSpecialUrlSubpage( 'Collection', 'rendering/' );
		$wgOut->redirect( wfAppendQuery( $redirect,
			'return_to=' . urlencode( $referrer->getPrefixedText() )
			. '&collection_id=' . urlencode( $response->collection_id )
			. '&writer=' . urlencode( $response->writer ) ) );
	}
	
	function rendering() {
		global $wgOut;
		global $wgRequest;
		global $wgServer;
		
		$this->setHeaders();
		
		$response = self::pdfServerCommand( 'render_status', array(
			'collection_id' => $wgRequest->getVal( 'collection_id' ),
			'writer' => $wgRequest->getVal( 'writer' ),
		) );
		if ( !$response ) {
			return;
		}
		
		$return_to = $wgRequest->getVal( 'return_to' );
				
		switch ( $response->state ) {
		case 'progress':
			$url = wfAppendQuery(
				SkinTemplate::makeSpecialUrlSubpage( 'Collection', 'rendering/' ),
				'collection_id=' . urlencode( $response->collection_id )
				. '&writer=' . urlencode( $response->writer )
				. '&return_to=' . urlencode( $return_to )
			);
			$wgOut->addMeta( 'http:refresh', '2; URL=' . $url );
			$wgOut->setPageTitle( wfMsg( 'coll-rendering_title' ) );
			$wgOut->addWikiText( wfMsgNoTrans( 'coll-rendering_text', $response->status->progress ) );
			break;
		case 'finished':
			$wgOut->setPageTitle( wfMsg( 'coll-rendering_finished_title' ) );
			$url = wfAppendQuery(
				SkinTemplate::makeSpecialUrlSubpage( 'Collection', 'download/' ),
				'collection_id=' . urlencode( $response->collection_id )
				. '&writer=' . urlencode( $response->writer )
			);
			$wgOut->addWikiText( wfMsgNoTrans( 'coll-rendering_finished_text', $wgServer . $url ) );
			if ( $return_to ) {
				// We are doing this the hard way (i.e. via the HTML detour), to prevent
				// the parser from replacing [[:Special:Collection]] with a selflink.
				$t = Title::newFromText( $return_to );
				$wgOut->addHTML( wfMsg(
					'coll-return_to_collection',
					htmlspecialchars( $t->getFullURL() ),
					htmlspecialchars( $return_to )
				) );
			}
			break;
		default:
			$wgOut->addWikiText( 'state: ' . $response->state );
		}
	}
	
	function download() {
		global $wgOut;
		global $wgRequest;
		
		$tempfile = tmpfile();
		$headers = self::pdfServerCommand( 'download', array(
			'collection_id' => $wgRequest->getVal( 'collection_id' ),
			'writer' => $wgRequest->getVal( 'writer' ),
		), $timeout=false, $toFile=$tempfile );
		wfResetOutputBuffers();
		if ( isset( $headers['content-type'] ) ) {
			header( 'Content-Type: ' . $headers['content-type']);
		}
		if ( isset( $headers['content-disposition'] ) ) {
			header( 'Content-Disposition: ' . $headers['content-disposition']);
		}
		if ( isset( $headers['content-length'] ) ) {
			header( 'Content-Length: ' . $headers['content-length']);
		}
		fseek( $tempfile, 0 );
		fpassthru( $tempfile );
		$wgOut->disable();
	}
	
	function renderArticle( $title, $oldid, $writer ) {
		global $wgOut;
		
		if ( is_null( $title ) ) {
			$wgOut->showErrorPage( 'notitle_title', 'notitle_msg' );
			return;
		}
		$article = array(
			'type' => 'article',
			'content-type' => 'text/x-wiki',
			'title' => $title->getPrefixedText()
		);
		if ( $oldid ) {
			$article['revision'] = strval( $oldid );
		}
		
		$revision = Revision::newFromTitle( $title, $oldid );
		$article['timestamp'] = wfTimestamp( TS_UNIX, $revision->mTimestamp );

		$this->renderCollection( array( 'items' => array( $article ) ), $title, $writer );
	}

	function postZIP( $partner ) {
		global $wgServer;
		global $wgScriptPath;
		global $wgOut;
		global $wgPDFTemplateBlacklist;
		
		$json = new Services_JSON();

		if ( !isset( $this->mPODPartners[$partner] ) ) {
			$wgOut->showErrorPage( 'coll-invalid_podpartner_title', 'coll-invalid_podpartner_msg' );
			return;
		}

		$url = $this->mPODPartners[$partner]['posturl'];
		$errorMessage = '';
		$contentType = '';
		$response = self::post( $url, array(), $errorMessage, $contentType );
		if ( !$response ) {
			$wgOut->showErrorPage( 'coll-post_failed_title', 'coll-post_failed_msg', array( $url, $errorMessage ) );
			return;
		}
		$postData = $json->decode( $response );
		
		$response = self::pdfServerCommand( 'zip_post', array(
			'metabook' => $this->buildJSONCollection( $_SESSION['wsCollection'] ),
			'base_url' => $wgServer . $wgScriptPath,
			'template_blacklist' => $wgPDFTemplateBlacklist,
			'post_url' => $postData->post_url,
		) );
		if ( !$response ) {
			return;
		}
		
		$wgOut->redirect( $postData->redirect_url );
	}
	
	private function outputIntro() {
		global $wgOut;

		$wgOut->addHTML( '<noscript>' );
		$wgOut->addWikiText( wfMsgNoTrans( 'coll-noscript_text' ) );
		$wgOut->addHTML( '</noscript>' );
		$wgOut->addWikiText( wfMsgNoTrans( 'coll-intro_text' ) );
	}

	private function outputArticleList() {
		global $wgOut;
		global $wgScriptPath;

		$wgOut->addWikiText( "== ". wfMsg( 'coll-my_collection' ) . " ==" );

		$title = wfMsgHtml( 'coll-title' );
		$subtitle = wfMsgHtml( 'coll-subtitle' );

		$wgOut->addHTML( <<<EOS
<table><tbody>
<tr>
	<th><label for="titleInput">$title</label></th>
	<td><input id="titleInput" type="text" value="" /></td>
</tr><tr>
	<th><label for="subtitleInput">$subtitle</label></th>
	<td><input id="subtitleInput" type="text" value="" /></td>
</tr>
</tbody></table>
EOS
		);

		$wgOut->addWikiText( "=== ". wfMsg( 'coll-contents' ) . " ===" );

		$createChapter = wfMsgHtml( 'coll-create_chapter' );
		$sortAlphabetically = wfMsgHtml( 'coll-sort_alphabetically' );
		$clearCollection = wfMsgHtml( 'coll-clear_collection' );
		$wgOut->addHTML( <<<EOS
<a id="createChapter" href="javascript:void(0);">$createChapter</a>
<span id="sortSpan" style="display:none;">| <a id="sortLink" href="javascript:void(0);">$sortAlphabetically</a></span>
<span id="clearSpan" style="display:none;">| <a id="clearLink" href="javascript:void(0);">$clearCollection</a></span>
EOS
		);

		$rename = wfMsgHtml( 'coll-rename' );
		$remove = wfMsgHtml( 'coll-remove' );
		$removeImage = htmlspecialchars( "$wgScriptPath/extensions/Collection/collection/cross.png" );
		$moveUp = wfMsgHtml( 'coll-move_up' );
		$moveUpImage = htmlspecialchars( "$wgScriptPath/extensions/Collection/collection/up.png" );
		$moveDown = wfMsgHtml( 'coll-move_down' );
		$moveDownImage = htmlspecialchars( "$wgScriptPath/extensions/Collection/collection/down.png" );
		$moveDisabledImage = htmlspecialchars( "$wgScriptPath/extensions/Collection/collection/trans.png" );
		$newChapter = wfMsgHtml( 'coll-new_chapter' );
		$renameChapter = wfMsgHtml( 'coll-rename_chapter' );
		$enterTitle = wfMsgHtml( 'coll-enter_title' );
		$collectionExists = wfMsgHtml( 'coll-collection_exists' );
		$errorResponse = wfMsgHtml( 'coll-error_response' );
		$emptyCollection = wfMsgHtml( 'coll-empty_collection' );
		$revision = wfMsgHtml( 'coll-revision' );
		$clearConfirm = wfMsgHtml( 'coll-clear_confirm' );

		$wgOut->addHTML( <<<EOS
<div id="collectionList"></div>
<br style="clear:both;"/>
<div style="display:none">
	<div id="articleListItem" class="article">
		<a class="removeLink" href="javascript:void(0)" title="$remove"><img src="$removeImage" width="11" height="11" alt="$remove" /></a>
		&nbsp;
		<a class="moveUpLink" href="javascript:void(0)" title="$moveUp"><img src="$moveUpImage" width="11" height="11" alt="$moveUp" /></a>
		<img class="moveUpDisabled" src="$moveDisabledImage" width="11" height="11" />
		<a class="moveDownLink" href="javascript:void(0)" title="$moveDown"><img src="$moveDownImage" width="11" height="11" alt="$moveDown" /></a>
		<img class="moveDownDisabled" src="$moveDisabledImage" width="11" height="11" />
		<a class="articleLink" style="margin-left:1em;"></a>
	</div>
	<div id="chapterListItem" class="chapter" style="margin-top:0.3em;">
		<a class="removeLink" href="javascript:void(0)" title="$remove"><img src="$removeImage" width="11" height="11" alt="$remove" /></a>
		&nbsp;
		<a class="moveUpLink" href="javascript:void(0)" title="$moveUp"><img src="$moveUpImage" width="11" height="11" alt="$moveUp" /></a>
		<img class="moveUpDisabled" src="$moveDisabledImage" width="11" height="11" />
		<a class="moveDownLink" href="javascript:void(0)" title="$moveDown"><img src="$moveDownImage" width="11" height="11" alt="$moveDown" /></a>
		<img class="moveDownDisabled" src="$moveDisabledImage" width="11" height="11" />
		<strong class="chapterTitle" style="margin-left: 0.5em;"></strong> 
		<a class="renameLink" href="javascript:void(0)">[$rename]</a>
	</div>
	<span id="newChapterText">$newChapter</span>
	<span id="renameChapterText">$renameChapter</span>
	<span id="enterTitleText">$enterTitle</span>
	<span id="collectionExistsText">$collectionExists</span>
	<span id="errorResponseText">$errorResponse</span>
	<span id="emptyCollectionText">$emptyCollection</span>
	<span id="revisionText">$revision</span>
	<span id="clearConfirmText">$clearConfirm</span>
</div>
EOS
		);
	}

	private function outputDownloadSection() {
		global $wgCollectionFormats;
		
		$downloadTitle = wfMsgHtml( 'coll-download_title' );
		$downloadText = wfMsgHtml( 'coll-download_text' );
		$url = htmlspecialchars( SkinTemplate::makeSpecialUrlSubpage( 'Collection', 'render/' ) );
		$buttonLabel = wfMsgHtml( 'coll-download' );
		$formatLabel = wfMsgHtml( 'coll-format_label' );
		$html = <<<EOS
<h2><span class="mw-headline">$downloadTitle</span></h2>
<p>$downloadText</p>
<form id="downloadForm" action="$url" method="POST">
<input id="downloadTitle" name="downloadTitle" type="hidden"></input>
<input id="downloadSubtitle" name="downloadSubtitle" type="hidden"></input>
<label for="formatSelect">$formatLabel</label>
<select id="formatSelect" name="writer">
EOS
		;
		foreach ( $wgCollectionFormats as $writer => $name ) {
			$writer = htmlspecialchars( $writer );
			$name = htmlspecialchars( $name );
			$html .= <<<EOS
<option value="$writer">$name</option>
EOS
			;
		}
		$html .= <<<EOS
</select>
<input id="downloadButton" type="submit" value="$buttonLabel"></input>
</form>
EOS
		;
		$this->outputBox( $html );
	}

	private function outputSaveSection() {
		global $wgCommunityCollectionNamespace;
		global $wgOut;
		global $wgUser;

		$html = '<h2><span class="mw-headline">' . wfMsgHtml( 'coll-save_collection_title' ) . '</span></h2>';

		if ($wgUser->isLoggedIn()) {
			$html .= '<p>' . wfMsgHtml( 'coll-save_collection_text' ) . '</p>';

			$personalColl = wfMsgHtml( 'coll-personal_collection_label' );
			$communityColl = wfMsgHtml( 'coll-community_collection_label' );
			$saveColl = wfMsgHtml( 'coll-save_collection' );

			$personalTitle = htmlspecialchars( $wgUser->getUserPage()->getPrefixedText(). '/' . wfMsgForContent( 'coll-collections' ) . '/' );
			$communityTitle = htmlspecialchars( Title::makeTitle( $wgCommunityCollectionNamespace, wfMsgForContent( 'coll-collections' ) )->getPrefixedText() . '/' );

			$url = htmlspecialchars( SkinTemplate::makeSpecialUrlSubpage( 'Collection', 'save_collection/' ) );
			$html .= <<<EOS
<form id="saveForm" action="$url" method="POST">
	<input id="personalCollType" type="radio" name="colltype" value="personal" checked="checked"></input>
	<label for="personalCollType">$personalColl</label>
	<label for="personalCollTitle">$personalTitle</label>
	<input id="personalCollTitle" type="text" name="pcollname"></input><br />
	<input id="communityCollType" type="radio" name="colltype" value="community"></input>
	<label for="communityCollType">$communityColl</label>
	<label for="communityCollTitle">$communityTitle</label>
	<input id="communityCollTitle" type="text" name="ccollname" disabled="disabled"></input><br />
	<input id="saveButton" type="submit" value="$saveColl" disabled="disabled"></input>
	<input id="saveTitle" name="saveTitle" type="hidden"></input>
	<input id="saveSubtitle" name="saveSubtitle" type="hidden"></input>
</form>
EOS
			;
		} else {
			$html .= wfMsgExt( 'coll-login_to_save', array( 'parse' ) );
		}
		$this->outputBox( $html );
	}

	private function outputSaveOverwrite( $title ) {
		global $wgOut;

		$wgOut->setPageTitle( wfMsg( 'coll-save_collection' ) );

		$wgOut->addWikiText( '==' . wfMsg( 'coll-overwrite_title' ) . '==' );
		$wgOut->addWikiText( wfMsgNoTrans( 'coll-overwrite_text', $title->getPrefixedText() ) );
		$yes = wfMsgHtml( 'coll-yes' );
		$no = wfMsgHtml( 'coll-no' );
		$escapedTitle = htmlspecialchars( $title->getPrefixedText() );
		$url = htmlspecialchars( SkinTemplate::makeSpecialUrlSubpage( 'Collection', 'save_collection/' ) );
		$wgOut->addHTML( <<<EOS
<form action="$url" method="POST">
	<input name="overwrite" type="submit" value="$yes"></input>
	<input name="abort" type="submit" value="$no"></input>
	<input name="colltitle" type="hidden" value="$escapedTitle"></input>
</form>
EOS
		);
	}

	private function outputLoadOverwrite( $title ) {
		global $wgOut;

		$wgOut->setPageTitle( wfMsg( 'coll-load_collection' ) );

		$wgOut->addWikiText( wfMsgNoTrans( 'coll-load_overwrite_text' ) );
		$overwrite = wfMsgHtml( 'coll-overwrite' );
		$append = wfMsgHtml( 'coll-append' );
		$cancel = wfMsgHtml( 'coll-cancel' );
		$escapedTitle = htmlspecialchars( $title->getPrefixedText() );
		$url = htmlspecialchars( SkinTemplate::makeSpecialUrlSubpage( 'Collection', 'load_collection/' ) );
		$wgOut->addHTML( <<<EOS
<form action="$url" method="POST">
	<input name="overwrite" type="submit" value="$overwrite"></input>
	<input name="append" type="submit" value="$append"></input>
	<input name="cancel" type="submit" value="$cancel"></input>
	<input name="colltitle" type="hidden" value="$escapedTitle"></input>
</form>
EOS
		);
	}
	private function outputBox( $content ) {
		global $wgOut;

		$html = <<<EOS
<table align="right" style="clear: both; float: right; margin-left: 20px; margin-bottom: 10px;" class="toccolours" width="50%">
	<tr>
		<td>$content</td>
	</tr>
</table>
EOS
		;
		$wgOut->addHTML( $html );
	}

	private function outputBookSection()
	{
		$bookTitle = wfMsgHtml( 'coll-book_title' );
		$bookText = wfMsgHtml( 'coll-book_text' );
		$html = <<<EOS
<h2><span class="mw-headline">$bookTitle</span></h2>
<p>$bookText</p>
<div id="ppList">
EOS
		;

		foreach( $this->mPODPartners as $partner => $partnerData ) {
			$formurl = htmlspecialchars( SkinTemplate::makeSpecialUrlSubpage( 'Collection', 'post_zip/' ) );
			$encPartner = htmlspecialchars( $partner );
			$url = htmlspecialchars( $partnerData['url'] );
			$logoURL = htmlspecialchars( $partnerData['logourl'] );
			$partnerName = htmlspecialchars( $partnerData['name'] );
			$orderLabel = wfMsgHtml( 'coll-order_from_pp', $partnerName );
			$aboutLabel = wfMsgHtml( 'coll-about_pp', $partnerName );
			$html .= <<<EOS
<p>
	<form action="$formurl" method="GET">
		<input type="hidden" name="partner" value="$encPartner"/>
		<input type="submit" value="$orderLabel"/>
		<a href="$url" target="_blank">$aboutLabel&nbsp;<img src="$logoURL" alt="$partnerName"/></a>
	</form>
</p>
EOS
			;
		}
		$html .= '</div>';
		$this->outputBox( $html );
	}

	static function isCollectionPage( $title, $article ) {
		wfLoadExtensionMessages( 'Collection' );

		if ( is_null( $title ) || is_null( $article ) ) {
			return false;
		}

		$categoryFinder = new Categoryfinder();
		$categoryFinder->seed( array( $article->getID() ), array( wfMsgForContent( 'coll-collections' ) ) );
		$articles = $categoryFinder->run();
		if ( in_array( $article->getID(), $articles ) ) {
			return true;
		}
		return false;
	}

	/**
	 * SkinTemplateBuildNavUrlsNav_urlsAfterPermalink hook
	 */
	function createNavURLs( &$skinTemplate, &$nav_urls, &$revid1, &$revid2 ) {
		global $wgArticle;
		global $wgRequest;
		global $wgCollectionFormats;

		wfLoadExtensionMessages( 'Collection' );

		$action = $wgRequest->getVal('action');

		if ( $skinTemplate->iscontent && ( $action == '' || $action == 'view' || $action == 'purge' ) ) {
			if ( self::isCollectionPage( $skinTemplate->mTitle, $wgArticle ) ) {
				$params = 'colltitle=' . wfUrlencode( $skinTemplate->mTitle->getPrefixedDBKey() );
				foreach ( $wgCollectionFormats as $writer => $name ) {
					$nav_urls['download_as_' . $writer] = array(
						'href' => wfAppendQuery( SkinTemplate::makeSpecialUrlSubpage(
							'Collection',
							'render_collection/'
						), $params . '&writer=' . $writer ),
						'text' => wfMsg( 'coll-download_as', $name ),
					);
				}
			} else {
				$params = 'arttitle=' . $skinTemplate->mTitle->getPrefixedURL();
				if( $wgArticle ) {
					$oldid = $wgArticle->getOldID();
					if ( $oldid ) {
						$params .= '&oldid=' . $oldid;
					}
				}
				foreach ( $wgCollectionFormats as $writer => $name ) {
					$nav_urls['download_as_' . $writer] = array(
						'href' => wfAppendQuery( SkinTemplate::makeSpecialUrlSubpage(
							'Collection',
							'render_article/'
						), $params . '&writer=' . $writer ),
						'text' => wfMsg( 'coll-download_as', $name )
					);
				}
			}
		}
		return true;
	}


	/**
	 * MonoBookTemplateToolboxEnd hook
	 */
	static function insertMonoBookToolboxLink( &$skinTemplate ) {
		global $wgCollectionFormats;
		
		foreach ( $wgCollectionFormats as $writer => $name ) {
			if ( !empty( $skinTemplate->data['nav_urls']['download_as_' . $writer]['href'] ) ) {
				$href = htmlspecialchars( $skinTemplate->data['nav_urls']['download_as_' . $writer]['href'] );
				$label = htmlspecialchars( $skinTemplate->data['nav_urls']['download_as_' . $writer]['text'] );
				print <<<EOS
<li id="t-download-as-$writer"><a href="$href">$label</a></li>
EOS
				;
			}
			
		}
		return true;
	}

	/**
	 * Return HTML-code to be inserted as portlet
	 */
	static function printPortlet() {
		global $wgArticle;
		global $wgTitle;
		global $wgOut;
		
		$myTitle = Title::makeTitle( NS_SPECIAL, 'Collection' );
		if ( $wgTitle->getPrefixedText() == $myTitle->getPrefixedText() ) {
			return;
		}

		wfLoadExtensionMessages( 'Collection' );

		$portletTitle = wfMsgHtml( 'coll-portlet_title' );
		$addArticle = wfMsgHtml( 'coll-add_page' );
		$removeArticle = wfMsgHtml( 'coll-remove_page' );
		$addCategory = wfMsgHtml( 'coll-add_category' );
		$loadCollection = wfMsgHtml( 'coll-load_collection' );
		$tooBigCat = wfMsgHtml( 'coll-too_big_cat' );

		print <<<EOS
			<div id="p-collection" class="portlet">
				<h5>$portletTitle</h5>
				<div class="pBody">
					<ul>
EOS
		;
		if ( is_null( $wgArticle ) || !$wgArticle->exists() ) {
			// no op
		} else if ( self::isCollectionPage( $wgTitle, $wgArticle) ) {
			$params = "colltitle=" . $wgTitle->getPrefixedUrl();
			$href = htmlspecialchars( wfAppendQuery( SkinTemplate::makeSpecialUrlSubpage(
				'Collection',
				'load_collection/'
			), $params ) );
			print "<li><a href=\"$href\">$loadCollection</a></li>";
		} else if ( $wgTitle->getNamespace() == NS_MAIN ) { // TODO: only NS_MAIN?
			$params = "arttitle=" . $wgTitle->getPrefixedUrl() . "&oldid=" . $wgArticle->getOldID();

			if ( self::findArticle( $wgTitle->getPrefixedText(), $wgArticle->getOldID() ) == -1 ) {
				$href = htmlspecialchars( wfAppendQuery( SkinTemplate::makeSpecialUrlSubpage(
					'Collection',
					'add_article/'
				), $params ) );
				print "<li><a href=\"$href\">$addArticle</a></li>";
			} else {
				$href = htmlspecialchars( wfAppendQuery( SkinTemplate::makeSpecialUrlSubpage(
					'Collection',
					'remove_article/'
				), $params ) );
				print "<li><a href=\"$href\">$removeArticle</a></li>";
			}
		} else if ( $wgTitle->getNamespace() == NS_CATEGORY ) {
			$params = "cattitle=" . $wgTitle->getPartialURL();
			$href = htmlspecialchars( wfAppendQuery( SkinTemplate::makeSpecialUrlSubpage(
				'Collection',
				'add_category/'
			), $params ) );
			print "<li><a href=\"$href\">$addCategory</a></li>";
		}

		$numArticles = self::countArticles();
		if ( $numArticles > 0 ) {
			# disable caching
			$wgOut->setSquidMaxage( 0 );
			$wgOut->enableClientCache( false );
		} 
		if ( $numArticles == 1 ){
			$articles = $numArticles . ' ' . wfMsgHtml( 'coll-page' );
		} else {
			$articles = $numArticles . ' ' . wfMsgHtml( 'coll-pages' );
		}
		$showCollection = wfMsgHtml( 'coll-show_collection' );
		$showURL = htmlspecialchars( SkinTemplate::makeSpecialUrl( 'Collection') );
		print <<<EOS
						<li><a href="$showURL">$showCollection<br />
							($articles)</a></li>
EOS
		;
		$helpCollections = wfMsgHtml( 'coll-help_collections' );
		$helpURL = htmlspecialchars( Title::makeTitle( NS_HELP, wfMsgForContent( 'coll-collections' ) )->getFullURL() );
		print <<<EOS
						<li><a href="$helpURL">$helpCollections</a></li>
					</ul>
				</div>
			</div>
			<span id="tooBigCategoryText" style="display:none">$tooBigCat</span>
EOS
		;
	}
	
	static function pdfServerCommand( $command, $args, $timeout=true, $toFile=null ) {
		global $wgOut;
		global $wgCollectionMWServeURL;
		global $wgCollectionMWServeCredentials;
		
		$args['command'] = $command;
		if ( $wgCollectionMWServeCredentials ) {
			$args['login_credentials'] = $wgCollectionMWServeCredentials;
		}
		$errorMessage = '';
		$headers = array();
		$response = self::post( $wgCollectionMWServeURL, $args, $errorMessage, $headers, $timeout, $toFile );
		if ( $toFile ) {
			return $headers;
		}
		
		if ( !$response ) {
			$wgOut->showErrorPage(
				'coll-post_failed_title',
				'coll-post_failed_msg',
				array( $wgCollectionMWServeURL, $errorMessage )
			);
			return false;
		}
		
		$json = new Services_JSON();
		$json_response = $json->decode( $response );
		
		if ( !$json_response ) {
			$wgOut->showErrorPage(
				'coll-pdfserver_failed_title',
				'coll-pdfserver_failed_msg',
				array( $response )
			);
			return false;
		}
		
		if ( array_key_exists( 'error', get_object_vars( $json_response ) ) && $json_response->error ) {
			$wgOut->showErrorPage(
				'coll-pdfserver_failed_title',
				'coll-pdfserver_failed_msg',
				array( $json_response->error )
			);
			return false;
		}
		
		return $json_response;
	}
	
	static function post( $url, $postFields, &$errorMessage, &$headers,
		$timeout=true, $toFile=null ) {
		global $wgHTTPTimeout, $wgHTTPProxy, $wgVersion, $wgTitle;
	
		$c = curl_init( $url );
		curl_setopt($c, CURLOPT_PROXY, $wgHTTPProxy);
		curl_setopt( $c, CURLOPT_USERAGENT, "MediaWiki/$wgVersion" );
		curl_setopt( $c, CURLOPT_POST, true );
		curl_setopt( $c, CURLOPT_POSTFIELDS, $postFields );
		curl_setopt( $c, CURLOPT_HTTPHEADER, array( 'Expect:' ) );
		if ( is_object( $wgTitle ) ) {
			curl_setopt( $c, CURLOPT_REFERER, $wgTitle->getFullURL() );
		}
		#curl_setopt( $c, CURLOPT_HEADER, true );
		if ( $timeout ) {
			curl_setopt( $c, CURLOPT_TIMEOUT, $wgHTTPTimeout );
		}
		$headerStream = tmpfile();
		curl_setopt( $c, CURLOPT_WRITEHEADER, $headerStream );
		if ( $toFile ) {
			curl_setopt( $c, CURLOPT_FILE, $toFile );
		} else {
			ob_start();
		}
		
		curl_exec( $c );
		if ( curl_errno( $c ) != CURLE_OK ) {
			$text = false;
			$errorMessage = curl_error( $c );
			$headers = false;
		} else if ( curl_getinfo( $c, CURLINFO_HTTP_CODE ) != 200 ) {
			$text = false;
			$errorMessage = 'HTTP status ' . curl_getinfo( $c, CURLINFO_HTTP_CODE );
			$headers = false;
		} else {
			$headerSize = curl_getinfo( $c, CURLINFO_HEADER_SIZE );
			fseek( $headerStream, 0 );
			$headerLines = explode( "\n", fread( $headerStream, $headerSize ) );
			foreach( $headerLines as $line ) {
				if ( preg_match( "/^(.+?):\s+(.+)$/", trim( $line ), $matches ) ) {
					$headers[ strtolower( $matches[1] ) ] = $matches[2];
				}
				unset( $matches );
			}
			if ( !$toFile ) {
				$text = ob_get_contents();
				ob_end_clean();
			}
			$errorMessage = '';
		}		
		curl_close( $c );
		return $text;
	}
}
