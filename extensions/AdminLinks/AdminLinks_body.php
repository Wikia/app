<?php
/**
 * Classes for the Admin Links extension
 *
 * @author Yaron Koren
 */

class AdminLinks extends SpecialPage {

	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct( 'AdminLinks' );
	}

	function createInitialTree() {
		$tree = new ALTree();

		// 'general' section
		$general_section = new ALSection( wfMsg( 'adminlinks_general' ) );
		$main_row = new ALRow( 'main' );
		$main_row->addItem( ALItem::newFromSpecialPage( 'Statistics' ) );
		$main_row->addItem( ALItem::newFromSpecialPage( 'Version' ) );
		$main_row->addItem( ALItem::newFromSpecialPage( 'Specialpages' ) );
		$main_row->addItem( ALItem::newFromSpecialPage( 'Log' ) );
		$main_row->addItem( ALItem::newFromSpecialPage( 'Allmessages' ) );
		$main_row->addItem( ALItem::newFromEditLink( 'Sidebar', wfMsg( 'adminlinks_editsidebar' ) ) );
		$main_row->addItem( ALItem::newFromEditLink( 'Common.css', wfMsg( 'adminlinks_editcss' ) ) );
		$main_row->addItem( ALItem::newFromEditLink( 'Mainpage', wfMsg( 'adminlinks_editmainpagename' ) ) );
		$general_section->addRow( $main_row );
		$tree->addSection( $general_section );

		// 'users' section
		$users_section = new ALSection( wfMsg( 'adminlinks_users' ) );
		$main_row = new ALRow( 'main' );
		$main_row->addItem( ALItem::newFromSpecialPage( 'Listusers' ) );
		$ul = SpecialPage::getTitleFor( 'Userlogin' );
		$al = SpecialPage::getTitleFor( 'AdminLinks' );
		$main_row->addItem( AlItem::newFromPage( $ul, wfMsg( 'adminlinks_createuser' ),
			array( 'type' => 'signup', 'returnto' => $al->getPrefixedText() ) ) );
		$main_row->addItem( ALItem::newFromSpecialPage( 'Userrights' ) );
		$users_section->addRow( $main_row );
		$tree->addSection( $users_section );

		// 'browsing and searching' section
		$browse_search_section = new ALSection( wfMsg( 'adminlinks_browsesearch' ) );
		$main_row = new ALRow( 'main' );
		$main_row->addItem( ALItem::newFromSpecialPage( 'Allpages' ) );
		$main_row->addItem( ALItem::newFromSpecialPage( 'Listfiles' ) );
		$main_row->addItem( ALItem::newFromSpecialPage( 'Search' ) );
		$browse_search_section->addRow( $main_row );
		$tree->addSection( $browse_search_section );

		// 'importing and exporting' section
		$import_export_section = new ALSection( wfMsg( 'adminlinks_importexport' ) );
		$main_row = new ALRow( 'main' );
		$main_row->addItem( ALItem::newFromSpecialPage( 'Export' ) );
		$main_row->addItem( ALItem::newFromSpecialPage( 'Import' ) );
		$import_export_section->addRow( $main_row );
		$tree->addSection( $import_export_section );

		return $tree;
	}

	function execute( $query ) {
		$this->setHeaders();
		$admin_links_tree = $this->createInitialTree();
		wfRunHooks( 'AdminLinks', array( &$admin_links_tree ) );
		global $wgOut;
		if ( method_exists( $wgOut, 'addModuleStyles' ) &&
			!is_null( $wgOut->getResourceLoader()->getModule( 'mediawiki.special' ) ) ) {
			$wgOut->addModuleStyles( 'mediawiki.special' );
		}
		$wgOut->addHTML( $admin_links_tree->toString() );
	}

	/**
	 * For administrators, add a link to the special 'AdminLinks' page
	 * among the user's "personal URLs" at the top, if they have
	 * the 'adminlinks' permission.
	 *
	 * @param array $personal_urls
	 * @param Title $title
	 *
	 * @return true
	 */
	public static function addURLToUserLinks( array &$personal_urls, Title &$title ) {
		global $wgUser;
		// if user is a sysop, add link
		if ( $wgUser->isAllowed( 'adminlinks' ) ) {
			$al = SpecialPage::getTitleFor( 'AdminLinks' );
			$href = $al->getLocalURL();
			$admin_links_vals = array(
				'text' => wfMsg( 'adminlinks' ),
				'href' => $href,
				'active' => ( $href == $title->getLocalURL() )
			);

			// find the location of the 'my preferences' link, and
			// add the link to 'AdminLinks' right before it.
			// this is a "key-safe" splice - it preserves both the
			// keys and the values of the array, by editing them
			// separately and then rebuilding the array.
			// based on the example at http://us2.php.net/manual/en/function.array-splice.php#31234
			$tab_keys = array_keys( $personal_urls );
			$tab_values = array_values( $personal_urls );
			$prefs_location = array_search( 'preferences', $tab_keys );
			array_splice( $tab_keys, $prefs_location, 0, 'adminlinks' );
			array_splice( $tab_values, $prefs_location, 0, array( $admin_links_vals ) );

			$personal_urls = array();
			for ( $i = 0; $i < count( $tab_keys ); $i++ ) {
				$personal_urls[$tab_keys[$i]] = $tab_values[$i];
			}
		}
		return true;
	}
}

