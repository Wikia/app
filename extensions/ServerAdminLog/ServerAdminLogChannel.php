<?php

/**
 * Channel object
 */
class ServerAdminLogChannel {

	/**
	 * Channel ID
	 *
	 * @var int
	 */
	protected $id = 0;

	/**
	 * Channel code
	 *
	 * @var string
	 */
	protected $code = '';

	/**
	 * Channel human readable name
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * Returns a channel instance by a code
	 *
	 * @param $code
	 * @return null|ServerAdminLogChannel
	 */
	public static function newFromCode( $code ) {
		$db = wfGetDB( DB_SLAVE );
		$row = $db->selectRow(
			'sal_channel',
			'*',
			array( 'salc_code' => $code ),
			__METHOD__
		);

		if ( $row === false ) {
			return null;
		}

		$channel = new self( $row );
		return $channel;
	}

	/**
	 * Constructor
	 *
	 * @param stdClass $row
	 */
	protected function __construct( $row ) {
		$this->id = $row->salc_id;

		if ( isset( $row->salc_code ) ) {
			$this->code = $row->salc_code;
		}

		if ( isset( $row->salc_name ) ) {
			$this->name = $row->salc_name;
		}
	}

	/**
	 * @return string
	 */
	public function getCode() {
		return $this->code;
	}

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

}
