<?php
/*
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Maciej Brencz <macbre(at)-spam-wikia.com>
 * @author Maciej Błaszkowski <marooned@wikia.com> - optimization
 */

if (!defined('MEDIAWIKI')) {
	exit( 1 );
}

class PagerWhosOnline extends IndexPager
{
	protected $mApiData;

	function __construct() {
		parent::__construct();

		$this->mApiData = array();
	}

	function getQueryInfo() {
		return array();
	}

	// use API instead of plain SQL query
	function reallyDoQuery( $offset, $limit, $descending ) {

		// update / remove report
		$FauxRequest = new FauxRequest(array (
		    'action'	=> 'query',
		    'list'	    => 'whosonline',
		    'wklimit'	=> intval($limit),
		    'wkoffset'	=> intval($offset)
		));

		$api = new ApiMain($FauxRequest);
		$api->execute();
		$data =& $api->GetResultData();

		// store API result
		$this->mApiData = $data;

		// we need to pretend we're using SQL queries
		$dbr  = wfGetDB( DB_SLAVE );

		return new ResultWrapper($dbr, false);
	}

	function getIndexField() {
		return ''; // dummy
	}

	// overload method to use API results
	function getBody() {
		if ( !$this->mQueryDone ) {
			$this->doQuery();
		}
		# Don't use any extra rows returned by the query
		$numRows = min( count($this->mApiData['query']['whosonline']), $this->mLimit );

		$s = $this->getStartBody();
		if ( $numRows ) {
			if ( $this->mIsBackwards ) {
				for ( $i = $numRows - 1; $i >= 0; $i-- ) {
					$row = $this->mApiData['query']['whosonline'][$i];
					$s .= $this->formatRow( $row );
				}
			} else {
				for ( $i = 0; $i < $numRows; $i++ ) {
					$row = $this->mApiData['query']['whosonline'][$i];
					$s .= $this->formatRow( $row );
				}
			}
		} else {
			$s .= $this->getEmptyBody();
		}
		$s .= $this->getEndBody();
		return $s;
	}


	function formatRow($row) {
		$userPageLink = Title::makeTitle(NS_USER, $row['user'])->getLocalURL();

		return '<li><a href="'.$userPageLink.'">' . htmlspecialchars($row['user']) . '</a></li>';
	}

	// extra methods
	function countUsersOnline() {
		return $this->mApiData['query']['users'];
	}

	function getNavigationBar() {
		global $wgContLang;

		return wfViewPrevNext(
			$this->mOffset,
			$this->mLimit,
			$wgContLang->specialpage('WhosOnline'),
			'',
			$this->countUsersOnline() < ($this->mLimit + $this->mOffset) // show next link
		);
	}
}

class SpecialWhosOnline extends SpecialPage
{
	public function SpecialWhosOnline() {
		parent::__construct('WhosOnline' );
	}

	public function execute( $para ) {
		global $wgRequest, $wgOut, $wgDBname;

		wfLoadExtensionMessages( 'WhosOnline' );

		$this->setHeaders();

		$pager = new PagerWhosOnline();
		$body = $pager->getBody();

		$wgOut->setSubtitle(wfMsg('whosonline-desc'));
		$wgOut->addHTML($pager->getNavigationBar());
		$wgOut->addHTML('<ul>'.$body.'</ul>');
	}
}