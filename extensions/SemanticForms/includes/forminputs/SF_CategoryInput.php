<?php
/**
 * File holding the SFCategoryInput class
 *
 * This input type is deprecated - in SF 2.6.2, it was replaced with, and
 * became a wrapper for, the "tree" input type.
 *
 * @file
 * @ingroup SF
 */

/**
 * The SFCategoryInput class.
 *
 * @ingroup SFFormInput
 */
class SFCategoryInput extends SFTreeInput {
	public static function getName() {
		return 'category';
	}

	public static function getOtherPropTypesHandled() {
		return array( '_wpg' );
	}
}
