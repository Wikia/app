<?php
/**
 * ***** BEGIN LICENSE BLOCK *****
 * This file is part of CategoryBrowser.
 *
 * CategoryBrowser is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * CategoryBrowser is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with CategoryBrowser; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * ***** END LICENSE BLOCK *****
 *
 * CategoryBrowser is an AJAX-enabled category filter and browser for MediaWiki.
 *
 * To activate this extension :
 * * Create a new directory named CategoryBrowser into the directory "extensions" of MediaWiki.
 * * Place the files from the extension archive there.
 * * Add this line at the end of your LocalSettings.php file :
 * require_once "$IP/extensions/CategoryBrowser/CategoryBrowser.php";
 *
 * @version 0.3.1
 * @link http://www.mediawiki.org/wiki/Extension:CategoryBrowser
 * @author Dmitriy Sintsov <questpc@rambler.ru>
 * @addtogroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is a part of MediaWiki extension.\n" );
}

abstract class CB_AbstractPagesView {

	// instance of pager (model), used to generate the view
	var $pager;

	function __construct( CB_AbstractPager $pager ) {
		$this->pager = $pager;
	}

	function initNavTpl() {
		# {{{ navigation link (prev,next) template
		$this->nav_link = '';
		if ( !isset( $this->nav_link_tpl ) ) {
			$this->nav_link_tpl =
				array( '__tag' => 'div', 'class' => 'cb_cat_container', '__end' => "\n", 0 => &$this->nav_link );
		}
		# }}}
	}

	function initAjaxLinkTpl() {
		# {{{ ajax link template
		$this->ajax_onclick = '';
		$this->ajax_link_text = '';
		$this->ajax_title_attr = '';
		if ( !isset( $this->ajax_link_tpl ) ) {
			$this->ajax_link_tpl =
				array( '__tag' => 'a', 'class' => 'cb_sublink', 'href' => '', 'onclick' => &$this->ajax_onclick, 'title' => &$this->ajax_title_attr, 0 => &$this->ajax_link_text );
		}
		# }}}
	}

	function initPagerStatsTpl() {
		$this->pager_stats = '';
		# {{{ pager current statistics template
		if ( !isset( $this->pager_stats_tpl ) ) {
			$this->pager_stats_tpl =
				array( '__tag' => 'span', 'class' => 'cb_comment', 0 => &$this->pager_stats );
		}
		# }}}
	}

	function initSortkeyTpl() {
		# {{{ category sortkey hint template
		$this->sortkey_hint = '';
		if ( !isset( $this->sortkey_hint_tpl ) ) {
			$this->sortkey_hint_tpl = array( '__tag' => 'span', 'class' => 'cb_comment', 'style' => 'padding:0em 0.1em 0em 0.1em;', 0 => &$this->sortkey_hint );
		}
		# }}}
	}

	/**
	 * previous page AJAX link
	 * @param $list, when the link is available it will be rendered then pushed to the list
	 *     we cannot just return rendered link, because it depends not just on pager offset,
	 *     but also on whether an instance of pager "suggests" using placeholders (shown instead of empty links) or not
	 */
	function addPrevPageLink( array &$list ) {
		$this->initAjaxLinkTpl();
		$this->initPagerStatsTpl();
		$this->initNavTpl();
		$prev_link = '&#160;'; // &nbsp;
		$link_obj = $this->pager->getPrevAjaxLink();
		if ( $this->pager->offset != 0 ) {
			$this->ajax_onclick = $link_obj->call;
			$this->ajax_link_text = wfMsg( 'cb_previous_items_link' );
			$prev_offset = $this->pager->getPrevOffset() + 1;
			$this->pager_stats = wfMsg( 'cb_previous_items_stats', $prev_offset, $prev_offset + $this->pager->limit - 1 );
			$this->nav_link = wfMsg( 'cb_previous_items_line', CB_XML::toText( $this->ajax_link_tpl ), CB_XML::toText( $this->pager_stats_tpl ) );
			$prev_link = CB_XML::toText( $this->nav_link_tpl );
		}
		if ( $link_obj->placeholders || $this->nav_link != '' ) {
			$list[] = $prev_link;
		}
	}

	/**
	 * next page AJAX link
	 * @param $list, when the link is available it will be rendered then pushed to the list
	 *     we cannot just return rendered link, because it depends not just on pager offset,
	 *     but also on whether an instance of pager "suggests" using placeholders (shown instead of empty links) or not
	 */
	function addNextPageLink( array &$list ) {
		$this->initAjaxLinkTpl();
		$this->initPagerStatsTpl();
		$this->initNavTpl();
		$next_link = '&#160;'; // &nbsp;
		$link_obj = $this->pager->getNextAjaxLink();
		if ( $this->pager->hasMoreEntries ) {
			$this->ajax_onclick = $link_obj->call;
			$this->ajax_link_text = wfMsg( 'cb_next_items_link' );
			$this->pager_stats = wfMsg( 'cb_next_items_stats', $this->pager->getNextOffset() + 1 );
			$this->nav_link = wfMsg( 'cb_next_items_line', CB_XML::toText( $this->ajax_link_tpl ), CB_XML::toText( $this->pager_stats_tpl ) );
			$next_link = CB_XML::toText( $this->nav_link_tpl );
		}
		if ( $link_obj->placeholders || $this->nav_link != '' ) {
			$list[] = $next_link;
		}
	}

	/**
	 * show the sortkey, when it does not match title name
	 * note that cl_sortkey is empty for CB_RootCond pager
	 * @return sortkey html hint, when the sortkey differs from title name, empty string otherwise
	 */
	function addSortkey( Title $title_obj, stdClass $pager_row ) {
		$this->initSortkeyTpl();
		$result = '';
		if ( !empty( $pager_row->cl_sortkey ) &&
				$title_obj->getText() != $pager_row->cl_sortkey ) {
			// TODO: Get better context
			$cv = new CategoryViewer( $title_obj, RequestContext::getMain() );
			$this->sortkey_hint = '(' . $cv->getSubcategorySortChar( $title_obj, $pager_row->cl_sortkey ) . ')';
			$result = CB_XML::toText( $this->sortkey_hint_tpl );
		}
		return $result;
	}
} /* end of CB_AbstractPagesView class */

