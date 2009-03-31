<?php

require_once('Wikidata.php');
require_once('OmegaWikiRecordSets.php');
require_once('OmegaWikiEditors.php');
require_once('DefinedMeaningModel.php');

class DefinedMeaning extends DefaultWikidataApplication {
	protected $definedMeaningModel;
	public function view() {
		global
			$wgOut, $wgTitle, $wgRequest, $wdCurrentContext;

		// Split title into defining expression and ID
		$titleText = $wgTitle->getText();
		$dmInfo = DefinedMeaningModel::splitTitleText($titleText);

		// Title doesn't have an ID in it (or ID 0)
		if(is_null($dmInfo) || !$dmInfo["id"]) {
			$wgOut->showErrorPage('errorpagetitle','ow_dm_badtitle');
			return false;
		}
		parent::view();
		$definedMeaningModel = new DefinedMeaningModel($dmInfo["id"], $this->viewInformation);
		$this->definedMeaningModel=$definedMeaningModel; #TODO if I wasn't so sleepy I'd make this consistent

		$copyTo=$wgRequest->getText('CopyTo');
		if ($copyTo) {
			$definedMeaningModel->copyTo($copyTo);
		}

		if(!empty($dmInfo["expression"])) {
		 	$definedMeaningModel->setDefiningExpression($dmInfo["expression"]);
		}

		// Search for this DM in all data-sets, beginning with the current one.
		// Switch dataset context if found elsewhere.
		$match=$definedMeaningModel->checkExistence(true, true);

		// The defining expression is likely incorrect for some reason. Let's just
		// try looking up the number.
		if(is_null($match) && !empty($dmInfo["expression"])) {
			$definedMeaningModel->setDefiningExpression(null);
			$dmInfo["expression"]=null;
			$match=$definedMeaningModel->checkExistence(true, true);
		}

		// The defining expression is either bad or missing. Let's redirect
		// to the correct URL.
		if(empty($dmInfo["expression"]) && !is_null($match)) {
			$definedMeaningModel->loadRecord();
			$title=Title::newFromText($definedMeaningModel->getWikiTitle());
			$url=$title->getFullURL();
			$wgOut->disable();
			header("Location: $url");
			return false;
		}

		// Bad defining expression AND bad ID! :-(
		if(is_null($match)) {
			$wgOut->showErrorPage('errorpagetitle','ow_dm_missing');
			return false;
		}

		$definedMeaningModel->loadRecord();
		$this->showDataSetPanel=false;

		# Raw mode
		$view_as=$wgRequest->getText('view_as');
		if ($view_as=="raw") {
			$wgOut->addHTML("<pre>".$definedMeaningModel->getRecord()."</pre>");
			#$wgOut->disable();
			return;
		}

		$this->outputViewHeader();
		$wgOut->addHTML($this->getConceptPanel());
		$editor=getDefinedMeaningEditor($this->viewInformation);
		$idStack=$this->getIdStack($definedMeaningModel->getId());
		$html=$editor->view($idStack,$definedMeaningModel->getRecord());
		$wgOut->addHTML($html);
		$this->outputViewFooter();
	}
	
	public function edit() {
		global
			$wgOut, $wgTitle;

		if(!parent::edit()) return false;

		$definedMeaningId = $this->getDefinedMeaningIdFromTitle($wgTitle->getText());

		$this->outputEditHeader();
		$dmModel = new DefinedMeaningModel($definedMeaningId, $this->viewInformation);
		
		if (is_null($dmModel->getRecord())) {
			$wgOut->addHTML(wfMsgSc("db_consistency__not_found")." ID:$definedMeaningId");
			return;
		}
		
		$wgOut->addHTML(
			getDefinedMeaningEditor($this->viewInformation)->edit(
				$this->getIdStack($dmModel->getId()), 
				$dmModel->getRecord()
			)
		);
		$this->outputEditFooter();
	}
	
	public function history() {
		global
			$wgOut, $wgTitle;

		parent::history();

		$definedMeaningId = $this->getDefinedMeaningIdFromTitle($wgTitle->getText());
		$dmModel=new DefinedMeaningModel($definedMeaningId, $this->viewInformation);
		$wgOut->addHTML(
			getDefinedMeaningEditor($this->viewInformation)->view(
				new IdStack("defined-meaning"), 
				$dmModel->getRecord()
			)
		);
		
		$wgOut->addHTML(DefaultEditor::getExpansionCss());
		$wgOut->addHTML("<script language='javascript'>/* <![CDATA[ */\nexpandEditors();\n/* ]]> */</script>");
	}

	protected function save($referenceQueryTransactionInformation) {
		global
			$wgTitle;

		parent::save($referenceQueryTransactionInformation);
		$definedMeaningId = $this->getDefinedMeaningIdFromTitle($wgTitle->getText());
		
		$dmModel = new DefinedMeaningModel($definedMeaningId, $this->viewInformation); 
		$definedMeaningId = $this->getDefinedMeaningIdFromTitle($wgTitle->getText());

		getDefinedMeaningEditor($this->viewInformation)->save(
			$this->getIdStack($definedMeaningId), 
			$dmModel->getRecord()
		);
	
	}
	
