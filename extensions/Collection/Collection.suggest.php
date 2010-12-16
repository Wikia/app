<?php

/*
 * Collection Extension for MediaWiki
 *
 * Copyright (C) 2008-2009, PediaPress GmbH
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

/*
 * Class: CollectionSuggest
 *
 * This class contains only static methods, so theres no need for a constructer.
 * When the page Special:Book/suggest/ is loaded the method run() is called.
 * Ajax calles refresh().
 * When clearing a book the method clear() should be called.
 */
class CollectionSuggest {

	/*
	 * ===============================================================================
	 * public methods
	 * ===============================================================================
	 */

	/*
	 * Main entrypoint
	 *
	 * @param $mode (type string) 'add', 'ban' or 'remove'
	 *        'add' => add article to the book
	 *        'ban' => ban article from the proposals
	 *        'remove' => remove article from the book
	 *        'addNum' => (type int) add the first $param articles to the collection
	 *        'addVal' => (type float) add all propossals to the collection with
	 *                    a value higher then $param
	 * @param $param (type string) name of the article to be added, banned or removed
	 *        or a number of articles to add or a value (1 - 1.5) all articles with a
	 *        higher value will be added to the collection
	 */
	public function run( $mode='', $param='' ) {
		global $wgOut;

		wfLoadExtensionMessages( 'CollectionCore' );
		wfLoadExtensionMessages( 'Collection' );

		if ( !CollectionSession::hasSession() ) {
			CollectionSession::startSession();
		}
		if ( !isset( $_SESSION['wsCollectionSuggestBan'] ) || $mode == 'resetbans' ) {
			$_SESSION['wsCollectionSuggestBan']  = array();
		}
		if ( !isset( $_SESSION['wsCollectionSuggestProp'] ) ) {
			$_SESSION['wsCollectionSuggestProp'] = array();
		}

		$template = self::getCollectionSuggestTemplate( $mode, $param );
		$wgOut->setPageTitle( wfMsg( 'coll-suggest_title' ) );
		$wgOut->addTemplate( $template );
	}

	/*
	 * Entrypoint for Ajax
	 *
	 * @param $mode (type string) 'add', 'ban' or 'remove'
	 *        'add' => add article to the book
	 *        'ban' => ban article from the proposals
	 *        'remove' => remove article from the book
	 *        'addNum' => (type int) add the first $param articles to the collection
	 *        'addVal' => (type float) add all propossals to the collection with
	 *                    a value higher then $param
	 * @param $param (type string) name of the article to be added, banned or removed
	 *        or a number of articles to add or a value (1 - 1.5) all articles with a
	 *        higher value will be added to the collection
	 * @return (type string) html-code for the proposallist and the memberlist
	 */
	public static function refresh( $mode, $param ) {
		global $wgLang;

		$template = self::getCollectionSuggestTemplate( $mode, $param );
		return array(
			'suggestions_html' => $template->getProposalList(),
			'members_html' => $template->getMemberList(),
			'num_pages' => wfMsgExt( 'coll-n_pages', 'parsemag', $wgLang->formatNum( CollectionSession::countArticles() ) ),
		);
	}

	public static function undo( $lastAction, $article ) {
		switch ( $lastAction ) {
		case 'add':
			$template = self::getCollectionSuggestTemplate( 'removeonly', $article );
			break;
		case 'ban':
			$template = self::getCollectionSuggestTemplate( 'unban', $article );
			break;
		case 'remove':
			$template = self::getCollectionSuggestTemplate( 'add', $article );
			break;
		}
		return array(
			'suggestions_html' => $template->getProposalList(),
			'members_html' => $template->getMemberList(),
		);
	}

	// remove the suggestion data from the session
	public static function clear() {
		if( isset( $_SESSION['wsCollectionSuggestBan'] ) ) {
		 	unset( $_SESSION['wsCollectionSuggestBan'] );
		}
		if( isset( $_SESSION['wsCollectionSuggestProp'] ) ) {
			unset( $_SESSION['wsCollectionSuggestProp'] );
		}
	}

	/*
	 * ===============================================================================
	 * private methods
	 * ===============================================================================
	 */

