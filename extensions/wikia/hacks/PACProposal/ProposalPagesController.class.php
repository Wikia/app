<?php

class ProposalPagesController extends WikiaController {

	public function get() {
		$pages = (new ProposalPages);
		$userId = $this->request->getVal( 'userId' );

		if( !empty( $userId ) ) {
			$this->response->setVal( 'pages', $pages->getList( $userId ) );
		}
		else {
			throw new WikiaException( 'User ID is empty' );
		}
	}

}