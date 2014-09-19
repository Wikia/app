<?php
/**
 * @file
 * @ingroup Profiler
 */

/**
 * ProfilerSimpleDataCollector class, that collects the standard profiling data
 * and lets senders to be attached later
 *
 * @ingroup Profiler
 */
class ProfilerSimpleDataCollector extends ProfilerSimple {

	public function logData() {
		$this->close();

		if ( isset( $this->mCollated['-total'] ) && $this->mCollated['-total']['real'] < $this->mMinimumTime ) {
			# Less than minimum, ignore
			return;
		}

		if ( !$this->hasSinks() ) {
			return;
		}

		$data = $this->buildProfilerPayload();
		$this->sendToSinks( $data );
	}

	protected function buildProfilerPayload() {
		$entries = array();
		foreach ( $this->mCollated as $name => $pfdata ) {
			if ( !isset( $pfdata['count'] )
				|| !isset( $pfdata['cpu'] )
				|| !isset( $pfdata['cpu_sq'] )
				|| !isset( $pfdata['real'] )
				|| !isset( $pfdata['real_sq'] )
			) {
				continue;
			}
			$entries[$name] = $pfdata;
		}

		$request = isset( $entries['-total'] ) ? $entries['-total'] : null;

		$data = new ProfilerData(
			ProfilerData::ENGINE_MEDIAWIKI,
			$this->getProfileID(),
			$request,
			$entries
		);

		return $data;
	}

}
