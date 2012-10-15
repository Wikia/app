<?php

class CentralNoticeBannerLogPager extends CentralNoticeCampaignLogPager {
	var $viewPage, $special;

	function __construct( $special ) {
		$this->special = $special;
		parent::__construct($special);

		$this->viewPage = SpecialPage::getTitleFor( 'NoticeTemplate', 'view' );
	}

	/**
	 * Sort the log list by timestamp
	 */
	function getIndexField() {
		return 'tmplog_timestamp';
	}

	/**
	 * Pull log entries from the database
	 */
	function getQueryInfo() {
		return array(
			'tables' => array( 'cn_template_log' ),
			'fields' => '*',
		);
	}

	/**
	 * Generate the content of each table row (1 row = 1 log entry)
	 */
	function formatRow( $row ) {
		global $wgLang, $wgExtensionAssetsPath;

		// Create a user object so we can pull the name, user page, etc.
		$loggedUser = User::newFromId( $row->tmplog_user_id );
		// Create the user page link
		$userLink = $this->getSkin()->makeLinkObj( $loggedUser->getUserPage(),
			$loggedUser->getName() );
		$userTalkLink = $this->getSkin()->makeLinkObj( $loggedUser->getTalkPage(),
			wfMsg ( 'centralnotice-talk-link' ) );

		// Create the banner link
		$bannerLink = $this->getSkin()->makeLinkObj( $this->viewPage,
			htmlspecialchars( $row->tmplog_template_name ),
			'template=' . urlencode( $row->tmplog_template_name ) );

		// Begin log entry primary row
		$htmlOut = Xml::openElement( 'tr' );

		$htmlOut .= Xml::openElement( 'td', array( 'valign' => 'top' ) );
		if ( $row->tmplog_action !== 'removed' ) {
			$htmlOut .= '<a href="javascript:toggleLogDisplay(\''.$row->tmplog_id.'\')">'.
				'<img src="'.$wgExtensionAssetsPath.'/CentralNotice/collapsed.png" id="cn-collapsed-'.$row->tmplog_id.'" style="display:block;vertical-align:baseline;"/>'.
				'<img src="'.$wgExtensionAssetsPath.'/CentralNotice/uncollapsed.png" id="cn-uncollapsed-'.$row->tmplog_id.'" style="display:none;vertical-align:baseline;"/>'.
				'</a>';
		}
		$htmlOut .= Xml::closeElement( 'td' );
		$htmlOut .= Xml::tags( 'td', array( 'valign' => 'top', 'class' => 'primary' ),
			$wgLang->date( $row->tmplog_timestamp ) . ' ' . $wgLang->time( $row->tmplog_timestamp )
		);
		$htmlOut .= Xml::tags( 'td', array( 'valign' => 'top', 'class' => 'primary' ),
			wfMsg ( 'centralnotice-user-links', $userLink, $userTalkLink )
		);
		$htmlOut .= Xml::tags( 'td', array( 'valign' => 'top', 'class' => 'primary' ),
			wfMsg ( 'centralnotice-action-'.$row->tmplog_action )
		);
		$htmlOut .= Xml::tags( 'td', array( 'valign' => 'top', 'class' => 'primary' ),
			$bannerLink
		);
		$htmlOut .= Xml::tags( 'td', array(),
			'&nbsp;'
		);

		// End log entry primary row
		$htmlOut .= Xml::closeElement( 'tr' );

		if ( $row->tmplog_action !== 'removed' ) {
			// Begin log entry secondary row
			$htmlOut .= Xml::openElement( 'tr', array( 'id' => 'cn-log-details-'.$row->tmplog_id, 'style' => 'display:none;' ) );

			$htmlOut .= Xml::tags( 'td', array( 'valign' => 'top' ),
				'&nbsp;' // force a table cell in older browsers
			);
			$htmlOut .= Xml::openElement( 'td', array( 'valign' => 'top', 'colspan' => '5' ) );
			if ( $row->tmplog_action == 'created' ) {
				$htmlOut .= $this->showInitialSettings( $row );
			} elseif ( $row->tmplog_action == 'modified' ) {
				$htmlOut .= $this->showChanges( $row );
			}
			$htmlOut .= Xml::closeElement( 'td' );

			// End log entry primary row
			$htmlOut .= Xml::closeElement( 'tr' );
		}

		return $htmlOut;
	}

