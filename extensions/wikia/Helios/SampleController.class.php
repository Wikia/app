<?php
namespace Wikia\Helios;

/**
 * A simple controller to demonstrate Helios in action.
 */
class SampleController extends \WikiaController
{
	/**
	 * A naive wrapper for \WikiPage::doEdit().
	 */
	public function edit()
	{
		$responseData = new \StdClass;
		$responseData->success = false;
		$responseData->title = null;
		$responseData->text = null;
		$responseData->summary = null;
		$responseData->user_id = 0;
		$responseData->user_name = null;
		
		$this->response->setFormat( 'json' );
		$this->response->setCacheValidity( \WikiaResponse::CACHE_DISABLED );

		if ( $this->getVal( 'secret' ) != $this->wg->TheSchwartzSecretToken || ! $this->request->wasPosted() ) {
			$this->response->setVal( 'data', $responseData );
			return;
		}

		$titleText = $this->getVal( 'title' );
		$responseData->title = $titleText;

		$title = \Title::newFromText( $titleText );
		\Wikia\Util\Assert::true( $title instanceof \Title );

		$article = new \Article( $title );
		\Wikia\Util\Assert::true( $article instanceof \Article );

		$text = $this->getVal( 'text' );
		$responseData->text = $text;

		$summary = $this->getVal( 'summary' );
		$responseData->summary = $summary;

		if ( $this->wg->User->isLoggedIn() ) {
			$responseData->user_id = $this->wg->User->getId();
			$responseData->user_name = $this->wg->User->getName();
			$responseData->success = $article->doEdit( $text, $summary )->isOK();
		}

		$this->response->setVal( 'data', $responseData );
	}
}
