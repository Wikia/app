<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

class CategoryMultisortChineseHooks {

	function __construct() {
		global $wgHooks;
		
		foreach ( array(
			'CategoryMultisortSortkeys',
		) as $hook ) {
			$wgHooks[$hook][] = $this;
		}
	}
	
	function onCategoryMultisortSortkeys_loadData() {
		$file = dirname( __FILE__ ) . '/CategoryMultisortChinese.dat';
		
		if ( file_exists( $file ) ) {
			$data = unserialize( file_get_contents( $file ) );
			if ( $data ) {
				return $data;
			}
		}
		
		$data = new CategoryMultisortChineseData();
		file_put_contents( $file, serialize( $data ) );
		return $data;
	}
	
	function onCategoryMultisortSortkeys( $parser, $category, &$categoryMultisorts ) {
		global $wgContLang;
		
		static $data = null;
		if ( is_null( $data ) ) {
			$data = $this->onCategoryMultisortSortkeys_loadData();
		}
		
		$title = $parser->getTitle();
		$text = $title->getText();
		
		$md = $this->onCategoryMultisortSortkeys_buildMandarinSortkeys( $data, $text );
		
		foreach ( $md as $mdname => $mdvalue ) {
		    $this->onCategoryMultisortSortkeys_setDefaultSortkey(
			    $categoryMultisorts, "mandarin-$mdname", $mdvalue
		    );
		}
		$this->onCategoryMultisortSortkeys_setDefaultSortkey( $categoryMultisorts, 'cantonese-jyutping',
			$this->onCategoryMultisortSortkeys_buildCantoneseJyutpingSortkey( $data, $text )
		);
		$this->onCategoryMultisortSortkeys_setDefaultSortkey( $categoryMultisorts, 'stroke',
			$this->onCategoryMultisortSortkeys_buildStrokeSortkey( $data, $text )
		);
		$this->onCategoryMultisortSortkeys_setDefaultSortkey( $categoryMultisorts, 'radical',
			$this->onCategoryMultisortSortkeys_buildRadicalSortkey( $data, $text )
		);
		
		$conv = $wgContLang->autoConvertToAllVariants( $text );
		
		if ( array_key_exists( 'zh-hans', $conv ) ) {
			$this->onCategoryMultisortSortkeys_setDefaultSortkey( $categoryMultisorts, 'stroke-simplified',
				$this->onCategoryMultisortSortkeys_buildStrokeSortkey( $data, $conv['zh-hans'] )
			);
			$this->onCategoryMultisortSortkeys_setDefaultSortkey( $categoryMultisorts, 'radical-simplified',
				$this->onCategoryMultisortSortkeys_buildRadicalSortkey( $data, $conv['zh-hans'] )
			);
		}
		
		if ( array_key_exists( 'zh-hant', $conv ) ) {
			$this->onCategoryMultisortSortkeys_setDefaultSortkey( $categoryMultisorts, 'stroke-traditional',
				$this->onCategoryMultisortSortkeys_buildStrokeSortkey( $data, $conv['zh-hant'] )
			);
			$this->onCategoryMultisortSortkeys_setDefaultSortkey( $categoryMultisorts, 'radical-traditional',
				$this->onCategoryMultisortSortkeys_buildRadicalSortkey( $data, $conv['zh-hant'] )
			);
		}
		
		return true;
	}
	
	function onCategoryMultisortSortkeys_setDefaultSortkey( &$categoryMultisorts, $skn, $default ) {
		if ( !array_key_exists( $skn, $categoryMultisorts ) ) {
			$categoryMultisorts[$skn] = $default;
		}
	}
	
	function onCategoryMultisortSortkeys_getStroke( $data, $chcp ) {
		return array_key_exists( $chcp, $data->totalStrokes )
			? sprintf( '%03d', $data->totalStrokes[$chcp] ) : '';
	}
	
