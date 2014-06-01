<?php

class ArticleSummaryController extends WikiaController {


	public function blurb () {

		$method = $this->request->getVal('method');
		$idStr = $this->request->getVal('ids');
		$ids = explode(',', $idStr);

		$this->summary = ArticleSummary::blurb($ids);
	}
}