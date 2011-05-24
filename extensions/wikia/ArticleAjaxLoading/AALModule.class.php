<?php

class AALModule extends Module {

	var $globalVariablesScript;
	var $pagetitle;
	var $data;
	var $jsFiles;

	public function executeIndex($params) {
		$this->data = array();

		$body = wfRenderModule('Body');
		$start = strpos($body, '<article ');
		$stop = strpos($body, '</article>');
		$this->data['body'] = substr($body, $start, $stop-$start+10);
		$this->data['title'] = $this->pagetitle;
		$this->data['globalVariablesScript'] = Skin::makeGlobalVariablesScript(Module::getSkinTemplateObj()->data);

		global $wgOut;
		$scripts = $wgOut->getScript();
		$csslinks = $wgOut->buildCssLinks();

		//$scripts = preg_replace("#<script[^>]+src=\".*WikiaStats.*\"></script>#", '', $scripts);
		//$scripts = preg_replace("#<link(.*)\/>#", '', $scripts);
		//$scripts = preg_replace("/<style>(.*)<\/style>/s", '', $scripts);

		$this->data['body'] .= $scripts . $csslinks;
	}
}
