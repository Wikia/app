<?php
/**
 * File holding the SFTreeInput class
 *
 * @file
 * @ingroup SF
 *
 * @author Yaron Koren
 * @author Mathias Lidal
 */

/**
 * The SFTreeInput class.
 *
 * @ingroup SFFormInput
 */
class SFTreeInput extends SFFormInput {

	private static $multipleSelect = false;

	public static function getName() {
		return 'tree';
	}

	public static function getOtherPropTypesHandled() {
		if ( defined( 'SMWDataItem::TYPE_STRING' ) ) {
			// SMW < 1.9
			return array( '_str', '_wpg' );
		} else {
			return array( '_txt', '_wpg' );
		}
	}

	public static function getOtherPropTypeListsHandled() {
		if ( defined( 'SMWDataItem::TYPE_STRING' ) ) {
			// SMW < 1.9
			return array( '_str', '_wpg' );
		} else {
			return array( '_txt', '_wpg' );
		}
	}

	public static function getOtherCargoTypesHandled() {
		return array( 'String', 'Page' );
	}

	public static function getOtherCargoTypeListsHandled() {
		return array( 'String', 'Page' );
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		// Handle the now-deprecated 'category' and 'categories'
		// input types.
		if ( $other_args['input type'] == 'category' ) {
			$inputType = "radio";
			self::$multipleSelect = false;
		} elseif ( $other_args['input type'] == 'categories' ) {
			$inputType = "checkbox";
			self::$multipleSelect = true;
		} else {
			$is_list = ( array_key_exists( 'is_list', $other_args ) && $other_args['is_list'] == true );
			if ( $is_list ) {
				$inputType = "checkbox";
				self::$multipleSelect = true;
			} else {
				$inputType = "radio";
				self::$multipleSelect = false;
			}
		}

		// get list delimiter - default is comma
		if ( array_key_exists( 'delimiter', $other_args ) ) {
			$delimiter = $other_args['delimiter'];
		} else {
			$delimiter = ',';
		}

		$cur_values = SFValuesUtils::getValuesArray( $cur_value, $delimiter );
		if ( array_key_exists( 'height', $other_args ) ) {
			$height = $other_args['height'];
		} else {
			$height = '100';
		}
		if ( array_key_exists( 'width', $other_args ) ) {
			$width = $other_args['width'];
		} else {
			$width = '500';
		}

		$dummy_str = "REPLACE THIS TEXT";
		$text = '<div class="sfTreeInput" id="' . $input_name . 'treeinput" style="height: ' . $height . 'px; width: ' . $width . 'px;">';

		if ( array_key_exists( 'depth', $other_args ) ) {
			$depth = $other_args['depth'];
		} else {
			$depth = '10';
		}

		if ( array_key_exists( 'top category', $other_args ) ) {
			$top_category = $other_args['top category'];

			$title = self::makeTitle( $top_category );
			if ( $title->getNamespace() != NS_CATEGORY ) {
				return null;
			}

			$tree = SFTree::newFromTopCategory( $top_category );
			$hideroot = array_key_exists( 'hideroot', $other_args );
		} elseif ( array_key_exists( 'structure', $other_args ) ) {
			$structure = $other_args['structure'];
			$tree = SFTree::newFromWikiText( $structure );
			$hideroot = true;
		} else {
			// Escape - we can't do anything.
			return null;
		}

		$inputText = self::treeToHTML( $tree, $input_name, $cur_values, $hideroot, $depth, $inputType );

		// Replace values one at a time, by an incrementing index -
		// inspired by http://bugs.php.net/bug.php?id=11457
		$i = 0;
		while ( ( $a = strpos( $inputText, $dummy_str ) ) > 0 ) {
			$inputText = substr( $inputText, 0, $a ) . $i++ . substr( $inputText, $a + strlen( $dummy_str ) );
		}
		$text .= $inputText;

		$text .= '</div>';

		return $text;
	}

