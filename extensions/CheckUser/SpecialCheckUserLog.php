<?php

class SpecialCheckUserLog extends SpecialPage {
	public function __construct() {
		parent::__construct( 'CheckUserLog', 'checkuser-log' );
	}

	function getCheckUserFormTitle() {
		if ( !isset( $this->checkUserFormTitle ) ) {
			$this->checkUserFormTitle = SpecialPage::getTitleFor('CheckUser');
		}
		return $this->checkUserFormTitle;
	}

	function execute( $par ) {
		$this->checkPermissions();

		$out = $this->getOutput();
		$request = $this->getRequest();
		$this->setHeaders();

		$type = $request->getVal( 'cuSearchType' );
		$target = $request->getVal( 'cuSearch' );
		$year = $request->getIntOrNull( 'year' );
		$month = $request->getIntOrNull( 'month' );
		$error = false;
		$dbr = wfGetDB( DB_SLAVE );
		$searchConds = false;

		if ( $type === null ) {
			$type = 'target';
		} elseif ( $type == 'initiator' ) {
			$user = User::newFromName( $target );
			if ( !$user || !$user->getID() ) {
				$error = 'checkuser-user-nonexistent';
			} else {
				$searchConds = array( 'cul_user' => $user->getID() );
			}
		} else /* target */ {
			$type = 'target';
			// Is it an IP?
			list( $start, $end ) = IP::parseRange( $target );
			if ( $start !== false ) {
				if ( $start == $end ) {
					$searchConds = array( 'cul_target_hex = ' . $dbr->addQuotes( $start ) . ' OR ' .
						'(cul_range_end >= ' . $dbr->addQuotes( $start ) . ' AND ' .
						'cul_range_start <= ' . $dbr->addQuotes( $end ) . ')'
					);
				} else {
					$searchConds = array(
						'(cul_target_hex >= ' . $dbr->addQuotes( $start ) . ' AND ' .
						'cul_target_hex <= ' . $dbr->addQuotes( $end ) . ') OR ' .
						'(cul_range_end >= ' . $dbr->addQuotes( $start ) . ' AND ' .
						'cul_range_start <= ' . $dbr->addQuotes( $end ) . ')'
					);
				}
			} else {
				// Is it a user?
				$user = User::newFromName( $target );
				if ( $user && $user->getID() ) {
					$searchConds = array(
						'cul_type' => array( 'userips', 'useredits' ),
						'cul_target_id' => $user->getID(),
					);
				} elseif ( $target ) {
					$error = 'checkuser-user-nonexistent';
				}
			}
		}

		$out->addHTML( Linker::linkKnown(
				$this->getCheckUserFormTitle(),
				$this->msg( 'checkuser-log-return' ) ) );
		
		$searchTypes = array( 'initiator', 'target' );
		$select = "<select name=\"cuSearchType\" style='margin-top:.2em;'>\n";
		foreach ( $searchTypes as $searchType ) {
			if ( $type == $searchType ) {
				$checked = 'selected="selected"';
			} else {
				$checked = '';
			}
			$caption = wfMsgHtml( 'checkuser-search-' . $searchType );
			$select .= "<option value=\"$searchType\" $checked>$caption</option>\n";
		}
		$select .= '</select>';

		$encTarget = htmlspecialchars( $target );
		$msgSearch = wfMsgHtml( 'checkuser-search' );
		$input = "<input type=\"text\" name=\"cuSearch\" value=\"$encTarget\" size=\"40\"/>";
		$msgSearchForm = wfMsgHtml( 'checkuser-search-form', $select, $input );
		$formAction = $this->getTitle()->escapeLocalURL();
		$msgSearchSubmit = '&#160;&#160;' . wfMsgHtml( 'checkuser-search-submit' ) . '&#160;&#160;';

		$s = "<form method='get' action=\"$formAction\">\n" .
			"<fieldset><legend>$msgSearch</legend>\n" .
			"<p>$msgSearchForm</p>\n" .
			"<p>" . Xml::dateMenu( $year, $month ) . "&#160;&#160;&#160;\n" .
			"<input type=\"submit\" name=\"cuSearchSubmit\" value=\"$msgSearchSubmit\"/></p>\n" .
			"</fieldset></form>\n";
		$out->addHTML( $s );

		if ( $error !== false ) {
			$out->wrapWikiMsg( '<div class="errorbox">$1</div>', $error );
			return;
		}

		$pager = new CheckUserLogPager( $this, $searchConds, $year, $month );
		$out->addHTML(
			$pager->getNavigationBar() .
			$pager->getBody() .
			$pager->getNavigationBar()
		);
	}
}
