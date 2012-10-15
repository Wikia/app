<?php

/**
 * @deprecated since 1.14
 * @ingroup SpecialPage
 */
class LogReader {
	var $pager;

	/**
	 * @param $request WebRequest: for internal use use a FauxRequest object to pass arbitrary parameters.
	 *
	 * @deprecated since 1.14
	 */
	function __construct( $request ) {
		global $wgUser, $wgOut;
		wfDeprecated(__METHOD__);
		# Get parameters
		$type = $request->getVal( 'type' );
		$user = $request->getText( 'user' );
		$title = $request->getText( 'page' );
		$pattern = $request->getBool( 'pattern' );
		$year = $request->getIntOrNull( 'year' );
		$month = $request->getIntOrNull( 'month' );
		$tagFilter = $request->getVal( 'tagfilter' );
		# Don't let the user get stuck with a certain date
		$skip = $request->getText( 'offset' ) || $request->getText( 'dir' ) == 'prev';
		if( $skip ) {
			$year = '';
			$month = '';
		}
		# Use new list class to output results
		$loglist = new LogEventsList( $wgUser->getSkin(), $wgOut, 0 );
		$this->pager = new LogPager( $loglist, $type, $user, $title, $pattern, $year, $month, $tagFilter );
	}

	/**
	* Is there at least one row?
	* @return bool
	*/
	public function hasRows() {
		return isset($this->pager) ? ($this->pager->getNumRows() > 0) : false;
	}
}

/**
 * @deprecated since 1.14
 * @ingroup SpecialPage
 */
class LogViewer {
	const NO_ACTION_LINK = 1;

	/**
	 * LogReader object
	 */
	var $reader;

	/**
	 * @param &$reader LogReader: where to get our data from
	 * @param $flags Integer: Bitwise combination of flags:
	 *     LogEventsList::NO_ACTION_LINK   Don't show restore/unblock/block links
	 *
	 * @deprecated since 1.14
	 */
	function __construct( &$reader, $flags = 0 ) {
		wfDeprecated(__METHOD__);
		$this->reader =& $reader;
		$this->reader->pager->mLogEventsList->flags = $flags;
		# Aliases for shorter code...
		$this->pager =& $this->reader->pager;
		$this->list =& $this->reader->pager->mLogEventsList;
	}

	/**
	 * Take over the whole output page in $wgOut with the log display.
	 */
	public function show() {
		global $wgOut;
		# Set title and add header
		$this->list->showHeader( $this->pager->getType() );
		# Show form options
		$this->list->showOptions( $this->pager->getType(), $this->pager->getUser(), $this->pager->getPage(),
			$this->pager->getPattern(), $this->pager->getYear(), $this->pager->getMonth() );
		# Insert list
		$logBody = $this->pager->getBody();
		if( $logBody ) {
			$wgOut->addHTML(
				$this->pager->getNavigationBar() .
				$this->list->beginLogEventsList() .
				$logBody .
				$this->list->endLogEventsList() .
				$this->pager->getNavigationBar()
			);
		} else {
			$wgOut->addWikiMsg( 'logempty' );
		}
	}

	/**
	 * Output just the list of entries given by the linked LogReader,
	 * with extraneous UI elements. Use for displaying log fragments in
	 * another page (eg at Special:Undelete)
	 *
	 * @param $out OutputPage: where to send output
	 */
	public function showList( &$out ) {
		$logBody = $this->pager->getBody();
		if( $logBody ) {
			$out->addHTML(
				$this->list->beginLogEventsList() .
				$logBody .
				$this->list->endLogEventsList()
			);
		} else {
			$out->addWikiMsg( 'logempty' );
		}
	}
}