/**
 * The 'tree' that holds all the sections, rows, and links for the AdminLinks
 * page
 */
class ALTree {
	var $sections;

	function __construct() {
		$this->sections = array();
	}

	function getSection( $section_header ) {
		foreach ( $this->sections as $cur_section ) {
			if ( $cur_section->header === $section_header ) {
				return $cur_section;
			}
		}
		return null;
	}

	function addSection( $section, $next_section_header = null ) {
		if ( $next_section_header == null ) {
			$this->sections[] = $section;
			return;
		}
		foreach ( $this->sections as $i => $cur_section ) {
			if ( $cur_section->header === $next_section_header ) {
				array_splice( $this->sections, $i, 0, array( $section ) );
				return;
			}
		}
		$this->sections[] = $section;
	}

	function toString() {
		$text = "";
		foreach ( $this->sections as $section ) {
			$text .= $section->toString();
		}
		return $text;
	}
}

/**
 * A single section of the Admin Links 'tree', composed of a header and rows
 */
class ALSection {
	var $header;
	var $rows;

	function __construct( $header ) {
		$this->header = $header;
		$this->rows = array();
	}

	function getRow( $row_name ) {
		foreach ( $this->rows as $cur_row ) {
			if ( $cur_row->name === $row_name ) {
				return $cur_row;
			}
		}
		return null;
	}

	function addRow( $row, $next_row_name = null ) {
		if ( $next_row_name == null ) {
			$this->rows[] = $row;
			return;
		}
		foreach ( $this->rows as $i => $cur_row ) {
			if ( $cur_row->name === $next_row_name ) {
				array_splice( $this->rows, $i, 0, array( $row ) );
				return;
			}
		}
		$this->rows[] = $row;
	}

	function toString() {
		$text = '	<h2 class="mw-specialpagesgroup">' . $this->header . "</h2>\n";
		foreach ( $this->rows as $row ) {
			$text .= $row->toString();
		}
		return $text;
	}
}

/**
 * A single row of the AdminLinks page, with a name (not displayed, used only
 * for organizing the rows), and a set of "items" (links)
 */
class ALRow {
	var $name;
	var $items;

	function __construct( $name ) {
		$this->name = $name;
		$this->items = array();
	}

	function addItem( $item, $next_item_label = null ) {
		if ( $next_item_label == null ) {
			$this->items[] = $item;
			return;
		}
		foreach ( $this->items as $i => $cur_item ) {
			if ( $cur_item->label === $next_item_label ) {
				array_splice( $this->items, $i, 0, array( $item ) );
				return;
			}
		}
		$this->items[] = $item;
	}

	function toString() {
		$text = "	<p>\n";
		foreach ( $this->items as $i => $item ) {
			if ( $i > 0 )
				$text .= " ·\n";
			$text .= '		' . $item->text;
		}
		return $text . "\n	</p>\n";
	}
}

/**
 * A single 'item' in the AdminLinks page, most likely representing a link
 * but also conceivably containing other text; also contains a label, which
 * is not displayed and is only used for organizational purposes.
 */
class ALItem {
	var $text;
	var $label;

	static function newFromPage( $page_name, $desc = null, $params = null ) {
		$item = new ALItem();
		$item->label = $desc;
		if ( $params != null ) {
			global $wgUser;
			$item->text = $wgUser->getSkin()->linkKnown( $page_name, $desc, array(), $params );
		} else
			$item->text = "[[$page_name|$desc]]";
		return $item;
	}

	static function newFromSpecialPage( $page_name ) {
		$item = new ALItem();
		$item->label = $page_name;
		$page = SpecialPage::getPage( $page_name );
		global $wgUser;
		$item->text = $wgUser->getSkin()->linkKnown( $page->getTitle(), $page->getDescription() );
		return $item;
	}

	static function newFromEditLink( $page_name, $desc ) {
		$item = new ALItem();
		$item->label = $page_name;
		$title = Title::makeTitleSafe( NS_MEDIAWIKI, $page_name );
		$edit_link = $title->getFullURL( 'action=edit' );
		$item->text = "<a href=\"$edit_link\">$desc</a>";
		return $item;
	}

	static function newFromExternalLink( $url, $label ) {
		$item = new ALItem();
		$item->label = $label;
		$item->text = "<a class=\"external text\" rel=\"nofollow\" href=\"$url\">$label</a>";
		return $item;
	}

}