class CB_CategoriesView extends CB_AbstractPagesView {

	function generateList() {
		if ( $this->pager->offset == -1 ) {
			return ''; // list has no entries
		}
		# {{{ one category container template
		$subcat_count_hint = '';
		$cat_expand_sign = '';
		$cat_link = '';
		$cat_tpl =
			array( '__tag' => 'div', 'class' => 'cb_cat_container', '__end' => "\n",
				array( '__tag' => 'div', 'class' => 'cb_cat_controls',
					array( '__tag' => 'span', 'title' => &$subcat_count_hint, 'class' => 'cb_cat_expand', 0 => &$cat_expand_sign ),
					array( '__tag' => 'span', 'class' => 'cb_cat_item', 0 => &$cat_link )
				)
			);
		# }}}
		# create list of categories
		$catlist = array();
		if ( $this->pager instanceof CB_RootPager ) {
			$catlist[] = array( '__tag' => 'noscript', 'class' => 'cb_noscript', 0 => wfMsg( 'cb_requires_javascript' ) );
		}
		$this->addPrevPageLink( $catlist );
		# generate entries list
		foreach ( $this->pager->entries as &$cat ) {
			// cat_title might be NULL sometimes - probably due to DB corruption?
			if ( ( $cat_title_str = $cat->cat_title ) == NULL ) {
				// weird, but occasionally may happen;
				if ( empty( $cat->cl_sortkey ) ) {
					continue;
				}
				$cat_title_str = $cat->cl_sortkey;
				$cat_title_obj = Title::newFromText( $cat_title_str, NS_CATEGORY );
			} else {
				$cat_title_obj = Title::makeTitle( NS_CATEGORY, $cat_title_str );
			}
			$js_cat_string = "'" . Xml::escapeJsString( $cat_title_str ) . "'";

			# generate tree "expand" sign
			$this->initAjaxLinkTpl();
			if ( $cat->cat_subcats === NULL ) {
				$cat_expand_sign = 'x';
				$subcat_count_hint = '';
			} elseif ( $cat->cat_subcats > 0 ) {
				$this->ajax_onclick = 'return CategoryBrowser.subCatsPlus(this,' . $js_cat_string . ')';
				$this->ajax_link_text = '+';
				$cat_expand_sign = CB_XML::toText( $this->ajax_link_tpl );
				$subcat_count_hint = wfMsgExt( 'cb_has_subcategories', array( 'parsemag' ), $cat->cat_subcats );
			} else {
				$cat_expand_sign = '&#160;'; // &nbsp;
				$subcat_count_hint = '';
			}

			# create AJAX links for viewing categories, pages, files, belonging to this category
			$ajax_links = '';
			$this->initAjaxLinkTpl();

			$this->ajax_onclick = 'return CategoryBrowser.subCatsLink(this,' . $js_cat_string . ')';
			$this->ajax_link_text = wfMsgExt( 'cb_has_subcategories', array( 'parsemag' ), $cat->cat_subcats );
			$cat_subcats = ( ( $cat->cat_subcats > 0 ) ? ' | ' . CB_XML::toText( $this->ajax_link_tpl ) : '' );

			$this->ajax_onclick = 'return CategoryBrowser.pagesLink(this,' . $js_cat_string . ')';
			$this->ajax_link_text = wfMsgExt( 'cb_has_pages', array( 'parsemag' ), $cat->cat_pages_only );
			$cat_pages = ( ( $cat->cat_pages_only > 0 ) ? ' | ' . CB_XML::toText( $this->ajax_link_tpl ) : '' );

			$this->ajax_onclick = 'return CategoryBrowser.filesLink(this,' . $js_cat_string . ')';
			$this->ajax_link_text = wfMsgExt( 'cb_has_files', array( 'parsemag' ), $cat->cat_files );
			$cat_files = ( ( $cat->cat_files > 0 ) ? ' | ' . CB_XML::toText( $this->ajax_link_tpl ) : '' );

			if ( CB_Setup::$allowNestedParents ) {
				$this->ajax_onclick = 'return CategoryBrowser.parentCatsLink(this,' . $js_cat_string . ')';
				$this->ajax_link_text = '↑';
				$this->ajax_title_attr = wfMsg( 'cb_has_parentcategories' );
				$cat_parentcats = ' | ' . CB_XML::toText( $this->ajax_link_tpl );
			} else {
				$cat_parentcats = '';
			}

			$ajax_links .= $cat_subcats . $cat_pages . $cat_files . $cat_parentcats;

			$cat_link = CB_Setup::$skin->link( $cat_title_obj, $cat_title_obj->getText() );
			# show sortkey, when it does not match title name
			$cat_link .= $this->addSortkey( $cat_title_obj, $cat );
			$cat_link .= $ajax_links;
			# finally add generated $cat_tpl/$cat_link to $catlist
			$catlist[] = CB_XML::toText( $cat_tpl );
		}
		$this->addNextPageLink( $catlist );
		return $catlist;
	}

} /* end of CB_CategoriesView class */

