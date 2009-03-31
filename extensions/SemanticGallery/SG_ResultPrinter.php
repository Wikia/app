<?php
if (!defined('MEDIAWIKI')) die();

/**
 * Print query results as a gallery.
 */
class SemanticGallery_ResultPrinter extends SMWResultPrinter
{
	public function getResult($results, $params, $outputmode)
	{
		// skip checks, results with 0 entries are normal
		$this->readParameters($params, $outputmode);
		return $this->getResultText($results, SMW_OUTPUT_HTML);
	}

	public function getResultText($res, $outputmode)
	{
		global $smwgIQRunningNumber, $wgUser, $wgParser;
		$skin = $wgUser->getSkin();

		$ig = new ImageGallery();
		$ig->setShowBytes(false);
		$ig->setShowFilename(false);
		$ig->setParser($wgParser);
		$ig->useSkin($skin);
		$ig->setCaption($this->mIntro); // set caption to IQ header

		if ( isset($this->m_params['perrow']) )
			$ig->setPerRow( $this->m_params['perrow'] );
		if ( isset($this->m_params['widths']) )
			$ig->setWidths( $this->m_params['widths'] );
		if ( isset($this->m_params['heights']) )
			$ig->setHeights( $this->m_params['heights'] );

		while ($row = $res->getNext()) {
			$firstField = $row[0];
			$imgTitle = $firstField->getNextObject()->getTitle();

			if ( isset($row[1]) ) {
				//$imgCaption = $this->recursiveTagParse( trim( $row[1]->getNextObject()-> ) ); // TODO: Support captions
				$imgCaption = $imgTitle->getBaseText();
			}
			else {
				$imgCaption = $imgTitle->getBaseText();
				$imgCaption = preg_replace('#\.[^.]+$#', '', $imgCaption);
			}

			$ig->add( $imgTitle, $imgCaption );

			# Only add real images (bug #5586)
			if ( $imgTitle->getNamespace() == NS_IMAGE ) {
				$wgParser->mOutput->addImage( $imgTitle->getDBkey() );
			}
		}

		$result = $ig->toHTML();


		return array($result, 'noparse' => 'true', 'isHTML' => 'true');
	}
}
