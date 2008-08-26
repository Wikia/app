<?php
/**
 * 
 * 
 */
 
class SearchRankTracker extends SpecialPage {
 
 private $mEntry = null;
 private $mFormErrors = array();
 private $mGraphWidth = 780;
 private $mGraphHeight = 280;
 	
	public function __construct() {
		global $wgExtensionMessagesFiles;
		
		// initialise messages
		$wgExtensionMessagesFiles['SearchRankTracker'] = dirname(__FILE__) . '/SpecialSearchRankTracker.i18n.php';
		wfLoadExtensionMessages('SearchRankTracker');

		parent::__construct( "SearchRankTracker"  /*class*/, 'searchranktracker' /*restriction*/, true);

	}
 	
	public function execute() {
		global $wgUser, $wgRequest, $wgCityId, $wgOut;
	
		// tmp hack
		$aAllowedUsers = array( '792596' );

		if(!$wgUser->isAllowed('searchranktracker') && !in_array($wgUser->getId(), $aAllowedUsers)) {
			$this->displayRestrictionError();
			return;
		}

		$this->mTitle = Title::makeTitle(NS_SPECIAL, 'SearchRankTracker');
		$this->mEntry = new SearchRankEntry($wgRequest->getVal('entryId'));

		$sAction = $wgRequest->getVal('action');
		
		if($wgRequest->wasPosted() && $wgRequest->getVal('entrySubmit')) {
			// edit form submitted
			if(!$wgRequest->getVal('entryPage')) {
				$this->mFormErrors[] = 'searchranktracker-page-name-required';
			}
			if(!$wgRequest->getVal('entryPhrase')) {
				$this->mFormErrors[] = 'searchranktracker-serach-phrase-required';
			}
			
			$this->mEntry->setPageName($wgRequest->getVal('entryPage'));
			$this->mEntry->setPhrase($wgRequest->getVal('entryPhrase'));

			if(!count($this->mFormErrors)) {
				// update entry
				$this->mEntry->setCityId($wgCityId);
				$this->mEntry->update();

				$wgOut->redirect($this->mTitle->getFullUrl('action=list'));
			}
			else {
				$sAction = 'edit';
			}
		}
		
		$this->setHeaders();
				
		switch($sAction) {
			case 'edit':
				$this->editEntry();
				break;
			case 'renderGraph':
				$this->renderGraph();
				break;
			case 'delete':
			 $this->deleteEntry();
			 break;
			case 'list':
			default:
				$this->showEntryList();
		}
			 		
	}
 	
	private function renderGraph() {
		global $wgOut, $wgSearchRankTrackerConfig, $wgAutoloadClasses, $IP;
		wfProfileIn( __METHOD__ );

		// jpgraph
		$wgAutoloadClasses['Graph'] = $IP . '/lib/jpgraph-2.3.3/src/jpgraph.php';
		$wgAutoloadClasses['LinePlot'] = $IP . '/lib/jpgraph-2.3.3/src/jpgraph_line.php';
		
		$wgOut = null;
		
		if($this->mEntry->getId()) {
			$dbr = wfGetDB(DB_SLAVE);
			
   $aDataX = array();
   $aDataY = array();
   $iMax = 0;
   $iMin = 99999;
   			
			$bShowGraph = false;
			foreach($wgSearchRankTrackerConfig['searchEngines'] as $sEngineName => $aEngineConfig) {
				$oResource = $this->mEntry->getRankResults($sEngineName , date('Y'), date('m'), date('d'), $wgSearchRankTrackerConfig['graphDaysBackNum']);

			 $aDataY[$sEngineName] = array();
			 $iResultsCount = 0;
				while($oResultRow = $dbr->fetchObject($oResource)) {
					// prepare data for y axis
					$aDataY[$sEngineName][$oResultRow->date_formatted] = $oResultRow->rre_rank;
					
					// prepare data for x axis
					if(!isset($aDataX[strtotime($oResultRow->date_formatted)])) {
						$aDataX[strtotime($oResultRow->date_formatted)] = $oResultRow->date_formatted; 
					}
					
					if($sEngineName == 'google') {
						if($oResultRow->rre_rank > $iMax) {
							$iMax = $oResultRow->rre_rank;
						}
						if($oResultRow->rre_rank < $iMin) {
							$iMin = $oResultRow->rre_rank;
						}
					}
					$iResultsCount++;
					if(($iResultsCount >= 2) && ($bShowGraph == false)) {
						$bShowGraph = true;
					}
				}
			}
			
			if($bShowGraph) {
				ksort($aDataX);
				
				$graph = new Graph( $this->mGraphWidth, $this->mGraphHeight );
				$graph->SetAxisStyle( AXSTYLE_YBOXOUT );
				$graph->SetMarginColor( 'white' );
				$graph->SetScale( "textlin" );
				$graph->SetFrame( false );
				$graph->SetMargin( 30, 50, 30, 80 );
	
				$graph->title->Set( $this->mEntry->getPageName() . " - \"" . $this->mEntry->getPhrase() . "\"  (high:$iMin, low:$iMax)" );
				$graph->yaxis->HideZeroLabel();
				$graph->yaxis->SetLabelFormatCallback( create_function('$value', 'return round(-$value);') );
				
				$graph->ygrid->SetFill( true, '#EFEFEF@0.5', '#BBCCFF@0.5' );
				$graph->xgrid->Show();
			
				$graph->xaxis->SetTickLabels(array_values($aDataX));
				$graph->xaxis->SetLabelAngle(90);
				
				$nullData = true;
				foreach($aDataY as $sEngineName => $aData) {
					// finall preparing data for y axis
					$aPlotData = array();
					foreach($aDataX as $sDate) {
						if($aData[$sDate]) {
							$aPlotData[] = -$aData[$sDate];
							$nullData = false;
						}
						else {
							$aPlotData[] = 'x';
						}
					}
					
					$plot = new LinePlot($aPlotData);
					$plot->mark->SetType($wgSearchRankTrackerConfig['searchEngines'][$sEngineName]['graphMark']);
					$plot->SetColor($wgSearchRankTrackerConfig['searchEngines'][$sEngineName]['graphColor']);
					$plot->SetLegend(ucfirst($sEngineName));
					
					if($sEngineName == 'google') {
						$plot->SetWeight(2);
					}
					
					$graph->Add($plot);				
				}
	
				if(!$nullData) {
					$graph->legend->SetShadow( 'gray@0.4', 5 );
					$graph->legend->SetPos( 0.1, 0.1, 'right', 'top' );			
					$graph->Stroke();					
				}
				else {
					// only zero/null values, display placeholder
					$sImageBody = file_get_contents(dirname(__FILE__) . '/no_data.png');
	
					header("Content-type: image/jpeg");
					header("Content-length: " . strlen($sImageBody));
					
					print $sImageBody;					
				}
			}
			else {
				// not enough data for plotting, display placeholder
				$sImageBody = file_get_contents(dirname(__FILE__) . '/scheduled.png');

				header("Content-type: image/jpeg");
				header("Content-length: " . strlen($sImageBody));
				
				print $sImageBody;
			}
		} // if(mEntry->getId()) 
		
		wfProfileOut( __METHOD__ );
		exit;
	}