	private static function unban( $article ) {
		$bans = $_SESSION['wsCollectionSuggestBan'];
		$newbans = array();
		foreach ( $bans as $ban ) {
			if ( $ban != $article ) {
				$newbans[] = $ban;
			}
		}
		$_SESSION['wsCollectionSuggestBan'] = $newbans;
	}

	/*
	 * Update the session and return the template
	 *
	 * @param $mode (type string) 'add', 'ban' or 'remove'
	 *        'add' => add article to the book
	 *        'ban' => ban article from the proposals
	 *        'remove' => remove article from the book
	 *        'addNum' => (type int) add the first $param articles to the collection
	 *        'addVal' => (type float) add all propossals to the collection with
	 *                    a value higher then $param
	 * @param $param (type string) name of the article to be added, banned or removed
	 *        or a number of articles to add or a value (1 - 1.5) all articles with a
	 *        higher value will be added to the collection
	 * @return the template for the wikipage
	 */
	private static function getCollectionSuggestTemplate( $mode, $param ) {
		global $wgCollectionMaxSuggestions;

		switch($mode) {
			case 'add':
				SpecialCollection::addArticleFromName(NS_MAIN, $param);
				self::unban( $param );
				break;
			case 'ban':
				$_SESSION['wsCollectionSuggestBan'][] = $param;
				break;
			case 'remove':
				SpecialCollection::removeArticleFromName(NS_MAIN, $param);
				$_SESSION['wsCollectionSuggestBan'][] = $param;
				break;
			case 'removeonly': // remove w/out banning (for undo)
				SpecialCollection::removeArticleFromName(NS_MAIN, $param);
				break;
			case 'unban': // for undo
				self::unban( $param );
				break;
		}

		$template = new CollectionSuggestTemplate();
		$proposals = new Proposals(
			$_SESSION['wsCollection'],
			$_SESSION['wsCollectionSuggestBan'],
			$_SESSION['wsCollectionSuggestProp']
		);

		if ( $mode == 'addAll' ) {
			self::addArticlesFromName( $param, $proposals );
		}

		$template->set( 'collection', $_SESSION['wsCollection'] );
		$template->set( 'proposals', $proposals->getProposals( $wgCollectionMaxSuggestions ) );
		$template->set( 'hasbans', $proposals->hasBans() );
		$template->set( 'num_pages', CollectionSession::countArticles() );

		$_SESSION['wsCollectionSuggestProp'] = $proposals->getLinkList();

		return $template;
	}

	/*
	 * Add some articles and update the book of the Proposal-Object
	 *
	 * @param $articleList an array with the names of the articles to be added
	 * @param $prop the proposal-Object
	 */
	private static function addArticlesFromName( $articleList, $prop ) {
		foreach( $articleList as $article ) {
			SpecialCollection::addArticleFromName( NS_MAIN, $article );
		}
		$prop->setCollection( $_SESSION['wsCollection'] );
	}
}

/*
 * class: Proposals
 * 
 * it needs 3 Lists:
 * - one with the bookmembers
 * - one where it can save the banned articles
 * - one where it can save the proposals
 *
 * the proposallist can be accessed with the public method getProposals()
 *
 * a list with the bookarticles as first and information about the outgoing
 * links of that article as second dimension can be accessed with the method
 * getLinkList()
 *
 * 
 *
 * the Class can only sort the proposals, if it can access the function compareProps
 */
class Proposals {

	/*
	 * ==================================================
	 * class attributes
	 * ==================================================
	 *
	 * only mLinkList and mPropList can be accessed from 
	 * outside the class via getLinkList() and getPropsosals()
	 */
	private $mColl;
	private $mPropList;
	private $mLinkList;
	private $mBanList;
	
	/*
	 * ==================================================
	 * constructor
	 * ==================================================
	 * 
	 * @param $coll the collection	
	 * @param $ban the list of the banned articles
	 * @param $props the lilst of the proposals
	 */
	public function Proposals( $coll, $ban, $props ) {
		$this->mPropList = array();
		$this->mColl = $coll;
		$this->mBanList = $ban;
		$this->mLinkList = $props;
	}


	/*
	 * ==================================================
	 * public methods
	 * ==================================================
	 */

	public function getLinkList() {
		return $this->mLinkList;
	}

	public function setCollection( $collection ) {
		$this->mColl = $collection;
	}

