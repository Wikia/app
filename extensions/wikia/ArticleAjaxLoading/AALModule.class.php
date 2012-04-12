<?php

class AALModule extends WikiaController {

	public function executeIndex($params) {
		$data = array();

		$body = wfRenderModule('Body');
		$start = strpos($body, '<article ');
		$stop = strpos($body, '</article>');
		$data['body'] = substr($body, $start, $stop-$start+10);
		$data['title'] = WikiaApp::getSkinTemplateObj()->data['pagetitle'];
		$data['globalVariablesScript'] = Skin::makeGlobalVariablesScript(WikiaApp::getSkinTemplateObj()->data);

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
