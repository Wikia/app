<?php

class TranslateTagUtils {
	const T_SOURCE = 1;
	const T_TRANSLATION = 2;
	const T_ANY = 3;

	const STATUSEXPIRY = 600; // in seconds

	public static function isTagPage( Title $title, $type = self::T_ANY ) {
		list( $key, $code ) = self::keyAndCode( $title );

		if ( $type === self::T_SOURCE && $code !== false ) return false;
		if ( $type === self::T_TRANSLATION && $code === false ) return false;


		static $members = null;
		if ( $members === null ) {
			wfLoadExtensionMessages( 'Translate' );
			$cat = Category::newFromName( wfMsgForContent( 'translate-tag-category' ) );
			$members = $cat->getMembers();
		}

		foreach ( $members as $member ) {
			if ( $member->getNamespace() === $title->getNamespace() ) {
				if ( $member->getDBkey() === $key ) return true;
			}
		}
		return false;
	}

	public static function keyAndCode( Title $title ) {
		$dbkey = $title->getDBkey();
		$code = false;

		$pos = strrpos( $dbkey, '/' );
		if ( $pos !== false ) {
			$code = substr( $dbkey, $pos + 1 );
			$key = substr( $dbkey, 0, $pos );
			if ( self::isValidCode( $code ) ) {
				return array( $key, $code );
			}
		}

		return array( $dbkey, false );
	}

	public static function isValidCode( $code ) {
		$codes = Language::getLanguageNames();
		return isset( $codes[$code] );
	}

	/**
	 * Returns a database resource which can be looped and text can be fetched via
	 * Revision::getRevisionText( $row ).
	 */
	public static function getPageContent( $namespace, $pages ) {
		$dbr = wfGetDB( DB_SLAVE );
		$rows = $dbr->select( array( 'page', 'revision', 'text' ),
			array( 'page_title', 'old_text', 'old_flags' ),
			array(
				'page_is_redirect'  => 0,
				'page_namespace'    => $namespace,
				'page_latest=rev_id',
				'rev_text_id=old_id',
				'page_title'        => $pages,
			),
			__METHOD__
		);

		return $rows;
	}

	public static function getTagPageSource( Title $title ) {
		$text = null;
		$res = self::getPageContent( $title->getNamespace(), $title->getDBkey() );

		foreach ( $res as $_ ) {
			$text = Revision::getRevisionText( $_ );
			break;
		}

		return $text;
	}

	public static function codefyTitle( Title $title, $code ) {
		global $wgContLang;
		$namespace = $title->getNamespace();
		$dbkey = $title->getDBkey();
		if ( $code !== $wgContLang->getCode() ) $dbkey .= "/$code";
		return Title::makeTitle( $namespace, "$dbkey" );
	}

	public static function deCodefy( Title $title ) {
		// Don't remove trail if source page
		$type = self::T_SOURCE;
		if ( self::isTagPage( $title, $type ) ) return $title;

		list( , $code ) = self::keyAndCode( $title );
		$namespace = $title->getNamespace();
		$dbkey = $title->getDBkey();
		$suflen = strlen( $code );
		if ( $suflen ) $dbkey = substr( $dbkey, 0, - ( $suflen + 1 ) );
		return Title::makeTitle( $namespace, $dbkey );
	}

	public static function getTranslationPercent( $pages, $code, $namespace ) {
		$pages = self::mapAppend( $pages, "/$code" );
		$n = count( $pages );
		$sectionSize = 1 / $n;
		$total = 0;

		$res = self::getPageContent( $namespace, $pages );
		foreach ( $res as $_ ) {
			$text = Revision::getRevisionText( $_ );
			if ( strpos( $text, TRANSLATE_FUZZY ) !== false ) {
				$total += $sectionSize / 2;
			} else {
				$total += $sectionSize;
			}
		}

		return $total;
	}

	public static function getPercentages( Title $title ) {
		// Check if relevant at all
		if ( !TranslateTagUtils::isTagPage( $title ) ) return false;

		// Normalise title, just to be sure
		$title = self::deCodefy( $title );

		// Check the memory cache, as this is very slow to calculate
		global $wgMemc;
		$memcKey = wfMemcKey( 'translate', 'status', $title->getPrefixedText() );
		$cache = $wgMemc->get( $memcKey );
		if ( is_array( $cache ) ) return $cache;

		// Fetch the available translation pages from database
		$dbr = wfGetDB( DB_SLAVE );
		$likePattern = $dbr->escapeLike( $title->getDBkey() ) . '/%%';
		$res = $dbr->select(
			'page',
			array( 'page_namespace', 'page_title' ),
			array(
				'page_namespace' => $title->getNamespace(),
				"page_title LIKE '$likePattern'"
			), __METHOD__ );

		$titles = TitleArray::newFromResult( $res );

		// Calculate percentages for the available translations
		$tag = TranslateTag::newFromTitle( $title );
		$pages = $tag->getSectionPages();
		$namespace = $tag->getNamespace( $title );


		$temp = array();


		$type = TranslateTagUtils::T_TRANSLATION;
		foreach ( $titles as $_ ) {
			if ( !TranslateTagUtils::isTagPage( $_, $type ) ) continue;
			list( , $code ) = TranslateTagUtils::keyAndcode( $_ );
			$percent = TranslateTagUtils::getTranslationPercent( $pages, $code, $namespace );
			$temp[$code] = $percent;
		}
		$temp['en'] = '1';

		// Ideally there would be some kind of purging here
		$wgMemc->set( $memcKey, $temp, self::STATUSEXPIRY );
		return $temp;
	}

	public static function mapAppend( array $array, $suffix ) {
		$function = create_function( '$_', "return \$_ . '$suffix';" );
		return array_map( $function, $array );
	}

}
