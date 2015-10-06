<?php

/**
 * Semantic watchlist page listing changes to watched properties.
 * 
 * @since 0.1
 * 
 * @file SemanticWatchlist.php
 * @ingroup SemanticWatchlist
 * 
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SpecialSemanticWatchlist extends SpecialPage {
	
	/**
	 * MediaWiki timestamp of when the watchlist was last viewed by the current user.
	 * 
	 * @since 0.1
	 * 
	 * @var integer
	 */
	protected $lastViewed;
	
	/**
	 * Constructor.
	 * 
	 * @since 0.1
	 */
	public function __construct() {
		parent::__construct( 'SemanticWatchlist', 'semanticwatch' );
	}
	
	/**
	 * @see SpecialPage::getDescription
	 * 
	 * @since 0.1
	 */
	public function getDescription() {
		return wfMsg( 'special-' . strtolower( $this->getName() ) );
	}
	
	/**
	 * Sets headers - this should be called from the execute() method of all derived classes!
	 * 
	 * @since 0.1
	 */
	public function setHeaders() {
		global $wgOut;
		$wgOut->setArticleRelated( false );
		$wgOut->setRobotPolicy( 'noindex,nofollow' );
		$wgOut->setPageTitle( $this->getDescription() );
	}	
	
	/**
	 * Main method.
	 * 
	 * @since 0.1
	 * 
	 * @param string $arg
	 */
	public function execute( $subPage ) {
		global $wgOut, $wgUser;
		
		$this->setHeaders();
		$this->outputHeader();
		
		// If the user is authorized, display the page, if not, show an error.
		if ( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}
		
		$this->registerUserView( $wgUser );
		
		$wgOut->addHTML( '<p>' );
		
		if ( $wgUser->isAllowed( 'semanticwatchgroups' ) ) {
			$wgOut->addHTML( wfMsgExt( 'swl-watchlist-can-mod-groups', 'parseinline', 'Special:WatchlistConditions' ) . '&#160' );
		}
		
		if ( $this->userHasWatchlistGroups( $wgUser ) ) {
			$wgOut->addHTML( wfMsgExt( 'swl-watchlist-can-mod-prefs', 'parseinline', 'Special:Preferences#prefsection-swl' ) );
			$wgOut->addHTML( '</p>' );
			
			$this->getAndDisplaySets( $subPage );
		}
		else {
			$wgOut->addHTML( wfMsgExt( 'swl-watchlist-no-groups', 'parseinline', 'Special:Preferences#prefsection-swl' ) );
			$wgOut->addHTML( '</p>' );
		}
	}
	
	/**
	 * Obtains the change sets and displays them by calling displayWatchlist.
	 * Also takes care of pagination and displaying appropriate message when there are no results.
	 * 
	 * @since 0.1
	 * 
	 * @param string $subPage
	 */
	protected function getAndDisplaySets( $subPage ) {
		global $wgRequest, $wgOut, $wgLang;
		
		$limit = $wgRequest->getInt( 'limit', 20 );
		$offset = $wgRequest->getInt( 'offset', 0 );
		$continue = $wgRequest->getVal( 'continue' );
		
		$changeSetData = $this->getChangeSetsData( $limit, $continue );
		
		$sets = array();
		
		foreach ( $changeSetData['sets'] as $set ) {
			$sets[] = SWLChangeSet::newFromArray( $set );
		}		
		
		$newContinue = false;
		
		if ( array_key_exists( 'query-continue', $changeSetData ) ) {
			$newContinue = $changeSetData['query-continue']['semanticwatchlist']['swcontinue'];
		}
		
		if ( $offset != 0 || count( $sets ) > 0 ) {
			$wgOut->addHTML( '<p>' . wfMsgExt(
				'swl-watchlist-position',
				array( 'parseinline' ),
				$wgLang->formatNum( count( $sets ) ),
				$wgLang->formatNum( $offset + 1 )
			) . '</p>' );
			
			$wgOut->addHTML( $this->getPagingControlHTML( $limit, $continue, $subPage, $newContinue, $offset ) );
		}
		
		if ( count( $sets ) > 0 ) {
			$this->displayWatchlist( $sets );
		}
		else {
			$wgOut->addWikiMsg( 'swl-watchlist-no-items' );
		}		
	}
	
	/**
	 * Register the user viewed the watchlist,
	 * so we know that following chnages should
	 * result into notification emails is desired.
	 * 
	 * @since 0.1
	 * 
	 * @param User $user
	 */
	protected function registerUserView( User $user ) {
		$this->lastViewed = $user->getGlobalAttribute( 'swl_last_view' );

		if ( is_null( $this->lastViewed ) ) {
			$this->lastViewed = wfTimestampNow();
		}

		$user->setGlobalAttribute( 'swl_last_view', wfTimestampNow() );
		$user->setGlobalAttribute( 'swl_mail_count',0 );
		$user->saveSettings();
	}
	
	/**
	 * @since 0.1
	 * 
	 * @return string
	 */
	protected function getPagingControlHTML( $limit, $currentContinue, $subPage, $newContinue, $offset ) {
		global $wgLang;
		
		$nextMsg = wfMsgExt( 'nextn', array( 'parsemag', 'escape' ), $limit );
		$firstMsg = wfMsgExt( 'swl-watchlist-firstn', array( 'parsemag', 'escape' ), $limit );
		
		if ( $newContinue === false ) {
			$nextLink = $nextMsg;
		}
		else {
			$nextLink = Html::element(
				'a',
				array(
					'href' => $this->getTitle( $subPage )->getLocalURL( wfArrayToCGI( array(
						'limit' => $limit,
						'continue' => $newContinue,
						'offset' => $offset + $limit
					) ) ),
					'title' => wfMsgExt( 'nextn-title', array( 'parsemag', 'escape' ), $limit ),
					'class' => 'mw-nextlink'
				),
				$nextMsg
			);
		}
		
		$limitLinks = array();
		$limitLinkArgs = array();
		
		if ( $currentContinue == '' ) {
			$firstLink = $firstMsg;
		}
		else {
			$limitLinkArgs['continue'] = $currentContinue;
			
			$firstLink = Html::element(
				'a',
				array(
					'href' => $this->getTitle( $subPage )->getLocalURL( wfArrayToCGI( array( 'limit' => $limit ) ) ),
					'title' => wfMsgExt( 'swl-watchlist-firstn-title', array( 'parsemag', 'escape' ), $limit )
				),
				$firstMsg
			);			
		}
		
		foreach ( array( 20, 50, 100, 250, 500 ) as $limitValue ) {
			$limitLinkArgs['limit'] = $limitValue;
			if ( $offset != 0 ) {
				$limitLinkArgs['offset'] = $offset;
			}
			
			$limitLinks[] = Html::element(
				'a',
				array(
					'href' => $this->getTitle( $subPage )->getLocalURL( wfArrayToCGI( $limitLinkArgs ) ),
					'title' => wfMsgExt( 'shown-title', array( 'parsemag', 'escape' ), $limitValue )
				),
				$wgLang->formatNum( $limitValue )
			);
		}
		
		return Html::rawElement(
			'p',
			array(),
			wfMsgHtml( 'swl-watchlist-pagincontrol', $wgLang->pipeList( array( $firstLink, $nextLink ) ), $wgLang->pipeList( $limitLinks ) )
		);
	}
	
	/**
	 * Displays the watchlist.
	 * 
	 * @since 0.1
	 * 
	 * @param array of SWLChangeSet $sets
	 */
	protected function displayWatchlist( array $sets ) {
		global $wgOut, $wgLang;
		
		$changeSetsHTML = array();
		
		foreach ( $sets as /* SWLChangeSet */ $set ) {
			$dayKey = substr( $set->getEdit()->getTime(), 0, 8 ); // Get the YYYYMMDD part.
			
			if ( !array_key_exists( $dayKey, $changeSetsHTML ) ) {
				$changeSetsHTML[$dayKey] = array();
			}
			
			$changeSetsHTML[$dayKey][] = $this->getChangeSetHTML( $set );
		}
		
		krsort( $changeSetsHTML );
		
		foreach ( $changeSetsHTML as $dayKey => $daySets ) {
			$wgOut->addHTML( Html::element(
				'h4',
				array(),
				$wgLang->date( str_pad( $dayKey, 14, '0' ) )
			) );
			
			$wgOut->addHTML( '<ul>' );
			
			foreach ( $daySets as $setHTML ) {
				$wgOut->addHTML( $setHTML );
			}
			
			$wgOut->addHTML( '</ul>' );
		}
		
		SMWOutputs::commitToOutputPage( $wgOut );
		
		$wgOut->addModules( 'ext.swl.watchlist' );
	}
	
	/**
	 * Returns the response of an internal request to the API semanticwatchlist query module.
	 * 
	 * @since 0.1
	 * 
	 * @param integer $limit
	 * @param string $continue
	 * 
	 * @return array
	 */
	protected function getChangeSetsData( $limit, $continue ) {
		$requestData = array(
			'action' => 'query',
			'list' => 'semanticwatchlist',
			'format' => 'json',
			'swuserid' => $GLOBALS['wgUser']->getId(),
			'swlimit' => $limit,
			'swcontinue' => $continue,
			'swmerge' => '1'
		);
		
		$api = new ApiMain( new FauxRequest( $requestData, true ), true );
		$api->execute();
		return $api->getResultData();
	}
	
	/**
	 * Gets the HTML for a single change set (edit).
	 * 
	 * @since 0.1
	 * 
	 * @param SWLChangeSet $changeSet
	 * 
	 * @return string
	 */
	protected function getChangeSetHTML( SWLChangeSet $changeSet ) {
		global $wgLang;
		
		$edit = $changeSet->getEdit();
		
		$html = '';
		
		$html .= '<li>';
		
		$html .= 
			'<p>' .
				$wgLang->time( $edit->getTime(), true ) . ' ' .
				Html::element(
					'a',
					array( 'href' => $edit->getTitle()->getLocalURL() ),
					$edit->getTitle()->getText()
				) . ' (' .
				Html::element(
					'a',
					array( 'href' => $edit->getTitle()->getLocalURL( 'action=history' ) ),
					wfMsg( 'hist' )
				) . ') . . ' .
				Html::element(
					'a',
					array( 'href' => $edit->getUser()->getUserPage()->getLocalURL() ),
					$edit->getUser()->getName()
				) . ' (' .
				Html::element(
					'a',
					array( 'href' => $edit->getUser()->getTalkPage()->getLocalURL() ),
					wfMsg( 'talkpagelinktext' )
				) . ' | ' .
				( $edit->getUser()->isAnon() ? '' :
					Html::element(
						'a',
						array( 'href' => SpecialPage::getTitleFor( 'Contributions', $edit->getUser()->getName() )->getLocalURL() ),
						wfMsg( 'contribslink' )						
					) . ' | '
				) .
				Html::element(
					'a',
					array( 'href' => SpecialPage::getTitleFor( 'Block', $edit->getUser()->getName() )->getLocalURL() ),
					wfMsg( 'blocklink' )
				) . ')' .
				( $edit->getTime() > $this->lastViewed ? ' [NEW]' : '' )	.
			'</p>'
		;
		
		$propertyHTML= array();
		
		foreach ( $changeSet->getAllProperties() as /* SMWDIProperty */ $property ) {
			$propertyHTML[] = $this->getPropertyHTML( $property, $changeSet->getAllPropertyChanges( $property ) );
		}
		
		$html .= implode( '', $propertyHTML );
		
		$html .=  '</li>';
		
		return $html;
	}
	
	/**
	 * Returns the HTML for the changes to a single propety.
	 * 
	 * @param SMWDIProperty $property
	 * @param array of SWLPropertyChange $changes
	 * 
	 * @return string
	 */
	protected function getPropertyHTML( SMWDIProperty $property, array $changes ) {
		$insertions = array();
		$deletions = array();
		
		// Convert the changes into a list of insertions and a list of deletions.
		foreach ( $changes as /* SWLPropertyChange */ $change ) {
			if ( !is_null( $change->getOldValue() ) ) {
				$deletions[] = SMWDataValueFactory::newDataItemValue( $change->getOldValue(), $property )->getLongHTMLText();
			}
			if ( !is_null( $change->getNewValue() ) ) {
				$insertions[] = SMWDataValueFactory::newDataItemValue( $change->getNewValue(), $property )->getLongHTMLText();
			}
		}
		
		$lines = array();
		
		if ( count( $deletions ) > 0 ) {
			$lines[] = Html::element( 'div', array( 'class' => 'swl-watchlist-deletions' ), wfMsg( 'swl-watchlist-deletions' ) ) . ' ' . implode( ', ', $deletions );
		}		
		
		if ( count( $insertions ) > 0 ) {
			$lines[] = Html::element( 'div', array( 'class' => 'swl-watchlist-insertions' ), wfMsg( 'swl-watchlist-insertions' ) ) . ' ' . implode( ', ', $insertions );
		}
		
		$html = Html::element( 'span', array( 'class' => 'swl-watchlist-prop' ), $property->getLabel() );
		
		$html .= Html::rawElement(
			'div',
			array( 'class' => 'swl-prop-div' ),
			implode( '<br />', $lines )
		);
		
		return $html;
	}
	
	/**
	 * Rteurns if the specified user has any watchlist groups in his notification list.
	 * 
	 * @since 0.1
	 * 
	 * @param User $user
	 * 
	 * @return boolean
	 */
	protected function userHasWatchlistGroups( User $user ) {
		if ( !$user->isLoggedIn() ) {
			return false;
		}
		
		$dbr = wfGetDB( DB_SLAVE );
		
		$group = $dbr->selectRow(
			'swl_users_per_group',
			array( 'upg_group_id' ),
			array( 'upg_user_id' => $user->getId() )
		);
		
		return $group !== false;
	}
	
}
