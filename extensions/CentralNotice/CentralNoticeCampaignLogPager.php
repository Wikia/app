<?php

class CentralNoticeCampaignLogPager extends ReverseChronologicalPager {
	var $viewPage, $special;

	function __construct( $special ) {
		$this->special = $special;
		parent::__construct();

		// Override paging defaults
		list( $this->mLimit, /* $offset */ ) = $this->mRequest->getLimitOffset( 20, '' );
		$this->mLimitsShown = array( 20, 50, 100 );

		$this->viewPage = SpecialPage::getTitleFor( 'CentralNotice' );
	}

	/**
	 * Sort the log list by timestamp
	 */
	function getIndexField() {
	return 'notlog_timestamp';
	}

	/**
	 * Pull log entries from the database
	 */
	function getQueryInfo() {
		global $wgRequest;

		$filterStartDate = 0;
		$filterEndDate = 0;
		$startYear = $wgRequest->getVal( 'start_year' );
		if ( $startYear === 'other' ) $startYear = null;
		$startMonth = $wgRequest->getVal( 'start_month' );
		if ( $startMonth === 'other' ) $startMonth = null;
		$startDay = $wgRequest->getVal( 'start_day' );
		if ( $startDay === 'other' ) $startDay = null;
		$endYear = $wgRequest->getVal( 'end_year' );
		if ( $endYear === 'other' ) $endYear = null;
		$endMonth = $wgRequest->getVal( 'end_month' );
		if ( $endMonth === 'other' ) $endMonth = null;
		$endDay = $wgRequest->getVal( 'end_day' );
		if ( $endDay === 'other' ) $endDay = null;

		if ( $startYear && $startMonth && $startDay ) {
			$filterStartDate = $startYear . $startMonth . $startDay;
		}
		if ( $endYear && $endMonth && $endDay ) {
			$filterEndDate = $endYear . $endMonth . $endDay;
		}
		$filterCampaign = $wgRequest->getVal( 'campaign' );
		$filterUser = $wgRequest->getVal( 'user' );
		$reset = $wgRequest->getVal( 'centralnoticelogreset' );

		$info = array(
			'tables' => array( 'cn_notice_log' ),
			'fields' => '*',
			'conds' => array()
		);

		if ( !$reset ) {
			if ( $filterStartDate > 0 ) {
				$filterStartDate = intval( $filterStartDate.'000000' );
				$info['conds'][] = "notlog_timestamp >= $filterStartDate";
			}
			if ( $filterEndDate > 0 ) {
				$filterEndDate = intval( $filterEndDate.'000000' );
				$info['conds'][] = "notlog_timestamp < $filterEndDate";
			}
			if ( $filterCampaign ) {
				$info['conds'][] = "notlog_not_name LIKE '$filterCampaign'";
			}
			if ( $filterUser ) {
				$user = User::newFromName( $filterUser );
				$userId = $user->getId();
				$info['conds'][] = "notlog_user_id = $userId";
			}
		}

		return $info;
	}

