<?php

/**
 * WikiaApiFormatTemplate - class to use EasyTemplate via WikiaAPI
 * (extensions/wikia/WikiaQuickForm/EasyTemplate.php)
 *
 * @author Piotr Molski (moli) <moli@wikia.com>
 *
 * @todo
 *
 */

if (!defined('MEDIAWIKI')) {
	// Eclipse helper - will be ignored in production
	require_once ('ApiFormatBase.php');
}

define ('TEMPLATE_NO_EXISTS', "<!-- TEMPLATE_NO_EXISTS -->");

class WikiaApiFormatTemplate extends ApiFormatBase {

	public function __construct($main, $format) {
		parent :: __construct($main, $format);
	}

	public function getMimeType() {
		return 'text/html';
	}

	public function execute() {
		global $wgMemc;
        $retval = "";

		$rt = wfGetMainCache();

		$ltempname = $this->getTemplateName($this->getResultData());
        $tmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

        if ($tmpl->template_exists( $ltempname )) {
			$tmpl->set_vars(array(
				"resultData" 	=> $this->getResultData(),
				"formatCssPath" => $ltempname.".css",
				"formatJsPath"	=> $formatJsPath.".js",
			));
			$retval = $tmpl->execute($ltempname);
        } else {
        	$retval = TEMPLATE_NO_EXISTS;
        }

        $this->printText($retval);
	}

	private function getTemplateName($data)
	{
		$lqueryparam = array_keys($data[query]);
		return $lqueryparam[0];
	}

	public function getDescription() {
		if ($this->mIsRaw)
			return 'Output data with the debuging elements in EasyTemplate format' . parent :: getDescription();
		else
			return 'Output data in EasyTemplate format' . parent :: getDescription();
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: WikiaApiFormatTemplate.php 17374 2006-11-03 06:53:47Z moli $';
	}

}
?>
