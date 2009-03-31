<?php

require_once("forms.php");
require_once("Transaction.php");
require_once("OmegaWikiAttributes.php");
require_once("WikiDataAPI.php");
require_once("Utilities.php");

class DefaultWikidataApplication {
	protected $showRecordLifeSpan;
	protected $transaction;
	protected $queryTransactionInformation;
	protected $showCommunityContribution;
	
	// The following member variables control some application specific preferences
	protected $filterLanguageId = 0;			// Filter pages on this languageId, set to 0 to show all languages
	protected $showClassicPageTitles = true;	// Show classic page titles instead of prettier page titles
	
	protected $propertyToColumnFilters = array();	
	protected $viewInformation;

	// Show a panel to select expressions from available data-sets
	protected $showDataSetPanel=true;

	public function __construct() {
		global
			$wgFilterLanguageId, 
			$wgShowClassicPageTitles, 
			$wgPropertyToColumnFilters;
			
		if (isset($wgFilterLanguageId))
			$this->filterLanguageId = $wgFilterLanguageId;
			
		if (isset($wgShowClassicPageTitles))
			$this->showClassicPageTitles = $wgShowClassicPageTitles;
			
		if (isset($wgPropertyToColumnFilters))
			$this->propertyToColumnFilters = $wgPropertyToColumnFilters;  
	}


	protected function outputViewHeader() {
		global
			$wgOut;
		
		if($this->showDataSetPanel) 
			$wgOut->addHTML($this->getDataSetPanel());
	}

	protected function outputViewFooter() {
		global
			$wgOut;
		
		$wgOut->addHTML(DefaultEditor::getExpansionCss());
		$wgOut->addHTML("<script language='javascript'>/* <![CDATA[ */\nexpandEditors();\n/* ]]> */</script>");
	} 
	
	public function view() {
		global
			$wgOut, $wgTitle, $wgUser;

		$wgOut->enableClientCache(false);

		$title = $wgTitle->getPrefixedText();

		if (!$this->showClassicPageTitles) 
			$title = $this->getTitle();

		$wgOut->setPageTitle($title);
		
		$this->queryTransactionInformation = new QueryLatestTransactionInformation();
		
		$viewInformation = new ViewInformation();
		$viewInformation->filterLanguageId = $this->filterLanguageId;
		$viewInformation->showRecordLifeSpan = false;
		$viewInformation->queryTransactionInformation = $this->queryTransactionInformation;
		$viewInformation->setPropertyToColumnFilters($this->propertyToColumnFilters);
		
		$this->viewInformation = $viewInformation;

		initializeOmegaWikiAttributes($viewInformation);
		initializeObjectAttributeEditors($viewInformation);		
	}
	
	protected function getDataSetPanel() {
		global $wgTitle, $wgUser;
		$dc=wdGetDataSetContext();
		$ow_datasets=wfMsgSc("datasets");
		$html="<div class=\"dataset-panel\">";;
		$html.="<table border=\"0\"><tr><th class=\"dataset-panel-heading\">$ow_datasets</th></tr>";
		$dataSets=wdGetDataSets();
		$sk=$wgUser->getSkin();
		foreach ($dataSets as $dataset) {
			$active=($dataset->getPrefix()==$dc->getPrefix());
			$name=$dataset->fetchName();
			$prefix=$dataset->getPrefix();

			$class= $active ? 'dataset-panel-active' : 'dataset-panel-inactive';
			$slot = $active ? "$name" : $sk->makeLinkObj($wgTitle,$name,"dataset=$prefix");
			$html.="<tr><td class=\"$class\">$slot</td></tr>";
		}
		$html.="</table>";
		$html.="</div>";
		return $html;
	}

	protected function save($referenceQueryTransactionInformation) {
		$viewInformation = new ViewInformation();
		$viewInformation->filterLanguageId = $this->filterLanguageId;
		$viewInformation->queryTransactionInformation = $referenceQueryTransactionInformation; 
		$viewInformation->setPropertyToColumnFilters($this->propertyToColumnFilters);
		$viewInformation->viewOrEdit = "edit";
		
		$this->viewInformation = $viewInformation;

		initializeOmegaWikiAttributes($this->viewInformation);	
		initializeObjectAttributeEditors($this->viewInformation);
	}
	
	public function saveWithinTransaction() {
		global
			$wgTitle, $wgUser, $wgRequest;

		$summary = $wgRequest->getText('summary');

		// Insert transaction information into the DB
		startNewTransaction($wgUser->getID(), wfGetIP(), $summary);

		// Perform regular save
		$this->save(new QueryAtTransactionInformation($wgRequest->getInt('transaction'), false));

		// Update page caches
		Title::touchArray(array($wgTitle));

		// Add change to RC log
		$now = wfTimestampNow();
		RecentChange::notifyEdit($now, $wgTitle, false, $wgUser, $summary, 0, $now, false, '', 0, 0, 0);
	}

