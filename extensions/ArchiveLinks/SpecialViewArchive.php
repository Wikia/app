<?php
/**
 * This special page exists to serve the cached versions of the pages that have been archived.
 */

class SpecialViewArchive extends SpecialPage {

	/**
	 * @var DatabaseBase
	 */
	private $db_master, $db_slave;
	private $db_result;

	function __construct() {
		parent::__construct( 'ViewArchive' );
	}

	/**
	 * Main function for the view archive page. This queries the resource table, disables
	 * output, and then displays the archived version of whichever page you'd like to view.
	 *
	 * @global $wgOut OutputPage
	 * @global $wgRequest object
	 * @param $par
	 */
	public function execute( $par ) {
		global $wgOut, $wgRequest;

		if ( isset( $par ) || $url = $wgRequest->getText( 'archive_url' ) ) {
			$this->db_master = wfGetDB( DB_MASTER );
			$this->db_slave = wfGetDB( DB_SLAVE );
			$db_result = array();

			if( !isset( $url ) ) {
				$url = $par;
			}

			$this->db_result['url_location'] = $this->db_slave->select( 'el_archive_resource', '*', array( 'resource_url' => $this->db_slave->strencode( $url ) ), __METHOD__ );

			if ( $this->db_result['url_location']->numRows() < 1 ) {
				//This URL doesn't exist in the archive, let's say so
				$this->db_result['log_check'] = $this->db_slave->select( 'el_archive_log', '*', array( 'log_url' => $this->db_slave->strencode( $url ) ), __METHOD__ );
				$this->db_result['queue_check'] = $this->db_slave->select( 'el_archive_queue', '*', array( 'url' => $this->db_slave->strencode( $url ) ), __METHOD__ );

				if ( ( $num_rows = $this->db_result['queue_check']->numRows() ) === 1 ) {
					$in_queue = true;
				} elseif ( $num_rows > 1 ) {
					//We found duplicates, delete them
					$job = $this->db_result['queue_check']->fetchRow();
					while( $row = $this->db_result['queue_check']->fetchRow() ) {
						$this->db_master->delete( 'el_archive_queue', array ( 'queue_id' => $row['queue_id'] ) );
					}
				} else {
					$in_queue = false;
				}

				if ( $this->db_result['log_check']->numRows() >= 1 ) {
					$in_logs = true;
				} else {
					$in_logs = false;
				}

				$this->output_form();
				$wgOut->addWikiMsg( 'archivelinks-view-archive-url-not-found' );
				/*$wgOut->addHTML(
						HTML::openElement( 'table' ) .
						HTML::openElement('tr') .
						HTML::openElement('td') .
						HTML::closeElement('td') .
						HTML::closeElement('tr') .
						HTML::closeElement( 'table' )
						);*/
			} else {
				//Disable the output so we don't get a skin around the archived content
				$wgOut->disable();

				ob_start();

				echo HTML::htmlHeader();
			}

		} else {
			//The user has not requested a URL, let's print a form so they can do so :D
			$this->output_form();
		}
	}

	/**
	 * Uses the HTML functions to output the appropiate form for the special page if no archived version
	 * exists or if no query has been specified by the user yet.
	 *
	 * @global $wgOut object
	 */
	private function output_form( ) {
		global $wgOut;
		$this->setHeaders();
		$wgOut->addWikiMsg( 'archivelinks-view-archive-desc' );

		$wgOut->addHTML(
			HTML::openElement( 'form', array( 'method' => 'get', 'action' => SpecialPage::getTitleFor( 'ViewArchive' )->getLocalUrl() ) ) .
			HTML::openElement( 'fieldset' ) .
			HTML::element('legend', null, wfMsg('ViewArchive') ) .
			XML::inputLabel( wfMsg( 'archivelinks-view-archive-url-field' ), 'archive_url', 'archive-links-archive-url', 120 ) .
			HTML::element( 'br' ) .
			XML::submitButton( wfMsg( 'archivelinks-view-archive-submit-button' ) ) .
			HTML::closeElement( 'fieldset' ) .
			HTML::closeElement( 'form' )
			);
	}
}