	// Perhaps treeToHTML() and nodeToHTML() should be moved to the
	// SFTree class? Currently SFTree doesn't know about HTML stuff, but
	// maybe it should.
	private static function treeToHTML( $fullTree, $input_name, $current_selection, $hideprefix, $depth, $inputType ) {
		$key_prefix = $input_name . "key";
		$text = '';
		if ( !$hideprefix ) {
			$text .= "<ul>\n";
		}
		$text .= self::nodeToHTML( $fullTree, $key_prefix, $input_name, $current_selection, $hideprefix, $depth, $inputType );
		if ( !$hideprefix ) {
			$text .= "</ul>\n";
		}
		if ( self::$multipleSelect ) {
			$text .= Html::hidden( $input_name . '[is_list]', 1 );
		}
		return $text;
	}

	private static function nodeToHTML( $node, $key_prefix, $input_name, $current_selection, $hidenode, $depth, $inputType, $index = 1 ) {
		global $sfgTabIndex, $sfgFieldNum;

		$input_id = "input_$sfgFieldNum";
		// HTML IDs can't contain spaces.
		$key_id = str_replace( ' ', '-', "$key_prefix-$index" );
		$dataItems = array();
		$li_data = "";
		if ( in_array( $node->title, $current_selection ) ) {
			$li_data .= 'class="selected" ';
		}

		if ( $depth > 0 ) {
			$dataItems[] = "'expand': true";
		}

		if ( $dataItems ) {
			$li_data .= "data=\"" . implode(",", $dataItems) . "\" ";
		}

		$text = '';
		if ( !$hidenode ) {
			$dummy_str = "REPLACE THIS TEXT";
			$text .= "<li id=\"$key_id\" $li_data>";
			if ( self::$multipleSelect) {
				$inputName = $input_name . "[" . $dummy_str . "]";
			} else {
				$inputName = $input_name;
			}
			$nodeAttribs = array(
				'tabindex' => $sfgTabIndex,
				'id' => "chb-$key_id",
				'class' => 'hidden'
			);
			if ( in_array( $node->title, $current_selection ) ) {
				$nodeAttribs['checked'] = true;
			}
			$text .= Html::input( $inputName, $node->title, $inputType, $nodeAttribs );
			$text .= $node->title . "\n";
		}
		if ( array_key_exists( 'children', $node ) ) {
			$text .= "<ul>\n";
			$i = 1;
			foreach ( $node->children as $cat ) {
				$text .= self::nodeToHTML( $cat, $key_id, $input_name, $current_selection, false, $depth - 1, $inputType, $i++ );
			}
			$text .= "</ul>\n";
		}
		return $text;
	}

	public static function getParameters() {
		$params = parent::getParameters();
		$params[] = array(
			'name' => 'top category',
			'type' => 'string',
			'description' => wfMessage( 'sf_forminputs_topcategory' )->text()
		);
		$params[] = array(
			'name' => 'structure',
			'type' => 'text',
			'description' => wfMessage( 'sf_forminputs_structure' )->text()
		);
		$params[] = array(
			'name' => 'hideroot',
			'type' => 'boolean',
			'description' => wfMessage( 'sf_forminputs_hideroot' )->text()
		);
		$params[] = array(
			'name' => 'depth',
			'type' => 'int',
			'description' => wfMessage( 'sf_forminputs_depth' )->text()
		);
		$params[] = array(
			'name' => 'height',
			'type' => 'int',
			'description' => wfMessage( 'sf_forminputs_height' )->text()
		);
		$params[] = array(
			'name' => 'width',
			'type' => 'int',
			'description' => wfMessage( 'sf_forminputs_width' )->text()
		);
		return $params;
	}

	/**
	 * Returns the HTML code to be included in the output page for this input.
	 */
	public function getHtmlText() {
		return self::getHTML(
			$this->mCurrentValue,
			$this->mInputName,
			$this->mIsMandatory,
			$this->mIsDisabled,
			$this->mOtherArgs
		);
	}

	/**
	 * Creates a Title object from a user-provided (and thus unsafe) string
	 * @param $title string
	 * @return null|Title
	 */
	static function makeTitle( $title ) {
		$title = trim( $title );

		if ( strval( $title ) === '' ) {
			return null;
		}

		# The title must be in the category namespace
		# Ignore a leading Category: if there is one
		$t = Title::newFromText( $title, NS_CATEGORY );
		if ( !$t || $t->getNamespace() != NS_CATEGORY || $t->getInterwiki() != '' ) {
			// If we were given something like "Wikipedia:Foo" or "Template:",
			// try it again but forced.
			$title = "Category:$title";
			$t = Title::newFromText( $title );
		}
		return $t;
	}

}

