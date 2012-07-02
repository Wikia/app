<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


class WCSourceTypeEnum extends WCParameterEnum {
	const general                     = 0;
	const book                        = 1;
		const dictionary              = 2;
		const encyclopedia            = 3;
	const periodical                  = 4;
		const magazine                = 5;
		const newspaper               = 6;
		const journal                 = 7;
	const entry                       = 8;
		const article                 = 9;
		const chapter                 = 10;
		const review                  = 11;
	const paper                       = 12;
		const manuscript              = 13;
		const musicalScore            = 14;
		const pamphlet                = 15;
		const conferencePaper         = 16;
		const thesis                  = 17;
		const report                  = 18;
		const poem                    = 19;
		const song                    = 20;
	const enactment                   = 21;
		const bill                    = 22;
		const statute                 = 23;
		const treaty                  = 24;
		const rule                    = 25;
		const regulation              = 26;
	const legalDocument               = 27;
		const patent                  = 28;
		const deed                    = 29;
		const governmentGrant         = 30;
		const filing                  = 31;
			const patentApplication   = 32;
			const regulatoryFiling    = 33;
	const litigation                  = 34;
		const legalOpinion            = 35;
		const legalCase               = 36;
	const graphic                     = 37;
		const photograph              = 38;
		const map                     = 39;
	const statement                   = 40;
		const pressRelease            = 41;
		const interview               = 42;
		const speech                  = 43;
		const personalCommunication   = 44;
	const internetResource            = 45;
		const webpage                 = 46;
		const post                    = 47;
	const production                  = 48;
		const motionPicture           = 49;
		const recording               = 50;
		const play                    = 51;
		const broadcast               = 52;
			const televisionBroadcast = 53;
			const radioBroadcast      = 54;
			const internetBroadcast   = 55;
	const object                      = 56;
		const star                    = 57;
		const gravestone              = 58;
		const monument                = 59;
		const realProperty            = 60;
	const __default                     = self::general;


	public static $general;
	public static $book;
		public static $dictionary;
		public static $encyclopedia;
	public static $periodical;
		public static $magazine;
		public static $newspaper;
		public static $journal;
	public static $entry;
		public static $article;
		public static $chapter;
		public static $review;
	public static $paper;
		public static $manuscript;
		public static $musicalScore;
		public static $pamphlet;
		public static $conferencePaper;
		public static $thesis;
		public static $report;
		public static $poem;
		public static $song;
	public static $enactment;
		public static $bill;
		public static $statute;
		public static $treaty;
		public static $rule;
		public static $regulation;
	public static $legalDocument;
		public static $patent;
		public static $deed;
		public static $governmentGrant;
		public static $filing;
			public static $patentApplication;
			public static $regulatoryFiling;
	public static $litigation;
		public static $legalOpinion;
		public static $legalCase;
	public static $graphic;
		public static $photograph;
		public static $map;
	public static $statement;
		public static $pressRelease;
		public static $interview;
		public static $speech;
		public static $personalCommunication;
	public static $internetResource;
		public static $webpage;
		public static $post;
	public static $production;
		public static $motionPicture;
		public static $recording;
		public static $play;
		public static $broadcast;
			public static $televisionBroadcast;
			public static $radioBroadcast;
			public static $internetBroadcast;
	public static $object;
		public static $star;
		public static $gravestone;
		public static $monument;
		public static $realProperty;


