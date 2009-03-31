<?php

require_once('Wikidata.php');
require_once('Transaction.php');
require_once('WikiDataAPI.php');
require_once('forms.php');
require_once('Attribute.php');
require_once('type.php');
require_once('languages.php');
require_once('HTMLtable.php');
require_once('OmegaWikiRecordSets.php');
require_once('OmegaWikiEditors.php');
require_once('ViewInformation.php');
require_once('WikiDataGlobals.php');

/**
 * Load and modify content in a OmegaWiki-enabled
 * namespace.
 *
 */
class OmegaWiki extends DefaultWikidataApplication {
	public function view() {
		global
			$wgOut, $wgTitle;

		parent::view();
		$this->outputViewHeader();

		$spelling = $wgTitle->getText();
		$recordset = getExpressionsRecordSet($spelling, $this->viewInformation);
		$wgOut->addHTML(
			getExpressionsEditor($spelling, $this->viewInformation)->view(
				$this->getIdStack(), 
				$recordset
			)
		);
		
		$this->outputViewFooter();
	}

	public function history() {
		global
			$wgOut, $wgTitle;

		parent::history();

		$spelling = $wgTitle->getText();

		$wgOut->addHTML(
			getExpressionsEditor($spelling, $this->viewInformation)->view(
				$this->getIdStack(), 
				getExpressionsRecordSet($spelling, $this->viewInformation)
			)
		);
		
		$wgOut->addHTML(DefaultEditor::getExpansionCss());
		$wgOut->addHTML("<script language='javascript'>/* <![CDATA[ */\nexpandEditors();\n/* ]]> */</script>");
	}

	protected function save($referenceQueryTransactionInformation) {
		global
			$wgTitle;

		parent::save($referenceQueryTransactionInformation);

		$spelling = $wgTitle->getText();
		
		getExpressionsEditor($spelling, $this->viewInformation)->save(
			$this->getIdStack(), 
			getExpressionsRecordSet($spelling, $this->viewInformation)
		);
	}

	public function edit() {
		global
			$wgOut, $wgTitle, $wgUser;

		if(!parent::edit()) return false;
		$this->outputEditHeader();

		$spelling = $wgTitle->getText();

		$wgOut->addHTML(
			getExpressionsEditor($spelling, $this->viewInformation)->edit(
				$this->getIdStack(), 
				getExpressionsRecordSet($spelling, $this->viewInformation)
			)
		);

		$this->outputEditFooter();
	}
	
	public function getTitle() {
		global
			$wgTitle, $wgExpressionPageTitlePrefix;
	
		if ($wgExpressionPageTitlePrefix != "")
			$prefix = $wgExpressionPageTitlePrefix . ": ";
		else
			$prefix	= "";
					
		return $prefix . $wgTitle->getText();
	}
	
	protected function getIdStack() {
		return new IdStack("expression");
	}
}


