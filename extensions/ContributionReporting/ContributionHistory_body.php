<?php
class ContributionHistory extends SpecialPage {
	function __construct() {
		parent::__construct( 'ContributionHistory' );
	}

	function execute( $language ) {
		global $wgRequest, $wgOut, $wgLang;

		# Emergency short cut until post donation comments are enabled
		$wgOut->redirect( SpecialPage::getTitleFor( 'FundraiserStatistics' )->getFullURL() );
		return;


		if ( !preg_match( '/^[a-z-]+$/', $language ) ) {
			$language = 'en';
		}
		$this->lang = Language::factory( $language );

		// Get request data
		$offset = $wgRequest->getIntOrNull( 'offset' );
		$show = 100;

		$this->setHeaders();

		$db = efContributionReportingConnection();

		$wgOut->addModules( 'ext.fundraiserstatistics.table' );

		// Paging controls
		$newer = $db->selectField( 'public_reporting', 'received',
			array_merge(
				array( 'received > ' . strtotime( 'July 1st 2011' ) ),
				( $offset !== null ? array( 'received > ' . $offset ) : array() )
			),
			__METHOD__,
			array(
				'ORDER BY' => 'received ASC',
				'LIMIT' => 1,
				'OFFSET' => $show
			)
		);
		$older = $db->selectField( 'public_reporting', 'received',
			array_merge(
				array( 'received > ' . strtotime( 'July 1st 2011' ) ),
				( $offset !== null ? array( 'received <= ' . $offset ) : array() )
			),
			__METHOD__,
			array(
				'ORDER BY' => 'received DESC',
				'LIMIT' => 1,
				'OFFSET' => $show
			)
		);

		$title = $this->getTitle( $language == 'en' ? null : $language );

		$pagingLinks = array();
		if( $offset !== null ) {
			$pagingLinks[] = Xml::element( 'a',
				array(
					'href' => $title->getFullURL( 'offset=' . $newer ),
				),
				$this->chMsg( 'contrib-hist-previous' )
			);
		}
		$pagingLinks[] = Xml::element( 'a',
			array(
				'href' => $title->getFullURL( 'offset=' . $older ),
			),
			$this->chMsg( 'contrib-hist-next' )
		);
		$pagingDiv = Xml::openElement( 'div',
				array( 'align' => 'right', 'style' => 'padding-bottom:20px' ) ) .
			$wgLang->pipeList( $pagingLinks ) .
			Xml::closeElement( 'div' );
		$output .= $pagingDiv;

		$output .= '<table style="width: 100%">';
		$output .= '<tr>';
		$output .= '<th width="60%">' . $this->chMsg( 'contrib-hist-name' ) . '</th>';
		$output .= '<th width="25%">' . $this->chMsg( 'contrib-hist-date' ) . '</th>';
		$output .= '<th width="15%" align="right">' . $this->chMsg( 'contrib-hist-amount' ) . '</th>';
		$output .= '</tr>';

		if ( $offset == null ) {
			$offset = $db->selectField( 'public_reporting', 'received',
				array( 'received > ' . strtotime( 'July 1st 2011' ) ),
				__METHOD__,
				array(
					'ORDER BY' => 'received DESC',
					'LIMIT' => 1
				)
			);
		}

		$url = SpecialPage::getTitleFor( 'ContributionHistory' )->getFullURL();

		$res = $db->select( 'public_reporting', '*',
			array_merge(
				array( 'received > ' . strtotime( 'July 1st 2011' ) ),
				( $offset !== null ? array( 'received <= ' . $offset ) : array() )
			),
			__METHOD__,
			array(
				'ORDER BY' => 'received DESC',
				'LIMIT' => $show
			)
		);
		$alt = true;
		foreach ( $res as $row ) {
			if ( $this->isTiny( $row ) ) {
				continue; // Skip over micro payments generally < $1
			}
			$contributionId = $row['contribution_id'];
			$name = $this->formatName( $row );

			$amount = $this->formatAmount( $row );
			$date = $this->formatDate( $row );

			$class = '';
			if ( $alt ) {
				$class = ' alt';
			}

			$output .= "<tr>";
			$output .= "<td class=\"left $class\"><a name=\"{$contributionId}\"></a><a href=\"{$url}?offset={$offset}#{$contributionId}\">{$name}</a></td>";
			$output .= "<td class=\"left $class\" style=\"width: 100px;\">$date</td>";
			$output .= "<td class=\"right $class\" style=\"width: 75px;\">$amount</td>";
			$output .= "</tr>";

			$alt = !$alt;
		}

		$output .= '</table>';

		$output .= $pagingDiv;

		header( 'Cache-Control: max-age=300,s-maxage=300' );
		$wgOut->addWikiText( '{{2009/Donate-header/' . $language . '}}' );
		$wgOut->addHTML( '<h1>' . $this->chMsg( 'contrib-hist-header' ) . '</h1>' );
		$wgOut->addWikiText( '<strong>{{2008/Contribution history introduction/' . $language . '}}</strong>' );
		$wgOut->addHTML( $output );
	}

	function chMsg( $key ) {
		return wfMsgExt( $key, array( 'escape', 'language' => $this->lang ) );
	}

	function formatName( $row ) {
		$name = htmlspecialchars( $row['name'] );
		if( !$name ) {
			$name = $this->chMsg( 'contrib-hist-anonymous' );
		}
		$name = '<strong>' . $name . '</strong>';

		if( $row['note'] && !$this->isTiny( $row ) ) {
			$name .= '<br />' . htmlspecialchars( $row['note'] );
		}

		return $name;
	}

	function isTiny( $row ) {
		$mins = array(
			'USD' => 1,
			'GBP' => 1, // $1.26
			'EUR' => 1, // $1.26
			'AUD' => 2, // $1.35
			'CAD' => 1, // $0.84
			'CHF' => 1, // $0.85
			'CZK' => 20, // $1.03
			'DKK' => 5, // $0.85
			'HKD' => 10, // $1.29
			'HUF' => 200, // $0.97
			'JPY' => 100, // $1
			'NZD' => 2, // $1.18
			'NOK' => 1, // $1.48
			'PLN' => 5, // $1.78
			'SGD' => 2, // $1.35
			'SEK' => 10, // $1.28
		);
		$currency = $row['original_currency'];
		if( $currency ) {
			$amount = $row['original_amount'];
		} else {
			$currency = 'USD';
			$amount = $row['converted_amount'];
		}
		if( isset( $mins[$currency] ) && $amount < $mins[$currency] ) {
			// Too small... don't show comments for 1-yen donations,
			// they tend to be disruptive.
			return true;
		} else {
			// dunno !
			return false;
		}
	}

	function formatDate( $row ) {
		$ts = wfTimestamp( TS_MW, $row['received'] );
		return $this->lang->timeanddate( $ts );
	}

	function formatAmount( $row ) {
		$converted = $row['converted_amount'];

		if ( $row['original_currency'] ) {
			$currency = $row['original_currency'];
			$amount = $row['original_amount'];
		} else {
			$currency = 'USD';
			$amount = $converted;
		}

		if ( $currency == 'JPY' ) {
			// No decimals for yen
			$amount = intval( $amount );
		}

		return Xml::element( 'span',
			array( 'title' => "USD " . $this->lang->formatNum( $converted ) ),
			"$currency " . $this->lang->formatNum( $amount ) );
	}
}
