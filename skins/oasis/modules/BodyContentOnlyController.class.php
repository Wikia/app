<?php

class BodyContentOnlyController extends WikiaController {

	public function executeIndex() {
		$this->bodytext = $this->app->getSkinTemplateObj()->data['bodytext'];
		switch ( RenderContentOnlyHelper::getRenderContentOnlyLevel() ) {
			case RenderContentOnlyHelper::LEAVE_NAV_ONLY:
				$this->overrideTemplate( 'NavOnly' );
				break;

			case RenderContentOnlyHelper::LEAVE_NO_SKIN_ELEMENTS:
				$this->overrideTemplate( 'NoArticleContainer' );
				break;

			case RenderContentOnlyHelper::LEAVE_ARTICLE_PLACEHOLDER_ONLY:
			default:
				// default behaviour
				break;
		}
	}

}
