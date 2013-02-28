<?php

class ArticleSummaryController extends WikiaController {


	public function blurb () {
		global $wgRequest;

		$method = $wgRequest->getVal('method');
		$id_str = $wgRequest->getVal('ids');
		$ids = explode(',', $id_str);

		$this->summary = ArticleSummary::blurb($ids);
	}
}