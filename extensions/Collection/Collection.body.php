<?php
/**
 * Collection Extension for MediaWiki
 *
 * Copyright (C) PediaPress GmbH
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
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

class SpecialCollection extends SpecialPage {
	var $mPODPartners = array(
		'pediapress' => array(
			'name' => 'PediaPress',
			'url' => 'http://pediapress.com/',
			'posturl' => 'http://pediapress.com/api/collections/',
		),
	);

	public function __construct() {
		parent::__construct( "Book" );
	}

	function getDescription() {
		return wfMsg( 'coll-collection' );
	}

	function execute( $par ) {
		global $wgOut, $wgRequest, $wgUser, $wgContLang, $wgCollectionMaxArticles;

		// support previous URLs (e.g. used in templates) which used the "$par" part
		// (i.e. subpages of the Special page)
		if ( $par ) {
			if ( $wgRequest->wasPosted() ) { // don't redirect POST reqs
				// TODO
			}
			$wgOut->redirect( wfAppendQuery(
				SkinTemplate::makeSpecialUrl( 'Book' ),
				$wgRequest->appendQueryArray( array( 'bookcmd' => rtrim( $par, '/' ) ), true )
			) );
			return;
		}

		switch ( $wgRequest->getVal( 'bookcmd', '' ) ) {
			case 'book_creator':
				$this->renderBookCreatorPage( $wgRequest->getVal( 'referer', '' ), $par );
				return;

			case 'start_book_creator':
				$title = Title::newFromText( $wgRequest->getVal( 'referer', '' ) );
				if ( is_null( $title ) ) {
					$title = Title::newMainPage();
				}
				CollectionSession::enable();
				$wgOut->redirect( $title->getFullURL() );
				return;
			case 'stop_book_creator':
				$title = Title::newFromText( $wgRequest->getVal( 'referer', '' ) );
				if ( is_null( $title ) || $title->equals( $this->getTitle( $par ) ) ) {
					$title = Title::newMainPage();
				}
				if ( $wgRequest->getVal( 'disable' ) ) {
					CollectionSession::disable();
				} elseif ( !$wgRequest->getVal( 'continue' ) ) {
					$this->renderStopBookCreatorPage( $title );
					return;
				}
				$wgOut->redirect( $title->getFullURL() );
				return;
			case 'add_article':
				if ( CollectionSession::countArticles() >= $wgCollectionMaxArticles ) {
					self::limitExceeded();
					return;
				}
				$oldid = $wgRequest->getInt( 'oldid', 0 );
				$title = Title::newFromText( $wgRequest->getVal( 'arttitle', '' ) );
				if ( !$title ) {
					return;
				}
				if ( self::addArticle( $title, $oldid ) ) {
					if ( $oldid == 0 ) {
						$redirectURL = $title->getFullURL();
					} else {
						$redirectURL = $title->getFullURL( 'oldid=' . $oldid );
					}
					$wgOut->redirect( $redirectURL );
				} else {
					$wgOut->showErrorPage(
						'coll-couldnotaddarticle_title',
						'coll-couldnotaddarticle_msg'
					);
				}
				return;
			case 'remove_article':
				$oldid = $wgRequest->getInt( 'oldid', 0 );
				$title = Title::newFromText( $wgRequest->getVal( 'arttitle', '' ) );
				if ( !$title ) {
					return;
				}
				if ( self::removeArticle( $title, $oldid ) ) {
					if ( $oldid == 0 ) {
						$redirectURL = $title->getFullURL();
					} else {
						$redirectURL = $title->getFullURL( 'oldid=' . $oldid );
					}
					$wgOut->redirect( $redirectURL );
				} else {
					$wgOut->showErrorPage(
						'coll-couldnotremovearticle_title',
						'coll-couldnotremovearticle_msg'
					);
				}
				return;
			case 'clear_collection':
				CollectionSession::clearCollection();
				$redirect = $wgRequest->getVal( 'return_to' );
				$redirectURL = SkinTemplate::makeSpecialUrl( 'Book' );
				if ( !empty( $redirect ) ) {
					$title = Title::newFromText( $redirect );
					if ( $title ) {
						$redirectURL = $title->getFullURL();
					}
				}
				$wgOut->redirect( $redirectURL );
				return;
			case 'set_titles':
				self::setTitles( $wgRequest->getText( 'collectionTitle', '' ), $wgRequest->getText( 'collectionSubtitle', '' ) );
				$wgOut->redirect( SkinTemplate::makeSpecialUrl( 'Book' ) );
				return;
			case 'sort_items':
				self::sortItems();
				$wgOut->redirect( SkinTemplate::makeSpecialUrl( 'Book' ) );
				return;
			case 'add_category':
				$title = Title::makeTitleSafe( NS_CATEGORY, $wgRequest->getVal( 'cattitle', '' ) );
				if ( self::addCategory( $title ) ) {
					self::limitExceeded();
					return;
				} else {
					$wgOut->redirect( $wgRequest->getVal( 'return_to', $title->getFullURL() ) );
				}
				return;
			case 'remove_item':
				self::removeItem( $wgRequest->getInt( 'index', 0 ) );
				$wgOut->redirect( SkinTemplate::makeSpecialUrl( 'Book' ) );
				return;
			case 'move_item':
				self::moveItem( $wgRequest->getInt( 'index', 0 ), $wgRequest->getInt( 'delta', 0 ) );
				$wgOut->redirect( SkinTemplate::makeSpecialUrl( 'Book' ) );
				return;
			case 'load_collection':
				$title = Title::newFromText( $wgRequest->getVal( 'colltitle', '' ) );
				if ( !$title ) {
					return;
				}
				if ( $wgRequest->getVal( 'cancel' ) ) {
					$wgOut->redirect( $title->getFullURL() );
					return;
				}
				if ( !CollectionSession::countArticles()
					 || $wgRequest->getVal( 'overwrite' )
					 || $wgRequest->getVal( 'append' ) ) {
					$collection = $this->loadCollection( $title, $wgRequest->getVal( 'append' ) );
					if ( $collection ) {
						CollectionSession::startSession();
						CollectionSession::setCollection( $collection );
						CollectionSession::enable();
						$wgOut->redirect( SkinTemplate::makeSpecialUrl( 'Book' ) );
					}
					return;
				}
				$this->renderLoadOverwritePage( $title );
				return;
			case 'order_collection':
				$title = Title::newFromText( $wgRequest->getVal( 'colltitle', '' ) );
				if ( !$title ) {
					return;
				}
				$collection = $this->loadCollection( $title );
				$partner = $wgRequest->getVal( 'partner', key( $this->mPODPartners ) );
				return $this->postZIP( $collection, $partner );
			case 'save_collection':
				if ( $wgRequest->getVal( 'abort' ) ) {
					$wgOut->redirect( SkinTemplate::makeSpecialUrl( 'Book' ) );
					return;
				}
				if ( !$wgUser->matchEditToken( $wgRequest->getVal( 'token' ) ) ) {
					return;
				}
				$colltype = $wgRequest->getVal( 'colltype' );
				$prefixes = self::getBookPagePrefixes();
				if ( $colltype == 'personal' ) {
					$collname = $wgRequest->getVal( 'pcollname' );
					if ( !$wgUser->isAllowed( 'collectionsaveasuserpage' ) || empty( $collname ) ) {
						return;
					}
					$title = Title::newFromText( $prefixes['user-prefix'] . $collname );
				} elseif ( $colltype == 'community' ) {
					$collname = $wgRequest->getVal( 'ccollname' );
					if ( !$wgUser->isAllowed( 'collectionsaveascommunitypage' ) || empty( $collname ) ) {
						return;
					}
					$title = Title::newFromText( $prefixes['community-prefix'] . $collname );
				}
				if ( !$title ) {
					return;
				}
				if ( $this->saveCollection( $title, $wgRequest->getBool( 'overwrite' ) ) ) {
					$wgOut->redirect( $title->getFullURL() );
				} else {
					$this->renderSaveOverwritePage(
						$colltype,
						$title,
						$wgRequest->getVal( 'pcollname' ),
						$wgRequest->getVal( 'ccollname' )
					);
				}
				return;
			case 'render':
				return $this->renderCollection(
					CollectionSession::getCollection(),
					SpecialPage::getTitleFor( 'Book' ),
					$wgRequest->getVal( 'writer', '' )
				);
			case 'forcerender':
				$this->forceRenderCollection();
				return;
			case 'rendering':
				$this->renderRenderingPage();
				return;
			case 'download':
				$this->download();
				return;
			case 'render_article':
				$title = Title::newFromText( $wgRequest->getVal( 'arttitle', '' ) );
				if ( !$title ) {
					return;
				}
				$oldid = $wgRequest->getInt( 'oldid', 0 );
				$this->renderArticle( $title, $oldid, $wgRequest->getVal( 'writer', 'rl' ) );
				return;
			case 'render_collection':
				$title = Title::newFromText( $wgRequest->getVal( 'colltitle', '' ) );
				if ( !$title ) {
					return;
				}
				$collection = $this->loadCollection( $title );
				if ( $collection ) {
					$this->renderCollection( $collection, $title, $wgRequest->getVal( 'writer', 'rl' ) );
				}
				return;
			case 'post_zip':
				$partner = $wgRequest->getVal( 'partner', 'pediapress' );
				$this->postZIP( CollectionSession::getCollection(), $partner );
				return;
			case 'suggest':
				$add = $wgRequest->getVal( 'add' );
				$ban = $wgRequest->getVal( 'ban' );
				$remove = $wgRequest->getVal( 'remove' );
				$addselected = $wgRequest->getVal( 'addselected' );

				if ( $wgRequest->getVal( 'resetbans' ) ) {
					CollectionSuggest::run( 'resetbans' );
				} elseif ( isset( $add ) ) {
					CollectionSuggest::run( 'add', $add );
				} elseif ( isset( $ban ) ) {
					CollectionSuggest::run( 'ban', $ban );
				} elseif ( isset( $remove ) ) {
					CollectionSuggest::run( 'remove', $remove );
				} elseif ( isset( $addselected ) ) {
					$articleList = $wgRequest->getArray( 'articleList' );
					if ( !is_null( $articleList ) ) {
						CollectionSuggest::run( 'addAll', $articleList );
					} else {
						CollectionSuggest::run();
					}
				} else {
					CollectionSuggest::run();
				}
				return;
			case '':
				$this->renderSpecialPage();
				return;
			default:
				$wgOut->showErrorPage( 'coll-unknown_subpage_title', 'coll-unknown_subpage_text' );
		}
		return;
	}

	function renderBookCreatorPage( $referer, $par ) {
		global $wgOut, $wgJsMimeType;

		$this->setHeaders();
		$wgOut->setPageTitle( wfMsg( 'coll-book_creator' ) );

		$wgOut->addWikiMsg( 'coll-book_creator_intro' );

		$wgOut->addModules( 'ext.collection.checkLoadFromLocalStorage' );

		$dialogtxt = wfMsg( 'coll-load_local_book' );

		$wgOut->addScript(
			"<script type=\"$wgJsMimeType\">\n" .
			"var collection_dialogtxt = " . Xml::encodeJsVar( $dialogtxt ) . ";\n" .
			"</script>" );

		$title = Title::newFromText( $referer );
		if ( is_null( $title ) || $title->equals( $this->getTitle( $par ) ) ) {
			$title = Title::newMainPage();
		}

		$wgOut->addHTML(
			Xml::tags( 'div',
				array(
					'style' => 'margin: 10px 0;',
				),
				Xml::tags( 'div',
					array(
						'class' => 'collection-button ok',
					),
					Xml::element( 'a',
						array(
							'href' => SkinTemplate::makeSpecialUrl(
								'Book',
								array(
									'bookcmd' => 'start_book_creator',
									'referer' => $referer,
								)
							),
							// TODO: title
						),
						wfMsg( 'coll-start_book_creator' )
					)
				)
				. Xml::tags( 'div',
					array(
						'class' => 'collection-button cancel',
					),
					Linker::link(
						$title,
						wfMsgHtml( 'coll-cancel' ),
						array(
							'rel' => 'nofollow',
							// TOOD: title
						),
						array(),
						array( 'known', 'noclasses' )
					)
				)
				. Xml::element( 'div',
					array(
						'style' => 'clear: both;',
					),
					'', false
				)
			)
		);

		$title_string = wfMsgForContent( 'coll-book_creator_text_article' );
		$t = Title::newFromText( $title_string );
		if ( !is_null( $t ) ) {
			$a = new Article( $t );
			if ( $a->exists() ) {
				$wgOut->addWikiText( '{{:' . $title_string . '}}' );
				return;
			}
		}
		$wgOut->addWikiMsg( 'coll-book_creator_help' );
	}

	function renderStopBookCreatorPage( $referer ) {
		global $wgOut;

		$this->setHeaders();
		$wgOut->setPageTitle( wfMsg( 'coll-book_creator_disable' ) );
		$wgOut->addWikiMsg( 'coll-book_creator_disable_text' );

		$wgOut->addHTML(
			Xml::tags( 'form',
				array(
					'action' => SkinTemplate::makeSpecialUrl(
						'Book',
						array( 'bookcmd' => 'stop_book_creator' )
					),
					'method' => 'post',
				),
				Xml::element( 'input',
					array(
						'type' => 'hidden',
						'name' => 'referer',
						'value' => $referer,
					)
				)
				. Xml::element( 'input',
					array(
						'type' => 'submit',
						'value' => wfMsg( 'coll-book_creator_continue' ),
						'name' => 'continue',
					)
				)
				. Xml::element( 'input',
					array(
						'type' => 'submit',
						'value' => wfMsg( 'coll-book_creator_disable' ),
						'name' => 'disable',
					)
				)
			)
		);
	}

	static function getBookPagePrefixes() {
		global $wgUser, $wgCommunityCollectionNamespace;

		$result = array();

		$t = wfMsgForContent( 'coll-user_book_prefix', $wgUser->getName() );
		if ( wfEmptyMsg( 'coll-user_book_prefix', $t ) || $t == '-' ) {
			$userPageTitle = $wgUser->getUserPage()->getPrefixedText();
			$result['user-prefix'] = $userPageTitle . '/'
				. wfMsgForContent( 'coll-collections' ) . '/';
		} else {
			$result['user-prefix'] = $t;
		}

		$t = wfMsgForContent( 'coll-community_book_prefix' );
		if ( wfEmptyMsg( 'coll-community_book_prefix', $t ) || $t == '-' ) {
			$title = Title::makeTitle(
				$wgCommunityCollectionNamespace,
				wfMsgForContent( 'coll-collections' )
			);
			$result['community-prefix'] = $title->getPrefixedText() . '/';
		} else {
			$result['community-prefix'] = $t;
		}
		return $result;
	}

	function renderSpecialPage() {
		global $wgCollectionFormats, $wgOut;

		if ( !CollectionSession::hasSession() ) {
			CollectionSession::startSession();
		}

		$this->setHeaders();
		$wgOut->setPageTitle( wfMsg( 'coll-manage_your_book' ) );
		$wgOut->addModules( 'ext.collection' );

		$template = new CollectionPageTemplate();
		$template->set( 'collection', CollectionSession::getCollection() );
		$template->set( 'podpartners', $this->mPODPartners );
		$template->set( 'formats', $wgCollectionFormats );
		$prefixes = self::getBookPagePrefixes();
		$template->set( 'user-book-prefix', $prefixes['user-prefix'] );
		$template->set( 'community-book-prefix', $prefixes['community-prefix'] );
		$wgOut->addTemplate( $template );
	}

	static function setTitles( $title, $subtitle ) {
		$collection = CollectionSession::getCollection();
		$collection['title'] = $title;
		$collection['subtitle'] = $subtitle;
		CollectionSession::setCollection( $collection );
	}

	static function title_cmp( $a, $b ) {
		return strcasecmp( $a['title'], $b['title'] );
	}

	static function sortItems() {
		$collection = CollectionSession::getCollection();
		$articles = array();
		$new_items = array();
		foreach ( $collection['items'] as $item ) {
			if ( $item['type'] == 'chapter' ) {
				usort( $articles, array( __CLASS__, 'title_cmp' ) );
				$new_items = array_merge( $new_items, $articles, array( $item ) );
				$articles = array();
			} elseif ( $item['type'] == 'article' ) {
				$articles[] = $item;
			}
		}
		usort( $articles, array( __CLASS__, 'title_cmp' ) );
		$collection['items'] = array_merge( $new_items, $articles );
		CollectionSession::setCollection( $collection );
	}

	static function addChapter( $name ) {
		$collection = CollectionSession::getCollection();
		array_push( $collection['items'], array(
			'type' => 'chapter',
			'title' => $name,
		) );
		CollectionSession::setCollection( $collection );
	}

	static function renameChapter( $index, $name ) {
		if ( !is_int( $index ) ) {
			return;
		}
		$collection = CollectionSession::getCollection();
		if ( $collection['items'][$index]['type'] != 'chapter' ) {
			return;
		}
		$collection['items'][$index]['title'] = $name;
		CollectionSession::setCollection( $collection );
	}

	static function addArticleFromName( $namespace, $name, $oldid = 0 ) {
		$title = Title::makeTitleSafe( $namespace, $name );
		if ( !$title ) {
			return false;
		}
		return self::addArticle( $title, $oldid );
	}

	/**
	 * @param $title Title
	 * @param $oldid int
	 * @return bool
	 */
	static function addArticle( $title, $oldid = 0 ) {
		global $wgCollectionHierarchyDelimiter;

		$latest = $title->getLatestRevID();

		$currentVersion = 0;
		if ( $oldid == 0 ) {
			$currentVersion = 1;
			$oldid = $latest;
		}

		$prefixedText = $title->getPrefixedText();

		$index = CollectionSession::findArticle( $prefixedText, $oldid );
		if ( $index != - 1 ) {
			return false;
		}

		if ( !CollectionSession::hasSession() ) {
			CollectionSession::startSession();
		}
		$collection = CollectionSession::getCollection();
		$revision = Revision::newFromTitle( $title, $oldid );

		$item = array(
			'type' => 'article',
			'content_type' => 'text/x-wiki',
			'title' => $prefixedText,
			'revision' => strval( $oldid ),
			'latest' => strval( $latest ),
			'timestamp' => wfTimestamp( TS_UNIX, $revision->getTimestamp() ),
			'url' => $title->getCanonicalURL(),
			'currentVersion' => $currentVersion,
		);

		if ( $wgCollectionHierarchyDelimiter != null ) {
			$parts = explode( $wgCollectionHierarchyDelimiter, $prefixedText );
			if ( count( $parts ) > 1 && end( $parts ) != '' ) {
				$item['displaytitle'] = end( $parts );
			}
		}

		$collection['items'][] = $item;
		CollectionSession::setCollection( $collection );
		return true;
	}

	static function removeArticleFromName( $namespace, $name, $oldid = 0 ) {
		$title = Title::makeTitleSafe( $namespace, $name );
		return self::removeArticle( $title, $oldid );
	}

	/**
	 * @param $title Title
	 * @param $oldid int
	 * @return bool
	 */
	static function removeArticle( $title, $oldid = 0 ) {
		if ( !CollectionSession::hasSession() ) {
			return false;
		}
		$collection = CollectionSession::getCollection();
		$index = CollectionSession::findArticle( $title->getPrefixedText(), $oldid );
		if ( $index != - 1 ) {
			array_splice( $collection['items'], $index, 1 );
		}
		CollectionSession::setCollection( $collection );
		return true;
	}

	static function addCategoryFromName( $name ) {
		$title = Title::makeTitleSafe( NS_CATEGORY, $name );
		return self::addCategory( $title );
	}

	static function addCategory( $title ) {
		global $wgCollectionMaxArticles, $wgCollectionArticleNamespaces;

		$limit = $wgCollectionMaxArticles - CollectionSession::countArticles();
		if ( $limit <= 0 ) {
			self::limitExceeded();
			return;
		}
		$db = wfGetDB( DB_SLAVE );
		$tables = array( 'page', 'categorylinks' );
		$fields = array( 'page_namespace', 'page_title' );
		$options = array(
			'USE INDEX' => 'cl_sortkey',
			'ORDER BY' => 'cl_type, cl_sortkey',
			'LIMIT' => $limit + 1,
		);
		$where = array(
			'cl_from=page_id',
			'cl_to' => $title->getDBkey(),
		);
		$res = $db->select( $tables, $fields, $where, __METHOD__, $options );

		$count = 0;
		$limitExceeded = false;
		foreach ( $res as $row ) {
			if ( ++$count > $limit ) {
				$limitExceeded = true;
				break;
			}
			if ( in_array( $row->page_namespace, $wgCollectionArticleNamespaces ) ) {
				$articleTitle = Title::makeTitle( $row->page_namespace, $row->page_title );
				if ( CollectionSession::findArticle( $articleTitle->getPrefixedText() ) == - 1 ) {
					self::addArticle( $articleTitle );
				}
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
		if ( !is_int( $index ) ) {
			return false;
		}
		if ( !CollectionSession::hasSession() ) {
			return false;
		}
		$collection = CollectionSession::getCollection();
		array_splice( $collection['items'], $index, 1 );
		CollectionSession::setCollection( $collection );
		return true;
	}

	static function moveItem( $index, $delta ) {
		if ( !CollectionSession::hasSession() ) {
			return false;
		}
		$collection = CollectionSession::getCollection();
		$saved = $collection['items'][$index + $delta];
		$collection['items'][$index + $delta] = $collection['items'][$index];
		$collection['items'][$index] = $saved;
		CollectionSession::setCollection( $collection );
		return true;
	}

	static function setSorting( $items ) {
		if ( !CollectionSession::hasSession() ) {
			return;
		}
		$collection = CollectionSession::getCollection();
		$old_items = $collection['items'];
		$new_items = array();
		foreach ( $items as $new_index => $old_index ) {
			$new_items[$new_index] = $old_items[$old_index];
		}
		$collection['items'] = $new_items;
		CollectionSession::setCollection( $collection );
	}

	function parseCollectionLine( &$collection, $line, $append ) {
		$line = trim( $line );
		if ( !$append && preg_match( '/^===\s*(.*?)\s*===$/', $line, $match ) ) {
			$collection['subtitle'] = $match[ 1 ];
		} elseif ( !$append && preg_match( '/^==\s*(.*?)\s*==$/', $line, $match ) ) {
			$collection['title'] = $match[ 1 ];
		} elseif ( substr( $line, 0, 1 ) == ';' ) { // chapter
			return array(
				'type' => 'chapter',
				'title' => trim( substr( $line, 1 ) ),
			);
		} elseif ( substr( $line, 0, 1 ) == ':' ) { // article
			$articleTitle = trim( substr( $line, 1 ) );
			if ( preg_match( '/^\[\[:?(.*?)(\|(.*?))?\]\]$/', $articleTitle, $match ) ) {
				$articleTitle = $match[1];
				if ( isset( $match[3] ) ) {
					$displayTitle = $match[3];
				} else {
					$displayTitle = null;
				}
				$oldid = - 1;
				$currentVersion = 1;
			} elseif ( preg_match( '/^\[\{\{fullurl:(.*?)\|oldid=(.*?)\}\}\s+(.*?)\]$/', $articleTitle, $match ) ) {
				$articleTitle = $match[1];
				if ( isset( $match[3] ) ) {
					$displayTitle = $match[3];
				} else {
					$displayTitle = null;
				}
				$oldid = $match[2];
				$currentVersion = 0;
			} else {
				return null;
			}

			$articleTitle = Title::newFromText( $articleTitle );
			if ( !$articleTitle ) {
				return null;
			}
			if ( $oldid < 0 ) {
				$article = new Article( $articleTitle );
			} else {
				$article = new Article( $articleTitle, $oldid );
			}
			if ( !$article->exists() ) {
				return null;
			}
			$revision = Revision::newFromTitle( $articleTitle, $article->getOldID() );
			$latest = $article->getLatest();
			$oldid = $article->getOldID();
			if ( !$oldid ) {
				$oldid = $latest;
			}
			$d = array(
				'type' => 'article',
				'content_type' => 'text/x-wiki',
				'title' => $articleTitle->getPrefixedText(),
				'latest' => $latest,
				'revision' => $oldid,
				'timestamp' => wfTimestamp( TS_UNIX, $revision->getTimestamp() ),
				'url' => $articleTitle->getCanonicalURL(),
				'currentVersion' => $currentVersion,
			);
			if ( $displayTitle ) {
				$d['displaytitle'] = $displayTitle;
			}
			return $d;
		}
		return null;
	}

	/**
	 * @param $title Title
	 * @param $append bool
	 * @return array|bool
	 */
	function loadCollection( $title, $append = false ) {
		global $wgOut;

		if ( is_null( $title ) ) {
			$wgOut->showErrorPage( 'coll-notitle_title', 'coll-notitle_msg' );
			return;
		}

		if ( !$title->exists() ) {
			$wgOut->showErrorPage( 'coll-notfound_title', 'coll-notfound_msg' );
			return false;
		}

		if ( !$append || !CollectionSession::hasSession() ) {
			$collection = array(
				'title' => '',
				'subtitle' => '',
			);
			$items = array();
		} else {
			$collection = CollectionSession::getCollection();
			$items = $collection['items'];
		}

		$article = new Article( $title );

		foreach ( preg_split( '/[\r\n]+/', $article->getContent() ) as $line ) {
			$item = $this->parseCollectionLine( $collection, $line, $append );
			if ( !is_null( $item ) ) {
				$items[] = $item;
			}
		}
		$collection['items'] = $items;
		return $collection;
	}

	/**
	 * @param $title Title
	 * @param $forceOverwrite bool
	 * @return bool
	 */
	function saveCollection( $title, $forceOverwrite = false ) {
		global $wgRequest, $wgUser;

		$article = new Article( $title );
		if ( $article->exists() && !$forceOverwrite ) {
			return false;
		}
		$articleText = "{{" . wfMsgForContent( 'coll-savedbook_template' ) . "}}\n\n";
		$collection = CollectionSession::getCollection();
		if ( $collection['title'] ) {
			$articleText .= '== ' . $collection['title'] . " ==\n";
		}
		if ( $collection['subtitle'] ) {
			$articleText .= '=== ' . $collection['subtitle'] . " ===\n";
		}
		if ( !empty( $collection['items'] ) ) {
			foreach ( $collection['items'] as $item ) {
				if ( $item['type'] == 'chapter' ) {
					$articleText .= ';' . $item['title'] . "\n";
				} elseif ( $item['type'] == 'article' ) {
					if ( $item['currentVersion'] == 1 ) {
						$articleText .= ":[[" . $item['title'];
						if ( isset( $item['displaytitle'] ) && $item['displaytitle'] ) {
							$articleText .= "|" . $item['displaytitle'];
						}
						$articleText .= "]]\n";
					} else {
						$articleText .= ":[{{fullurl:" . $item['title'];
						$articleText .= "|oldid=" . $item['revision'] . "}} ";
						if ( isset( $item['displaytitle'] ) && $item['displaytitle'] ) {
							$articleText .= $item['displaytitle'];
						} else {
							$articleText .= $item['title'];
						}
						$articleText .= "]\n";
					}
				}
				// $articleText .= $item['revision'] . "/" . $item['latest']."\n";
			}
		}
		$t = wfMsgForContent( 'coll-bookscategory' );
		if ( !wfEmptyMsg( 'coll-bookscategory', $t ) && $t != '-' ) {
			$catTitle = Title::makeTitle( NS_CATEGORY, $t );
			if ( !is_null( $catTitle ) ) {
				$articleText .= "\n[[" . $catTitle->getPrefixedText() . "|" . wfEscapeWikiText( $title->getSubpageText() ) . "]]\n";
			}
		}

		$req = new DerivativeRequest(
			$wgRequest,
			array(
				'action' => 'edit',
				'title' => $title->getPrefixedText(),
				'text' => $articleText,
				'token' => $wgUser->editToken(),
		), true);
		$api = new ApiMain( $req, true );
		$api->execute();
		return true;
	}

	function getLicenseInfos() {
		global $wgCollectionLicenseName, $wgCollectionLicenseURL, $wgRightsIcon;
		global $wgRightsPage, $wgRightsText, $wgRightsUrl;

		$licenseInfo = array(
			"type" => "license",
		);

		$from_msg = wfMsgForContent( 'coll-license_url' );
		if ( !wfEmptyMsg( 'coll-license_url', $from_msg ) && $from_msg != '-' ) {
			$licenseInfo['mw_license_url'] = $from_msg;
			return array( $licenseInfo );
		}

		if ( $wgCollectionLicenseName ) {
			$licenseInfo['name'] = $wgCollectionLicenseName;
		} else {
			$licenseInfo['name'] = wfMsgForContent( 'coll-license' );
		}

		if ( $wgCollectionLicenseURL ) {
			$licenseInfo['mw_license_url'] = $wgCollectionLicenseURL;
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
			} elseif ( $item['type'] == 'chapter' ) {
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
		global $wgOut, $wgContLang, $wgScriptPath, $wgScriptExtension;

		if ( !$writer ) {
			$writer = 'rl';
		}

		$response = self::mwServeCommand( 'render', array(
			'metabook' => $this->buildJSONCollection( $collection ),
			'base_url' => wfExpandUrl( $wgScriptPath, PROTO_CURRENT ),
			'script_extension' => $wgScriptExtension,
			'template_blacklist' => wfMsgForContent( 'coll-template_blacklist_title' ),
			'template_exclusion_category' => wfMsgForContent( 'coll-exclusion_category_title' ),
			'print_template_prefix' => wfMsgForContent( 'coll-print_template_prefix' ),
			'print_template_pattern' => wfMsgForContent( 'coll-print_template_pattern' ),
			'language' => $wgContLang->getCode(),
			'writer' => $writer,
		) );

		if ( !$response ) {
			return;
		}

		$query = 'bookcmd=rendering'
			. '&return_to=' . urlencode( $referrer->getPrefixedText() )
			. '&collection_id=' . urlencode( $response['collection_id'] )
			. '&writer=' . urlencode( $response['writer'] );
		if ( isset( $response['is_cached'] ) && $response['is_cached'] ) {
			$query .= '&is_cached=1';
		}
		$redirect = SkinTemplate::makeSpecialUrl( 'Book', $query );
		$wgOut->redirect( $redirect );
	}

	function forceRenderCollection() {
		global $wgOut, $wgContLang, $wgRequest, $wgScriptPath, $wgScriptExtension;

		$collectionID = $wgRequest->getVal( 'collection_id', '' );
		$writer = $wgRequest->getVal( 'writer', 'rl' );

		$response = self::mwServeCommand( 'render', array(
			'collection_id' => $collectionID,
			'base_url' => wfExpandUrl( $wgScriptPath, PROTO_CURRENT ),
			'script_extension' => $wgScriptExtension,
			'template_blacklist' => wfMsgForContent( 'coll-template_blacklist_title' ),
			'template_exclusion_category' => wfMsgForContent( 'coll-exclusion_category_title' ),
			'print_template_prefix' => wfMsgForContent( 'coll-print_template_prefix' ),
			'print_template_pattern' => wfMsgForContent( 'coll-print_template_pattern' ),
			'language' => $wgContLang->getCode(),
			'writer' => $writer,
			'force_render' => true
		) );

		if ( !$response ) {
			return;
		}

		$query = 'bookcmd=rendering'
			. '&return_to=' . $wgRequest->getVal( 'return_to', '' )
			. '&collection_id=' . urlencode( $response['collection_id'] )
			. '&writer=' . urlencode( $response['writer'] );
		if ( $response['is_cached'] ) {
			$query .= '&is_cached=1';
		}
		$wgOut->redirect( SkinTemplate::makeSpecialUrl( 'Book', $query ) );
	}

	function renderRenderingPage() {
		global $wgLang, $wgOut, $wgRequest;

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
			$url = htmlspecialchars( SkinTemplate::makeSpecialUrl( 'Book', 'bookcmd=rendering&' . $query ) );
			$wgOut->addHeadItem( 'refresh-nojs', '<noscript><meta http-equiv="refresh" content="2" /></noscript>' );
			$wgOut->addInlineScript( 'var collection_id = "' . urlencode( $response['collection_id'] ) . '";' );
			$wgOut->addInlineScript( 'var writer = "' . urlencode( $response['writer'] ) . '";' );
			$wgOut->addInlineScript( 'var collection_rendering = true;' );
			$wgOut->addModules( 'ext.collection' );
			$wgOut->setPageTitle( wfMsg( 'coll-rendering_title' ) );

			if ( isset( $response['status']['status'] ) && $response['status']['status'] ) {
				$statusText = $response['status']['status'];
				if ( isset( $response['status']['article'] ) && $response['status']['article'] ) {
					$statusText .= ' ' . wfMsg( 'coll-rendering_article', $response['status']['article'] );
				} elseif ( isset( $response['status']['page'] ) && $response['status']['page'] ) {
					$statusText .= ' ' . wfMsg( 'coll-rendering_page', $wgLang->formatNum( $response['status']['page'] ) );
				}
				$status = wfMsg( 'coll-rendering_status', $statusText );
			} else {
				$status = '';
			}

			$template = new CollectionRenderingTemplate();
			$template->set( 'status', $status );
			if ( !isset( $response['status']['progress'] ) ) {
				$response['status']['progress'] = 1.00;
			}
			$template->set( 'progress', $response['status']['progress'] );
			$wgOut->addTemplate( $template );
			break;
		case 'finished':
			$wgOut->setPageTitle( wfMsg( 'coll-rendering_finished_title' ) );

			$template = new CollectionFinishedTemplate();
			$template->set( 'download_url', wfExpandUrl( SkinTemplate::makeSpecialUrl( 'Book', 'bookcmd=download&' . $query ), PROTO_CURRENT ) );
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
		global $wgOut, $wgRequest, $wgCollectionContentTypeToFilename;

		$tempfile = tmpfile();
		$r = self::mwServeCommand( 'render_status', array(
			'collection_id' => $wgRequest->getVal( 'collection_id' ),
			'writer' => $wgRequest->getVal( 'writer' ),
		) );

		$info = false;
		if ( isset( $r['url'] ) ) {
			$result = Http::get( $r['url'] );
			if ($result) {
				fwrite($tempfile, $result);
				$info = true;
			}
			$content_type = $r['content_type'];
			$content_length = $r['content_length'];
			$content_disposition = $r['content_disposition'];
		} else {
			$info = self::mwServeCommand( 'download', array(
				'collection_id' => $wgRequest->getVal( 'collection_id' ),
				'writer' => $wgRequest->getVal( 'writer' ),
			) );
			$content_type = $info['content_type'];
			$content_length = $info['download_content_length'];
			$content_disposition = null;
		}
		if ( !$info ) {
			$wgOut->showErrorPage( 'coll-download_notfound_title', 'coll-download_notfound_text' );
			return;
		}
		wfResetOutputBuffers();
		header( 'Content-Type: ' . $content_type );
		header( 'Content-Length: ' . $content_length );
		if ( $content_disposition ) {
			header( 'Content-Disposition: ' . $content_disposition );
		} else {
			$ct_enc = explode( ';', $content_type );
			$ct = $ct_enc[0];
			if ( isset( $wgCollectionContentTypeToFilename[$ct] ) ) {
				header( 'Content-Disposition: ' . 'inline; filename=' . $wgCollectionContentTypeToFilename[$ct] );
			}
		}
		fseek( $tempfile, 0 );
		fpassthru( $tempfile );
		$wgOut->disable();
	}

	/**
	 * @param $title Title
	 * @param $oldid
	 * @param $writer
	 * @return
	 */
	function renderArticle( $title, $oldid, $writer ) {
		global $wgOut;

		if ( is_null( $title ) ) {
			$wgOut->showErrorPage( 'coll-notitle_title', 'coll-notitle_msg' );
			return;
		}
		$article = array(
			'type' => 'article',
			'content_type' => 'text/x-wiki',
			'title' => $title->getPrefixedText()
		);
		if ( $oldid ) {
			$article['revision'] = strval( $oldid );
		}

		$revision = Revision::newFromTitle( $title, $oldid );
		$article['timestamp'] = wfTimestamp( TS_UNIX, $revision->getTimestamp() );

		$this->renderCollection( array( 'items' => array( $article ) ), $title, $writer );
	}

	function postZIP( $collection, $partner ) {
		global $wgScriptPath, $wgScriptExtension, $wgOut;

		if ( !isset( $this->mPODPartners[$partner] ) ) {
			$wgOut->showErrorPage( 'coll-invalid_podpartner_title', 'coll-invalid_podpartner_msg' );
			return;
		}

		$response = self::mwServeCommand( 'zip_post', array(
			'metabook' => $this->buildJSONCollection( $collection ),
			'base_url' => wfExpandUrl( $wgScriptPath, PROTO_CURRENT ),
			'script_extension' => $wgScriptExtension,
			'template_blacklist' => wfMsgForContent( 'coll-template_blacklist_title' ),
			'template_exclusion_category' => wfMsgForContent( 'coll-exclusion_category_title' ),
			'print_template_prefix' => wfMsgForContent( 'coll-print_template_prefix' ),
			'print_template_pattern' => wfMsgForContent( 'coll-print_template_pattern' ),
			'pod_api_url' => $this->mPODPartners[$partner]['posturl'],
		) );
		if ( !$response ) {
			return;
		}
		$wgOut->redirect( $response['redirect_url'] );
	}

	private function renderSaveOverwritePage( $colltype, $title, $pcollname, $ccollname ) {
		global $wgOut;

		$this->setHeaders();
		$wgOut->setPageTitle( wfMsg( 'coll-save_collection' ) );

		$template = new CollectionSaveOverwriteTemplate();
		$template->set( 'title', $title );
		$template->set( 'pcollname', $pcollname );
		$template->set( 'ccollname', $ccollname );
		$template->set( 'colltype', $colltype );
		$wgOut->addTemplate( $template );
	}

	private function renderLoadOverwritePage( $title ) {
		global $wgOut;

		$this->setHeaders();
		$wgOut->setPageTitle( wfMsg( 'coll-load_collection' ) );

		$template = new CollectionLoadOverwriteTemplate();
		$template->set( 'title', $title );
		$wgOut->addTemplate( $template );
	}

	static function mwServeCommand( $command, $args ) {
		global $wgOut, $wgCollectionMWServeURL, $wgCollectionMWServeCredentials, $wgCollectionFormatToServeURL;

		$serveURL = $wgCollectionMWServeURL;
		if ( array_key_exists( $args['writer'], $wgCollectionFormatToServeURL ) )
			$serveURL = $wgCollectionFormatToServeURL[ $args['writer'] ];

		$args['command'] = $command;
		if ( $wgCollectionMWServeCredentials ) {
			$args['login_credentials'] = $wgCollectionMWServeCredentials;
		}
		$response = Http::post($serveURL, array('postData' => $args));

		if ( !$response ) {
			$wgOut->showErrorPage(
				'coll-post_failed_title',
				'coll-post_failed_msg',
				array( $serveURL )
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

}