	public static $magicWordKeys = array(
		self::general                     => 'wc_general',
		self::book                        => 'wc_book',
			self::dictionary              => 'wc_dictionary',
			self::encyclopedia            => 'wc_encyclopedia',
		self::periodical                  => 'wc_periodical',
			self::magazine                => 'wc_magazine',
			self::newspaper               => 'wc_newspaper',
			self::journal                 => 'wc_journal',
		self::entry                       => 'wc_entry',
			self::article                 => 'wc_article',
			self::chapter                 => 'wc_chapter',
			self::review                  => 'wc_review',
		self::paper                       => 'wc_paper',
			self::manuscript              => 'wc_manuscript',
			self::musicalScore            => 'wc_musical_score',
			self::pamphlet                => 'wc_pamphlet',
			self::conferencePaper         => 'wc_conference_paper',
			self::thesis                  => 'wc_thesis',
			self::report                  => 'wc_report',
			self::poem                    => 'wc_poem',
			self::song                    => 'wc_song',
		self::enactment                   => 'wc_enactment',
			self::bill                    => 'wc_bill',
			self::statute                 => 'wc_statute',
			self::treaty                  => 'wc_treaty',
			self::rule                    => 'wc_rule',
			self::regulation              => 'wc_regulation',
		self::legalDocument               => 'wc_legal_document',
			self::patent                  => 'wc_patent',
			self::deed                    => 'wc_deed',
			self::governmentGrant         => 'wc_government_grant',
			self::filing                  => 'wc_filing',
				self::patentApplication   => 'wc_patent_application',
				self::regulatoryFiling    => 'wc_regulatory_filing',
		self::litigation                  => 'wc_litigation',
			self::legalOpinion            => 'wc_legal_opinion',
			self::legalCase               => 'wc_legal_case',
		self::graphic                     => 'wc_graphic',
			self::photograph              => 'wc_photograph',
			self::map                     => 'wc_map',
		self::statement                   => 'wc_statement',
			self::pressRelease            => 'wc_press_release',
			self::interview               => 'wc_interview',
			self::speech                  => 'wc_speech',
			self::personalCommunication   => 'wc_personal_communication',
		self::internetResource            => 'wc_internet_resource',
			self::webpage                 => 'wc_web_page',
			self::post                    => 'wc_post',
		self::production                  => 'wc_production',
			self::motionPicture           => 'wc_motion_picture',
			self::recording               => 'wc_recording',
			self::play                    => 'wc_play',
			self::broadcast               => 'wc_broadcast',
				self::televisionBroadcast => 'wc_television_broadcast',
				self::radioBroadcast      => 'wc_radio_broadcast',
				self::internetBroadcast   => 'wc_internet_broadcast',
		self::object                      => 'wc_object',
			self::star                    => 'wc_star',
			self::gravestone              => 'wc_gravestone',
			self::monument                => 'wc_monument',
			self::realProperty            => 'wc_real_property',
	);

	public static $substitutes = array (
		self::general                      => array( self::general ),
		self::book                         => array( self::book, self::general ),
			self::dictionary               => array( self::dictionary, self::encyclopedia, self::book ),
			self::encyclopedia             => array( self::encyclopedia, self::dictionary, self::book ),
		self::periodical                   => array( self::periodical, self::journal, self::general ),
			self::magazine                 => array( self::magazine, self::journal, self::periodical, self::general ),
			self::newspaper                => array( self::newspaper, self::journal, self::periodical, self::general ),
			self::journal                  => array( self::journal, self::periodical, self::general ),
		self::entry                        => array( self::entry, self::general ),
			self::article                  => array( self::article, self::entry ),
			self::chapter                  => array( self::chapter, self::entry ),
			self::review                   => array( self::review, self::article, self::entry ),
		self::paper                        => array( self::paper, self::general ),
			self::manuscript               => array( self::manuscript, self::paper, self::general ),
			self::musicalScore             => array( self::musicalScore, self::paper, self::general ),
			self::pamphlet                 => array( self::pamphlet, self::paper, self::general ),
			self::conferencePaper          => array( self::conferencePaper, self::paper, self::general ),
			self::thesis                   => array( self::thesis, self::paper, self::general ),
			self::report                   => array( self::report, self::paper, self::general ),
			self::poem                     => array( self::poem, self::paper, self::general ),
			self::song                     => array( self::song, self::paper, self::general ),
		self::enactment                    => array( self::enactment, self::general ),
			self::bill                     => array( self::bill, self::enactment, self::general ),
			self::statute                  => array( self::statute, self::enactment, self::general ),
			self::treaty                   => array( self::treaty, self::statute, self::enactment, self::general ),
			self::rule                     => array( self::rule, self::regulation, self::statute, self::enactment, self::general ),
			self::regulation               => array( self::regulation, self::statute, self::enactment, self::general ),
		self::legalDocument                => array( self::legalDocument, self::paper, self::general ),
			self::patent                   => array( self::patent, self::legalDocument, self::paper, self::general ),
			self::deed                     => array( self::deed, self::legalDocument, self::paper, self::general ),
			self::governmentGrant          => array( self::governmentGrant, self::legalDocument, self::paper, self::general ),
			self::filing                   => array( self::filing, self::legalDocument, self::paper, self::general ),
				self::patentApplication    => array( self::patentApplication, self::filing, self::legalDocument, self::paper, self::general ),
				self::regulatoryFiling     => array( self::regulatoryFiling, self::filing, self::legalDocument, self::paper, self::general ),
		self::litigation                   => array( self::litigation, self::general ),
			self::legalOpinion             => array( self::legalOpinion, self::legalCase, self::litigation, self::general ),
			self::legalCase                => array( self::legalCase, self::litigation, self::general ),
		self::graphic                      => array( self::graphic, self::paper, self::general ),
			self::photograph               => array( self::photograph, self::graphic, self::paper, self::general ),
			self::map                      => array( self::map, self::graphic, self::paper, self::general ),
		self::statement                    => array( self::statement, self::paper, self::general ),
			self::pressRelease             => array( self::pressRelease, self::statement, self::paper, self::general ),
			self::interview                => array( self::interview, self::statement, self::paper, self::general ),
			self::speech                   => array( self::speech, self::statement, self::paper, self::general ),
			self::personalCommunication    => array( self::personalCommunication, self::statement, self::paper, self::general ),
		self::internetResource             => array( self::internetResource, self::general ),
			self::webpage                  => array( self::webpage, self::internetResource, self::general ),
			self::post                     => array( self::post, self::internetResource, self::general ),
		self::production                   => array( self::production, self::general ),
			self::motionPicture            => array( self::motionPicture, self::production, self::general ),
			self::recording                => array( self::recording, self::production, self::general ),
			self::play                     => array( self::play, self::production, self::general ),
			self::broadcast                => array( self::broadcast, self::production, self::general ),
				self::televisionBroadcast  => array( self::televisionBroadcast, self::broadcast, self::production, self::general ),
				self::radioBroadcast       => array( self::radioBroadcast, self::broadcast, self::production, self::general ),
				self::internetBroadcast    => array( self::internetBroadcast, self::broadcast, self::production, self::webpage, self::general ),
		self::object                       => array( self::object, self::general ),
			self::star                     => array( self::star, self::object, self::general ),
			self::gravestone               => array( self::gravestone, self::object, self::general ),
			self::monument                 => array( self::monument, self::object, self::general ),
			self::realProperty             => array( self::realProperty, self::object, self::general )
	);

