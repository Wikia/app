<?php

/**
 * Pager for log entries
 */
class ServerAdminLogEntryPager extends ReverseChronologicalPager {

	/**
	 * Channel to filter entries to
	 *
	 * @var null|int
	 */
	protected $channel = null;

	/**
	 * Last date for an entry
	 *
	 * @var string
	 */
	protected $lastDate = '';

	/**
	 * Abstract formatting function. This should return an HTML string
	 * representing the result row $row. Rows will be concatenated and
	 * returned by getBody()
	 *
	 * @param $row Object: database row
	 * @return String
	 */
	function formatRow( $row ) {

		$time = $this->getLanguage()->time( wfTimestamp( TS_MW, $row->sale_timestamp ) );
		$message = htmlspecialchars( $row->sale_comment );

		// Link to the user if they're not anon
		if ( $row->sale_user == 0 ) {
			$user = $row->sale_user_text;
		} else {
			$userPage = Title::makeTitle( NS_USER, $row->user_name );
			$user = Linker::link( $userPage, htmlspecialchars( $userPage->getText() ) );
		}

		// Link to the channel name if the column is there
		if ( isset( $row->salc_name ) ) {
			$chanTitle = SpecialPage::getTitleFor( 'AdminLog', $row->salc_code );
			$channel = Linker::link( $chanTitle, htmlspecialchars( $row->salc_name ) );
			$channel = ' ' . $this->msg( 'parentheses' )->rawParams( $channel )->escaped();
		} else {
			$channel = '';
		}

		$html = "<li>{$time}{$channel} {$user}: ${message}</li>";

		$date = $this->getLanguage()->date( wfTimestamp( TS_MW, $row->sale_timestamp ) );
		if ( $date != $this->lastDate ) {
			$html = "<h2>$date</h2>\n<ul>\n$html";

			// Close the last list if there is one
			if ( $this->lastDate != '' ) {
				$html = "</ul>\n$html";
			}

			$this->lastDate = $date;
		}

		return $html;
	}

	protected function getStartBody() {
		return $this->getNavigationBar();
	}

	protected function getEndBody() {
		return '</ul>' . $this->getNavigationBar();
	}


	/**
	 * This function should be overridden to provide all parameters
	 * needed for the main paged query. It returns an associative
	 * array with the following elements:
	 *    tables => Table(s) for passing to Database::select()
	 *    fields => Field(s) for passing to Database::select(), may be *
	 *    conds => WHERE conditions
	 *    options => option array
	 *    join_conds => JOIN conditions
	 *
	 * @return Array
	 */
	function getQueryInfo() {
		$info = array(
			'tables' => array( 'sal_entry', 'sal_channel', 'user' ),
			'fields' => array(
				'sale_id', 'sale_user', 'sale_user_text',
				'sale_timestamp', 'sale_comment', 'user_name',
			),
			'join_conds' => array(
				'sal_channel' => array( 'LEFT JOIN', 'sale_channel = salc_id' ),
				'user' => array( 'LEFT JOIN', 'sale_user != 0 AND sale_user = user_id' ),
			),
			'options' => array(),
			'conds' => array(),
		);

		if ( $this->channel === null ) {
			// No channel!
			$info['fields'][] = 'salc_name';
			$info['fields'][] = 'salc_code';
		} else {
			// Has a channel, filter by it
			$info['conds'][] = 'sale_channel = ' . intval( $this->channel );
		}

		return $info;
	}

	/**
	 * Precache the user links
	 */
	protected function doBatchLookups() {
		parent::doBatchLookups();

		$this->mResult->rewind();
		$batch = new LinkBatch();
		foreach ( $this->mResult as $row ) {
			if ( $row->sale_user != 0 ) {
				$batch->addObj( Title::makeTitleSafe( NS_USER, $row->user_name ) );
			}
		}
		$batch->execute();
		$this->mResult->rewind();
	}

	/**
	 * This function should be overridden to return the name of the index fi-
	 * eld.  If the pager supports multiple orders, it may return an array of
	 * 'querykey' => 'indexfield' pairs, so that a request with &count=querykey
	 * will use indexfield to sort.  In this case, the first returned key is
	 * the default.
	 *
	 * Needless to say, it's really not a good idea to use a non-unique index
	 * for this!  That won't page right.
	 *
	 * @return string|Array
	 */
	function getIndexField() {
		return 'sale_id';
	}

	/**
	 * Sets the channel to filter
	 *
	 * @param int $channel
	 */
	public function setChannel( $channel ) {
		$this->channel = $channel;
	}
}
