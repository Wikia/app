<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


class WCPropertyEnum extends WCParameterEnum {
	const title           = 0;
	const shortTitle      = 1;
	const place           = 2;
	const edition         = 3;
	const firstPage	      = 4;
	const version         = 5;
	const number          = 6;
	const archive         = 7;
	const jurisdiction    = 10;
	const keyword         = 11;

	const page            = 12;
	const pageRange       = 13;
	const volume          = 14;
	const issue           = 15;
	const opus            = 16;
	const bookLoc         = 17; # i.e., biblical "book," book III of Lord of the Rings, etc.
	const part            = 18;
	const chapterLoc      = 19;
	const folio           = 20;
	const column          = 21;
	const table           = 22;
	const figure          = 23;
	const section         = 24;
	const paragraph       = 25;
	const noteLoc         = 26;
		const footnote    = 27;
		const endnote     = 28;
	const verse           = 29;
	const line            = 30;
	const locator         = 31;

	const type            = 32;

	const link            = 33;
	const url             = 34;

	const callNumber      = 35;
	const doi             = 36;
	const isbn            = 37;

	const date            = 38;
	const accessed        = 39;
	const issued          = 40;
	const filed           = 41;

	const __default       = self::title;


	public static $title;
	public static $shortTitle;
	public static $place;
	public static $edition;
	public static $firstPage;
	public static $version;
	public static $number;
	public static $archive;
	public static $jurisdiction;
	public static $keyword;

	public static $page;
	public static $pageRange;
	public static $volume;
	public static $issue;
	public static $opus;
	public static $bookLoc; # i.e., biblical "book," book III of Lord of the Rings, etc.
	public static $part;
	public static $chapterLoc;
	public static $folio;
	public static $column;
	public static $table;
	public static $figure;
	public static $section;
	public static $paragraph;
	public static $noteLoc;
		public static $footnote;
		public static $endnote;
	public static $verse;
	public static $line;
	public static $locator;

	public static $type;

	public static $link;
	public static $url;

	public static $callNumber;
	public static $doi;
	public static $isbn;

	public static $date;
	public static $accessed;
	public static $issued;
	public static $filed;


	public static $magicWordKeys = array(
		self::title           => 'wc_title',
		self::shortTitle      => 'wc_short_title',
		self::place           => 'wc_place',
		self::edition         => 'wc_edition',
		self::firstPage	      => 'wc_first_page',
		self::version         => 'wc_version',
		self::number          => 'wc_number',
		self::archive         => 'wc_archive',
		self::jurisdiction    => 'wc_jurisdiction',
		self::keyword         => 'wc_keyword',

		self::page            => 'wc_page',
		self::pageRange       => 'wc_page_range',
		self::volume          => 'wc_volume',
		self::issue           => 'wc_issue',
		self::opus            => 'wc_opus',
		self::bookLoc         => 'wc_book_loc', # i.e., biblical "book," book III of Lord of the Rings, etc.
		self::part            => 'wc_part',
		self::chapterLoc      => 'wc_chapter_loc',
		self::folio           => 'wc_folio',
		self::column          => 'wc_column',
		self::table           => 'wc_table',
		self::figure          => 'wc_figure',
		self::section         => 'wc_section',
		self::paragraph       => 'wc_paragraph',
		self::noteLoc         => 'wc_note_loc',
			self::footnote    => 'wc_footnote',
			self::endnote     => 'wc_endnote',
		self::verse           => 'wc_verse',
		self::line            => 'wc_line',
		self::locator         => 'wc_locator',

		self::type            => 'wc_type',

		self::link            => 'wc_link',
		self::url             => 'wc_URL',

		self::callNumber      => 'wc_call_number',
		self::doi             => 'wc_DOI',
		self::isbn            => 'wc_ISBN',

		self::date            => 'wc_date',
		self::accessed        => 'wc_accessed',
		self::issued          => 'wc_issued',
		self::filed           => 'wc_filed',
	);