	/*
	 * Calculate the new proposals and return it
	 *
	 * @param $num (type int) number of proposals to be returned
	 *        0 or less means, that all proposals will be returned
	 *        this parameter is optional, the method will return
	 *        all proposals by defaulted
	 * @param $doUpdate (type boolean) when true, $linkList will
	 *        updated before calculating the proposals
	 *        default is true
	 * @return a 2-dimensional array that contains the proposals
	 *         the first dimesion is numeric, the second contains
	 *         3 entries: 
	 *         - 'name': the name of a proposed article
	 *         - 'num' : how often this artikel was linked in the
	 *                   bookmembers
	 *         - 'val' : a value between 1 and 1.5, the higher the
	 *                   more this article is proposed
	 */
	public function getProposals( $num=0, $doUpdate=true ) {
		if ( $doUpdate ) {
			$this->updateLinkList();
		}
			
		$this->getPropList();

		if ($num > 0) {
			return array_slice( $this->mPropList, 0, $num );
		} else {
			return $this->mPropList;
		}
	}

	public function hasBans() {
		return count($this->mBanList) > 0;
	}

	/*
	 * ==================================================
	 * private methods
	 * ==================================================
	 */

	private function updateLinkList() {
		$this->addCollectionArticles();
		$this->deleteUnusedArticles();
	}

	// Check if all articles form the book are in $mLinkList
	private function addCollectionArticles() {
		global $wgCollectionSuggestThreshhold;

		$numItems = count( $this->mColl['items'] );

		if ( $numItems > $wgCollectionSuggestThreshhold ) {
			return;
		}

		foreach( $this->mColl['items'] as $item ) {
			if ( $this->searchEntry( $item['title'], $this->mLinkList ) === false 
				&& $item['type'] == 'article'
			) {
				$articleName = $item['title'];
				$title = Title::makeTitleSafe( NS_MAIN, $articleName );
				$article = new Article( $title, $item['revision'] );

				if ( is_null( $article ) ) {
					continue;
				}

				$this->mLinkList[] = array(
					'name' => $articleName,
					'links' => $this->getWeightedLinks( $numItems, $article->getContent() ),
				);
			}
		}
	}

	// Delete items from $mLinkList that are not in the collection any more
	private function deleteUnusedArticles() {
		$newList = array();
		foreach ( $this->mLinkList as $item ) {
			if ( CollectionSession::findArticle( $item['name'] ) != -1 ) {
				$newList[] = $item;
			}
		}
		$this->mLinkList = $newList;
	}

	private function resolveRedirects( $title ) {
		if ( !$title->isRedirect() ) {
			return $title;
		}

		$article = new Article( $title, 0 );
		if ( method_exists( $title, 'newFromRedirectRecurse' ) ) {
			return Title::newFromRedirectRecurse( $article->getContent() );
		} else {
			return Title::newFromRedirect( $article->getContent() );
		}
	}

