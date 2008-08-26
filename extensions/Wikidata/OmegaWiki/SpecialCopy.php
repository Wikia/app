<?php
if (!defined('MEDIAWIKI')) die();
/**
 * A Special Page extension to copy defined meanings between datasets.
 * 
 * Copied over from SpecialConceptMapping.
 * User Interface temporarily retained (but currently flawed)
 * Web API will be implemented
 * Minimal documentation is available by calling with &action=help, as a parameter
 * @addtogroup Extensions
 *
 * @author Erik Moeller <Eloquence@gmail.com>	(Possibly some remaining code)
 * @author Kim Bruning <kim@bruning.xs4all.nl>
 # @author Alan Smithee <Alan.Smithee@brown.paper.bag> (if code quality improves, may yet claim)
 * @license GPLv2 or later.
 */


$wgExtensionFunctions[] = 'wfSpecialCopy';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'SpecialCopy',
	'author' => 'Alan Smithee',
);

function wfSpecialCopy() {
	# Add messages
	#require_once "$IP/includes/SpecialPage.php";

        global $wgMessageCache;
        $wgMessageCache->addMessages(array('Copy'=>'Wikidata: Copy'),'en');
                
	require_once("Wikidata.php");
	require_once("WikiDataAPI.php");
	require_once("Utilities.php");
	require_once("DefinedMeaningModel.php");
	require_once("Copy.php");
	class SpecialCopy extends UnlistedSpecialPage {

		function SpecialCopy() {
			UnlistedSpecialPage::UnlistedSpecialPage( 'Copy' );
		}
		function execute( $par ) {
			global $wgOut, $wgRequest, $wgTitle, $wgUser, $wdTermDBDataSet;

			#$wgOut->setPageTitle("Special:Copy");
			if(!$wgUser->isAllowed('wikidata-copy')) {

				$wgOut->addHTML(wfMsgSc("Permission_denied"));
				return false;
			}

			$action=$wgRequest->getText('action');
			if(!$action) {
				$this->ui();
			} elseif ($action=="copy") {
				$this->copy_by_param();
			} elseif ($action=="list") {
				$this->list_sets();
			} elseif ($action=="help"){
				$this->help();
			} else {
				$wgOut->addWikiText(wfMsgSc("no_action_specified",$action));	
				$wgOut->addWikiText(wfMsgSc("copy_help"));
			}
		}

		/** reserved for ui elements */
		protected function ui() {

			global $wgOut ;
			$wgOut->addWikiText(wfMsgSc("no_action_specified"));

		}

		/** display a helpful help message. 
		 * (if desired)
		 */
		protected function help() {
			global $wgOut;
			$wgOut->addWikiText("<h2>Help</h2>");
			$wgOut->addWikiText(wfMsgSc("copy_help"));
		}
		
		/**read in and partially validate parameters,
		 * then call _doCopy()
		 */
		protected function copy_by_param() {
			global 
				$wgRequest, $wgOut;
			
			$dmid_dirty=$wgRequest->getText("dmid");
			$dc1_dirty=$wgRequest->getText("dc1");
			$dc2_dirty=$wgRequest->getText("dc2");	

			$abort=false; 	# check all input before aborting

			if (is_null($dmid_dirty)) {
				$wgOut->addWikiText(wfMsgSc("please_provide_dmid"));
				$abort=true;
			}
			if (is_null($dc1_dirty)) {
				$wgOut->addWikiText(wfMsgSc("please_provide_dc1"));
				$abort=true;
			}
			if (is_null($dc2_dirty)) {
				$wgOut->addWikiText(wfMsgSc("please_provide_dc2"));
				$abort=true;
			}

			if ($abort)
				return;

			#seems ok so far, let's try and copy.
			$success=$this->_doCopy($dmid_dirty, $dc1_dirty, $dc2_dirty);
			if ($success)
				$this->autoredir();
			else
				$wgOut->addWikiText(wfMsgSc("copy_unsuccessful"));
		}

		/** automatically redirects to another page.
		 * make sure you haven't used $wgOut before calling this!
		 */
		protected function autoredir() {
			global 
				$wgTitle, $wgOut, $wgRequest;

			$dmid_dirty=$wgRequest->getText("dmid");	
			$dc1_dirty=$wgRequest->getText("dc1");	
			$dc2_dirty=$wgRequest->getText("dc2");	

			# Where should we redirect to?
			$meanings=getDefinedMeaningDataAssociatedByConcept($dmid_dirty, $dc1_dirty);
			$targetdmm=$meanings[$dc2_dirty];
			$title=$targetdmm->getTitleObject();
			$url=$title->getLocalURL("dataset=$dc2_dirty&action=edit");

			# do the redirect
			$wgOut->disable();
			header('Location: '.$url);
			#$wgOut->addHTML("<a href=\"$url\">$url</a>");
		}


		/* Using Copy.php; perform a copy of a defined meaning from one dataset to another,
		   provided the user has permission to do so,*/
		protected function _doCopy($dmid_dirty, $dc1_dirty, $dc2_dirty) {
			global 
				$wgCommunityEditPermission, $wgOut, $wgUser, $wgCommunity_dc;
			
			# escape parameters
			$dmid=mysql_real_escape_string($dmid_dirty);
			$dc1=mysql_real_escape_string($dc1_dirty);
			$dc2=mysql_real_escape_string($dc2_dirty);

			# check permission
			if (!($wgUser->isAllowed('wikidata-copy')) or $dc2!=$wgCommunity_dc) {
				$wgOut->addHTML(wfMsgSc("Permission_denied"));
				return false; # we didn't perform the copy.
			}

			# copy
			CopyTools::newCopyTransaction($dc1, $dc2);
			$dmc=new DefinedMeaningCopier($dmid, $dc1, $dc2);
			$dmc->dup(); 

			# For purposes of current "edit copy", 
			# having the dm be already_there() is ok.
			# (hence commented out)
			#if ($dmc->already_there() ) {
			#	$wgOut->addHTML(wfMsgSc("already_there"));
			#	return false;
			#}

			return true; # seems everything went ok.
	
		}
	}
	SpecialPage::addPage( new SpecialCopy );
	
}