	/**
	 * Generate the content of each table row (1 row = 1 log entry)
	 */
	function formatRow( $row ) {
		global $wgLang, $wgExtensionAssetsPath;

		// Create a user object so we can pull the name, user page, etc.
		$loggedUser = User::newFromId( $row->notlog_user_id );
		// Create the user page link
		$userLink = $this->getSkin()->makeLinkObj( $loggedUser->getUserPage(),
			$loggedUser->getName() );
		$userTalkLink = $this->getSkin()->makeLinkObj( $loggedUser->getTalkPage(),
			wfMsg ( 'centralnotice-talk-link' ) );

		// Create the campaign link
		$campaignLink = $this->getSkin()->makeLinkObj( $this->viewPage,
			htmlspecialchars( $row->notlog_not_name ),
			'method=listNoticeDetail&notice=' . urlencode( $row->notlog_not_name ) );

		// Begin log entry primary row
		$htmlOut = Xml::openElement( 'tr' );

		$htmlOut .= Xml::openElement( 'td', array( 'valign' => 'top' ) );
		if ( $row->notlog_action !== 'removed' ) {
			$htmlOut .= '<a href="javascript:toggleLogDisplay(\''.$row->notlog_id.'\')">'.
				'<img src="'.$wgExtensionAssetsPath.'/CentralNotice/collapsed.png" id="cn-collapsed-'.$row->notlog_id.'" style="display:block;"/>'.
				'<img src="'.$wgExtensionAssetsPath.'/CentralNotice/uncollapsed.png" id="cn-uncollapsed-'.$row->notlog_id.'" style="display:none;"/>'.
				'</a>';
		}
		$htmlOut .= Xml::closeElement( 'td' );
		$htmlOut .= Xml::tags( 'td', array( 'valign' => 'top', 'class' => 'primary' ),
			$wgLang->date( $row->notlog_timestamp ) . ' ' . $wgLang->time( $row->notlog_timestamp )
		);
		$htmlOut .= Xml::tags( 'td', array( 'valign' => 'top', 'class' => 'primary' ),
			wfMsg ( 'centralnotice-user-links', $userLink, $userTalkLink )
		);
		$htmlOut .= Xml::tags( 'td', array( 'valign' => 'top', 'class' => 'primary' ),
			wfMsg ( 'centralnotice-action-'.$row->notlog_action )
		);
		$htmlOut .= Xml::tags( 'td', array( 'valign' => 'top', 'class' => 'primary' ),
			$campaignLink
		);
		$htmlOut .= Xml::tags( 'td', array(),
			'&nbsp;'
		);

		// End log entry primary row
		$htmlOut .= Xml::closeElement( 'tr' );

		if ( $row->notlog_action !== 'removed' ) {
			// Begin log entry secondary row
			$htmlOut .= Xml::openElement( 'tr', array( 'id' => 'cn-log-details-'.$row->notlog_id, 'style' => 'display:none;' ) );

			$htmlOut .= Xml::tags( 'td', array( 'valign' => 'top' ),
				'&nbsp;' // force a table cell in older browsers
			);
			$htmlOut .= Xml::openElement( 'td', array( 'valign' => 'top', 'colspan' => '5' ) );
			if ( $row->notlog_action == 'created' ) {
				$htmlOut .= $this->showInitialSettings( $row );
			} elseif ( $row->notlog_action == 'modified' ) {
				$htmlOut .= $this->showChanges( $row );
			}
			$htmlOut .= Xml::closeElement( 'td' );

			// End log entry primary row
			$htmlOut .= Xml::closeElement( 'tr' );
		}

		return $htmlOut;
	}

	function showInitialSettings( $row ) {
		global $wgLang;
		$details = '';
		$details .= wfMsg (
			'centralnotice-log-label',
			wfMsg ( 'centralnotice-start-date' ),
			$wgLang->date( $row->notlog_end_start ).' '.$wgLang->time( $row->notlog_end_start )
		)."<br/>";
		$details .= wfMsg (
			'centralnotice-log-label',
			wfMsg ( 'centralnotice-end-date' ),
			$wgLang->date( $row->notlog_end_end ).' '.$wgLang->time( $row->notlog_end_end )
		)."<br/>";
		$details .= wfMsg (
			'centralnotice-log-label',
			wfMsg ( 'centralnotice-projects' ),
			$row->notlog_end_projects
		)."<br/>";
		$language_count = count( explode ( ', ', $row->notlog_end_languages ) );
		$languageList = '';
		if ( $language_count > 15 ) {
			$languageList = wfMsg ( 'centralnotice-multiple-languages', $language_count );
		} elseif ( $language_count > 0 ) {
			$languageList = $row->notlog_end_languages;
		}
		$details .= wfMsg (
			'centralnotice-log-label',
			wfMsg ( 'centralnotice-languages' ),
			$languageList
		)."<br/>";
		$details .= wfMsg (
			'centralnotice-log-label',
			wfMsg ( 'centralnotice-geo' ),
			($row->notlog_end_geo ? 'on' : 'off')
		)."<br/>";
		if ( $row->notlog_end_geo ) {
			$country_count = count( explode ( ', ', $row->notlog_end_countries ) );
			$countryList = '';
			if ( $country_count > 20 ) {
				$countryList = wfMsg ( 'centralnotice-multiple-countries', $country_count );
			} elseif ( $country_count > 0 ) {
				$countryList = $row->notlog_end_countries;
			}
			$details .= wfMsg (
				'centralnotice-log-label',
				wfMsg ( 'centralnotice-countries' ),
				$countryList
			)."<br/>";
		}
		return $details;
	}

