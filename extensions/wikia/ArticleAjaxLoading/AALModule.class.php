<?php

class AALModule extends WikiaController {

	public function executeIndex($params) {
		$data = array();

		$body = wfRenderModule('Body');
		$start = strpos($body, '<article ');
		$stop = strpos($body, '</article>');
		$templateObj = $this->app->getSkinTemplateObj();
		$data['body'] = substr($body, $start, $stop-$start+10);
		$data['title'] = $templateObj->data['pagetitle'];
		$data['globalVariablesScript'] = Skin::makeGlobalVariablesScript($templateObj->data);

		global $wgOut;
		$scripts = $wgOut->getScript();
		$csslinks = $wgOut->buildCssLinks();

		//$scripts = preg_replace("#<script[^>]+src=\".*WikiaStats.*\"></script>#", '', $scripts);
		//$scripts = preg_replace("#<link(.*)\/>#", '', $scripts);
		//$scripts = preg_replace("/<style>(.*)<\/style>/s", '', $scripts);

		$data['body'] .= $scripts . $csslinks;
		$this->data = $data;
	}
}