class CB_PagesView extends CB_AbstractPagesView {

	function __construct( CB_SubPager $pager ) {
		parent::__construct( $pager );
	}

	function generateList() {
		if ( $this->pager->offset == -1 ) {
			return ''; // list has no entries
		}
		# {{{ one page container template
		$page_link = '';
		$page_tpl =
			array( '__tag' => 'div', 'class' => 'cb_cat_container', '__end' => "\n",
				array( '__tag' => 'span', 'class' => 'cb_cat_expand', 0 => '' ), // empty cb_cat_expand makes line height matching to CB_CategoriesView
				array( '__tag' => 'span', 'class' => 'cb_cat_item', 0 => &$page_link )
			);
		# }}}
		# create list of pages
		$pagelist = array();
		$this->addPrevPageLink( $pagelist );
		foreach ( $this->pager->entries as &$page ) {
			$page_title = Title::makeTitle( $page->page_namespace, $page->page_title );
			$page_link = CB_Setup::$skin->link( $page_title, $page_title->getPrefixedText() );
			# show sortkey, when it does not match title name
			$page_link .= $this->addSortkey( $page_title, $page );
			$pagelist[] = CB_XML::toText( $page_tpl );
		}
		$this->addNextPageLink( $pagelist );
		return $pagelist;
	}

} /* end of CB_PagesView class */

class CB_FilesView extends CB_PagesView {

	function generateList() {
		if ( $this->pager->offset == -1 ) {
			return ''; // list has no entries
		}
		# {{{ gallery container template
		$gallery_html = '';
		$gallery_tpl = array( '__tag' => 'div', 'class' => 'cb_files_container', 0 => &$gallery_html );
		# }}}
		# create list of files (holder of prev/next AJAX links and generated image gallery)
		$filelist = array();
		# create image gallery
		$gallery = new ImageGallery();
		$gallery->setHideBadImages();
		$gallery->setPerRow( CB_Setup::$imageGalleryPerRow );
		$this->addPrevPageLink( $filelist );
		foreach ( $this->pager->entries as &$file ) {
			$file_title = Title::makeTitle( $file->page_namespace, $file->page_title );
			# show the sortkey, when it does not match title name
			$gallery->add( $file_title, $this->addSortKey( $file_title, $file ) );
		}
		if ( !$gallery->isEmpty() ) {
			$gallery_html = $gallery->toHTML();
			$filelist[] = CB_XML::toText( $gallery_tpl );
		}
		$this->addNextPageLink( $filelist );
		return $filelist;
	}

} /* end of CB_FilesView class */
