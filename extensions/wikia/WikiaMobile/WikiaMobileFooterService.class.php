<?php
/**
 * WikiaMobile Footer
 *
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 */
class WikiaMobileFooterService extends WikiaService {
	public function index(){
		$this->response->setVal( 'copyrightLink', $this->request->getVal( 'copyrightLink' ) );
		$this->response->setVal( 'links', array(
			$this->getLinkFromMessage( 'wikiamobile-footer-link1' ),
			$this->getLinkFromMessage( 'wikiamobile-footer-link2' ),
			$this->getLinkFromMessage( 'wikiamobile-footer-link3' )
		) );
		$this->response->setVal( 'feedbackLink', 'https://docs.google.com/a/wikia-inc.com/spreadsheet/viewform?hl=en_US&formkey=dDlxWlYwLV8zTGszZmZPN3hEYTVDMFE6MQ#gid=0');
	}

	private function getLinkFromMessage( $msgName ){
		return str_replace(
			array( '<p>', '</p>' ),
			'',
			$this->wf->MsgExt( $msgName , array( 'parse' ) )
		);
	}
}