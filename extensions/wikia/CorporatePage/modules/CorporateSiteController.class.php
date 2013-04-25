<?php
/**
 * Description of CorporateModule
 *
 * @author owen
 */
class CorporateSiteController extends WikiaController {

	// These are just templates
	// FIXME: refactor the common functionality out of these
	public function executeSalesSupport () {

		global $wgUser;
		wfProfileIn(__METHOD__);

		// add CSS for this module
		$this->isAdmin = $wgUser->isAllowed('editinterface');

		wfProfileOut(__METHOD__);
	}

	public function executeSlider() {
		global $wgOut, $wgTitle, $wgParser;

		if (BodyController::isHubPage()) {
			$this->slider_class = "small";
			$tag_name = AutoHubsPagesHelper::getHubNameFromTitle($wgTitle);
			// Beware: the true/false at the end is important, it actually changes the return format slightly
			$this->slider = CorporatePageHelper::parseMsgImg( 'hub-' . $tag_name . '-slider', false );

			// render slider's HTML using WikiaPhotoGallery (BugId:8478)
			$slider = new WikiaPhotoGallery();
			$slider->setParser($wgParser);
			$wgParser->startExternalParse($wgTitle, new ParserOptions(), Parser::OT_HTML);
			$slider->parseParams(array(
				'type' => 'slider',
				'orientation'=> 'bottom',
			));

			// add images
			$sliderWikitext = '';

			foreach($this->slider as $image) {
				// ElmoControlRoom.jpg|Label|link=http://wikia.com|linktext=Link text
				// if parsgMsgImg has a thumbnail or the 2nd param=true (and right now it is not) then the return vals move around
				if (isset($image['param']))  // no thumbnail in msg
					$sliderWikitext .= "{$image['param']}|{$image['title']}|link={$image['href']}|linktext={$image['imagetitle']}\n";
				else // has thumbnail in msg
					$sliderWikitext .= "{$image['imagetitle']}|{$image['title']}|link={$image['href']}|linktext={$image['desc']}\n";
			}

			// set the content and parse it
			$slider->setText($sliderWikitext);
			$slider->parse();

			// render it
			$this->sliderHtml = $slider->toHTML();
		}

		if (WikiaPageType::isMainPage()) {
			$this->isMainPage = true;
			$this->slider_class = "big";
			$this->slider = CorporatePageHelper::parseMsgImg('corporatepage-slider',true);
		}
		else {
			$this->isMainPage = false;
		}
	}
}