	function showChanges( $row ) {
		global $wgLang;
		$details = '';
		if ( $row->notlog_begin_start !== $row->notlog_end_start ) {
			$details .= wfMsg (
				'centralnotice-log-label',
				wfMsg ( 'centralnotice-start-date' ),
				wfMsg (
					'centralnotice-changed',
					$wgLang->date( $row->notlog_begin_start ).' '.$wgLang->time( $row->notlog_begin_start ),
					$wgLang->date( $row->notlog_end_start ).' '.$wgLang->time( $row->notlog_end_start )
				)
			)."<br/>";
		}
		if ( $row->notlog_begin_end !== $row->notlog_end_end ) {
			$details .= wfMsg (
				'centralnotice-log-label',
				wfMsg ( 'centralnotice-end-date' ),
				wfMsg (
					'centralnotice-changed',
					$wgLang->date( $row->notlog_begin_end ).' '.$wgLang->time( $row->notlog_begin_end ),
					$wgLang->date( $row->notlog_end_end ).' '.$wgLang->time( $row->notlog_end_end )
				)
			)."<br/>";
		}
		$details .= $this->testBooleanChange( 'enabled', $row );
		$details .= $this->testBooleanChange( 'preferred', $row );
		$details .= $this->testBooleanChange( 'locked', $row );
		$details .= $this->testBooleanChange( 'geo', $row );
		$details .= $this->testSetChange( 'projects', $row );
		$details .= $this->testSetChange( 'languages', $row );
		$details .= $this->testSetChange( 'countries', $row );
		if ( $row->notlog_begin_banners !== $row->notlog_end_banners ) {
			// Show changes to banner weights and assignment
			$beginBannersObject = json_decode( $row->notlog_begin_banners );
			$endBannersObject = json_decode( $row->notlog_end_banners );
			$beginBanners = array();
			$endBanners = array();
			foreach( $beginBannersObject as $key => $weight ) {
				$beginBanners[$key] = $key.' ('.$weight.')';
			}
			foreach( $endBannersObject as $key => $weight ) {
				$endBanners[$key] = $key.' ('.$weight.')';
			}
			if ( $beginBanners ) {
				$before = implode( ', ', $beginBanners );
			} else {
				$before = wfMsg ( 'centralnotice-no-assignments' );
			}
			if ( $endBanners ) {
				$after = implode( ', ', $endBanners );
			} else {
				$after = wfMsg ( 'centralnotice-no-assignments' );
			}
			$details .= wfMsg (
				'centralnotice-log-label',
				wfMsg ( 'centralnotice-templates' ),
				wfMsg ( 'centralnotice-changed', $before, $after)
			)."<br/>";
		}
		return $details;
	}

	private function testBooleanChange( $param, $row ) {
		$result = '';
		$beginField = 'notlog_begin_'.$param;
		$endField = 'notlog_end_'.$param;
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

	private function testSetChange( $param, $row ) {
		$result = '';
		$beginField = 'notlog_begin_'.$param;
		$endField = 'notlog_end_'.$param;
		if ( $row->$beginField !== $row->$endField ) {
			$beginSet = array();
			$endSet = array();
			if ( $row->$beginField ) {
				$beginSet = explode( ', ', $row->$beginField );
			}
			if ( $row->$endField ) {
				$endSet = explode( ', ', $row->$endField );
			}
			$added = array_diff( $endSet, $beginSet );
			$removed = array_diff( $beginSet, $endSet );
			$differences = '';
			if ( $added ) {
				$differences .= wfMsg ( 'centralnotice-added', implode( ', ', $added ) );
				if ( $removed ) $differences .= '; ';
			}
			if ( $removed ) {
				$differences .= wfMsg ( 'centralnotice-removed', implode( ', ', $removed ) );
			}
			$result .= wfMsg (
				'centralnotice-log-label',
				wfMsg ( 'centralnotice-'.$param ),
				$differences
			)."<br/>";
		}
		return $result;
	}

	/**
	 * Specify table headers
	 */
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
			wfMsg ( 'centralnotice-notice' )
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

}
