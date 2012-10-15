<?php
class SpecialPremoderationWhiteList extends SpecialPage {
	protected $mParams = false;
	protected $mPosted = false;
	protected $mRequest = array();
	
	function __construct() {
		global $wgRequest;
		parent::__construct( 'PremoderationWhiteList', 'premoderation-wlist' );
		
		if( $wgRequest->wasPosted() ) {			
			$this->mPosted = true;
			$this->mRequest = $wgRequest->getValues();		
		}
	}
	
	public function execute( $subpage ) {
		global $wgUser, $wgOut;
		
		if( !$wgUser->isAllowed( 'premoderation-wlist' ) ) {
			$this->displayRestrictionError();
			return;
		}
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}
		
		$wgOut->setPageTitle( wfMsg( 'premoderationwhitelist' ) );
		$wgOut->addWikiMsg( 'premoderation-whitelist-intro' );
		
		$params = array_values( explode( '/', $subpage ) );
		$action = array_shift( &$params );
		
		if( $action == '' ) {
			$action = 'list';
		} elseif( $action == 'list' && isset( $params ) ) {
			$this->mParams = Premoderation::formatParams( $params );
		} else {
			$wgOut->setPageTitle( wfMsg( 'premoderation-manager-invalidaction' ) );
			$wgOut->addWikiMsg( 'premoderation-invalidaction' );
			return;
		}
		
		if( $this->mPosted ) {
			$msg = $this->updateList();			
			$wgOut->addHTML( '<p class="error">' . wfMsg( $msg ) . '</p>' );
		}
		
		$wgOut->addHTML( $this->getAddForm() );
		
		$whiteList = Premoderation::loadWhitelist();
		if( is_array( $whiteList ) ) {
			$output = '<table class="wikitable"><tr><th>' . wfMsg( 'premoderation-table-list-ip' ) .
				'</th><th>' . wfMsg( 'premoderation-table-list-delete' ) . '</th></tr>';
			foreach( $whiteList as $ip ) {
				$output .= '<tr><td>' . $ip . '</td>' .
					'<td>' . $this->getDeletionButton( $ip ) . '</td></tr>';
			}
			$output .= '</table>';
			$wgOut->addHTML( $output );
		} else {
			$wgOut->addWikiMsg( 'premoderation-whitelist-empty' );
		}
	}
	
	protected function getAddForm() {
		return Xml::fieldset( wfMsg( 'premoderation-wl-addip-fieldset' ) ) .
			Xml::openElement( 'form', array( 'id' => 'prem-wl-form', 'method' => 'post' ) ) .
			'<table><tr><td>' .	wfMsg( 'premoderation-private-ip' ) . '</td><td>' .
			Xml::input( 'ip', 50, '', array( 'id' => 'prem-whitelist-addip' ) ) . '</td></tr>' .
			'<tr><td>' . wfMsg( 'summary' ) . '</td><td>' . Xml::input( 'summary', 50, '',
			array( 'id' => 'prem-summary' ) ) . '</td></tr><tr>' . '<td>' .
			Xml::submitButton( wfMsg( 'htmlform-submit' ), array( 'id' => 'prem-wl-submit' ) ) .
			'<input type="hidden" name="action" value="add" /></td></tr></table>' .
			Xml::closeElement( 'form' ) . Xml::closeElement( 'fieldset' );
	}
	
	protected function getDeletionButton( $ip ) {
		return Xml::openElement( 'form', array( 'id' => 'prem-wl-delete' . $ip, 'method' => 'post' ) ) .
			Xml::submitButton( wfMsg( 'premoderation-table-list-delete' ) ) .
			'<input type="hidden" name="action" value="delete" />' .
			'<input type="hidden" name="ip" value="' . $ip . '" />' .
			Xml::closeElement( 'form' );
	}
	
	protected function updateList() {
		$ip = $this->mRequest['ip'];
		
		switch( $this->mRequest['action'] ) {
			case 'add':
				if( !IP::isIPAddress( $ip ) ) {
					return 'prem-whitelist-invalid-ip';
				}
				$dbw = wfGetDB( DB_MASTER );
				$dbw->insert( 'pm_whitelist', array( 'pmw_ip' => $ip ), __METHOD__ );
				$this->addLogEntry( $this->mRequest['action'], array( $ip ) );
				return 'prem-whitelist-added';
			
			case 'delete':
				if( !IP::isIPAddress( $ip ) ) {
					return 'prem-whitelist-invalid-ip';
				}
				$dbw = wfGetDB( DB_MASTER );
				$dbw->delete( 'pm_whitelist', array( 'pmw_ip' => $ip ), __METHOD__ );
				$this->addLogEntry( $this->mRequest['action'], array( $ip ) );
				return 'prem-whitelist-deleted';
			
			default:
				return 'prem-whitelist-error-action';
		}
	}
	
	protected function addLogEntry( $action, $params ) {
		$log = new LogPage( 'prem-whitelist' );
		
		$self = $this->getTitle();
		$summary = isset( $this->mRequest['summary'] ) ? strval( $this->mRequest['summary'] ) : '';
		$log->addEntry( $action, $self, $summary, $params );	
	}
}