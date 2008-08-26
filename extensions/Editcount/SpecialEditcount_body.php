<?php
if (!defined('MEDIAWIKI')) die();

class Editcount extends IncludableSpecialPage {
	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'Editcount' );
	}

	/**
	 * main()
	 */
	public function execute( $par ) {
		global $wgRequest, $wgOut, $wgContLang;
		wfLoadExtensionMessages( 'Editcount' );

		$target = isset( $par ) ? $par : $wgRequest->getText( 'username' );

		list( $username, $namespace ) = $this->extractParamaters( $target );

		$username = Title::newFromText( $username );
		$username = is_object( $username ) ? $username->getText() : '';

		$uid = User::idFromName( $username );

		if ( $this->including() ) {
			if ( $namespace === null ) {
				if ($uid != 0)
					$out = $wgContLang->formatNum( User::edits( $uid ) );
				else
					$out = "";
			} else {
				$out = $wgContLang->formatNum( $this->editsInNs( $uid, $namespace ) );
			}
			$wgOut->addHTML( $out );
		} else {
			if ($uid != 0)
				$total = $this->getTotal( $nscount = $this->editsByNs( $uid ) );
			$html = new EditcountHTML;
			$html->outputHTML( $username, $uid, @$nscount, @$total );
		}
	}

	/**
	 * Parse the username and namespace parts of the input and return them
	 *
	 * @access private
	 *
	 * @param string $par
	 * @return array
	 */
	function extractParamaters( $par ) {
		global $wgContLang;

		@list($user, $namespace) = explode( '/', $par, 2 );

		// str*cmp sucks
		if ( isset( $namespace ) )
			$namespace = $wgContLang->getNsIndex( $namespace );

		return array( $user, $namespace );
	}

	/**
	 * Compute and return the total edits in all namespaces
	 *
	 * @access private
	 *
	 * @param array $nscount An associative array
	 * @return int
	 */
	function getTotal( $nscount ) {
		$total = 0;
		foreach ( array_values( $nscount ) as $i )
			$total += $i;

		return $total;
	}

	/**
	 * Count the number of edits of a user by namespace
	 *
	 * @param int $uid The user ID to check
	 * @return array
	 */
	function editsByNs( $uid ) {
		$fname = 'Editcount::editsByNs';
		$nscount = array();

		$dbr =& wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			array( 'user', 'revision', 'page' ),
			array( 'page_namespace', 'COUNT(*) as count' ),
			array(
				'user_id' => $uid,
				'rev_user = user_id',
				'rev_page = page_id'
			),
			$fname,
			array( 'GROUP BY' => 'page_namespace' )
		);

		while( $row = $dbr->fetchObject( $res ) ) {
			$nscount[$row->page_namespace] = $row->count;
		}

		return $nscount;
	}

	/**
	 * Count the number of edits of a user in a given namespace
	 *
	 * @param int $uid The user ID to check
	 * @param int $ns  The namespace to check
	 * @return string
	 */
	function editsInNs( $uid, $ns ) {
		$fname = 'Editcount::editsInNs';
		$nscount = array();

		$dbr =& wfGetDB( DB_SLAVE );
		$res = $dbr->selectField(
			array( 'user', 'revision', 'page' ),
			array( 'COUNT(*) as count' ),
			array(
				'user_id' => $uid,
				'page_namespace' => $ns,
				'rev_user = user_id',
				'rev_page = page_id'
			),
			$fname,
			array( 'GROUP BY' => 'page_namespace' )
		);

		return $res;
	}
}

class EditcountHTML extends Editcount {
	/**
	 * @access private
	 * @var array
	 */
	var $nscount;

	/**
	 * @access private
	 * @var int
	 */
	var $total;

	/**
	 * Output the HTML form on Special:Editcount
	 *
	 * @param string $username
	 * @param int    $uid
	 * @param array  $nscount
	 * @param int    $total
	 */
	function outputHTML( $username, $uid, $nscount, $total ) {
		$this->nscount = $nscount;
		$this->total = $total;

		global $wgTitle, $wgOut, $wgLang;

		$this->setHeaders();

		$action = $wgTitle->escapeLocalUrl();
		$user = wfMsgHtml( 'editcount_username' );
		$submit = wfMsgHtml( 'editcount_submit' );
		$out = "
		<form id='editcount' method='post' action=\"$action\">
			<table>
				<tr>
					<td>$user</td>
					<td><input tabindex='1' type='text' size='20' name='username' value=\"" . htmlspecialchars( $username ) . "\"/></td>
					<td><input type='submit' name='submit' value=\"$submit\"/></td>
				</tr>";
		if ($username != null && $uid != 0) {
			$editcounttable = $this->makeTable();
			$out .= "
				<tr>
					<td>&nbsp;</td>
					<td>$editcounttable</td>
					<td>&nbsp;</td>
				</tr>";
		}
		$out .="
			</table>
		</form>";
		$wgOut->addHTML( $out );
	}

	/**
	 * Make the editcount-by-namespaces HTML table
	 *
	 * @access private
	 */
	function makeTable() {
		global $wgLang;

		$total = wfMsgHtml( 'editcount_total' );
		$ftotal = $wgLang->formatNum( $this->total );
		$percent = $this->total > 0 ? wfPercent( $this->total / $this->total * 100 , 2 ) : wfPercent( 0 ); // @bug 4400
		$ret = "<table border='1' style='background-color: #fff; border: 1px #aaa solid; border-collapse: collapse;'>
				<tr>
					<th>$total</th>
					<th>$ftotal</th>
					<th>$percent</th>
				</tr>
		";

		foreach ($this->nscount as $ns => $edits) {
			$fedits = $wgLang->formatNum( $edits );
			$fns = $ns == NS_MAIN ? wfMsg( 'blanknamespace' ) : $wgLang->getFormattedNsText( $ns );
			$percent = wfPercent( $edits / $this->total * 100 );
			$fpercent = $wgLang->formatNum( $percent );
			$ret .="
				<tr>
					<td>$fns</td>
					<td>$fedits</td>
					<td>$fpercent</td>
				</tr>
			";
		}
		$ret .= "</table>
		";

		return $ret;
	}
}