	function getStartBody() {
		$htmlOut = '';
		$htmlOut .= Xml::openElement( 'table', array( 'id' => 'cn-campaign-logs', 'cellpadding' => 3 ) );
		$htmlOut .= Xml::openElement( 'tr' );
		$htmlOut .= Xml::element( 'th', array( 'style' => 'width: 20px;' ) );
		$htmlOut .= Xml::element( 'th', array( 'align' => 'left', 'style' => 'width: 130px;' ),
			 wfMsg ( 'centralnotice-timestamp' )
		);
		$htmlOut .= Xml::element( 'th', array( 'align' => 'left', 'style' => 'width: 160px;' ),
			 wfMsg ( 'centralnotice-user' )
		);
		$htmlOut .= Xml::element( 'th', array( 'align' => 'left', 'style' => 'width: 100px;' ),
			 wfMsg ( 'centralnotice-action' )
		);
		$htmlOut .= Xml::element( 'th', array( 'align' => 'left', 'style' => 'width: 160px;' ),
			wfMsg ( 'centralnotice-banner' )
		);
		$htmlOut .= Xml::tags( 'td', array(),
			'&nbsp;'
		);
		$htmlOut .= Xml::closeElement( 'tr' );
		return $htmlOut;
	}

	/**
	 * Close table
	 */
	function getEndBody() {
		$htmlOut = '';
		$htmlOut .= Xml::closeElement( 'table' );
		return $htmlOut;
	}

	function showInitialSettings( $row ) {
		$details = '';
		$details .= wfMsg (
			'centralnotice-log-label',
			wfMsg ( 'centralnotice-anon' ),
			($row->tmplog_end_anon ? 'on' : 'off')
		)."<br/>";
		$details .= wfMsg (
			'centralnotice-log-label',
			wfMsg ( 'centralnotice-account' ),
			($row->tmplog_end_account ? 'on' : 'off')
		)."<br/>";
		$details .= wfMsg (
			'centralnotice-log-label',
			wfMsg ( 'centralnotice-fundraising' ),
			($row->tmplog_end_fundraising ? 'on' : 'off')
		)."<br/>";
		$details .= wfMsg (
			'centralnotice-log-label',
			wfMsg ( 'centralnotice-autolink' ),
			($row->tmplog_end_autolink ? 'on' : 'off')
		)."<br/>";
		if ( $row->tmplog_end_landingpages ) {
			$details .= wfMsg (
				'centralnotice-log-label',
				wfMsg ( 'centralnotice-landingpages' ),
				$row->tmplog_end_landingpages
			)."<br/>";
		}
		return $details;
	}

	function showChanges( $row ) {
		$details = $this->testBooleanChange( 'anon', $row );
		$details .= $this->testBooleanChange( 'account', $row );
		$details .= $this->testBooleanChange( 'fundraising', $row );
		$details .= $this->testBooleanChange( 'autolink', $row );
		$details .= $this->testTextChange( 'landingpages', $row );
		if ( $row->tmplog_content_change ) {
			// Show changes to banner content
			$details .= wfMsg (
				'centralnotice-log-label',
				wfMsg ( 'centralnotice-banner-content' ),
				wfMsg ( 'centralnotice-banner-content-changed' )
			)."<br/>";
		}
		return $details;
	}

	private function testBooleanChange( $param, $row ) {
		$result = '';
		$beginField = 'tmplog_begin_'.$param;
		$endField = 'tmplog_end_'.$param;
		if ( $row->$beginField !== $row->$endField ) {
			$result .= wfMsg (
				'centralnotice-log-label',
				wfMsg ( 'centralnotice-'.$param ),
				wfMsg (
					'centralnotice-changed',
					( $row->$beginField ? wfMsg ( 'centralnotice-on' ) : wfMsg ( 'centralnotice-off' ) ),
					( $row->$endField ? wfMsg ( 'centralnotice-on' ) : wfMsg ( 'centralnotice-off' ) )
				)
			)."<br/>";
		}
		return $result;
	}

	private function testTextChange( $param, $row ) {
		$result = '';
		$beginField = 'tmplog_begin_'.$param;
		$endField = 'tmplog_end_'.$param;
		if ( $row->$beginField !== $row->$endField ) {
			$result .= wfMsg (
				'centralnotice-log-label',
				wfMsg ( 'centralnotice-'.$param ),
				wfMsg (
					'centralnotice-changed',
					$row->$beginField,
					$row->$endField
				)
			)."<br/>";
		}
		return $result;
	}
}
