<?php
/**
 * File holding the SFCategoriesInput class
 *
 * This input type is deprecated - in SF 2.6.2, it was replaced with, and
 * became a wrapper for, the "tree" input type.
 *
 * @file
 * @ingroup SF
 */

/**
 * The SFCategoriesInput class.
 *
 * @ingroup SFFormInput
 */
class SFCategoriesInput extends SFTreeInput {
	public static function getName() {
		return 'categories';
	}

	public static function getOtherPropTypeListsHandled() {
		return array( '_wpg' );
	}
}
