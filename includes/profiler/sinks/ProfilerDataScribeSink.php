<?php

/**
 * Class ProfilerDataScribeSink implements sending profiling data via Scribe
 */
class ProfilerDataScribeSink implements ProfilerDataSink {

	/**
	 * Send data via Scribe
	 *
	 * @param ProfilerData $data
	 */
	public function send( ProfilerData $data ) {
		if ( !$this->checkDependencies() ) {
			return;
		}

		$scribeKey = $this->getScribeKey( $data->getEngine() );


		$data = array(
			'time' => microtime(true),
			'engine' => $data->getEngine(),
			'profile' => $data->getProfile(),
			'context' => Transaction::getAttributes(),
			'request' => $data->getRequest(),
			'entries' => $data->getEntries(),
		);

		$data = json_encode( $data );

		try {
			WScribeClient::singleton( $scribeKey )->send( $data );
		} catch ( TException $e ) {
			Wikia::log( __METHOD__, 'scribeClient exception', $e->getMessage() );
		}

	}

	/**
	 * Returns Scribe category key for given profiling engine
	 *
	 * @param $engine
	 * @return bool|string
	 */
	protected function getScribeKey( $engine ) {
		switch ( $engine ) {
			case ProfilerData::ENGINE_MEDIAWIKI:
				return 'mwprofiler_data';
				break;
			case ProfilerData::ENGINE_XHPROF:
				return 'xhprof_data';
				break;
		}
		return false;
	}

	/**
	 * Checks if the required extension is already loaded and initialized.
	 *
	 * @return bool
	 */
	protected function checkDependencies() {
		return is_callable( 'WScribeClient::singleton' );
	}

}
