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
		$oResponseData = new \StdClass;
		$oResponseData->success = false;
		$oResponseData->title = null;
		$oResponseData->text = null;
		$oResponseData->summary = null;
		$oResponseData->user_id = 0;
		$oResponseData->user_name = null;
		
		$this->response->setFormat( 'json' );
		$this->response->setCacheValidity( \WikiaResponse::CACHE_DISABLED );

		if ( $this->getVal( 'secret' ) != $this->wg->TheSchwartzSecretToken || ! $this->request->wasPosted() ) {
			$this->response->setVal( 'data', $oResponseData );
			return;
		}

		$sTitle = $this->getVal( 'title' );
		$oResponseData->title = $sTitle;
		$oTitle = \Title::newFromText( $sTitle );
		\Wikia\Util\Assert::true( $oTitle instanceof \Title );

		$oArticle = new \Article( $oTitle );
		\Wikia\Util\Assert::true( $oArticle instanceof \Article );

		$sText = $this->getVal( 'text' );
		$oResponseData->text = $sText;

		$sSummary = $this->getVal( 'summary' );
		$oResponseData->summary = $sSummary;

		if ( $this->wg->User->isLoggedIn() ) {
			$oResponseData->user_id = $this->wg->User->getId();
			$oResponseData->user_name = $this->wg->User->getName();
			$oResponseData->success = $oArticle->doEdit( $sText, $sSummary )->isOK();
		}

		$this->response->setVal( 'data', $oResponseData );
	}
}
