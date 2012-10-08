<?php

class InWikiGameRailController extends WikiaController {

	/**
	 * @desc The idea is to look for an element in WF variable and if it's there display the rail module with proper image and link
	 */
	public function executeIndex() {
		//once we agree about this solution and get assets we'll put it into WikiFactory
		$fakeWikiFactoryArr = array(
			175762 => array( //rotmg wiki id
				'background-img-url' => array(
					'width' => 279,
					'height' => 181,
					'src' => 'http://images.wikia.com/lotr/images/e/e3/Thehobbit.png',
				),
				'article-with-game-url' => 'http://rotmg.nandy.wikia-dev.com/wiki/Play'
			),
		);

		if( in_array($this->wg->cityId, array_keys($fakeWikiFactoryArr)) ) {
			$cfg = $fakeWikiFactoryArr[$this->wg->cityId];

			$this->img = new stdClass();
			$this->img->width = $cfg['background-img-url']['width'];
			$this->img->height = $cfg['background-img-url']['height'];
			$this->img->src = $cfg['background-img-url']['src'];

			$this->gameUrl = $cfg['article-with-game-url'];
		}
	}
}
