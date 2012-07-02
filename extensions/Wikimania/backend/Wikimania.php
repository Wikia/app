<?php
/**
 * Manager class for this year's Wikimania
 */
class Wikimania {
	/**
	 * Singleton
	 * @var Wikimania
	 */
	private static $i = null;

	/**
	 * Payment handler
	 * @var Payment
	 */
	private $paymentClass;

	/**
	 * Year of Wikimania
	 * @var String
	 */
	private $year;

	/**
	 * Beginning registration date
	 * @var String
	 */
	private $openDate;

	/**
	 * Ending registration date
	 * @var String
	 */
	private $closeDate;

	/**
	 * Base currency code
	 * @var String
	 */
	private $baseCurrency;

	/**
	 * Country hosting Wikimania
	 * @var String
	 */
	private $country;

	/**
	 * Do a bit of delayed setup, based on this year's config
	 * @param $year int Year to host Wikimania for
	 */
	public static function hostWikimania( $year ) {
		if( !self::$i ) {
			global $wgWikimaniaConf, $wgExtensionMessagesFiles;
			if( !isset( $wgWikimaniaConf['year'] ) || $wgWikimaniaConf['year'] !== $year ) {
				throw new MWException( "Trying to host Wikimania for invalid $year\n" );
			}
			self::$i = new self( $wgWikimaniaConf );
			$wgExtensionmessagesFiles["wikimania-$year"] = dirname( __FILE__ ) .
				"/lang/Wikimania{$year}.i18n.php";
		} elseif( self::$i && self::$i->getYear() !== $year ) {
			throw new MWException( "Can only host one year at a time!\n" );
		}
	}

	/**
	 * Accessor for singleton
	 * @return Wikimania
	 */
	public static function getWikimania() {
		if( !self::$i ) {
			throw new MWException( "Tried to getWikimania() with no instance found. Did you forget hostWikimania()?\n" );
		}
		return self::$i;
	}

	/**
	 * Constructor. Use the singleton
	 * @param $conf Array A $wgWikimaniaConf array
	 */
	private function __construct( array $conf ) {
		$baseRequiredConf = array( 'year', 'openDate', 'closeDate', 'baseCurrency', 'country' );
		foreach( $baseRequiredConf as $confItem ) {
			if( !isset( $conf[$confItem] ) ) {
				throw new MWException( "Missing config item '$confItem'\n" );
			}
			$this->$confItem = $conf[$confItem];
		}
		$paymentClass = isset( $conf['paymentClass'] ) ? $conf['paymentClass'] : 'PaymentBogus';
		$this->paymentClass = new $paymentClass( $this );
	}

	/**
	 * Get the configured payment handler
	 * @return Payment
	 */
	public function getPaymentClass() {
		return $this->paymentClass;
	}

	/**
	 * Get the year hosting Wikimania
	 * @return int
	 */
	public function getYear() {
		return $this->year;
	}

	/**
	 * Get the date we're opening registration on
	 * @return String
	 */
	public function getOpenDate() {
		return $this->openDate;
	}

	/**
	 * Get the date we're closing registration on
	 * @return String
	 */
	public function getCloseDate() {
		return $this->closeDate;
	}

	/**
	 * Get the currency code that all prices are configured in
	 * @return String
	 */
	public function getBaseCurrency() {
		return $this->baseCurrency;
	}

	/**
	 * Get the country code of the country hosting Wikimania
	 * @return String
	 */
	public function getCountry() {
		return $this->country;
	}
}
