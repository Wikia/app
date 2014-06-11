<?php
/**
 * Class WikiaInteractiveMapsBaseController
 */
class WikiaInteractiveMapsBaseController extends WikiaController {

	/**
	 * @var WikiaMaps
	 */
	protected $mapsModel;

	/**
	 * Keeps data needed while creating map/tile/poi process
	 * @var Array
	 */
	protected $data;

	public function __construct() {
		parent::__construct();
		$this->mapsModel = new WikiaMaps( $this->wg->IntMapConfig );
	}

	/**
	 * Getter for data we don't want expose outside
	 *
	 * @param String $name name of the data key
	 * @param Bool $default
	 *
	 * @return Mixed
	 */
	protected function getData( $name, $default = false ) {
		if( isset( $this->data[ $name ] ) ) {
			return $this->data[ $name ];
		}

		return $default;
	}

	/**
	 * Setter of data we don't want expose outside
	 *
	 * @param String $name
	 * @param Mixed $value
	 */
	protected function setData( $name, $value ) {
		$this->data[ $name ] = $value;
	}

	protected function getAllData() {
		return $this->data;
	}

}
