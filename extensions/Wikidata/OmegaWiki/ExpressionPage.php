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
 * The ExpressionPage class renders pages in the Expression: namespace of a Wikidata application.
 * It is essentially a disambiguation page which can be customized using MediaWiki templates.
*/
class ExpressionPage extends DefaultWikidataApplication {
	public function view() {
		global
			$wgOut, $wgTitle;

		parent::view();
		$expressionAsPageTitle = $wgTitle->getText();
		$wgOut->setPageTitle(wfMsgSc("meaningsoftitle",$expressionAsPageTitle));
		$wgOut->setSubtitle(wfMsgSc("meaningsofsubtitle",$wgTitle->getPrefixedText()));
		$sets=wdGetDataSets();
		$html='';
		foreach($sets as $set) {
			$html.=$this->getMeaningBox($expressionAsPageTitle, $set);
		}		
		$wgOut->addHTML($html);
	}

	protected function getMeaningBox($expression, $dataset) {
		global $wgOut, $wgUser;
		$name=$dataset->fetchName();
		$exp=getExpressions($expression, $dataset);
		$wikiMagic='';
		if(!empty($exp)) {
			foreach($exp as $foundExpression) {
				$foundExpression->fetchMeaningIds();
				$languageNames=getOwLanguageNames();
				$lang=$languageNames[$foundExpression->languageId];
				$spell=$foundExpression->spelling;
				$wikiMagic.="{{Expression|language=$lang|spelling=$spell}}\n";
				$defs=array();
				foreach($foundExpression->meaningIds as $mid) {
					$def=getDefinedMeaningDefinitionForLanguage($mid,getLanguageIdForCode($wgUser->getOption('language')), $dataset);
					$defexrow=definingExpressionRow($mid);
					$defex=$defexrow[1];
					$wikiMagic.="{{Meaning|definition=$def|dmid=$mid|defined_by=$defex}}\n";					
				}
				$wikiMagic.="\n";
				
			}
		} else {
			$meaningList="No meanings found.";
		}
		$templatesAsHTML=$wgOut->parse($wikiMagic);
		$lang_select=getLanguageSelect("Language");
		
	$boxhtml=<<<HTML
<P>
<div style="border-style:solid;border-width:1px;border-color:#666666;padding:5px;">
<div style="float:right;"><span style="background:#eeeeee;border-style:solid;order-color:black;padding:3px;border-width:1px;"><B>$name</B></span>
</div>
$templatesAsHTML
<br />
<B>Add new meaning:</B>
<form>
Language: $lang_select<br />
Definition:<br /><textarea cols="80"></textarea>
<input type="submit" value="Add meaning">

</form>
</div>
</P>
HTML;
	return $boxhtml;
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
