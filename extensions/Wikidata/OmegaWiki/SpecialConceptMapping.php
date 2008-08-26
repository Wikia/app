<?php
if (!defined('MEDIAWIKI')) die();
/**
 * A Special Page extension to create concept-mappings
 * also provides a web-api. Minimal documentation is available by calling with &action=help, as a parameter
 * @addtogroup Extensions
 *
 * @author Erik Moeller <Eloquence@gmail.com>
 * @author Kim Bruning <kim@bruning.xs4all.nl>
 * @license  GPLv2 or later
 */


$wgExtensionFunctions[] = 'wfSpecialConceptMapping';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'SpecialConceptMapping',
	'author' => 'Kim Bruning',
);

function wfSpecialConceptMapping() {
	# Add messages
	#require_once "$IP/includes/SpecialPage.php";

        global $wgMessageCache;
        $wgMessageCache->addMessages(array('conceptmapping'=>'Wikidata: Concept mapping'),'en');
                
	require_once("Wikidata.php");
	require_once("WikiDataAPI.php");
	require_once("Utilities.php");
	require_once("DefinedMeaningModel.php");
	class SpecialConceptMapping extends SpecialPage {

		function SpecialConceptMapping() {
			SpecialPage::SpecialPage( 'ConceptMapping' );
		}

		function execute( $par ) {
			global $wgOut, $wgRequest, $wgTitle, $wgUser, $wdTermDBDataSet;
			$wgOut->setPageTitle("ConceptMapping");

			if(!$wgUser->isAllowed('editwikidata-'.$wdTermDBDataSet)) {
				$wgOut->addHTML(wfMsgSc("Permission_denied"));
				return false;
			}
			$action=$wgRequest->getText('action');
			if(!$action) {
				$this->ui();
			} elseif ($action=="insert"){
				$this->insert();
			} elseif ($action=="get"){
				$this->get();
			} elseif ($action=="list_sets"){
				$this->list_sets();
			} elseif ($action=="help"){
				$this->help();
			} elseif ($action=="get_associated"){
				$this->get_associated();
			} else {
				$wgOut->addWikiText(wfMsgSc("conceptmapping_no_action_specified",$action));	
				$wgOut->addWikiText(wfMsgSc("conceptmapping_help"));
			}
		}

		protected function ui() {

			global $wgOut, $wgRequest, $wgUser;
			$lang=$wgUser->getOption("language");
			require_once("forms.php");			
			$wgOut->addHTML(wfMsgSc("conceptmapping_uitext"));
			$sets=wdGetDataSets();
			$options = array();
			$html="";
			$mappings=array();
			$rq=array();

			foreach ($sets as $key=>$setObject) {
				$set=$setObject->getPrefix();
				$rq[$set]=$wgRequest->getText("set_".$set);
				$rq[$set]=trim($rq[$set]);
				$rq[$set]=(int)$rq[$set];
				if($rq[$set]) {
					$dmModel=new DefinedMeaningModel($rq[$set],null,$setObject);
					$defaultSel=$dmModel->getSyntransByLanguageCode($lang);
					$options[$setObject->fetchName()]=getSuggest("set_$set", 'defined-meaning',array(), $rq[$set], $defaultSel, array(0), $setObject);
				} else {
					$options[$setObject->fetchName()]=getSuggest("set_$set", 'defined-meaning', array(), null, null, array(0), $setObject);
				}

			}
			$wgOut->addHTML(getOptionPanel($options));
			$noerror=$wgRequest->getText("suppressWarnings");

			foreach ($sets as $key=>$setObject) {
				$set=$setObject->getPrefix();
				if(!$rq[$set]) {
					$wgOut->addHTML(' <span style="color:yellow">['.wfMsgSc("dm_not_present").']</span>');
				} else  {
					$dmModel=new DefinedMeaningModel($rq[$set],null,$setObject);
					$dmModel->checkExistence();
					if ($dmModel->exists()) {
						$id=$dmModel->getId();
						$title=$dmModel->getTitleText();
					} else {
						$id=null;
						$title=null;
					}
					if(!$noerror) {
						$wgOut->addHTML("$key: ".$rq[$set]." ($title)");
					}
					if ($id!=null) {
						$mappings[$key]=$id;
						if(!$noerror) {
							$wgOut->addHTML(' <span style="color:green">['.wfMsgSc("dm_OK").']</span>');
						}
					} else {
						if(!$noerror) {
							$wgOut->addHTML(' <span style="color:red">['.wfMsgSc("dm_not_found").']</span>');
						}
					}
				}
				$wgOut->addHTML("<br />\n");	
			}
			if (sizeOf($mappings)>1) { 
				createConceptMapping($mappings);
				$wgOut->addHTML(wfMsgSc("mapping_successful"));
			} else {
				$wgOut->addHTML(wfMsgSc("mapping_unsuccessful"));
			}

		}

		protected function getDm($dataset) {
			global $wgRequest;
			$setname="set_".$dataset->getPrefix();
			$rq=$wgRequest->getText($setname);
			$html=getTextBox($setname, $rq);
			return $html;
		}

		
		protected function help() {
			global $wgOut;
			$wgOut->addWikiText("<h2>Help</h2>");
			$wgOut->addWikiText(wfMsgSc("conceptmapping_help"));
		}
		
		protected function insert() {
			global 
				$wgRequest, $wgOut;
			
			# $wgRequest->getText( 'page' );
			$sets=wdGetDataSets();
			#$requests=$wgRequest->getValues();
			$wgOut->addWikiText("<h2>".wfMsgSc("will_insert")."</h2>");
			$map=array();
			foreach ($sets as $key => $set) {
				$dc=$set->getPrefix();
				$dm_id=$wgRequest->getText($dc);
				$name=$set->fetchName();

				$dm_id_ui=$dm_id; # Only for teh purdy
				if ($dm_id_ui==null)
					$dm_id_ui="unset";  
				$wgOut->addWikiText("$name ->$dm_id_ui");
				$map[$dc]=$dm_id;
			#$dbr=&wfGetDB(DB_MASTER);
			}
			createConceptMapping($map);
		}

		protected function get() {
			global 
				$wgOut, $wgRequest;
			$concept_id=$wgRequest->getText("concept");
			$wgOut->addWikiText("<h2>".wfMsgSc("contents_of_mapping")."</h2>");
			$map=readConceptMapping($concept_id);
			#$sets=wdGetDataSets();

			foreach ($map as $dc => $dm_id) {
				$wgOut->addWikiText("$dc -> $dm_id");
			}
		}

		protected function list_sets() {
			global $wgOut;
			$wgOut->addWikiText("<h2>".wfMsgSc("available contexts")."</h2>");
			$sets=wdGetDataSets();
			foreach ($sets as $key => $set) {
				$name=$set->fetchName();
				$wgOut->addWikiText("$key => $name");
			}
		}

		protected function get_associated() {
			global $wgOut, $wgRequest;
			$dm_id=$wgRequest->getText("dm");
			$dc=$wgRequest->getText("dc");
			$map=getAssociatedByConcept($dm_id, $dc);
			foreach ($map as $dc => $dm_id) {
				$wgOut->addWikiText("$dc -> $dm_id");
			}
		}

	}

	SpecialPage::addPage( new SpecialConceptMapping );
	
}

