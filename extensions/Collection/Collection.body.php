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
		global $wgCommunityCollectionNamespace;
		global $wgCollectionMaxArticles;
		
		wfLoadExtensionMessages( 'Collection' );
		
		if ( $par == 'add_article/' ) {
			if ( self::countArticles() >= $wgCollectionMaxArticles ) {
				self::limitExceeded();
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
			$wgUser->invalidateCache();
			$wgOut->redirect( $redirectURL );
			return;
		} else if ( $par == 'remove_article/' ) {
			$title_url = $wgRequest->getVal( 'arttitle', '' );
			$oldid = $wgRequest->getInt( 'oldid', 0 );
			$title = Title::newFromURL( $title_url );
			self::removeArticle( $title, $oldid );
			if ( $oldid == 0 ) {
				$redirectURL = $title->getFullURL();
			} else {
				$redirectURL = $title->getFullURL( 'oldid=' . $oldid );
			}
			$wgUser->invalidateCache();
			$wgOut->redirect( $redirectURL );
			return;
		} else if ( $par == 'clear_collection/' ) {
			self::clearCollection();
			$wgUser->invalidateCache();
			$wgOut->redirect( $wgRequest->getVal( 'return_to', SkinTemplate::makeSpecialUrl( 'Collection' ) ) );
			return;
		} else if ( $par == 'set_titles/' ) {
			self::setTitles( $wgRequest->getText( 'collectionTitle', '' ), $wgRequest->getText( 'collectionSubtitle', '') );
			$wgUser->invalidateCache();
			$wgOut->redirect( SkinTemplate::makeSpecialUrl( 'Collection' ) );
			return;
		} else if ( $par == 'sort_items/' ) {
			self::sortItems();
			$wgUser->invalidateCache();
			$wgOut->redirect( SkinTemplate::makeSpecialUrl( 'Collection' ) );
			return;
		} else if ( $par == 'add_category/' ) {
			$title = Title::makeTitleSafe( NS_CATEGORY, $wgRequest->getVal( 'cattitle', '' ) );
			if ( self::addCategory( $title ) ) {
				self::limitExceeded();
				return;
			} else {
				$wgOut->redirect( $title->getFullURL() );
			}
			$wgUser->invalidateCache();
			return;
		} else if ( $par == 'remove_item/' ) {
			self::removeItem( $wgRequest->getInt( 'index', 0 ) );
			$wgUser->invalidateCache();
			$wgOut->redirect( SkinTemplate::makeSpecialUrl( 'Collection' ) );
			return;
		} else if ( $par == 'move_item/' ) {
			self::moveItem( $wgRequest->getInt( 'index', 0 ), $wgRequest->getInt( 'delta', 0 ) );
			$wgUser->invalidateCache();
			$wgOut->redirect( SkinTemplate::makeSpecialUrl( 'Collection' ) );
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
					self::startSession();
					$_SESSION['wsCollection'] = $collection;
					$wgOut->redirect( SkinTemplate::makeSpecialUrl( 'Collection' ) );
				}
				return;
			}
			$this->renderLoadOverwritePage( $title );
			return;
		} else if ( $par == 'order_collection/' ) {
			$title = Title::newFromText( $wgRequest->getVal( 'colltitle', '' ) );
			$collection = $this->loadCollection( $title );
			$partner = $wgRequest->getVal( 'partner', 'pediapress' );
			return $this->postZIP( $collection, $partner );
		} else if ( $par == 'save_collection/' ) {
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
				$this->renderSaveOverwritePage( $title );
			}
			return;
		} else if ( $par == 'render/' ) {
			return $this->renderCollection(
				$_SESSION['wsCollection'],
				Title::makeTitle( NS_SPECIAL, 'Collection' ),
				$wgRequest->getVal( 'writer', '' )
			);
		} else if ( $par == 'forcerender/' ) {
			return $this->forceRenderCollection();
		} else if ( $par == 'rendering/' ) {
			return $this->renderRenderingPage();
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
			$partner = $wgRequest->getVal( 'partner', 'pediapress' );
			return $this->postZIP( $_SESSION['wsCollection'], $partner );
		} else if ( $par == '' ){
			$this->renderSpecialPage();			
		} else {
			$wgOut->showErrorPage( 'coll-unknown_subpage_title', 'coll-unknown_subpage_text' );
		}
	}
	
	function renderSpecialPage() {
		global $wgCollectionFormats;
		global $wgCollectionVersion;
		global $wgCollectionStyleVersion;
		global $wgJsMimeType;
		global $wgScriptPath;
		global $wgOut;

		if ( !self::hasSession() ) {
			self::startSession();
		}
		
		$this->setHeaders();
		$wgOut->addInlineScript( "var wgCollectionVersion = \"$wgCollectionVersion\";" );		
		$wgOut->addScript( "<script type=\"$wgJsMimeType\" src=\"$wgScriptPath/extensions/Collection/collection/jquery.js?$wgCollectionStyleVersion\"></script>" );
		$wgOut->addScript( "<script type=\"$wgJsMimeType\" src=\"$wgScriptPath/extensions/Collection/collection/jquery.ui.js?$wgCollectionStyleVersion\"></script>" );
		$wgOut->addInlineScript( "jQuery.noConflict();" );		
		$wgOut->addScript( "<script type=\"$wgJsMimeType\" src=\"$wgScriptPath/extensions/Collection/collection/collection.js?$wgCollectionStyleVersion\"></script>" );
		
		$template = new CollectionPageTemplate();
		$template->set( 'collection', $_SESSION['wsCollection'] );
		$template->set( 'podpartners', $this->mPODPartners );
		$template->set( 'formats', $wgCollectionFormats);
		$wgOut->addTemplate( $template );
	}

	static function hasSession() {
		return isset( $_SESSION['wsCollection'] );
	}
	
	static function clearCollection() {
		$_SESSION['wsCollection'] = array(
			'title' => '',
			'subtitle' => '',
			'items' => array(),
		);
		self::touchSession();
	}
	
	static function setTitles( $title, $subtitle ) {
		$collection = $_SESSION['wsCollection'];
		$collection['title'] = $title;
		$collection['subtitle'] = $subtitle;
		$_SESSION['wsCollection'] = $collection;
		self::touchSession();
	}
	
	static function sortItems() {
		$collection = $_SESSION['wsCollection'];
		$articles = array();
		$new_items = array();
		function title_cmp($a, $b) {
			return strcasecmp($a['title'], $b['title']);
		}
		foreach ( $collection['items'] as $item ) {
			if ( $item['type'] == 'chapter' ) {
				usort( $articles, 'title_cmp' );
				while ( count( $articles ) ) {
					$new_items[] = array_shift( $articles );
				}
				$new_items[] = $item;
			} else if ( $item['type'] == 'article' ) {
				$articles[] = $item;
			}
		}
		if ( count( $articles ) ) {
			usort( $articles, 'title_cmp' );
			while ( count( $articles ) ) {
				$new_items[] = array_shift( $articles );
			}
		}
		$collection['items'] = $new_items;
		$_SESSION['wsCollection'] = $collection;
		self::touchSession();
	}
	
	static function addChapter( $name ) {
		$collection = $_SESSION['wsCollection'];
		array_unshift( $collection['items'], array(
			'type' => 'chapter',
			'title' => $name,
		) );
		$_SESSION['wsCollection'] = $collection;
		self::touchSession();
	}
	
	static function renameChapter( $index, $name ) {
		$collection = $_SESSION['wsCollection'];
		if ( $collection['items'][$index]['type'] != 'chapter' ) {
			return;
		}
		$collection['items'][$index]['title'] = $name;
		$_SESSION['wsCollection'] = $collection;
		self::touchSession();
	}
	
	static function startSession() {
		if( session_id() == '' ) {
			wfSetupSession();
		}
		self::clearCollection();
	}
	
	static function touchSession() {
		$collection = $_SESSION['wsCollection'];
		$collection['timestamp'] = wfTimestampNow();
		$_SESSION['wsCollection'] = $collection;
	}
	
	static function countArticles() {
		if ( !self::hasSession() ) {
			return 0;
		}
		$count = 0;
		foreach ( $_SESSION['wsCollection']['items'] as $item ) {
			if ( $item['type'] == 'article') {
				$count++;
			}
		}
		return $count;
	}

	static function findArticle( $title, $oldid=0 ) {
		if ( !self::hasSession() ) {
			return -1;
		}
		
		foreach ( $_SESSION['wsCollection']['items'] as $index => $item ) {
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

	static function addArticleFromName( $namespace, $name, $oldid=0 ) {
		$title = Title::makeTitleSafe( $namespace, $name );
		return self::addArticle( $title, $oldid );
	}
	
	static function addArticle( $title, $oldid=0 ) {
		$article = new Article( $title, $oldid );
		$latest = $article->getLatest();
		
		$currentVersion = 0;
		if ( $oldid == 0 ) {
			$currentVersion = 1;
			$oldid = $latest;
		} 
		$index = self::findArticle( $title->getPrefixedText(), $oldid );
		if ( $index != -1 ) {
			return;
		}

		if ( !self::hasSession() ) {
			self::startSession();
		}
		$collection = $_SESSION['wsCollection'];
		$revision = Revision::newFromTitle( $title, $oldid );
		$collection['items'][] = array(
			'type' => 'article',
			'content-type' => 'text/x-wiki',
			'title' => $title->getPrefixedText(),
			'revision' => strval( $oldid ),
			'latest' => strval( $latest ),
			'timestamp' => wfTimestamp( TS_UNIX, $revision->mTimestamp ),
			'url' => $title->getFullURL(),
			'currentVersion' => $currentVersion,
		);
		$_SESSION['wsCollection'] = $collection;
		self::touchSession();
	}

	static function removeArticleFromName( $namespace, $name, $oldid=0 ) {
		$title = Title::makeTitleSafe( $namespace, $name );
		return self::removeArticle( $title, $oldid );
	}
	
	static function removeArticle( $title, $oldid=0 ) {
		if ( !self::hasSession() ) {
			return;
		}
		$collection = $_SESSION['wsCollection'];
		$index = self::findArticle( $title->getPrefixedText(), $oldid );
		if ( $index != -1 ) {
			array_splice( $collection['items'], $index, 1 );
		}
		$_SESSION['wsCollection'] = $collection;
		self::touchSession();
	}

	static function addCategoryFromName( $name ) {
		$title = Title::makeTitleSafe( NS_CATEGORY, $name );
		return self::addCategory( $title );
	}
	
	static function addCategory( $title ) {
		global $wgOut;
		global $wgCollectionMaxArticles;

		$limit = $wgCollectionMaxArticles - self::countArticles();
		if ( $limit <= 0 ) {
			self::limitExceeded();
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
			if ( self::findArticle( $articleTitle->getPrefixedText() ) == -1 ) {
				self::addArticle( $articleTitle );
			}
		}
		$db->freeResult( $res );
		return $limitExceeded;
	}

	static function limitExceeded() {
		global $wgOut;

		$wgOut->showErrorPage( 'coll-limit_exceeded_title', 'coll-limit_exceeded_text' );
	}

	static function removeItem( $index ) {
		if ( !self::hasSession() ) {
			return;
		}
		$collection = $_SESSION['wsCollection'];
		array_splice( $collection['items'], $index, 1 );
		$_SESSION['wsCollection'] = $collection;
		self::touchSession();		
	}
	
	static function moveItem( $index, $delta ) {
		if ( !self::hasSession() ) {
			return;
		}
		$collection = $_SESSION['wsCollection'];
		$saved = $collection['items'][$index + $delta];
		$collection['items'][$index + $delta] = $collection['items'][$index];
		$collection['items'][$index] = $saved;
		$_SESSION['wsCollection'] = $collection;
		self::touchSession();
	}
	
	static function setSorting( $items ) {
		if ( !self::hasSession() ) {
			return;
		}
		$collection = $_SESSION['wsCollection'];
		$old_items = $collection['items'];
		$new_items = array();
		foreach ($items as $new_index => $old_index) {
			$new_items[$new_index] = $old_items[$old_index];
		}
		$collection['items'] = $new_items;
		$_SESSION['wsCollection'] = $collection;
		self::touchSession();
	}
	
	function loadCollection( $title, $append=false ) {
		if ( is_null( $title ) ) {
			$wgOut->showErrorPage( 'coll-notitle_title', 'coll-notitle_msg' );
			return;
		}

		$article = new Article( $title );
		if ( !$article->exists() ) {
			$wgOut->showErrorPage( 'coll-notfound_title', 'coll-notfound_msg' );
			return false;
		}

		if ( !$append || !self::hasSession() ) {
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
					$oldid = -1;
					$currentVersion = 1;
				} else if ( preg_match( '/\[\{\{fullurl:(.*?)\|oldid=(.*?)\}\}\s+(.*?)\]/', $articleTitle, $match ) ) {
				       	$articleTitle = $match[1];
					$displayTitle = $match[3];
					$oldid = $match[2];
					$currentVersion = 0;
				}


				if( is_null( $articleTitle ) ) {
					continue;
				}
				$articleTitle = Title::makeTitleSafe( NS_MAIN, $articleTitle );
				if ($oldid < 0) {
				   $article = new Article( $articleTitle );
				} else {
				   $article = new Article( $articleTitle, $oldid );
				}
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
					'currentVersion' => $currentVersion,
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
					if ($item['currentVersion'] == 1) {
						$articleText .= ":[[" . $item['title'];
						if ( $item['displaytitle'] ) {
							$articleText .= "|" . $item['displaytitle'];
						}
						$articleText .= "]]\n";
					} else {
						$articleText .= ":[{{fullurl:" . $item['title'];
						$articleText .= "|oldid=" . $item['revision'] . "}} ";
						if ( $item['displaytitle'] ) {
							$articleText .= $item['displaytitle'];
						} else {
							$articleText .= $item['title'];
						}
						$articleText .= "]\n";
					}
				}
				//$articleText .= $item['revision'] . "/" . $item['latest']."\n";
			}
		}
		$catTitle = Title::makeTitle( NS_CATEGORY, wfMsgForContent( 'coll-collections' ) );
		if ( !is_null( $catTitle ) ) {
			$articleText .= "\n[[" . $catTitle->getPrefixedText() . "]]\n";
		}

		$article->doEdit( $articleText, '' );
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
		global $wgContLang;
		global $wgServer;
		global $wgScriptPath;
		global $wgScriptExtension;
		
		if ( !$writer ) {
			$writer = 'rl';
		}
		
		$response = self::mwServeCommand( 'render', array(
			'metabook' => $this->buildJSONCollection( $collection ),
			'base_url' => $wgServer . $wgScriptPath,
			'script_extension' => $wgScriptExtension,
			'template_blacklist' => wfMsgForContent( 'coll-template_blacklist_title' ),
			'template_exclusion_category' => wfMsgForContent( 'coll-exclusion_category_title' ),
			'print_template_prefix' => wfMsgForContent( 'coll-print_template_prefix' ),
			'language' => $wgContLang->getCode(),
			'writer' => $writer,
		) );
		
		if ( !$response ) {
			return;
		}
		
		$redirect = SkinTemplate::makeSpecialUrlSubpage( 'Collection', 'rendering/' );
		$query = 'return_to=' . urlencode( $referrer->getPrefixedText() )
			. '&collection_id=' . urlencode( $response['collection_id'] )
			. '&writer=' . urlencode( $response['writer'] );
		if ( isset( $response['is_cached'] ) && $response['is_cached'] ) {
			$query .= '&is_cached=1';
		}
		$wgOut->redirect( wfAppendQuery( $redirect, $query ) );
	}
	
	function forceRenderCollection() {
		global $wgOut;
		global $wgContLang;
		global $wgRequest;
		global $wgServer;
		global $wgScriptPath;
		global $wgScriptExtension;
		
		$collectionID = $wgRequest->getVal( 'collection_id', '' );
		$writer = $wgRequest->getVal( 'writer', 'rl' );
		
		$response = self::mwServeCommand( 'render', array(
			'collection_id' => $collectionID,
			'base_url' => $wgServer . $wgScriptPath,
			'script_extension' => $wgScriptExtension,
			'template_blacklist' => wfMsgForContent( 'coll-template_blacklist_title' ),
			'template_exclusion_category' => wfMsgForContent( 'coll-exclusion_category_title' ),
			'print_template_prefix' => wfMsgForContent( 'coll-print_template_prefix' ),
			'language' => $wgContLang->getCode(),
			'writer' => $writer,
			'force_render' => true
		) );
		
		if ( !$response ) {
			return;
		}
		
		$redirect = SkinTemplate::makeSpecialUrlSubpage( 'Collection', 'rendering/' );
		$query = 'return_to=' . $wgRequest->getVal( 'return_to', '' )
			. '&collection_id=' . urlencode( $response['collection_id'] )
			. '&writer=' . urlencode( $response['writer'] );
		if ( $response['is_cached'] ) {
			$query .= '&is_cached=1';
		}
		$wgOut->redirect( wfAppendQuery( $redirect, $query ) );
	}
	
	function renderRenderingPage() {
		global $wgCollectionVersion;
		global $wgCollectionStyleVersion;
		global $wgJsMimeType;
		global $wgLang;
		global $wgOut;
		global $wgRequest;
		global $wgScriptPath;
		global $wgServer;

		$response = self::mwServeCommand( 'render_status', array(
			'collection_id' => $wgRequest->getVal( 'collection_id' ),
			'writer' => $wgRequest->getVal( 'writer' ),
		) );
		if ( !$response ) {
			return; // FIXME?
		}

		$this->setHeaders();
		
		$return_to = $wgRequest->getVal( 'return_to' );

		$query = 'collection_id=' . urlencode( $response['collection_id'] )
			. '&writer=' . urlencode( $response['writer'] )
			. '&return_to=' . urlencode( $return_to );
		
		switch ( $response['state'] ) {
		case 'progress':
			$url = htmlspecialchars( SkinTemplate::makeSpecialUrlSubpage( 'Collection', 'rendering/', $query ) );
			$wgOut->addHeadItem( 'refresh-nojs', '<noscript><meta http-equiv="refresh" content="2" /></noscript>');
			$wgOut->addInlineScript( 'var collection_id = "' . urlencode( $response['collection_id']) . '";' );
			$wgOut->addInlineScript( 'var writer = "' . urlencode( $response['writer']) . '";' );
			$wgOut->addInlineScript( 'var collection_rendering = true;' );
			$wgOut->addInlineScript( "var wgCollectionVersion = \"$wgCollectionVersion\";" );		
			$wgOut->addScript( "<script type=\"$wgJsMimeType\" src=\"$wgScriptPath/extensions/Collection/collection/jquery.js?$wgCollectionStyleVersion\"></script>" );
			$wgOut->addScript( "<script type=\"$wgJsMimeType\" src=\"$wgScriptPath/extensions/Collection/collection/collection.js?$wgCollectionStyleVersion\"></script>" );
			$wgOut->setPageTitle( wfMsg( 'coll-rendering_title' ) );

			if ( isset($response['status']['status'] ) && $response['status']['status'] ) {
				$statusText = $response['status']['status'];
				if ( isset( $response['status']['article'] ) && $response['status']['article'] ) {
					$statusText .= wfMsg( 'coll-rendering_article', $response['status']['article'] );
				} else if ( isset( $response['status']['page'] ) && $response['status']['page'] ) {
					$statusText .= wfMsg( 'coll-rendering_page', $wgLang->formatNum( $response['status']['page'] ) );
				}
				$status = wfMsg( 'coll-rendering_status', $statusText );
			} else {
				$status = '';
			}
			
			$template = new CollectionRenderingTemplate();
			$template->set( 'status',  $status );
			$template->set( 'progress', $response['status']['progress'] );
			$wgOut->addTemplate( $template );
			break;
		case 'finished':
			$wgOut->setPageTitle( wfMsg( 'coll-rendering_finished_title' ) );

			$template = new CollectionFinishedTemplate();
			$template->set( 'download_url', $wgServer . SkinTemplate::makeSpecialUrlSubpage( 'Collection', 'download/', $query ) );
			$template->set( 'is_cached', $wgRequest->getVal( 'is_cached' ) );
			$template->set( 'query', $query );
			$template->set( 'return_to', $return_to );
			$wgOut->addTemplate( $template );
			break;
		default:
			$wgOut->addWikiText( 'state: ' . $response['state'] );
		}
	}
	
	function download() {
		global $wgOut;
		global $wgRequest;
		
		$tempfile = tmpfile();
		$headers = self::mwServeCommand( 'download', array(
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
			$wgOut->showErrorPage( 'coll-notitle_title', 'coll-notitle_msg' );
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

	function postZIP( $collection, $partner ) {
		global $wgServer;
		global $wgScriptPath;
		global $wgScriptExtension;
		global $wgOut;
		
		$json = new Services_JSON();

		if ( !isset( $this->mPODPartners[$partner] ) ) {
			$wgOut->showErrorPage( 'coll-invalid_podpartner_title', 'coll-invalid_podpartner_msg' );
			return;
		}

		$response = self::mwServeCommand( 'zip_post', array(
			'metabook' => $this->buildJSONCollection( $collection ),
			'base_url' => $wgServer . $wgScriptPath,
			'script_extension' => $wgScriptExtension,
			'template_blacklist' => wfMsgForContent( 'coll-template_blacklist_title' ),
			'template_exclusion_category' => wfMsgForContent( 'coll-exclusion_category_title' ),
			'print_template_prefix' => wfMsgForContent( 'coll-print_template_prefix' ),
			'pod_api_url' => $this->mPODPartners[$partner]['posturl'],
		) );
		if ( !$response ) {
			return;
		}	
		$wgOut->redirect( $response['redirect_url'] );
	}
	
	private function renderSaveOverwritePage( $title ) {
		global $wgOut;

		$this->setHeaders();
		$wgOut->setPageTitle( wfMsg( 'coll-save_collection' ) );
		
		$template = new CollectionSaveOverwriteTemplate();
		$template->set( 'title',  $title );
		$wgOut->addTemplate( $template );
	}

	private function renderLoadOverwritePage( $title ) {
		global $wgOut;

		$this->setHeaders();
		$wgOut->setPageTitle( wfMsg( 'coll-load_collection' ) );
		
		$template = new CollectionLoadOverwriteTemplate();
		$template->set( 'title',  $title );
		$wgOut->addTemplate( $template );
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
	static function createNavURLs( &$skinTemplate, &$nav_urls, &$revid1, &$revid2 ) {
		global $wgArticle;
		global $wgRequest;
		global $wgCollectionFormats;

		wfLoadExtensionMessages( 'Collection' );

		$action = $wgRequest->getVal('action');

		if ( $skinTemplate->iscontent && ( $action == '' || $action == 'view' || $action == 'purge' ) ) {
			if ( self::isCollectionPage( $skinTemplate->mTitle, $wgArticle ) ) {
				$params = 'colltitle=' . wfUrlencode( $skinTemplate->mTitle->getPrefixedDBKey() );
				if ( isset( $wgCollectionFormats['rl'] ) ) {
					$nav_urls['printable_version_pdf'] = array(
						'href' => SkinTemplate::makeSpecialUrlSubpage(
							'Collection',
							'render_collection/',
						  $params . '&writer=rl'),
						'text' => wfMsg( 'coll-printable_version_pdf' ),
					);
				}
				foreach ( $wgCollectionFormats as $writer => $name ) {
				}
			} else {
				$params = 'arttitle=' . $skinTemplate->mTitle->getPrefixedURL();
				if( $wgArticle ) {
					$oldid = $wgArticle->getOldID();
					if ( $oldid ) {
						$params .= '&oldid=' . $oldid;
					}
				}
				if ( isset( $wgCollectionFormats['rl'] ) ) {
					$nav_urls['printable_version_pdf'] = array(
						'href' => SkinTemplate::makeSpecialUrlSubpage(
							'Collection',
							'render_article/',
						  $params . '&writer=rl' ),
						'text' => wfMsg( 'coll-printable_version_pdf' )
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
		
		if ( !empty( $skinTemplate->data['nav_urls']['printable_version_pdf']['href'] ) ) {
			$href = htmlspecialchars( $skinTemplate->data['nav_urls']['printable_version_pdf']['href'] );
			$label = htmlspecialchars( $skinTemplate->data['nav_urls']['printable_version_pdf']['text'] );
			print <<<EOS
<li id="t-download-as-$writer"><a href="$href" rel="nofollow">$label</a></li>
EOS
			;
		}
		return true;
	}


	/**
	 * Callback for hook SkinBuildSidebar (MediaWiki >= 1.14)
	 */
	static function buildSidebar( $skin, &$bar ) {
		global $wgArticle;
		global $wgUser;
		global $wgPortletForLoggedInUsersOnly;
		
		if( !$wgPortletForLoggedInUsersOnly || $wgUser->isLoggedIn() ) {
			// We don't want this sidebar gadget polluting the HTTP caches.
			// To stay on the safe side for now, we'll show this only for
			// logged-in users.
			//
			// In theory this could be managed properly for open sessions,
			// but you'd have to inject something for non-open sessions or
			// it would be very confusing.
			$html = self::getPortlet();
			if ( $html ) {
				$bar[ wfMsg( 'coll-portlet_title' )] = $html;
			}
		}
		return true;
	}

	/**
	 * This function is the fallback solution for MediaWiki < 1.14
	 * (where the hook SkinBuildSidebar doesn't exist)
	 */
	static function printPortlet() {
		wfLoadExtensionMessages( 'Collection' );

		$html = self::getPortlet();
		
		if ( $html ) {
			$portletTitle = wfMsgHtml( 'coll-portlet_title' );
			print <<<EOS
<div id="p-collection" class="portlet">	 
  <h5>$portletTitle</h5>	 
    <div class="pBody">	 
EOS
			;
			print $html;
			print '</div></div>';
		}
	}
	
	/**
	 * Return HTML-code to be inserted as portlet
	 */
	static function getPortlet( $ajaxHint='' ) {
		global $wgArticle;
		global $wgRequest;
		global $wgTitle;
		global $wgOut;
		global $wgCollectionArticleNamespaces;
		
		// Note: we need to use $wgRequest, b/c there is apparently no way to get
		// the subpage part of a Special page via $wgTitle.
		$mainTitle = Title::makeTitle( NS_SPECIAL, 'Collection' );
		if ( $wgRequest->getRequestURL() == $mainTitle->getLocalURL() ) {
			return;
		}
		
		wfLoadExtensionMessages( 'Collection' );

		$addArticle = wfMsgHtml( 'coll-add_page' );
		$removeArticle = wfMsgHtml( 'coll-remove_page' );
		$addCategory = wfMsgHtml( 'coll-add_category' );
		$loadCollection = wfMsgHtml( 'coll-load_collection' );
		
		$numArticles = self::countArticles();
		
		$out = "<ul id=\"collectionPortletList\">";
		
		if ( self::isCollectionPage( $wgTitle, $wgArticle) ) {
			$params = "colltitle=" . $wgTitle->getPrefixedUrl();
			$href = htmlspecialchars( SkinTemplate::makeSpecialUrlSubpage(
				'Collection',
				'load_collection/',
			  $params ) );
			$out .= "<li><a href=\"$href\" rel=\"nofollow\">$loadCollection</a></li>";
		} else {
	
			// disable caching
			$wgOut->setSquidMaxage( 0 );
			$wgOut->enableClientCache( false );
			
			$namespace =  $wgTitle->getNamespace();
			
  		if ( $ajaxHint == 'AddCategory' || $namespace == NS_CATEGORY ) {
				$params = "cattitle=" . $wgTitle->getPartialURL();
				$href = htmlspecialchars( SkinTemplate::makeSpecialUrlSubpage(
					'Collection',
					'add_category/',
				  $params ) );
				$out .= <<<EOS
<li>
	<a href="$href" onclick="collectionCall('AddCategory', [wgTitle]); return false;" rel="nofollow">$addCategory</a>
</li>
EOS
				;
			} else if ( !$ajaxHint && (is_null( $wgArticle ) || !$wgArticle->exists()) ) {
				if ( self::countArticles() == 0) {
					return;
				}
			} else if ( $ajaxHint || in_array( $namespace, $wgCollectionArticleNamespaces ) ) {
				$params = "arttitle=" . $wgTitle->getPrefixedUrl();
				if ( !is_null( $wgArticle ) ) {
					$oldid = $wgArticle->getOldID();
					$params .= "&oldid=" . $oldid;
				} else {
					$oldid = null;
				}

				if ( $ajaxHint == "RemoveArticle" || self::findArticle( $wgTitle->getPrefixedText(), $oldid ) == -1 ) {
					$href = htmlspecialchars( SkinTemplate::makeSpecialUrlSubpage(
						'Collection',
						'add_article/',
					  $params ) );
					$out .= <<<EOS
<li>
	<a href="$href" onclick="collectionCall('AddArticle', [wgNamespaceNumber, wgTitle, $oldid]); return false;" rel="nofollow">$addArticle</a>
</li>
EOS
					;
				} else {
					$href = htmlspecialchars( SkinTemplate::makeSpecialUrlSubpage(
						'Collection',
						'remove_article/',
					  $params ) );
					$out .= <<<EOS
<li>
	<a href="$href" onclick="collectionCall('RemoveArticle', [wgNamespaceNumber, wgTitle, $oldid]); return false;" rel="nofollow">$removeArticle</a>
</li>
EOS
					;
				}
			}
			
			if ( $numArticles > 0 ) {
				global $wgLang;
				$articles = wfMsgExt( 'coll-n_pages', array( 'parsemag' ), $wgLang->formatNum( $numArticles ) );
				$showCollection = wfMsgHtml( 'coll-show_collection' );
				$showURL = htmlspecialchars( SkinTemplate::makeSpecialUrl( 'Collection') );
				$out .= <<<EOS
							<li><a href="$showURL" rel="nofollow">$showCollection<br />
								($articles)</a></li>
EOS
				;
			
				$clearCollection = wfMsgHtml( 'coll-clear_collection' );
				$params = 'return_to=' . $wgTitle->getFullURL();
				$href = htmlspecialchars( SkinTemplate::makeSpecialUrlSubpage(
					'Collection',
					'clear_collection/',
				  $params ) );
				$msg = htmlspecialchars( wfMsg( 'coll-clear_collection_confirm' ) );
				$out .= <<<EOS
<li>
	<a href="$href" onclick="if (confirm('$msg')) collectionCall('Clear', []); return false;" rel="nofollow">$clearCollection</a>
</li>
EOS
				;
			}
			
			$helpCollections = wfMsgHtml( 'coll-help_collections' );
			$helpURL = htmlspecialchars( Title::makeTitle( NS_HELP, wfMsgForContent( 'coll-collections' ) )->getFullURL() );
			$out .= <<<EOS
							<li><a href="$helpURL">$helpCollections</a></li>
EOS
			;
		}
		
		$out .= "</ul>";

		$out .= <<<EOS
<script type="text/javascript">
/* <![CDATA[ */
	function collectionCall(func, args) {
		sajax_request_type = 'POST';
		sajax_do_call('wfAjaxCollection' + func, args, function(xhr) {
			sajax_request_type = 'GET';
			sajax_do_call('wfAjaxCollectionGetPortlet', [func], function(xhr) {
				document.getElementById('collectionPortletList').parentNode.innerHTML = xhr.responseText;
			});
		});
	}
/* ]]> */
</script>
EOS
			;

		return $out;
	}
	
	static function mwServeCommand( $command, $args, $timeout=true, $toFile=null ) {
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
		
		$json = new Services_JSON( SERVICES_JSON_LOOSE_TYPE );
		$json_response = $json->decode( $response );
		
		if ( !$json_response ) {
			$wgOut->showErrorPage(
				'coll-mwserve_failed_title',
				'coll-mwserve_failed_msg',
				array( $response )
			);
			return false;
		}
		
		if ( isset( $json_response['error'] ) && $json_response['error'] ) {
			$wgOut->showErrorPage(
				'coll-mwserve_failed_title',
				'coll-mwserve_failed_msg',
				array( $json_response['error'] )
			);
			return false;
		}
		
		return $json_response;
	}
	
	static function post( $url, $postFields, &$errorMessage, &$headers,
		$timeout=true, $toFile=null ) {
		global $wgHTTPTimeout, $wgHTTPProxy, $wgTitle, $wgVersion;
		global $wgCollectionMWServeCert;
		global $wgCollectionVersion;
		
		$c = curl_init( $url );
		curl_setopt($c, CURLOPT_PROXY, $wgHTTPProxy);
		$userAgent = wfGetAgent();
		if ( !$userAgent ) $userAgent = "Unknown user agent";
		curl_setopt( $c, CURLOPT_USERAGENT, $userAgent . " (via MediaWiki/$wgVersion, Collection/$wgCollectionVersion)" );
		curl_setopt( $c, CURLOPT_POST, true );
		curl_setopt( $c, CURLOPT_POSTFIELDS, $postFields );
		curl_setopt( $c, CURLOPT_HTTPHEADER, array( 'Expect:' ) );
		if ( is_object( $wgTitle ) ) {
			curl_setopt( $c, CURLOPT_REFERER, $wgTitle->getFullURL() );
		}
		if ( $timeout ) {
			curl_setopt( $c, CURLOPT_TIMEOUT, $wgHTTPTimeout );
		}
		/* Allow the use of self-signed certificates by referencing
		 * a local (to the mediawiki install) copy of the signing
		 * certificate */
		if ( !($wgCollectionMWServeCert === null) ) {
			curl_setopt ($c, CURLOPT_SSL_VERIFYPEER, TRUE); 
			curl_setopt ($c, CURLOPT_CAINFO, $wgCollectionMWServeCert);
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
	
	/**
	 * OutputPageCheckLastModified hook
	 */
	static function checkLastModified( $modifiedTimes ) {
		if ( self::hasSession() ) {
			$modifiedTimes['collection'] = $_SESSION['wsCollection']['timestamp'];
		}
		return true;
	}
}