	function onCategoryMultisortSortkeys_getRadical( $data, $chcp ) {
		if ( !array_key_exists( $chcp, $data->radicalStrokeCounts ) ) {
			return '';
		} else {
			list( $radicalId, $rest ) = $data->radicalStrokeCounts[$chcp];
			$radicalCp = $data->radicals[$radicalId];
			return sprintf( '%s%03d', codepointToUtf8( $radicalCp ), $rest );
		}
	}
	
	function onCategoryMultisortSortkeys_splitString( $str ) {
		global $wgContLang;
		
		$result = array();
		while ( $str ) {
			$fc = $wgContLang->firstChar( $str );
			$result[] = $fc;
			$str = substr( $str, strlen( $fc ) );
		}
		return $result;
	}
	
	function onCategoryMultisortSortkeys_buildMandarinSortkeys( $data, $str ) {
		$results = array(
		    'pinyin' => '', 'bopomofo' => '', 'wadegiles' => '', 'mps2' => '', 'tongyong' => ''
		);
		foreach ( $this->onCategoryMultisortSortkeys_splitString( $str ) as $ch ) {
			# One UTF-8 character can have 4 bytes max.
			$c = str_pad( $ch, 4 );
			$chcp = utf8ToCodepoint( $ch );
			# One Mandarin pinyin entry can have 7 bytes max.
			$mdpx = array_key_exists( $chcp, $data->mandarin ) ? $data->mandarin[$chcp] : '';
			$mdp = str_pad( $mdpx, 7 );
			$mdo = array_key_exists( $mdpx, $data->systems ) ? $data->systems[$mdpx] : array('', '', '', '');
			list( $mdb, $mdw, $md2, $mdt ) = $mdo;
			# Other max lengths
			$mdb = str_pad( $mdb, 10 );
			$mdw = str_pad( $mdw, 8 );
			$md2 = str_pad( $md2, 7 );
			$mdt = str_pad( $mdt, 7 );
			$results['pinyin'] .= $mdp . $c;
			$results['bopomofo'] .= $mdb . $c;
			$results['wadegiles'] .= $mdw . $c;
			$results['mps2'] .= $md2 . $c;
			$results['tongyong'] .= $mdt . $c;
		}
		return $results;
	}
	
	function onCategoryMultisortSortkeys_buildCantoneseJyutpingSortkey( $data, $str ) {
		$result = '';
		foreach ( $this->onCategoryMultisortSortkeys_splitString( $str ) as $ch ) {
			# One UTF-8 character can have 4 bytes max.
			$c = str_pad( $ch, 4 );
			$chcp = utf8ToCodepoint( $ch );
			# One Cantonese jyutping entry can have 7 bytes max ([a-z]{1,6}[1-6]).
			$ctj = str_pad( array_key_exists( $chcp, $data->cantonese ) ? $data->cantonese[$chcp] : '', 7 );
			$result .= $ctj . $c;
		}
		return $result;
	}
	
	function onCategoryMultisortSortkeys_buildStrokeSortkey( $data, $str ) {
		$result = '';
		foreach ( $this->onCategoryMultisortSortkeys_splitString( $str ) as $ch ) {
			# One UTF-8 character can have 4 bytes max.
			$c = str_pad( $ch, 4 );
			$chcp = utf8ToCodepoint( $ch );
			# One stroke entry always has 3 bytes, or blank if unavailable.
			$s = str_pad( $this->onCategoryMultisortSortkeys_getStroke( $data, $chcp ), 3 );
			$result .= $s . $c;
		}
		return $result;
	}
	
	function onCategoryMultisortSortkeys_buildRadicalSortkey( $data, $str ) {
		$result = '';
		foreach ( $this->onCategoryMultisortSortkeys_splitString( $str ) as $ch ) {
			# One UTF-8 character can have 4 bytes max.
			$c = str_pad( $ch, 4 );
			$chcp = utf8ToCodepoint( $ch );
			# One radical-stroke entry always has 3 (radical) + 3 (stroke) = 6 bytes, or blank if unavailable.
			$r = str_pad( $this->onCategoryMultisortSortkeys_getRadical( $data, $chcp ), 6 );
			$result .= $r . $c;
		}
		return $result;
	}
}