	/*
	 * Extract & count links from wikitext
	 *
	 * @param wikitext: article text
	 * @return an array with links and their weights
	 */
	private function getWeightedLinks( $num_articles, $wikitext ) {
		global $wgCollectionSuggestCheapWeightThreshhold;

		$allLinks = array();
		preg_match_all(
			'/\[\[(.+?)\]\]/',
			$wikitext,
			$allLinks,
			PREG_SET_ORDER
		);

		$linkmap = array();
		foreach ( $allLinks as $link ) {
			$link = $link[1];

			if ( preg_match( '/[:#]/', $link ) ) { // skip links with ':' and '#'
				continue;
			}
				
			// handle links with a displaytitle
			$matches = array();
			if ( preg_match( '/(.+?)\|(.+)/', $link, $matches ) ) {
				$link = $matches[1];
				$alias = $matches[2];
			} else {
				$alias = $link;
			}

			// check & normalize title
			$title = Title::makeTitleSafe( NS_MAIN, $link );
			if ( is_null( $title ) || !$title->exists() ) {
				continue;
			}
			$link = $this->resolveRedirects( $title )->getText();

			if ( isset ($linkmap[$link] ) ) {
				$linkmap[$link][$link] = true;
			} else {
				$linkmap[$link] = array( $link => true );
			}
			if ( $link != $alias ) {
				if ( isset( $linkmap[$alias] ) ) {
					$linkmap[$alias][$link] = true;
				} else {
					$linkmap[$alias] = array( $link => true );
				}
			}
		}

		$linkcount = array();
		if ( $num_articles < $wgCollectionSuggestCheapWeightThreshhold ) {
			// more expensive algorithm: count words
			foreach ( $linkmap as $alias => $linked ) {
				$matches = array();
				preg_match_all(
					'/\W' . preg_quote( $alias, '/' ) . '\W/i',
					$wikitext,
					$matches
				);
				$num = count( $matches[0] );

				foreach ( $linked as $link => $dummy ) {
					if ( isset( $linkcount[$link] ) ) {
						$linkcount[$link] += $num;
					} else {
						$linkcount[$link] = $num;
					}
				}
			}
			
			if ( count( $linkcount ) == 0 ) {
				return array();
			}

			// normalize:
			$lc_max = 0;
			foreach ( $linkcount as $link => $count ) {
				if ( $count > $lc_max) {
					$lc_max = $count;
				}
			}
			$norm = log( $lc_max );
			$result = array();
			if ( $norm > 0 ) {
				foreach ( $linkcount as $link => $count ) {
					$result[$link] = 1 + 0.5*log($count)/$norm;
				}
			} else {
				foreach ( $linkcount as $link => $count ) {
					$result[$link] = 1;
				}
			}

			return $result;
		} else {
			// cheaper algorithm: just count links
			foreach ( $linkmap as $alias => $linked ) {
				foreach ( $linked as $link => $dummy) {
					$linkcount[$link] = 1;
				}
			}

			return $linkcount;
		}
	}

	// Calculate the $mPropList from $mLinkList and $mBanList
	private function getPropList() {
		$prop = array();
		foreach ( $this->mLinkList as $article ) {
			foreach ( $article['links'] as $linkName => $val) {
				if ( !$this->checkLink( $linkName ) ) {  
					continue;
				}
				$key = $this->searchEntry( $linkName, $prop );
				if ( $key !== false ) {
					$prop[$key]['val'] += $val;
				} else {
					$prop[] = array(
						'name' => $linkName,
						'val' => $val,
					);
				}
			}
		}
		usort( $prop, "wgCollectionCompareProps" );
		$this->mPropList = array();
		$have_real_weights = false;
		foreach ( $prop as $p ) {
			if ( $p['val'] > 1 ) {
				$have_real_weights = true;
			}
			if ( $p['val'] <= 1 && $have_real_weights ) {
				break;
			}
			$this->mPropList[] = $p;
		}
	}

	/*
	 * Search an article in an array and returns its key or false
	 * if the array doesn't contain the article
	 *
	 * @param $entry (type string) an articlename
	 * @param $array the array to be searched, it has to 2-dimensional
	 *               the 2nd dimension needs the key 'name'
	 * @return the key as integer or false
	 */
	private function searchEntry( $entry, $array ) {
		for ( $i = 0; $i < count( $array ); $i++ ) {
			if ( $array[$i]['name'] == $entry ) {
				return $i;
			}
		}
		return false;
	}

	/*
	 * Check if an article is banned or belongs to the book/collection
	 *
	 * @param $link (type string) an articlename
	 * @return (type boolean) true: if the article can be added to the proposals
	 *                        false: if the article can't be added to the proposals
	 */
	private function checkLink( $link ) {
		foreach ( $this->mColl['items'] as $item ) {
			if ( $item['type'] == 'article' && $item['title'] == $link ) {
				return false;
			}
		}

		if ( in_array( $link, $this->mBanList ) ) {
			return false;
		}

		return true;
	}

	private function getPropCount() {
		return count( $this->mPropList );
	}
}

/*
 * sort $mPropList by the entries values
 * sort alphabetically by equal values
 * 
 * @param $a, $b: arrays that contain two entries
 *                the keys: 'name' & 'val'
 *                'name': an articlename
 *                'val' : a value from 1 to 1.5
 * @return 1, -1 or 0
 */
function wgCollectionCompareProps( $a, $b ) {
	if ( $a['val'] == $b['val'] ) {
		return strcmp( $a['name'], $b['name'] );
	}
	if ( $a['val'] < $b['val'] ) {
		return 1;
	} else {
		return -1;
	}
}
