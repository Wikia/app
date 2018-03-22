<?php

namespace Onoi\HttpRequest\Tests;

/**
 * @codeCoverageIgnore
 * @see https://gist.github.com/ukolka/8448362
 */
class MockHttpStreamWrapper {

	public static $mockBodyData = '';
	public static $mockResponseCode = 'HTTP/1.1 200 OK';

	public $context;
	public $position = 0;
	public $bodyData = 'test data';
	public $responseCode = '';

	protected $streamArray = array();
	protected $options = array();
	protected $isOpen = false;

	/**
	 * StreamWrapper::stream_open
	 */
	public function stream_open( $path, $mode, $options, &$opened_path ) {
		$this->bodyData = self::$mockBodyData;
		$this->responseCode = self::$mockResponseCode;
		array_push( $this->streamArray, self::$mockResponseCode );
		$this->isOpen = true;
		return true;
	}

	/**
	 * StreamWrapper::stream_write
	 */
	public function stream_write( $data ) {

		if ( $this->isOpen ) {
			return strlen( $data );
		}

		return 0;
	}

	/**
	 * StreamWrapper::stream_read
	 */
	public function stream_read( $count ) {

		if ( $this->position > strlen($this->bodyData)) {
			return false;
		}

		$result = substr( $this->bodyData, $this->position, $count );
		$this->position += $count;
		return $result;
	}

	/**
	 * StreamWrapper::stream_eof
	 */
	public function stream_eof() {
		return $this->position >= strlen($this->bodyData);
	}

	/**
	 * StreamWrapper::stream_set_option
	 */
	public function stream_set_option( $option, $arg1, $arg2 ) {
		$this->options[$option] = array();
	}

	/**
	 * StreamWrapper::stream_stat
	 */
	public function stream_stat() {
		return array( 'wrapper_data' => array( 'test' ) );
	}

	/**
	 * StreamWrapper::stream_tell
	 */
	public function stream_tell() {
		return $this->position;
	}

}
