<?php

/**
 * Class describing a single translation memory unit.
 *
 * @since 0.4
 *
 * @file LT_TMUnit.php
 * @ingroup LiveTranslate
 *
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class LTTMUnit {

	/**
	 * List of language variants of the translation memory unit.
	 *
	 * language code => array( primary translation [, synonym [, ect]] )
	 *
	 * @since 0.4
	 *
	 * @var array
	 */
	protected $variants = array();

	/**
	 * Creates a new translation memory unit.
	 *
	 * @since 0.4
	 *
	 * @param array $variants
	 */
	public function __construct( array $variants = array() ) {
		$this->addVariants( $variants );
	}

	/**
	 * Returns the list of language variants of the translation memory unit.
	 *
	 * @since 0.4
	 *
	 * @var array: language code => array( primary translation [, synonym [, ect]] )
	 */
	public function getVariants() {
		return $this->variants;
	}

	/**
	 * Adds the translation (and optional synonyms) of the unit in a single language.
	 *
	 * @since 0.4
	 *
	 * @param string $language
	 * @param string $translation
	 * @param array $synonyms
	 */
	public function addVariant( $language, $translation, array $synonyms = array() ) {
		$this->variants[$language] = array_merge( array( $translation ), $synonyms );
	}

	/**
	 * Adds a list of translations to the translation memory unit.
	 *
	 * @since 0.4
	 *
	 * @param array $variants language code => array( primary translation [, synonym [, ect]] )
	 */
	public function addVariants( array $variants ) {
		foreach ( $variants as $language => $variant ) {
			$variant = (array)$variant; // Do not require an array, to simplify notation when there are no synonyms.
			$primaryTranslation = array_shift( $variant );
			$this->addVariant( $language, $primaryTranslation, $variant );
		}
	}

	/**
	 * Returns if the translation unit has any variants. If not, it can probably be ignored.
	 *
	 * @since 0.4
	 *
	 * @return boolean
	 */
	public function hasVariants() {
		return count( $this->variants ) > 0;
	}

	/**
	 * Returns if the translation unit has any significant value. This means it has at least 2
	 * variants with different values.
	 *
	 * @since 0.4
	 *
	 * @return boolean
	 */
	public function isSignificant() {
		return count( $this->variants ) > 1 && $this->hasVariantDifferences();
	}

	/**
	 * Returns if the translation unit has a certain minimal amount (default: 1) of
	 * differences in values in it's variants.
	 *
	 * @since 0.4
	 *
	 * @return boolean
	 */
	public function hasVariantDifferences( $minAmount = 1 ) {
		$amount = -1; // The first unknown value is not a difference.
		$knownValues = array();

		foreach ( $this->variants as $variant ) {
			// If the value is not known yet, it's a difference.
			if ( !in_array( $variant[0], $knownValues ) ) {
				$knownValues[] = $variant[0];
				$amount++;
			}
			// If there are synonyms, just assume it's different.
			// This might not be the case, but no full accuracy is required.
			elseif ( count( $variant ) > 1 ) {
				$amount++;
			}

			if ( $amount >= $minAmount ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Returns the amount of languages (variants).
	 *
	 * @since 0.4
	 *
	 * @return integer
	 */
	public function getLanguageAmount() {
		return count( $this->variants );
	}

}
