<?php

class PortableInfoboxBuilderController extends WikiaController {

	const INFOBOX_BUILDER_PARAM = 'portableInfoboxBuilder';

	public function getAssets() {
		$response = $this->getResponse();
		$response->setFormat( WikiaResponse::FORMAT_JSON );
		$response->setVal( 'css', AssetsManager::getInstance()->getURL( 'portable_infobox_scss' ) );
	}

	public function publish() {
		$response = $this->getResponse();
		$response->setFormat( WikiaResponse::FORMAT_JSON );

		$status = $this->attemptSave( $this->getRequest()->getParams() );

		$response->setVal( 'success', $status->isOK() );
		$response->setVal( 'errors', $status->getErrorsArray() );
		$response->setVal( 'warnings', $status->getWarningsArray() );
	}

	private function attemptSave( $params ) {
		$status = new Status();
		// check for title
		if ( !$params[ 'title' ] ) {
			$status->fatal( 'no-title-provided' );
		}
		$title = $status->isGood() ? Title::newFromText( $params[ 'title' ], NS_TEMPLATE ) : false;
		// check if title object created
		if ( $status->isGood() && !$title ) {
			$status->fatal( 'no-title-object' );
		}
		// user permissions check
		if ( $status->isGood() && !$title->userCan( 'edit' ) ) {
			$status->fatal( 'user-cant-edit' );
		}

		return $status->isGood() ? $this->save( $title, $params[ 'data' ] ) : $status;
	}

	private function save( Title $title, $data ) {
		$article = new Article( $title );
		$editPage = new EditPage( $article );
		$editPage->initialiseForm();
		$editPage->edittime = $article->getTimestamp();
		$infoboxMarkup = ( new PortableInfoboxBuilderService() )->translate( $data );

		//TODO: refactor it, to use template instead, think about adding different example for different fields
		$infobox = \Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( $infoboxMarkup );
		$sources = $infobox->getSource();
		$documentation = "\n<noinclude>{{" . $title->getText();
		foreach ( $sources as $key ) {
			$documentation .= "|{$key}=example";
		}
		$documentation .= "}}</noinclude>";


		$editPage->textbox1 = $infoboxMarkup . $documentation;
		$status = $editPage->internalAttemptSave( $result );
		return $status;
	}
}
