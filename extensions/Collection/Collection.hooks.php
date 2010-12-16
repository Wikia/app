<?php

/*
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
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

class CollectionHooks {
	/**
	 * Callback for hook SkinBuildSidebar (MediaWiki >= 1.14)
	 */
	static function buildSidebar( $skin, &$bar ) {
		global $wgUser;
		global $wgCollectionPortletForLoggedInUsersOnly;

		if( !$wgCollectionPortletForLoggedInUsersOnly || $wgUser->isLoggedIn() ) {
			$html = self::getPortlet();
			if( $html ) {
				$bar[ 'coll-print_export' ] = $html;
			}
		}
		return true;
	}

	function buildNavUrls( $skin, &$navUrls ) {
		global $wgUser;
		global $wgCollectionPortletForLoggedInUsersOnly;
		
		if( !$wgCollectionPortletForLoggedInUsersOnly || $wgUser->isLoggedIn() ) {
			if( isset( $navUrls['print'] ) ) {
				// We move this guy out to our own box
				unset( $navUrls['print'] );
			}
		}
		return true;
	}
	
	/**
	 * This function is the fallback solution for MediaWiki < 1.14
	 * (where the hook SkinBuildSidebar does not exist)
	 */
	static function printPortlet() {
		wfLoadExtensionMessages( 'CollectionCore' );

		$html = self::getPortlet();

		if( $html ) {
			$portletTitle = wfMsg( 'coll-print_export' );
			print "<div id=\"p-coll-print_export\" class=\"portlet\">
	<h5>$portletTitle</h5>
		<div class=\"pBody\">\n$html\n</div></div>";
		}
	}

	/**
	 * Return HTML-code to be inserted as portlet
	 */
	static function getPortlet() {
		global $wgArticle;
		global $wgRequest;
		global $wgTitle;
		global $wgUser;
		global $wgCollectionArticleNamespaces;
		global $wgCollectionFormats;
		global $wgCollectionPortletFormats;
		global $wgScriptPath;

		if ( is_null( $wgTitle ) || !$wgTitle->exists() ) {
			return;
		}
		
		$namespace = $wgTitle->getNamespace();

		if ( !in_array( $namespace, $wgCollectionArticleNamespaces )
			&& $namespace != NS_CATEGORY ) {
			return false;
		}

		$action = $wgRequest->getVal('action');
		if( $action != '' && $action != 'view' && $action != 'purge' ) {
			return false;
		}

		wfLoadExtensionMessages( 'CollectionCore' );

		$sk = $wgUser->getSkin();

		$out = Xml::element( 'ul', array( 'id' => 'collectionPortletList' ), null );

		if ( !CollectionSession::isEnabled() ) {
			$out .= Xml::tags( 'li',
				array( 'id' => 'coll-create_a_book' ),
				$sk->link(
					SpecialPage::getTitleFor( 'Book' ),
					wfMsgHtml( 'coll-create_a_book' ),
					array(
						'rel' => 'nofollow',
						'title' => wfMsg( 'coll-create_a_book_tooltip' )
					),
					array( 'bookcmd' => 'book_creator', 'referer' => $wgTitle->getPrefixedText() ),
					array( 'known', 'noclasses' )
				)
			);
		} else {
			$out .= Xml::tags( 'li',
				array( 'id' => 'coll-book_creator_disable' ),
				$sk->link(
					SpecialPage::getTitleFor( 'Book' ),
					wfMsgHtml( 'coll-book_creator_disable' ),
					array(
						'rel' => 'nofollow',
						'title' => wfMsg( 'coll-book_creator_disable_tooltip' )
					),
					array( 'bookcmd' => 'stop_book_creator', 'referer' => $wgTitle->getPrefixedText() ),
					array( 'known', 'noclasses' )
				)
			);
		}

		$params = array( 
			'bookcmd' => 'render_article',
			'arttitle' => $wgTitle->getPrefixedText(),
		);

		if( $wgArticle ) {
			$oldid = $wgArticle->getOldID();
			if ( $oldid ) {
				$params['oldid'] = $oldid;
			} else {
				$params['oldid'] = $wgArticle->getLatest();
			}
		}

		foreach ( $wgCollectionPortletFormats as $writer ) {
			$params['writer'] = $writer;
			$out .= Xml::tags( 'li',
				array( 'id' => 'coll-download-as-' . $writer ),
				$sk->link(
					SpecialPage::getTitleFor( 'Book' ),
					wfMsgHtml( 'coll-download_as', htmlspecialchars( $wgCollectionFormats[$writer] ) ),
					array(
						'rel' => 'nofollow',
						'title' => wfMsg( 'coll-download_as_tooltip', $wgCollectionFormats[$writer] )
					),
					$params,
					array( 'known', 'noclasses' )
				)
			);
		}

		// Move the 'printable' link into our section for consistency
		$action = $wgRequest->getVal( 'action', 'view' );
		if( $action == 'view' || $action == 'purge' ) {
			global $wgOut;
			if ( !$wgOut->isPrintable() ) {
				$attribs = array(
					'href' => $wgRequest->appendQuery( 'printable=yes' ),
					'title' => $sk->titleAttrib( 't-print', 'withaccess' ),
					'accesskey' => $sk->accesskey( 't-print' ),
				);
				if ( $attribs['title'] === false ) {
					unset( $attribs['title'] );
				}
				if ( $attribs['accesskey'] === false ) {
					unset( $attribs['accesskey'] );
				}
				$out .= Xml::tags( 'li',
					array( 'id' => 't-print' ),
					Xml::element( 'a', $attribs, wfMsg( 'printableversion' ) ) );
			}
		}
		
		$out .= Xml::closeElement( 'ul' );

		return $out;
	}

	/**
	 * Callback for hook SiteNoticeAfter
	 */
	static function siteNoticeAfter( &$siteNotice ) {
		global $wgCollectionArticleNamespaces;
		global $wgRequest;
		global $wgTitle;

		$action = $wgRequest->getVal('action');
		if( $action != '' && $action != 'view' && $action != 'purge' ) {
			return true;
		}

		if ( !CollectionSession::hasSession()
			|| !$_SESSION['wsCollection']['enabled'] ) {
			return true;
		}

		$myTitle = SpecialPage::getTitleFor( 'Book' );
		if ( $myTitle->equals( $wgTitle ) ) {
			$cmd = $wgRequest->getVal('bookcmd', '');
			if ( $cmd == 'suggest' ) {
				$siteNotice .= self::renderBookCreatorBox( 'suggest' );
			} else if ( $cmd == '' ) {
				$siteNotice .= self::renderBookCreatorBox( 'showbook' );
			}
			return true;
		}

		if ( is_null( $wgTitle ) || !$wgTitle->exists() ) {
			return true;
		}

		$namespace = $wgTitle->getNamespace();
		if ( !in_array( $namespace, $wgCollectionArticleNamespaces )
			&& $namespace != NS_CATEGORY ) {
			return true;
		}

		$siteNotice .= self::renderBookCreatorBox();
		return true;
	}

	static function renderBookCreatorBox( $mode='' ) {
		global $wgArticle;
		global $wgCollectionArticleNamespaces;
		global $wgCollectionStyleVersion;
		global $wgCollectionVersion;
		global $wgJsMimeType;
		global $wgOut;
		global $wgScriptPath;
		global $wgTitle;
		global $wgUser;

		$namespace = $wgTitle->getNamespace();

		wfLoadExtensionMessages( 'CollectionCore' );

		$sk = $wgUser->getSkin();
		$jsPath = "$wgScriptPath/extensions/Collection/js";
		$imagePath = "$wgScriptPath/extensions/Collection/images";
		$ptext = $wgTitle->getPrefixedText();
		$oldid = 0;
		if ( !is_null( $wgArticle ) ) {
			$oldid = $wgArticle->getOldID();
			if ( !$oldid  || $oldid == $wgArticle->getLatest() ) {
				$oldid = 0;
			} 
		}

		$html = '';

		if ( method_exists( $wgOut, 'includeJQuery' ) ) {
			$wgOut->includeJQuery();
		} else {
			$html .= Xml::element( 'script',
				array(
					'type' => $wgJsMimeType,
					'src' => "$jsPath/jquery.js?$wgCollectionStyleVersion",
				),
				'', false
			);
		}

		$html .= Xml::element( 'script', 
			array(
				'type' => $wgJsMimeType,
				'src' => "$jsPath/bookcreator.js?$wgCollectionStyleVersion",
			),
			'', false
		);
		$html .= Xml::element( 'style',
			array( 'type' => 'text/css' ),
			<<<EOS
#collectionpopup {
	position: absolute;
	padding: 4px;
	border: 1px solid #000;
	background-color: #fea;
	z-index: 9999;
	display: inline;
	font-size: 10pt;
}
EOS
			, false
		);
		
		$addRemoveState = $mode;

		$html .= Xml::element( 'div',
			array( 'style' => wfMsg( 'coll-book_creator_box_style' ) ),
			null
		);

		$html .= Xml::element( 'img',
			array(
				'src' => "$imagePath/Open_book.png?$wgCollectionStyleVersion",
				'alt' => '',
				'width' => '80',
				'height' => '45',
				'style' => 'float: left;',
			),
			'',
			true
		);

		$html .= Xml::tags( 'div',
			array( 'style' => 'margin-left: 90px;' ),
			Xml::tags( 'div',
				array( 'style' => 'float: right' ),
				$sk->link(
					Title::newFromText( wfMsg( 'coll-helppage' ) ),
					Xml::element('img',
						array(
							'src' => "$imagePath/silk-help.png",
							'alt' => '',
							'width' => '16',
							'height' => '16',
							'style' => 'vertical-align: text-bottom;',
						)
					)
					. '&nbsp;' . wfMsgHtml( 'coll-help' ),
					array( 
						'rel' => 'nofollow',
						'title' => wfMsg( 'coll-help_tooltip' ),
					),
					array(),
					array( 'known', 'noclasses' )
				)
			)
			. Xml::tags( 'strong',
				array( 'style' => 'font-size: 1.2em' ),
				wfMsgHtml( 'coll-book_creator' )
			)
			. ' ('
			. $sk->link(
				SpecialPage::getTitleFor( 'Book' ),
				wfMsgHtml( 'coll-disable' ),
				array(
					'rel' => 'nofollow',
					'title' => wfMsg( 'coll-book_creator_disable_tooltip' ),
				),
				array( 'bookcmd' => 'stop_book_creator', 'referer' => $ptext ),
				array( 'known', 'noclasses' )
			)
			. ')'
		);

		$html .= Xml::tags( 'div',
			array(
				'id' => 'coll-book_creator_box',
				'style' => 'margin-left: 90px; margin-bottom: 0;',
			),
			self::getBookCreatorBoxContent( $addRemoveState, $oldid )
	 	);

		$html .= Xml::closeElement( 'div' );
		return $html;
	}

	static function getBookCreatorBoxContent( $ajaxHint=null, $oldid=null ) {
		global $wgUser;
		global $wgScriptPath;

		wfLoadExtensionMessages( 'CollectionCore' );

		$sk = $wgUser->getSkin();
		$imagePath = "$wgScriptPath/extensions/Collection/images";

		return self::getBookCreatorBoxAddRemoveLink( $sk, $imagePath, $ajaxHint, $oldid )
			. self::getBookCreatorBoxShowBookLink( $sk, $imagePath, $ajaxHint )
			. self::getBookCreatorBoxSuggestLink( $sk, $imagePath, $ajaxHint );
	}

	static function getBookCreatorBoxAddRemoveLink( $sk, $imagePath, $ajaxHint, $oldid ) {
		global $wgArticle;
		global $wgJsMimeType;
		global $wgTitle;
		global $wgScriptPath;

		$namespace = $wgTitle->getNamespace();
		$ptext = $wgTitle->getPrefixedText();

		if ( is_null( $oldid ) && !is_null( $wgArticle ) ) {
			$oldid = $wgArticle->getOldID();
			if ( !$oldid  || $oldid == $wgArticle->getLatest() ) {
				$oldid = 0;
			} 
		}

		if ( $ajaxHint == 'suggest' || $ajaxHint == 'showbook' ) {
			return Xml::tags( 'span',
				array( 'style' => 'color: #777;' ),
				Xml::element( 'img',
					array(
						'src' => "$imagePath/disabled.png",
						'alt' => '',
						'width' => '16',
						'height'=> '16',
						'style' => 'vertical-align: text-bottom',
					)
				)
				. '&nbsp;' . wfMsgHtml( 'coll-not_addable' )
			);
		}

		if ( $ajaxHint == 'addcategory' || $namespace == NS_CATEGORY ) {
			$id = 'coll-add_category';
			$icon = 'silk-add.png';
			$captionMsg = 'coll-add_category';
			$tooltipMsg = 'coll-add_category_tooltip';
			$query = array( 'bookcmd' => 'add_category', 'cattitle' => $wgTitle->getText() );
			$onclick = "collectionCall('AddCategory', ['addcategory', wgTitle]); return false;";
		} else {
			if ( $ajaxHint == 'addarticle'
				|| ($ajaxHint == '' && CollectionSession::findArticle( $ptext, $oldid ) == -1) ) {
				$id = 'coll-add_article';
				$icon = 'silk-add.png';
				$captionMsg = 'coll-add_this_page';
				$tooltipMsg = 'coll-add_page_tooltip';
				$query = array( 'bookcmd' => 'add_article', 'arttitle' => $ptext, 'oldid' => $oldid );
				$onclick = "collectionCall('AddArticle', ['removearticle', wgNamespaceNumber, wgTitle, " .
					Xml::encodeJsVar( $oldid ) . "]); return false;";
			} else {
				$id = 'coll-remove_article';
				$icon = 'silk-remove.png';
				$captionMsg = 'coll-remove_this_page';
				$tooltipMsg = 'coll-remove_page_tooltip';
				$query = array( 'bookcmd' => 'remove_article', 'arttitle' => $ptext, 'oldid' => $oldid );
				$onclick = "collectionCall('RemoveArticle', ['addarticle', wgNamespaceNumber, wgTitle, " .
					Xml::encodeJsVar( $oldid ) . "]); return false;";
			}
		}

		return $sk->link(
			SpecialPage::getTitleFor( 'Book' ),
			Xml::element('img',
				array(
					'src' => "$imagePath/$icon",
					'alt' => '',
					'width' => '16',
					'height' => '16',
					'style' => 'vertical-align: text-bottom',
				)
			)
			. '&nbsp;' . wfMsgHtml( $captionMsg ),
			array(
				'id' => $id,
				'rel' => 'nofollow',
				'title' => wfMsg( $tooltipMsg ),
				'onclick' => $onclick,
			),
			$query,
			array( 'known', 'noclasses' )
		);

	}

	static function getBookCreatorBoxShowBookLink( $sk, $imagePath, $ajaxHint ) {
		$numArticles = CollectionSession::countArticles();
		if ( $ajaxHint == 'showbook' ) {
			return Xml::tags( 'strong',
				array(
					'style' => 'margin-left: 10px;',
				),
				Xml::element('img',
					array(
						'src' => "$imagePath/silk-book_open.png",
						'alt' => '',
						'width' => '16',
						'height' => '16',
						'style' => 'vertical-align: text-bottom',
					)
				)
				. '&nbsp;' . wfMsgHtml( 'coll-show_collection' )
				. ' (' . wfMsgExt( 'coll-n_pages', array( 'parsemag', 'escape' ), $numArticles ) . ')'
			);
		} else {
			return $sk->link(
				SpecialPage::getTitleFor( 'Book' ),
				Xml::element('img',
					array(
						'src' => "$imagePath/silk-book_open.png",
						'alt' => '',
						'width' => '16',
						'height' => '16',
						'style' => 'vertical-align: text-bottom',
					)
				)
				. '&nbsp;' . wfMsgHtml( 'coll-show_collection' )
					. ' (' . wfMsgExt( 'coll-n_pages', array( 'parsemag', 'escape' ), $numArticles ) . ')',
				array(
					'rel' => 'nofollow',
					'title' => wfMsg( 'coll-show_collection_tooltip' ),
					'style' => 'margin-left: 10px',
				),
				array(),
				array( 'known', 'noclasses' )
			);
		}
	}

	static function getBookCreatorBoxSuggestLink( $sk, $imagePath, $ajaxHint ) {
		if ( wfMsg( 'coll-suggest_enabled' ) != '1' ) {
			return '';
		}

		if ( $ajaxHint == 'suggest' ) {
			return Xml::tags( 'strong',
				array(
					'style' => 'margin-left: 10px;',
				),
				Xml::element('img',
					array(
						'src' => "$imagePath/silk-wand.png",
						'alt' => '',
						'width' => '16',
						'height' => '16',
						'style' => 'vertical-align: text-bottom',
					)
				)
				. '&nbsp;' . wfMsgHtml( 'coll-make_suggestions' )
			);
		} else {
			return $sk->link(
				SpecialPage::getTitleFor( 'Book' ),
				Xml::element('img',
					array(
						'src' => "$imagePath/silk-wand.png",
						'alt' => '',
						'width' => '16',
						'height' => '16',
						'style' => 'vertical-align: text-bottom',
					)
				)
				. '&nbsp;' . wfMsgHtml( 'coll-make_suggestions' ),
				array(
					'rel' => 'nofollow',
					'title' => wfMsg( 'coll-make_suggestions_tooltip' ),
					'style' => 'margin-left: 10px',
				),
				array( 'bookcmd' => 'suggest', ),
				array( 'known', 'noclasses' )
			);
		}
	}

	/**
	* OutputPageCheckLastModified hook
	*/
	static function checkLastModified( $modifiedTimes ) {
		if ( CollectionSession::hasSession() ) {
			$modifiedTimes['collection'] = $_SESSION['wsCollection']['timestamp'];
		}
		return true;
	}
}

