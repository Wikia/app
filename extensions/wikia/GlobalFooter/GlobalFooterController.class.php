<?php

class GlobalFooterController extends WikiaController {

	const MEMC_KEY_GLOBAL_FOOTER_LINKS = 'mGlobalFooterLinks';
	const MESSAGE_KEY_GLOBAL_FOOTER_LINKS = 'shared-Oasis-footer-wikia-links';
	const CORPORATE_CATEGORY_ID = 4;

	public function index() {
		$this->footer_links = $this->getGlobalFooterLinks();
		$this->copyright = RequestContext::getMain()->getSkin()->getCopyright();
		$this->hub = $this->getHub();

		$this->isCorporate = $this->hub->cat_id == self::CORPORATE_CATEGORY_ID;
	}

	private function getGlobalFooterLinks() {
		global $wgCityId, $wgContLang, $wgLang, $wgMemc;

		wfProfileIn(__METHOD__);

		$catId = WikiFactoryHub::getInstance()->getCategoryId( $wgCityId );
		$memcKey = wfMemcKey(self::MEMC_KEY_GLOBAL_FOOTER_LINKS , $wgContLang->getCode(), $wgLang->getCode(), $catId);

		$globalFooterLinks = $wgMemc->get($memcKey);
		if (!empty($globalFooterLinks)) {
			return $globalFooterLinks;
		}

		if (is_null($globalFooterLinks = getMessageAsArray(self::MESSAGE_KEY_GLOBAL_FOOTER_LINKS . '-' . $catId))) {
			if(is_null($globalFooterLinks = getMessageAsArray(self::MESSAGE_KEY_GLOBAL_FOOTER_LINKS))) {
				wfProfileOut( __METHOD__ );
				return [];
			}
		}

		$parsedLinks = [];
		foreach($globalFooterLinks as $link) {
			if(strpos(trim($link), '*') === 0) {
				$parsedLink = parseItem($link);
				if ((strpos($parsedLink['text'], 'LICENSE') !== false) || $parsedLink['text'] == 'GFDL') {
					$parsedLink['isLicense'] = true;
				} else {
					$parsedLink['isLicense'] = false;
				}
				$parsedLinks[] = $parsedLink;
			}
		}

		wfProfileOut( __METHOD__ );

		return $parsedLinks;
	}

	private function getHub() {
		global $wgCityId;

		wfProfileIn( __METHOD__ );

		$catInfo = HubService::getCategoryInfoForCity($wgCityId);

		if (!empty($catInfo)) {
			$catInfo->cat_link = wfMessage('oasis-corporatefooter-hub-'. $catInfo->cat_name .'-link')->text();
			$catInfo->cat_name = wfMessage('hub-'. $catInfo->cat_name)->text();
		}

		wfProfileOut( __METHOD__ );
		return $catInfo;
	}

}