	public static $substitutes = array(
		self::title           => array( self::title, self::shortTitle ),
		self::shortTitle      => array( self::shortTitle, self::title ),
		self::place           => array( self::place ),
		self::edition         => array( self::edition ),
		self::firstPage       => array( self::firstPage ),
		self::version         => array( self::version ),
		self::number          => array( self::number ),
		self::archive         => array( self::archive ),
		self::jurisdiction    => array( self::jurisdiction ),
		self::keyword         => array( self::keyword ),

		self::page            => array( self::page, self::locator, self::pageRange ),
		self::pageRange       => array( self::pageRange, self::page ),
		self::volume          => array( self::volume ),
		self::issue           => array( self::issue ),
		self::opus            => array( self::opus ),
		self::bookLoc         => array( self::bookLoc ),
		self::part            => array( self::part ),
		self::chapterLoc      => array( self::chapterLoc ),
		self::folio           => array( self::folio, self::page ),
		self::column          => array( self::column ),
		self::table           => array( self::table ),
		self::figure          => array( self::figure ),
		self::section         => array( self::section ),
		self::paragraph       => array( self::paragraph ),
		self::noteLoc         => array( self::noteLoc, self::footnote, self::endnote ),
			self::footnote    => array( self::footnote, self::noteLoc ),
			self::endnote     => array( self::endnote, self::noteLoc ),
		self::verse           => array( self::verse ),
		self::line            => array( self::line ),
		self::locator         => array( self::locator, self::page ),

		self::type            => array( self::type ),

		self::link            => array( self::link ),
		self::url             => array( self::url ),

		self::callNumber      => array( self::callNumber ),
		self::doi             => array( self::doi ),
		self::isbn            => array( self::isbn ),

		self::date            => array( self::date, self::issued, self::filed, self::accessed ),
		self::accessed        => array( self::accessed, self::date ),
		self::issued          => array( self::issued, self::date ),
		self::filed           => array( self::filed, self::date ),
	);

	public static $attributeClasses = array(
		self::title           => WCAttributeEnum::title,
		self::shortTitle      => WCAttributeEnum::title,
		self::place           => WCAttributeEnum::text,
		self::edition         => WCAttributeEnum::text,
		self::firstPage       => WCAttributeEnum::locator,
		self::version         => WCAttributeEnum::text,
		self::number          => WCAttributeEnum::text,
		self::archive         => WCAttributeEnum::text,
		self::jurisdiction    => WCAttributeEnum::text,
		self::keyword         => WCAttributeEnum::text,

		self::page            => WCAttributeEnum::locator,
		self::pageRange       => WCAttributeEnum::locator,
		self::volume          => WCAttributeEnum::locator,
		self::issue           => WCAttributeEnum::locator,
		self::opus            => WCAttributeEnum::locator,
		self::bookLoc         => WCAttributeEnum::locator,
		self::part            => WCAttributeEnum::locator,
		self::chapterLoc      => WCAttributeEnum::locator,
		self::folio           => WCAttributeEnum::locator,
		self::column          => WCAttributeEnum::locator,
		self::table           => WCAttributeEnum::locator,
		self::figure          => WCAttributeEnum::locator,
		self::section         => WCAttributeEnum::locator,
		self::paragraph       => WCAttributeEnum::locator,
		self::noteLoc         => WCAttributeEnum::locator,
			self::footnote    => WCAttributeEnum::locator,
			self::endnote     => WCAttributeEnum::locator,
		self::verse           => WCAttributeEnum::locator,
		self::line            => WCAttributeEnum::locator,
		self::locator         => WCAttributeEnum::locator,

		self::type            => WCAttributeEnum::parameter,

		self::link            => WCAttributeEnum::text,
		self::url             => WCAttributeEnum::text,

		self::callNumber      => WCAttributeEnum::text,
		self::doi             => WCAttributeEnum::text,
		self::isbn            => WCAttributeEnum::text,

		self::date            => WCAttributeEnum::date,
		self::accessed        => WCAttributeEnum::date,
		self::issued          => WCAttributeEnum::date,
		self::filed           => WCAttributeEnum::date,
	);

	public static $magicWordArray;
	public static $flipMagicWordKeys = array();

	protected $attributeEnum;