	protected function getIdStack($definedMeaningId) {

		$o=OmegaWikiAttributes::getInstance();
			
		$definedMeaningIdStructure = new Structure($o->definedMeaningId);
		$definedMeaningIdRecord = new ArrayRecord($definedMeaningIdStructure, $definedMeaningIdStructure);
		$definedMeaningIdRecord->definedMeaningId = $definedMeaningId;	
		
		$idStack = new IdStack("defined-meaning");
		$idStack->pushKey($definedMeaningIdRecord);
		
		return $idStack;
	}
	
	/** @deprecated, use DefinedMeaningData.setTitle instead */
	protected function getDefinedMeaningIdFromTitle($title) {
		// get id from title: DefinedMeaning:expression (id)
		$bracketPosition = strrpos($title, "(");
		$definedMeaningId = substr($title, $bracketPosition + 1, strlen($title) - $bracketPosition - 2);
		return $definedMeaningId;
	}	
	
	public function getTitle() {
		global
			$wgTitle, $wgDefinedMeaningPageTitlePrefix;
	
		if ($wgDefinedMeaningPageTitlePrefix != "")
			$prefix = $wgDefinedMeaningPageTitlePrefix . ": ";
		else
			$prefix	= "";
					
		return $prefix . definedMeaningExpression($this->getDefinedMeaningIdFromTitle($wgTitle->getText()));
	}

	public function getDefinedMeaningId() {
		global 
			$wgTitle;
		return $this->getDefinedMeaningIdFromTitle($wgTitle->getText());
	}

	/** 
	 * Creates sidebar HTML for indicating concepts which exist
	 * in multiple datasets, and providing a link to add new
	 * mappings.
	 *
	 * Potential refactor candidate!
	*/
	protected function getConceptPanel() {
		global $wgTitle, $wgUser, $wdShowCopyPanel;
		$active=true; # wrong place, but hey
		$dmId=$this->getDefinedMeaningId();
		$dc=wdGetDataSetContext();
		$ow_conceptpanel=wfMsgSc("concept_panel");

		$html="<div class=\"dataset-panel\">";;
		$html.="<table border=\"0\"><tr><th class=\"dataset-panel-heading\">$ow_conceptpanel</th></tr>";
		$sk=$wgUser->getSkin();
		$meanings=getDefinedMeaningDataAssociatedByConcept($dmId, $dc);
		if($meanings) {
			foreach ($meanings as $dm) {
				$dataset=$dm->getDataset();
				$active=($dataset->getPrefix()==$dc->getPrefix());
				$name=$dataset->fetchName();
				$prefix=$dataset->getPrefix();
	
				$class= $active ? 'dataset-panel-active' : 'dataset-panel-inactive';
				$slot = $active ? "$name" : $sk->makeLinkObj($dm->getTitleObject(),$name,"dataset=$prefix");
				$html.="<tr><td class=\"$class\">$slot</td></tr>";
			}
		} else {
				$name=$dc->fetchName();
				$html.="<tr><td class=\"dataset-panel-active\">$name</td></tr>";
		}
		$cmtitle=Title::newFromText("Special:ConceptMapping");
		$titleText=$wgTitle->getPrefixedURL();
		$cmlink=$sk->makeLinkObj($cmtitle,"<small>".wfMsgSc("add_concept_link")."</small>","set_$dc=$dmId&suppressWarnings=true");
		$html.="<tr><td>$cmlink</td></tr>\n";
		if($wdShowCopyPanel) {
			$html.="<tr><td>".$this->getCopyPanel()."<td><tr>";
		}
		$html.="</table>\n";
		$html.="</div>\n";
		return $html;
	}
	
	/** @returns user interface html for copying Defined Meanings
	 * between datasets. returns an empty string if the user
	 * actually doesn't have permission to edit.
	 */
	protected function getCopyPanel() {

		# mostly same code as in SpecialAddCollection... possibly might 
		# make a nice separate function 

		global 
			$wgUser;
		if(!$wgUser->isAllowed('wikidata-copy')) {
			return "";
		}

		$datasets=wdGetDatasets();
		$datasetarray['']=wfMsgSc('none_selected');
		foreach($datasets as $datasetid=>$dataset) {
			$datasetarray[$datasetid]=$dataset->fetchName();
		}

		/* Deprecated for now
		
		$html= getOptionPanel( array (
			'Copy to' => getSelect('CopyTo', $datasetarray)
		));
		*/
		$html=$this->getCopyPanel2();
		return $html;
	}	
	
	/** links to futt bugly alternate copy mechanism, the
	 * latter being something that actually is somewhat
	 * understandable (though not yet refactored into
	 * something purdy and maintainable)
	 */
	protected function getCopyPanel2() { 
		global 
			$wgScriptPath, $wgCommunity_dc;
		
		$html="Copy to:<br />\n"; 
		$datasets=wdGetDatasets();
		$dataset=$datasets[$wgCommunity_dc];
		$dmid=$this->definedMeaningModel->getId();
		$dc1=$this->definedMeaningModel->getDataSet();
		$name=$dataset->fetchName(); 
		$dc2=$wgCommunity_dc;
		$html.="<a href='index.php?title=Special:Copy&action=copy&dmid=$dmid&dc1=$dc1&dc2=$dc2'>$name</a><br />\n";

		return $html;
	}

}

