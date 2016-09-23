<?php

class ChatBanTimeOptions {

	private static $FACTORS = [
		'seconds' => 1,
		'minutes' => 60,
		'hours' => 3600,
		'days' => 86400,
		'weeks' => 604800,
		'months' => 2592000,
		'years' => 31536000
	];

	private $textSource;
	private $items;

	public function __construct( $textSource ) {
		$this->textSource = $textSource;
		$this->parseSource();
	}

	public function get() {
		return $this->items;
	}

	private function parseSource() {
		$this->items = [ ];
		$inputItems = explode( ',', $this->textSource );
		foreach ( $inputItems as $inputItem ) {
			list( $label, $time ) = $this->parseItem( $inputItem );
			if ( $label !== null ) {
				$this->items[$label] = $time;
			}
		}
	}

	/**
	 * @param $inputItem
	 * @return array(string,int)
	 */
	private function parseItem( $inputItem ) {
		$split = explode( ':', $inputItem );
		if ( count( $split ) != 2 ) {
			return array( null, null );
		}

		$label = trim( $split[0] );
		$time = $this->parseTime( trim( $split[1] ) );
		if ( $time === null ) {
			return array( null, null );
		}

		return array( $label, $time );
	}

	/**
	 * @param $factorText
	 * @return int
	 */
	private function getFactor( $factorText ) {
		if ( isset( self::$FACTORS[$factorText] ) ) {
			return self::$FACTORS[$factorText];
		}
		if ( isset( self::$FACTORS[$factorText . 's'] ) ) {
			return self::$FACTORS[$factorText . 's'];
		}

		return null;
	}

	/**
	 * @param $timeText
	 * @return int|null
	 */
	private function parseTime( $timeText ) {
		if ( $timeText == 'infinite' ) {
			$time = 1000 * $this->getFactor( 'year' );
		} else {
			$split = explode( ' ', $timeText );
			if ( count( $split ) != 2 ) {
				return null;
			}

			$number = (int)trim( $split[0] );
			$factor = $this->getFactor( trim( $split[1] ) );;
			if ( $number < 1 || $factor < 1 ) {
				return null;
			}

			$time = $number * $factor;
		}

		return $time;
	}

	/**
	 * @return ChatBanTimeOptions
	 */
	public static function newDefault() {
		$textSource = wfMessage( 'chat-ban-option-list' )->inContentLanguage()->text();
		$textSource = preg_replace( '!\s+!', ' ', $textSource );

		return new self( $textSource );
	}

}