	/**
	 * @return true if permission to edit, false if not
	**/
	public function edit() {
		global
			$wgOut, $wgRequest, $wgUser;
			
		$wgOut->enableClientCache(false);

		$dc=wdGetDataSetContext();
 		if(!$wgUser->isAllowed('editwikidata-'.$dc)) {
 			$wgOut->addWikiText(wfMsgSc("noedit",$dc->fetchName()));
			$wgOut->setPageTitle(wfMsgSc("noedit_title"));
 			return false;
 		}

		if ($wgRequest->getText('save') != '') 
			$this->saveWithinTransaction();

		$viewInformation = new ViewInformation();
		$viewInformation->filterLanguageId = $this->filterLanguageId;
		$viewInformation->showRecordLifeSpan = false;
		$viewInformation->queryTransactionInformation = new QueryLatestTransactionInformation();
		$viewInformation->viewOrEdit = "edit";
		$viewInformation->setPropertyToColumnFilters($this->propertyToColumnFilters);
		
		$this->viewInformation = $viewInformation;
		
		initializeOmegaWikiAttributes($this->viewInformation);	
		initializeObjectAttributeEditors($this->viewInformation);

		return true;
	}
	
	public function history() {
		global
			$wgOut, $wgTitle, $wgRequest;
			
		$wgOut->enableClientCache(false);

		$title = $wgTitle->getPrefixedText();

		if (!$this->showClassicPageTitles) 
			$title = $this->getTitle();

		$wgOut->setPageTitle(wfMsgSc("history",$title));

		# Plain filter for the lifespan info about each record
		if (isset($_GET['show'])) {
			$this->showRecordLifeSpan = isset($_GET["show-record-life-span"]);
			$this->transaction = (int) $_GET["transaction"];
		}	
		else {
			$this->showRecordLifeSpan = true;
			$this->transaction = 0;
		}
		
		# Up to which transaction to view the data
		if ($this->transaction == 0)
			$this->queryTransactionInformation = new QueryHistoryTransactionInformation();
		else
			$this->queryTransactionInformation = new QueryAtTransactionInformation($this->transaction, $this->showRecordLifeSpan);
			
		$transactionId = $wgRequest->getInt('transaction');

		$wgOut->addHTML(getOptionPanel(
			array(
				'Transaction' => getSuggest('transaction','transaction', array(), $transactionId, getTransactionLabel($transactionId), array(0, 2, 3)),
				'Show record life span' => getCheckBox('show-record-life-span',$this->showRecordLifeSpan)
			),
			'history'
		));

		$viewInformation = new ViewInformation();
		$viewInformation->filterLanguageId = $this->filterLanguageId;
		$viewInformation->showRecordLifeSpan = $this->showRecordLifeSpan;
		$viewInformation->queryTransactionInformation = $this->queryTransactionInformation;
		$viewInformation->setPropertyToColumnFilters($this->propertyToColumnFilters);
		
		$this->viewInformation = $viewInformation;

		initializeOmegaWikiAttributes($this->viewInformation);	
		initializeObjectAttributeEditors($viewInformation);
	}
	
	protected function outputEditHeader() {
		global
			$wgOut, $wgTitle;
			
		$title = $wgTitle->getPrefixedText();

		if (!$this->showClassicPageTitles) 
			$title = $this->getTitle();

		$wgOut->setPageTitle($title);
		$wgOut->setPageTitle(wfMsg("editing",$title));

		$wgOut->addHTML(
			'<form method="post" action="">' .
				'<input type="hidden" name="transaction" value="'. getLatestTransactionId() .'"/>'
		);
	}
	
	protected function outputEditFooter() {
		global
			$wgOut;
		
		$wgOut->addHTML(
			'<div class="option-panel">'.
				'<table cellpadding="0" cellspacing="0"><tr>' .
					'<th>' . wfMsg("summary") . ': </th>' .
					'<td class="option-field">' . getTextBox("summary") .'</td>' .
				'</tr></table>' .
				getSubmitButton("save", wfMsgSc("save")).
			'</div>'
		);
		
		$wgOut->addHTML('</form>');
		$wgOut->addHTML(DefaultEditor::getExpansionCss());
		$wgOut->addHTML("<script language='javascript'><!--\nexpandEditors();\n--></script>");
	}
	
