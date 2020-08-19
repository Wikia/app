<?php

require_once( dirname( __FILE__ ) . '/../LanguageConverter.php' );
require_once( dirname( __FILE__ ) . '/LanguageZh_hans.php' );

/**
 * @ingroup Language
 */
class ZhConverter extends LanguageConverter {

	/**
	 * @param $langobj Language
	 * @param $maincode string
	 * @param $variants array
	 * @param $variantfallbacks array
	 * @param $flags array
	 * @param $manualLevel array
	 */
	function __construct( $langobj, $maincode,
								$variants = array(),
								$variantfallbacks = array(),
								$flags = array(),
								$manualLevel = array() ) {
		$this->mDescCodeSep = '：';
		$this->mDescVarSep = '；';
		parent::__construct( $langobj, $maincode,
									$variants,
									$variantfallbacks,
									$flags,
									$manualLevel );
		$names = array(
			'zh'      => '原文',
			'zh-hans' => '简体',
			'zh-hant' => '繁體',
			'zh-cn'   => '大陆',
			'zh-tw'   => '台灣',
			'zh-hk'   => '香港',
			'zh-mo'   => '澳門',
			'zh-sg'   => '新加坡',
			'zh-my'   => '大马',
		);
		$this->mVariantNames = array_merge( $this->mVariantNames, $names );
	}

	function loadDefaultTables() {
		require( dirname( __FILE__ ) . "/../../includes/ZhConversion.php" );
		$this->mTables = array(
			'zh-hans' => new ReplacementArray( $zh2Hans ),
			'zh-hant' => new ReplacementArray( $zh2Hant ),
			'zh-cn'   => new ReplacementArray( array_merge( $zh2Hans, $zh2CN ) ),
			'zh-hk'   => new ReplacementArray( array_merge( $zh2Hant, $zh2HK ) ),
			'zh-mo'   => new ReplacementArray( array_merge( $zh2Hant, $zh2HK ) ),
			'zh-my'   => new ReplacementArray( array_merge( $zh2Hans, $zh2SG ) ),
			'zh-sg'   => new ReplacementArray( array_merge( $zh2Hans, $zh2SG ) ),
			'zh-tw'   => new ReplacementArray( array_merge( $zh2Hant, $zh2TW ) ),
			'zh'      => new ReplacementArray
		);
	}

	function postLoadTables() {
		$this->mTables['zh-cn']->setArray(
			$this->mTables['zh-cn']->getArray() + $this->mTables['zh-hans']->getArray()
		);
		$this->mTables['zh-hk']->setArray(
			$this->mTables['zh-hk']->getArray() + $this->mTables['zh-hant']->getArray()
		);
		$this->mTables['zh-mo']->setArray(
			$this->mTables['zh-mo']->getArray() + $this->mTables['zh-hant']->getArray()
		);
		$this->mTables['zh-my']->setArray(
			$this->mTables['zh-my']->getArray() + $this->mTables['zh-hans']->getArray()
		);
		$this->mTables['zh-sg']->setArray(
			$this->mTables['zh-sg']->getArray() + $this->mTables['zh-hans']->getArray()
		);
		$this->mTables['zh-tw']->setArray(
			$this->mTables['zh-tw']->getArray() + $this->mTables['zh-hant']->getArray()
		);
	}

	/**
	 * there shouldn't be any latin text in Chinese conversion, so no need
	 * to mark anything.
	 * $noParse is there for compatibility with LanguageConvert::markNoConversion
	 *
	 * @param $text string
	 * @param $noParse bool
	 *
	 * @return string
	 */
	function markNoConversion( $text, $noParse = false ) {
		return $text;
	}

	/**
	 * @param $key string
	 * @return String
	 */
	function convertCategoryKey( $key ) {
		return $this->autoConvert( $key, 'zh' );
	}
}

/**
 * class that handles both Traditional and Simplified Chinese
 * right now it only distinguish zh_hans, zh_hant, zh_cn, zh_tw, zh_sg and zh_hk.
 *
 * @ingroup Language
 */
class LanguageZh extends LanguageZh_hans {

	function __construct() {
		global $wgHooks;
		parent::__construct();

		$variants = array( 'zh', 'zh-hans', 'zh-hant', 'zh-cn', 'zh-hk', 'zh-mo', 'zh-my', 'zh-sg', 'zh-tw' );

		$variantfallbacks = array(
			'zh'      => array( 'zh-hans', 'zh-hant', 'zh-cn', 'zh-tw', 'zh-hk', 'zh-sg', 'zh-mo', 'zh-my' ),
			'zh-hans' => array( 'zh-cn', 'zh-sg', 'zh-my' ),
			'zh-hant' => array( 'zh-tw', 'zh-hk', 'zh-mo' ),
			'zh-cn'   => array( 'zh-hans', 'zh-sg', 'zh-my' ),
			'zh-sg'   => array( 'zh-hans', 'zh-cn', 'zh-my' ),
			'zh-my'   => array( 'zh-hans', 'zh-sg', 'zh-cn' ),
			'zh-tw'   => array( 'zh-hant', 'zh-hk', 'zh-mo' ),
			'zh-hk'   => array( 'zh-hant', 'zh-mo', 'zh-tw' ),
			'zh-mo'   => array( 'zh-hant', 'zh-hk', 'zh-tw' ),
		);
		$ml = array(
			'zh'      => 'disable',
			'zh-hans' => 'unidirectional',
			'zh-hant' => 'unidirectional',
		);

		$this->mConverter = new ZhConverter( $this, 'zh',
								$variants, $variantfallbacks,
								array(),
								$ml );

		$wgHooks['ArticleSaveComplete'][] = $this->mConverter;
	}

	/**
	 * this should give much better diff info
	 *
	 * @param $text string
	 * @return string
	 */
	function segmentForDiff( $text ) {
		return preg_replace(
			"/([\\xc0-\\xff][\\x80-\\xbf]*)/e",
			"' ' .\"$1\"", $text );
	}

	/**
	 * @param $text string
	 * @return string
	 */
	function unsegmentForDiff( $text ) {
		return preg_replace(
			"/ ([\\xc0-\\xff][\\x80-\\xbf]*)/e",
			"\"$1\"", $text );
	}

	/**
	 * auto convert to zh-hans and normalize special characters.
	 *
	 * @param $string String
	 * @param $autoVariant String, default to 'zh-hans'
	 * @return String
	 */
	function normalizeForSearch( $string, $autoVariant = 'zh-hans' ) {
		wfProfileIn( __METHOD__ );

		// always convert to zh-hans before indexing. it should be
		// better to use zh-hans for search, since conversion from
		// Traditional to Simplified is less ambiguous than the
		// other way around
		$s = $this->mConverter->autoConvert( $string, $autoVariant );
		// LanguageZh_hans::normalizeForSearch
		$s = parent::normalizeForSearch( $s );
		wfProfileOut( __METHOD__ );
		return $s;

	}

	/**
	 * @param $termsArray array
	 * @return array
	 */
	function convertForSearchResult( $termsArray ) {
		$terms = implode( '|', $termsArray );
		$terms = self::convertDoubleWidth( $terms );
		$terms = implode( '|', $this->mConverter->autoConvertToAllVariants( $terms ) );
		$ret = array_unique( explode( '|', $terms ) );
		return $ret;
	}
}

