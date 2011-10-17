<?php
/**
 * File holding the SFCategoriesInput class
 *
 * @file
 * @ingroup SF
 */

if ( !defined( 'SF_VERSION' ) ) {
	die( 'This file is part of the SemanticForms extension, it is not a valid entry point.' );
}

/**
 * The SFCategoriesInput class.
 *
 * @ingroup SFFormInput
 */
class SFCategoriesInput extends SFCategoryInput {
	public static function getName() {
		return 'categories';
	}

	public static function getOtherPropTypeListsHandled() {
		return array( '_wpg' );
	}

	public static function getHTML( $cur_value, $input_name, $is_mandatory, $is_disabled, $other_args ) {
		// escape if CategoryTree extension isn't included
		if ( !function_exists( 'efCategoryTreeParserHook' ) ) {
			return null;
		}

		global $sfgTabIndex, $sfgFieldNum, $wgCapitalLinks;

		$className = ( $is_mandatory ) ? 'mandatoryField' : 'createboxInput';
		if ( array_key_exists( 'class', $other_args ) ) {
			$className .= ' ' . $other_args['class'];
		}
		$input_id = "input_$sfgFieldNum";
		$info_id = "info_$sfgFieldNum";
		// get list delimiter - default is comma
		if ( array_key_exists( 'delimiter', $other_args ) ) {
			$delimiter = $other_args['delimiter'];
		} else {
			$delimiter = ',';
		}
		$cur_values = SFUtils::getValuesArray( $cur_value, $delimiter );
		if ( array_key_exists( 'top category', $other_args ) ) {
			$top_category = $other_args['top category'];
		} else {
			// escape - we can't do anything
			return null;
		}
		$hideroot = array_key_exists( 'hideroot', $other_args );
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

		global $wgCategoryTreeMaxDepth;
		$wgCategoryTreeMaxDepth = 10;
		$tree = efCategoryTreeParserHook(
			$top_category, array(
				'mode' => 'categories',
				'namespaces' => array( NS_CATEGORY ),
				'depth' => 10,
				'hideroot' => $hideroot,
			)
		);
		// Some string that will hopefully never show up in a category,
		// template or field name.
		$dummy_str = 'REPLACE THIS STRING!';
		$tree = preg_replace(
			'/(<a class="CategoryTreeLabel.*>)(.*)(<\/a>)/',
			'<input id="' . $input_id . '" tabindex="' . $sfgTabIndex .
				'" name="' . $input_name . '[' . $dummy_str .
				']" value="$2" type="checkbox"> $1$2$3',
			$tree
		);
		// replace values one at a time, by an incrementing index -
		// inspired by http://bugs.php.net/bug.php?id=11457
		$i = 0;
		while ( ( $a = strpos( $tree, $dummy_str ) ) > 0 ) {
			$tree = substr( $tree, 0, $a ) . $i++ . substr( $tree, $a + strlen( $dummy_str ) );
		}
		// set all checkboxes matching $cur_values to checked
		foreach ( $cur_values as $value ) {
			// Capitalize the first letter, if first letters
			// always get capitalized.
			if ( $wgCapitalLinks ) {
				global $wgContLang;
				$value = $wgContLang->ucfirst( $value );
			}

			$tree = str_replace( "value=\"$value\"", "value=\"$value\" checked=\"checked\"", $tree );
		}
		// if it's disabled, set all to disabled
		if ( $is_disabled ) {
			$tree = str_replace( 'type="checkbox"', 'type="checkbox" disabled', $tree );
		}

		// Get rid of all the 'no subcategories' messages.
		$tree = str_replace(
			'<div class="CategoryTreeChildren" style="display:block"><i class="CategoryTreeNotice">' .
				wfMsg( 'categorytree-no-subcategories' ) . '</i></div>',
			'',
			$tree
		);

		$text = '<div style="overflow: auto; padding: 5px; border: 1px #aaaaaa solid; max-height: ' . $height . 'px; width: ' . $width . 'px;">' . $tree . '</div>';

		$text .= SFFormUtils::hiddenFieldHTML( $input_name . '[is_list]', 1 );
		$spanClass = 'checkboxesSpan';
		if ( $is_mandatory ) {
			$spanClass .= ' mandatoryFieldSpan';
		}
		$text = "\n" . Xml::tags( 'span', array( 'class' => $spanClass ), $text ) . "\n";

		return $text;
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
			$mOtherArgs
		);
	}
}
