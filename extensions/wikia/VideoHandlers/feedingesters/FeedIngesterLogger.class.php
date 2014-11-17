<?php

class FeedIngesterLogger {

	protected $resultSummary = [
		'found'    => 0,
		'ingested' => 0,
		'skipped'  => 0,
		'warnings' => 0,
		'errors'   => 0,
	];

	protected $resultIngestedVideos = [
		'Games'         => [],
		'Entertainment' => [],
		'Lifestyle'     => [],
		'International' => [],
		'Other'         => [],
	];

	/**
	 * Set summary result for video found
	 * @param integer $num - the number of video found
	 */
	public function videoFound( $num ) {
		$msg = "Found $num videos.\n";
		$this->printAndSetResultSummary( 'found', $msg, $num );
	}

	/**
	 * Set summary result for skipped video
	 * @param string $msg
	 */
	public function videoSkipped( $msg = '' ) {
		$this->printAndSetResultSummary( 'skipped', $msg );
	}

	/**
	 * Set summary result for ingested video
	 * @param string $msg
	 * @param array $categories
	 */
	public function videoIngested( $msg = '', array $categories = [] ) {
		if ( !empty( $msg ) ) {
			$addedResult = false;
			foreach ( $categories as $category ) {
				if ( array_key_exists( $category, $this->resultIngestedVideos ) ) {
					$this->resultIngestedVideos[$category][] = $msg;
					$addedResult = true;
					break;
				}
			}

			// If this video is in some other category, make sure it still gets into the report
			if ( !$addedResult ) {
				$this->resultIngestedVideos['Other'][] = $msg;
			}
		}

		$msg .= "\n";
		$this->printAndSetResultSummary( 'ingested', $msg );
	}

	/**
	 * Set summary result for warnings
	 * @param string $msg
	 */
	public function videoWarnings( $msg = '' ) {
		$this->printAndSetResultSummary( 'warnings', $msg );
	}

	/**
	 * Set summary result for errors
	 * @param string $msg
	 */
	public function videoErrors( $msg = '' ) {
		$this->printAndSetResultSummary( 'errors', $msg );
	}

	/**
	 * Set summary result
	 * @param string $field [found/skipped/ingested/warnings/errors]
	 * @param string $msg
	 * @param integer $num
	 */
	public function printAndSetResultSummary( $field, $msg = '', $num = 1 ) {
		if ( !empty( $msg ) ) {
			echo $msg;
		}
		$this->resultSummary[$field] += $num;
	}

	/**
	 * Get summary result
	 * @return array
	 */
	public function getResultSummary() {
		return $this->resultSummary;
	}

	/**
	 * Get messages for ingested videos by category
	 * @return array
	 */
	public function getResultIngestedVideos() {
		return $this->resultIngestedVideos;
	}
}