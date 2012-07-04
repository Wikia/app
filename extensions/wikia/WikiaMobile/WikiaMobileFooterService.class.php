<?php
/**
 * WikiaMobile Footer
 *
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 */
class WikiaMobileFooterService extends WikiaService {
	public function index(){
		$this->response->setVal( 'copyrightLink', $this->getLinkFromMessage( 'wikiamobile-footer-link-licencing' ) );
		$this->response->setVal( 'links', array(
			$this->getLinkFromMessage( 'wikiamobile-footer-link-videogames' ),
			$this->getLinkFromMessage( 'wikiamobile-footer-link-entertainment' ),
			$this->getLinkFromMessage( 'wikiamobile-footer-link-lifestyle' )
		) );
		$this->response->setVal( 'defaultSkin', urlencode( $this->wg->DefaultSkin ) );
		$this->response->setVal( 'feedbackLink', 'https://docs.google.com/a/wikia-inc.com/spreadsheet/viewform?hl=en_US&formkey=dDlxWlYwLV8zTGszZmZPN3hEYTVDMFE6MQ&entry_1=' . urlencode( $_SERVER['HTTP_USER_AGENT'] ) . "&entry_2={$this->wg->Title->getFullURL()}" );
	}

	private function getLinkFromMessage( $msgName ){
		return str_replace(
			array( '<p>', '</p>' ),
			'',
			$this->wf->MsgExt( $msgName , array( 'parse' ) )
		);
	}
}