	public static $magicWordArray;
	public static $flipMagicWordKeys = array();

	public static function init() {
		parent::init( self::$magicWordKeys, self::$substitutes,
				self::$magicWordArray, self::$flipMagicWordKeys );
		self::$general                     = new self( self::general );
		self::$book                        = new self( self::book );
			self::$dictionary              = new self( self::dictionary );
			self::$encyclopedia            = new self( self::encyclopedia );
		self::$periodical                  = new self( self::periodical );
			self::$magazine                = new self( self::magazine );
			self::$newspaper               = new self( self::newspaper );
			self::$journal                 = new self( self::journal );
		self::$entry                       = new self( self::entry );
			self::$article                 = new self( self::article );
			self::$chapter                 = new self( self::chapter );
			self::$review                  = new self( self::review );
		self::$paper                       = new self( self::paper );
			self::$manuscript              = new self( self::manuscript );
			self::$musicalScore            = new self( self::musicalScore );
			self::$pamphlet                = new self( self::pamphlet );
			self::$conferencePaper         = new self( self::conferencePaper );
			self::$thesis                  = new self( self::thesis );
			self::$report                  = new self( self::report );
			self::$poem                    = new self( self::poem );
			self::$song                    = new self( self::song );
		self::$enactment                   = new self( self::enactment );
			self::$bill                    = new self( self::bill );
			self::$statute                 = new self( self::statute );
			self::$treaty                  = new self( self::treaty );
			self::$rule                    = new self( self::rule );
			self::$regulation              = new self( self::regulation );
		self::$legalDocument               = new self( self::legalDocument );
			self::$patent                  = new self( self::patent );
			self::$deed                    = new self( self::deed );
			self::$governmentGrant         = new self( self::governmentGrant );
			self::$filing                  = new self( self::filing );
				self::$patentApplication   = new self( self::patentApplication );
				self::$regulatoryFiling    = new self( self::regulatoryFiling );
		self::$litigation                  = new self( self::litigation );
			self::$legalOpinion            = new self( self::legalOpinion );
			self::$legalCase               = new self( self::legalCase );
		self::$graphic                     = new self( self::graphic );
			self::$photograph              = new self( self::photograph );
			self::$map                     = new self( self::map );
		self::$statement                   = new self( self::statement );
			self::$pressRelease            = new self( self::pressRelease );
			self::$interview               = new self( self::interview );
			self::$speech                  = new self( self::speech );
			self::$personalCommunication   = new self( self::personalCommunication );
		self::$internetResource            = new self( self::internetResource );
			self::$webpage                 = new self( self::webpage );
			self::$post                    = new self( self::post );
		self::$production                  = new self( self::production );
			self::$motionPicture           = new self( self::motionPicture );
			self::$recording               = new self( self::recording );
			self::$play                    = new self( self::play );
			self::$broadcast               = new self( self::broadcast );
				self::$televisionBroadcast = new self( self::televisionBroadcast );
				self::$radioBroadcast      = new self( self::radioBroadcast );
				self::$internetBroadcast   = new self( self::internetBroadcast );
		self::$object                      = new self( self::object );
			self::$star                    = new self( self::star );
			self::$gravestone              = new self( self::gravestone );
			self::$monument                = new self( self::monument );
			self::$realProperty            = new self( self::realProperty );
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
WCSourceTypeEnum::init();