	private function showEntryList() {
		global $wgOut;
		wfProfileIn( __METHOD__ );

		$aEntries = SearchRankEntry::getList();
		
		$oTemplate = new EasyTemplate(dirname( __FILE__ ) . '/templates/');
		$oTemplate->set_vars( 
			array(
				'title' => $this->mTitle,
				'entries' => $aEntries
			)
		);
		
		$wgOut->setPageTitle(wfMsg('searchranktracker-entry-list'));
		$wgOut->addHTML($oTemplate->execute('entryList'));

		wfProfileOut( __METHOD__ );
	}

 private function editEntry() {
 	global $wgRequest, $wgOut, $wgServer;
		wfProfileIn( __METHOD__ );

		$oTemplate = new EasyTemplate(dirname( __FILE__ ) . '/templates/');
		$oTemplate->set_vars( 
			array(
		 	'title' => $this->mTitle,
		 	'wikiUrl' => $wgServer,
				'entry' => $this->mEntry,
				'formErrors' => $this->mFormErrors
			)
		);
		
		$wgOut->setPageTitle(wfMsg('searchranktracker-edit-entry'));
		$wgOut->addHTML($oTemplate->execute('entryEditForm'));
		
		wfProfileOut( __METHOD__ );
 }
 
 private function deleteEntry() {
		global $wgOut;
		wfProfileIn( __METHOD__ );
		
		if($this->mEntry->getId()) {
			$this->mEntry->delete();
		}
		
		$wgOut->redirect($this->mTitle->getFullUrl('action=list'));
		wfProfileOut( __METHOD__ );
 }
 
 /**
  * (ajax) checking whether page exists on wiki
  * @return array result response (json encoded)
  */
 public static function axCheckPage() {
 	global $wgRequest;
 	wfProfileIn( __METHOD__ );	
 	
 	$oTitle = Title::newFromText($wgRequest->getVal('name'));
 	$oArticle = new Article($oTitle);

 	$aResponse = array(
			'pageUrl' => urldecode($oTitle->getFullUrl()),
			'result' => 'not_found',
			'mainPage' => SearchRankTracker::isWikiMainPage($oTitle)
		);
 	
		if($oArticle->exists()) {
			$aResponse['result'] = 'exists';
		}
 	
		if(!function_exists('json_encode'))  {
			$oJson = new Services_JSON();
		 $sJson = $oJson->encode($aResponse);
		}
		else {
			$sJson = json_encode($aResponse);
		}
		
		wfProfileOut( __METHOD__ );
		return $sJson;
 }

	public static function isWikiMainPage($oTitle) {		
		$sMainPage = wfMsgForContent('Mainpage');
		
		return ($oTitle->getText() == $sMainPage);
	}
 	
}