	public function getTitle() {
		global
			$wgTitle;
			
		return $wgTitle->getText();
	}

}


# Global context override. This is an evil hack to allow saving, basically.
global $wdCurrentContext;
$wdCurrentContext=null;

/**
 * A Wikidata application can manage multiple data sets.
 * The current "context" is dependent on multiple factors:
 * - the URL can have a dataset parameter
 * - there is a global default
 * - there can be defaults for different user groups
 * @param $dc	optional, for convenience.
 *		if the dataset context is already set, will
		return that value, else will find the relevant value
 * @return prefix (without underscore)
**/
function wdGetDataSetContext($dc=null) {
	global $wgRequest, $wdDefaultViewDataSet, $wdGroupDefaultView, $wgUser,
		$wdCurrentContext;

	# overrides
	if (!is_null($dc)) 
		return $dc; #local override
	if (!is_null($wdCurrentContext))
		return $wdCurrentContext; #global override
		
	$datasets=wdGetDataSets();
	$groups=$wgUser->getGroups();
	$dbs=wfGetDB(DB_SLAVE);
	$pref=$wgUser->getOption('ow_uipref_datasets');

	$trydefault='';
	foreach($groups as $group) {
		if(isset($wdGroupDefaultView[$group])) {
			# We don't know yet if this prefix is valid.
			$trydefault=$wdGroupDefaultView[$group];
		}
	}

	# URL parameter takes precedence over all else
	if( ($ds=$wgRequest->getText('dataset')) && array_key_exists($ds,$datasets) && $dbs->tableExists($ds."_transactions") ) {
		return $datasets[$ds];
	# User preference
	} elseif(!empty($pref) && array_key_exists($pref,$datasets)) {
		return $datasets[$pref];
	}
	# Group preference
	 elseif(!empty($trydefault) && array_key_exists($trydefault,$datasets)) {
		return $datasets[$trydefault];
	} else {
		return $datasets[$wdDefaultViewDataSet];
	}
}


/**
 * Load dataset definitions from the database if necessary.
 *
 * @return an array of all available datasets
**/
function &wdGetDataSets() {

	static $datasets, $wgGroupPermissions;
	if(empty($datasets)) {
		// Load defs from the DB
		$dbs =& wfGetDB(DB_SLAVE);
		$res=$dbs->select('wikidata_sets', array('set_prefix'));

		while($row=$dbs->fetchObject($res)) {

			$dc=new DataSet();
			$dc->setPrefix($row->set_prefix);
			if($dc->isValidPrefix()) {
				$datasets[$row->set_prefix]=$dc;
				wfDebug("Imported data set: ".$dc->fetchName()."\n");
			} else {
				wfDebug($row->set_prefix . " does not appear to be a valid dataset!\n");
			}
		}
	}
	return $datasets;
}

class DataSet {

	private $dataSetPrefix;
	private $isValidPrefix=false;
	private $fallbackName='';
	private $dmId=0; # the dmId of the dataset name

	public function getPrefix() {
		return $this->dataSetPrefix;
	}

	public function isValidPrefix() {
		return $this->isValidPrefix;
	}

	public function setDefinedMeaningId($dmid) {
		$this->dmId=$dmid;
	}
	public function getDefinedMeaningId() {
		return $this->dmId;
	}

	public function setValidPrefix($isValid=true) {
		$this->isValidPrefix=$isValid;
	}

	public function setPrefix($cp) {

		$fname="DataSet::setPrefix";

		$dbs =& wfGetDB(DB_SLAVE);
		$this->dataSetPrefix=$cp;
		$sql="select * from wikidata_sets where set_prefix=".$dbs->addQuotes($cp);
		$res=$dbs->query($sql);
		$row=$dbs->fetchObject($res);
		if($row->set_prefix) {
			$this->setValidPrefix();
			$this->setDefinedMeaningId($row->set_dmid);
			$this->setFallbackName($row->set_fallback_name);
		} else {
			$this->setValidPrefix(false);
		}
	}

	// Fetch!
	function fetchName() {
		global $wgUser, $wdTermDBDataSet;
		if($wdTermDBDataSet) {
			$userLanguage=$wgUser->getOption('language');
			$spelling=getSpellingForLanguage($this->dmId, $userLanguage, 'en',$wdTermDBDataSet);
			if($spelling) return $spelling;
		}
		return $this->getFallbackName();
	}

	public function getFallbackName() {
		return $this->fallbackName;
	}

	public function setFallbackName($name) {
		$this->fallbackName=$name;
	}

	function __toString() {
		return $this->getPrefix();
	}

}
