<?php
/*******************************************************************************
 *
 *	Copyright (c) 2010 Frank Dengler, Jonas Bissinger
 *
 *   Semantic Project Management is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   Semantic Project Management is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with Semantic Project Management. If not, see <http://www.gnu.org/licenses/>.
 *******************************************************************************/

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

/**
 *
 * @author Frank Dengler, Jonas Bissinger
 *
 * @ingroup SemanticProjectManagement
 *
 */


class SPMWBS extends SMWResultPrinter {
	protected $m_projectmanagementclass;
	
	
	protected function readParameters($params,$outputmode) {

		SMWResultPrinter::readParameters($params,$outputmode);

		// init breakdown instance
		$this->m_projectmanagementclass = new ProjectManagementClass();
		$this->m_projectmanagementclass->setInternals();
		
	}
	public function getMimeType($res) {
		return 'text/xml';
	}
	
	public function getFileName($res) {
		if ($this->getSearchLabel(SMW_OUTPUT_WIKI) != '') {
			return str_replace(' ', '_',$this->getSearchLabel(SMW_OUTPUT_WIKI)) . '.xml';
		} else {
			return 'MSProject.xml';
		}
	}

	public function getQueryMode($context) {
		return ($context==SMWQueryProcessor::SPECIAL_PAGE)?SMWQuery::MODE_INSTANCES:SMWQuery::MODE_NONE;
	}

	public function getName() {
		return wfMsg('spm_printername_wbs');
	}

	
	
	/**
	 *	This method renders the result set provided by SMW according to the printer
	 * 
	 *  @param res				SMWQueryResult, result set of the ask query provided by SMW
	 *  @param outputmode		?
	 *  @return				String, rendered HTML output of this printer for the ask-query
	 *
	 */
	protected function getResultText($res, $outputmode) {
		global $wgContLang; // content language object
		$result = '';
		$m_outlineLevel= 0;
		$hasChildren=array();
		$m_outlineLevel++;
		$m_seedCategory = "";
		$m_seedName = "";
		$m_categories = $this->m_projectmanagementclass->getCategories();
		$m_properties = $this->m_projectmanagementclass->getProperties();
		if ($outputmode == SMW_OUTPUT_FILE) { 
	
		$queryparts = preg_split("/]]/", $res->getQueryString());
		$taskname = str_replace("[[","",$queryparts[0]);
		
		if ((strpos($taskname,"Category:") === false)){
			
			//case: [[{{PAGENAME}}]]
			if (($res->getCount() == 1)){
				
				$m_seedName = trim(str_replace("[[","",str_replace("]]","",$res->getQueryString())));
				$firstQuery = smwfGetStore()->getQueryResult(SMWQueryProcessor::createQuery('[['.$m_seedName.']]',array(),SMWQueryProcessor::INLINE_QUERY,'',$res->getPrintRequests()));						
				//$firstQuery = smwfGetStore()->getQueryResult(SMWQueryProcessor::createQuery('[[Part of::'.$m_seedName.']]',array(),SMWQueryProcessor::INLINE_QUERY,'',$res->getPrintRequests()));
				
			}
			else {
				return "<html><body>ERROR: Query: ".$res->getQueryString()."is invalid! Valid formats: [[Category:SampleCategory]] or: [[{{PAGENAME}}]]</body></html>";				
			} 
		}
		
		//case: [[Category:SampleCategory]]
		else {
			$m_seedCategory = trim(str_replace("Category:","",$taskname));
			
			if (in_array($m_seedCategory,$m_categories)){
			
				$firstQuery = smwfGetStore()->getQueryResult(SMWQueryProcessor::createQuery('[[Category:'.$m_seedCategory.']]',array(),SMWQueryProcessor::INLINE_QUERY,'',$res->getPrintRequests()));						
				
			}
			else {
				return "<html><body>ERROR: Category: ".$m_seedCategory." has not been defined on Special:SemanticProjectManagement </body></html>";				
			} 	
		}
		
		$this->m_projectmanagementclass->setName("ProjectManagementClass");
		
			
		//	echo "First Query: ".$firstQuery->getQueryString()."<br/>";

		//generate seed task	
		
		$task = $this->m_projectmanagementclass->makeTask("seed",0);
		$task->addWBS(0,0);
		$task->setUid(0);

		$hasChildren = $this->m_projectmanagementclass->getTaskResults($firstQuery,$outputmode, $m_outlineLevel, $task);
		
		$processedChildren = array();
		$hasChild=true;
		while ($hasChild){
			$hasChild = false;
			$allTempChildren = array();
			$m_outlineLevel++;

			foreach ($hasChildren as $child){

				if (in_array($child,$processedChildren)){
						
				} else {
						

					if ((isset($m_properties[$child->getLevel()])) && isset($m_categories[$child->getLevel()])) {
											
						//build new Query
						if ($child->getLevel() != 0)
					    $res2 = smwfGetStore()->getQueryResult(SMWQueryProcessor::createQuery('[[Category:'.$m_categories[$child->getLevel()].']] [['.$m_properties[$child->getLevel()].'::'.$child->getPage().']]',array(),SMWQueryProcessor::INLINE_QUERY,'',$res->getPrintRequests()));						
					    else {
					    	if (isset($m_properties[1])) $res2 = smwfGetStore()->getQueryResult(SMWQueryProcessor::createQuery('[[Category:'.$m_categories[0].']] [['.$m_properties[1].'::'.$child->getPage().']]',array(),SMWQueryProcessor::INLINE_QUERY,'',$res->getPrintRequests()));
					    	else $res2 = smwfGetStore()->getQueryResult(SMWQueryProcessor::createQuery('[['.$child->getPage().']]',array(),SMWQueryProcessor::INLINE_QUERY,'',$res->getPrintRequests()));
					    }
					    
					    
					//	echo "Next Query: ".$res2->getQueryString()." Level: ".$m_outlineLevel."<br/>";
						
						$queryresults = $this->m_projectmanagementclass->getTaskResults($res2, $outputmode, $m_outlineLevel,$child);
						$processedChildren[] = $child;
						foreach ($queryresults as $temp)
						$allTempChildren[] = $temp;
					}
						
				}
			}

			$hasChildren = $allTempChildren;
			if (count($hasChildren)>0)
				$hasChild = true;
		}

		$task->addWBS(1,0);
		
		
		$result .= $this->m_projectmanagementclass->getXML();
		
		} else { // just make xml file
						if ($this->getSearchLabel($outputmode)) {
				$label = $this->getSearchLabel($outputmode);
			} else {
				$label = wfMsgForContent('spm_wbs_link');
			}
			$link = $res->getQueryLink($label);
			$link->setParameter('wbs','format');
			if ($this->getSearchLabel(SMW_OUTPUT_WIKI) != '') {
				$link->setParameter($this->getSearchLabel(SMW_OUTPUT_WIKI),'searchlabel');
			}
			if (array_key_exists('limit', $this->m_params)) {
				$link->setParameter($this->m_params['limit'],'limit');
			} else { // use a reasonable default limit
				$link->setParameter(500,'limit');
			}
			$result .= $link->getText($outputmode,$this->mLinker);
			$this->isHTML = ($outputmode == SMW_OUTPUT_HTML); // yes, our code can be viewed as HTML if requested, no more parsing needed
			
			// make xml file
		
		
		
		}
		return $result;


	}
}