/**
 * A class that defines a tree - and can populate it based on either
 * wikitext or a category structure.
 *
 * @author Yaron Koren
 */
class SFTree {
	var $title, $children;

	function __construct( $curTitle ) {
		$this->title = $curTitle;
		$this->children = array();
	}

	function addChild( $child ) {
		$this->children[] = $child;
	}

	/**
	 * Turn a manually-created "structure", defined as a bulleted list
	 * in wikitext, into a tree. This is based on the concept originated
	 * by the "menuselect" input type in the Semantic Forms Inputs
	 * extension - the difference here is that the text is manually
	 * parsed, instead of being run through the MediaWiki parser.
	 */
	public static function newFromWikiText( $wikitext ) {
		// The top node, called "Top", will be ignored, because
		// we'll set "hideroot" to true.
		$fullTree = new SFTree( 'Top' );
		$lines = explode( "\n", $wikitext );
		foreach ( $lines as $line ) {
			$numBullets = 0;
			for ( $i = 0; $i < strlen( $line ) && $line[$i] == '*'; $i++ ) {
				$numBullets++;
			}
			if ( $numBullets == 0 ) continue;
			$lineText = trim( substr( $line, $numBullets ) );
			$curParentNode = $fullTree->getLastNodeForLevel( $numBullets );
			$curParentNode->addChild( new SFTree( $lineText ) );
		}
		return $fullTree;
	}

	function getLastNodeForLevel( $level ) {
		if ( $level <= 1 || count( $this->children ) == 0 ) {
			return $this;
		}
		$lastNodeOnCurLevel = end( $this->children );
		return $lastNodeOnCurLevel->getLastNodeForLevel( $level - 1 );
	}

	/**
	 * @param $top_category String
	 * @return mixed
	 */
	static function newFromTopCategory( $top_category ) {
		$sfTree = new SFTree( $top_category );
		$defaultDepth = 20;
		$sfTree->populateChildren( $defaultDepth );
		return $sfTree;
	}

	/**
	 * Recursive function to populate a tree based on category information.
	 */
	private function populateChildren( $depth ) {
		if ( $depth == 0 ) return;
		$subcats = self::getSubcategories( $this->title );
		foreach( $subcats as $subcat ) {
			$childTree = new SFTree( $subcat );
			$childTree->populateChildren( $depth - 1 );
			$this->addChild( $childTree );
		}
	}

	/**
	 * Gets all the subcategories of the passed-in category.
	 *
	 * @TODO This might not belong in this class.
	 *
	 * @param Title $title
	 * @return array
	 */
	private static function getSubcategories( $categoryName ) {
		$dbr = wfGetDb( DB_SLAVE );

		$tables = array( 'page', 'categorylinks' );
		$fields = array( 'page_id', 'page_namespace', 'page_title',
			'page_is_redirect', 'page_len', 'page_latest', 'cl_to',
			'cl_from' );
		$where = array();
		$joins = array();
		$options = array( 'ORDER BY' => 'cl_type, cl_sortkey' );

		$joins['categorylinks'] = array( 'JOIN', 'cl_from = page_id' );
		$where['cl_to'] = str_replace( ' ', '_', $categoryName );
		$options['USE INDEX']['categorylinks'] = 'cl_sortkey';

		$tables = array_merge( $tables, array( 'category' ) );
		$fields = array_merge( $fields, array( 'cat_id', 'cat_title', 'cat_subcats', 'cat_pages', 'cat_files' ) );
		$joins['category'] = array( 'LEFT JOIN', array( 'cat_title = page_title', 'page_namespace' => NS_CATEGORY ) );

		$res = $dbr->select( $tables, $fields, $where, __METHOD__, $options, $joins );
		$subcats = array();

		foreach ( $res as $row ) {
			$t = Title::newFromRow( $row );
			if ( $t->getNamespace() == NS_CATEGORY ) {
				$subcats[] = $t->getText();
			}
		}
		return $subcats;
	}

}