	public static function init() {
		parent::init( self::$magicWordKeys, self::$substitutes,
				self::$magicWordArray, self::$flipMagicWordKeys );
		self::$title           = new self( self::title );
		self::$shortTitle      = new self( self::shortTitle );
		self::$place           = new self( self::place );
		self::$edition         = new self( self::edition );
		self::$firstPage       = new self( self::firstPage );
		self::$version         = new self( self::version );
		self::$number          = new self( self::number );
		self::$archive         = new self( self::archive );
		self::$jurisdiction    = new self( self::jurisdiction );
		self::$keyword         = new self( self::keyword );

		self::$page            = new self( self::page );
		self::$pageRange       = new self( self::pageRange );
		self::$volume          = new self( self::volume );
		self::$issue           = new self( self::issue );
		self::$opus            = new self( self::opus );
		self::$bookLoc         = new self( self::bookLoc );
		self::$part            = new self( self::part );
		self::$chapterLoc      = new self( self::chapterLoc );
		self::$folio           = new self( self::folio );
		self::$column          = new self( self::column );
		self::$table           = new self( self::table );
		self::$figure          = new self( self::figure );
		self::$section         = new self( self::section );
		self::$paragraph       = new self( self::paragraph );
		self::$noteLoc         = new self( self::noteLoc );
			self::$footnote    = new self( self::footnote );
			self::$endnote     = new self( self::endnote );
		self::$verse           = new self( self::verse );
		self::$line            = new self( self::line );
		self::$locator         = new self( self::locator );

		self::$type            = new self( self::type );

		self::$link            = new self( self::link );
		self::$url             = new self( self::url );

		self::$callNumber      = new self( self::callNumber );
		self::$doi             = new self( self::doi );
		self::$isbn            = new self( self::isbn );

		self::$date            = new self( self::date );
		self::$accessed        = new self( self::accessed );
		self::$issued          = new self( self::issued );
		self::$filed           = new self( self::filed );
	}

	/**
	 * Identity the appropriate WCAttributeEnum for this property.
	 * 
	 * @return WCAttributeEnum
	 */
	public function getAttribute() {
		return new WCAttributeEnum( self::$attributeClasses[ $this->key ] );
	}

	/**
	 * Delete when moving to PHP 3.3 and use late static binding in WCParameterEnum.
	 */
	public function __construct( $key = self::__default ) {
		parent::__construct( $key );
		$subs = &self::$substitutes[ $this->key ];
		if ( $subs ) {
			$this->substituteArray = $subs;
		}
	}
	/**
	 * Delete when moving to PHP 3.3 and use late static binding in WCParameterEnum.
	 */
	public static function match( $parameterText ) {
		$id = self::$magicWordArray->matchStartToEnd( $parameterText );
		if ( $id ) {
			return new self( self::$flipMagicWordKeys[ $id ] );
		} else {
			return Null;
		}
	}
	/**
	 * Delete when moving to PHP 3.3 and use late static binding in WCParameterEnum.
	 */
	public static function matchVariable( $parameterText ) {
		list( $id, $var ) = self::$magicWordArray->matchVariableStartToEnd( $parameterText );
		if ( $id ) {
			return array( new self( self::$flipMagicWordKeys[ $id ] ), $var );
		} else {
			return Null;
		}
	}
	/**
	 * Delete when moving to PHP 3.3 and use late static binding in WCParameterEnum.
	 */
	public static function matchPrefix( $parameterText ) {
		$id = self::$magicWordArray->matchStartAndRemove( $parameterText );
		if ( $id ) {
			# Remove any initial punctuation or spaces
			$parameterText = preg_replace( '/^[\p{P}\p{Z}\p{C}]+/u', '', $parameterText );
			return array( new self( self::$flipMagicWordKeys[ $id ] ), $parameterText );
		} else {
			return array( Null, $parameterText );
		}
	}
	/**
	 * Delete when moving to PHP 3.3 and use late static binding in WCParameterEnum.
	 */
	public static function matchPartAndNumber( $parameterText ) {
		# Extract number and remove number, white spaces and punctuation.
		if ( preg_match( '/\d+/u', $parameterText, $matches ) ) {
			$numString = $matches[0];
			$num = (int) $numString;
			$parameterText = preg_replace( '/' . $numString . '|[\p{P}\p{Z}\p{C}]+/uS', '', $parameterText );
		} else {
			$num = 1;
		}
		# Match what remains.
		$id = self::$magicWordArray->matchStartToEnd( $parameterText );
		if ( $id ) {
			return array( new self( self::$flipMagicWordKeys[ $id ] ), $num );
		} else {
			return array( Null, $num );
		}
	}
	
	
}
WCPropertyEnum::init();
