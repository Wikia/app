<?php
// this file is UTF-8 encoded and contains some special characters.
// Editing this file with an ASCII editor will potentially destroy it!

class DPL {
	
	var $mArticles;
	var $mHeadingType; 	// type of heading: category, user, etc. (depends on 'ordermethod' param)
	var $mHListMode; 	// html list mode for headings
	var $mListMode;		// html list mode for pages
	var $mEscapeLinks;	// whether to escape img/cat or not
	var $mAddExternalLink; // whether to add the text of an external link or not
	var $mIncPage; 		// true only if page transclusion is enabled
	var $mIncMaxLen; 	// limit for text to include
	var $mIncSecLabels         = array(); // array of labels of sections to transclude
	var $mIncSecLabelsMatch    = array(); // array of match patterns for sections to transclude
	var $mIncSecLabelsNotMatch = array(); // array of NOT match patterns for sections to transclude
	var $mIncParsed;    // whether to match raw parameters or parsed contents
	var $mParser;
	var $mParserOptions;
	var $mParserTitle;
	var $mLogger; 		// DPLLogger
	var $mOutput;
	var $mReplaceInTitle;
 	var $filteredCount = 0;	// number of (filtered) row count
	var $nameSpaces;
	var $mTableRow;	// formatting rules for table fields
	
	function DPL($headings, $bHeadingCount, $iColumns, $iRows, $iRowSize, $sRowColFormat, $articles, $headingtype, $hlistmode, 
				 $listmode, $bescapelinks, $baddexternallink, $includepage, $includemaxlen, $includeseclabels, $includeseclabelsmatch, 
				 $includeseclabelsnotmatch, $includematchparsed, &$parser, $logger, $replaceInTitle, $iTitleMaxLen,
				 $defaultTemplateSuffix, $aTableRow, $bIncludeTrim, $iTableSortCol, $updateRules, $deleteRules ) {
	   	global $wgContLang;
		$this->nameSpaces = $wgContLang->getNamespaces();
		$this->mArticles = $articles;
		$this->mListMode = $listmode;
		$this->mEscapeLinks = $bescapelinks;
		$this->mAddExternalLink = $baddexternallink;
		$this->mIncPage = $includepage;
		if($includepage) {
			$this->mIncSecLabels         = $includeseclabels;
			$this->mIncSecLabelsMatch    = $includeseclabelsmatch;
			$this->mIncSecLabelsNotMatch = $includeseclabelsnotmatch;
			$this->mIncParsed            = $includematchparsed;
		}
			
		if (isset($includemaxlen)) $this->mIncMaxLen = $includemaxlen + 1;
		else					   $this->mIncMaxLen = 0;
		$this->mParser = $parser;
		$this->mParserOptions = $parser->mOptions;
		$this->mParserTitle = $parser->mTitle;
		$this->mLogger = $logger;
		$this->mReplaceInTitle = $replaceInTitle;
		$this->mTableRow = $aTableRow;
		
		if(!empty($headings)) {
			if ($iColumns!=1 || $iRows!=1) {
				$hspace = 2; // the extra space for headings
				// repeat outer tags for each of the specified columns / rows in the output
				// we assume that a heading roughly takes the space of two articles
				$count   = count($articles) + $hspace * count($headings); 
				if ($iColumns != 1) $iGroup = $iColumns;
				else				$iGroup = $iRows;
				$nsize   = floor($count / $iGroup);
				$rest    = $count - (floor($nsize) * floor($iGroup));
				if ($rest>0) $nsize += 1;
				$this->mOutput .= "{|".$sRowColFormat."\n|\n";
				if ($nsize<$hspace+1) $nsize=$hspace+1; // correction for result sets with one entry 
				$this->mHeadingType = $headingtype;
				$this->mHListMode = $hlistmode;
				$this->mOutput .= $hlistmode->sListStart;
				$nstart  = 0;
				$greml = $nsize; // remaining lines in current group
				$g=0;
				$offset=0;
				foreach($headings as $heading => $headingCount) {
					$headingLink = $articles[$nstart-$offset]->mParentHLink;
					$this->mOutput .= $hlistmode->sItemStart;
					$this->mOutput .= $hlistmode->sHeadingStart . $headingLink . $hlistmode->sHeadingEnd;
					if ($bHeadingCount) $this->mOutput .= $this->formatCount($headingCount);
					$offset+=$hspace;
					$nstart+=$hspace;
					$portion= $headingCount;
					$greml-=$hspace;
					do {
						$greml -= $portion;
						// $this->mOutput .= "nsize=$nsize, portion=$portion, greml=$greml";
						if ($greml>0) {
							$this->mOutput .= $this->formatList($nstart-$offset, $portion, $iTitleMaxLen, $defaultTemplateSuffix, $bIncludeTrim, $iTableSortCol, $updateRules, $deleteRules);
							$nstart += $portion;
							$portion=0;
							break;
						}
						else {
							$this->mOutput .= $this->formatList($nstart-$offset, $portion+$greml, $iTitleMaxLen, $defaultTemplateSuffix, $bIncludeTrim, $iTableSortCol, $updateRules, $deleteRules);
							$nstart += ($portion+$greml);
							$portion = (-$greml);
							if ($iColumns!=1) 	$this->mOutput .= "\n|valign=top|\n";
							else				$this->mOutput .= "\n|-\n|\n";
							++$g;
							// if ($rest != 0 && $g==$rest) $nsize -= 1;
							if ($nstart+$nsize > $count) $nsize = $count - $nstart;
							$greml=$nsize;
							if ($greml<=0) break;
						}
					} while ($portion>0);
					$this->mOutput .= $hlistmode->sItemEnd;
				}
				$this->mOutput .= $hlistmode->sListEnd;
				$this->mOutput .= "\n|}\n";
			}			
			else {
				$this->mHeadingType = $headingtype;
				$this->mHListMode = $hlistmode;
				$this->mOutput .= $hlistmode->sListStart;
				$headingStart = 0;
				foreach($headings as $heading => $headingCount) {
					$headingLink = $articles[$headingStart]->mParentHLink;
					$this->mOutput .= $hlistmode->sItemStart;
					$this->mOutput .= $hlistmode->sHeadingStart . $headingLink . $hlistmode->sHeadingEnd;
					if ($bHeadingCount) $this->mOutput .= $this->formatCount($headingCount);
					$this->mOutput .= $this->formatList($headingStart, $headingCount, $iTitleMaxLen, $defaultTemplateSuffix, $bIncludeTrim, $iTableSortCol, $updateRules, $deleteRules);
					$this->mOutput .= $hlistmode->sItemEnd;
					$headingStart += $headingCount;
				}
				$this->mOutput .= $hlistmode->sListEnd;
			}
		} else if ($iColumns!=1 || $iRows!=1) {
			// repeat outer tags for each of the specified columns / rows in the output
			$nstart  = 0;
			$count   = count($articles);
			if ($iColumns != 1) $iGroup = $iColumns;
			else				$iGroup = $iRows;
			$nsize   = floor($count / $iGroup);
			$rest    = $count - (floor($nsize) * floor($iGroup));
			if ($rest>0) $nsize += 1;
			$this->mOutput .= "{|".$sRowColFormat."\n|\n";
			for ($g=0;$g<$iGroup;$g++) {
				$this->mOutput .= $this->formatList($nstart, $nsize, $iTitleMaxLen, $defaultTemplateSuffix, $bIncludeTrim, $iTableSortCol, $updateRules, $deleteRules);
				if ($iColumns!=1) 	$this->mOutput .= "\n|valign=top|\n";
				else				$this->mOutput .= "\n|-\n|\n";
				$nstart = $nstart + $nsize;
				// if ($rest != 0 && $g+1==$rest) $nsize -= 1;
				if ($nstart+$nsize > $count) $nsize = $count - $nstart;
			}
			$this->mOutput .= "\n|}\n";
		} else if ($iRowSize>0) {
			// repeat row header after n lines of output
			$nstart  = 0;
			$nsize   = $iRowSize;
			$count   = count($articles);
			$this->mOutput .= '{|'.$sRowColFormat."\n|\n";
			do {
				if ($nstart+$nsize > $count) $nsize = $count - $nstart;
				$this->mOutput .= $this->formatList($nstart, $nsize, $iTitleMaxLen, $defaultTemplateSuffix, $bIncludeTrim, $iTableSortCol, $updateRules, $deleteRules);
				$this->mOutput .= "\n|-\n|\n";
				$nstart = $nstart + $nsize;
				if ($nstart >= $count) break;
			} while (true);
			$this->mOutput .= "\n|}\n";
		} else {
			$this->mOutput .= $this->formatList(0, count($articles), $iTitleMaxLen, $defaultTemplateSuffix, $bIncludeTrim, $iTableSortCol, $updateRules, $deleteRules);
		}
		
	}
	
	function formatCount($numart) {
		global $wgLang;
		if($this->mHeadingType == 'category')
			$message = 'categoryarticlecount';
		else 
			$message = 'dpl_articlecount';
		return '<p>' . $this->msgExt( $message, array( 'parse' ), $numart) . '</p>';
	}

	// substitute symbolic names within a user defined format tag
	function substTagParm($tag, $pagename, $article, $imageUrl, $nr, $titleMaxLength) {
		global $wgLang;
		if (strchr($tag,'%')<0) return $tag;
		$sTag = str_replace('%PAGE%',$pagename,$tag);
		$sTag = str_replace('%PAGEID%',$article->mID,$sTag);
		$sTag = str_replace('%NAMESPACE%',$this->nameSpaces[$article->mNamespace],$sTag);
		$sTag = str_replace('%IMAGE%',$imageUrl,$sTag);
		$sTag = str_replace('%EXTERNALLINK%',$article->mExternalLink,$sTag);

		$title = $article->mTitle->getText();
		if (strpos($title,'%TITLE%')>=0) {
			if ($this->mReplaceInTitle[0]!='') $title = preg_replace($this->mReplaceInTitle[0],$this->mReplaceInTitle[1],$title);
			if( isset($titleMaxLength) && (strlen($title) > $titleMaxLength)) $title = substr($title, 0, $titleMaxLength) . '...';
			$sTag = str_replace('%TITLE%',$title,$sTag);
		}

	    $sTag 								  = str_replace('%NR%',$nr,$sTag);
	    if ($article->mCounter  != '') 	$sTag = str_replace('%COUNT%',$article->mCounter,$sTag);
	    if ($article->mCounter  != '') 	$sTag = str_replace('%COUNTFS%',floor(log($article->mCounter)*0.7),$sTag);
	    if ($article->mCounter  != '') 	$sTag = str_replace('%COUNTFS2%',floor(sqrt(log($article->mCounter))),$sTag);
	    if ($article->mSize     != '') 	$sTag = str_replace('%SIZE%',$article->mSize,$sTag);
	    if ($article->mSize     != '') 	$sTag = str_replace('%SIZEFS%',floor(sqrt(log($article->mSize))*2.5-5),$sTag);
	    if ($article->mDate     != '')  {
		    // note: we must avoid literals in the code which could create confusion when transferred via http
		    //       therefore we write '%'.'DA...'
			if ($article->myDate != '') $sTag = str_replace('%'.'DATE%',$article->myDate,$sTag);
			else 		    		    $sTag = str_replace('%'.'DATE%',$wgLang->timeanddate($article->mDate, true),$sTag);
	   	}
	    if ($article->mRevision != '') 	$sTag = str_replace('%REVISION%',$article->mRevision,$sTag);
    	if ($article->mContribution!=''){
	    	$sTag = str_replace('%CONTRIBUTION%',$article->mContribution,$sTag);
	    	$sTag = str_replace('%CONTRIB%',$article->mContrib,$sTag);
    	   	$sTag = str_replace('%CONTRIBUTOR%',$article->mContributor,$sTag);
		}
		if ($article->mUserLink != '')	$sTag = str_replace('%USER%',$article->mUser,$sTag);
    	if ($article->mSelTitle!= '')	{
	    	if ($article->mSelNamespace==0)	$sTag = str_replace('%PAGESEL%',str_replace('_',' ',$article->mSelTitle),$sTag);
	    	else	{
		    	$sTag = str_replace('%PAGESEL%',$this->nameSpaces[$article->mSelNamespace].':'.str_replace('_',' ',$article->mSelTitle),$sTag);
	    	}
    	}
		if ($article->mImageSelTitle!= '')	$sTag = str_replace('%IMAGESEL%',str_replace('_',' ',$article->mImageSelTitle),$sTag);
	    if (!empty($article->mCategoryLinks) ) {
		    $sTag = str_replace('%'.'CATLIST%',implode(', ', $article->mCategoryLinks),$sTag);
		    $sTag = str_replace('%'.'CATBULLETS%','* '.implode("\n* ", $article->mCategoryLinks),$sTag);
		    $sTag = str_replace('%'.'CATNAMES%',implode(', ', $article->mCategoryTexts),$sTag);
	    }
	    else {
		    $sTag = str_replace('%'.'CATLIST%','',$sTag);
		    $sTag = str_replace('%'.'CATBULLETS%','',$sTag);
		    $sTag = str_replace('%'.'CATNAMES%','',$sTag);
	    }
		return $sTag;
	}
		
	function formatList($iStart, $iCount, $iTitleMaxLen, $defaultTemplateSuffix, $bIncludeTrim, $iTableSortCol, $updateRules, $deleteRules) {
		global $wgUser, $wgLang, $wgContLang;
		
		$mode = $this->mListMode;
		//categorypage-style list output mode
		if($mode->name == 'category') return $this->formatCategoryList($iStart, $iCount);
		
		//other list modes
		$sk = & $wgUser->getSkin();
		
		//process results of query, outputing equivalent of <li>[[Article]]</li> for each result,
		//or something similar if the list uses other startlist/endlist;
		$rBody='';
		// the following statement caused a problem with multiple columns:  $this->filteredCount = 0;
		for ($i = $iStart; $i < $iStart+$iCount; $i++) {

			$article = $this->mArticles[$i];
			$pagename = $article->mTitle->getPrefixedText();
			$imageUrl='';
			if ($article->mNamespace==6) {
				// calculate URL for existing images
				$img = Image::newFromName($article->mTitle->getText());
				if ($img && $img->exists()) $imageUrl = $img->getURL();
			}
			if ($this->mEscapeLinks && ($article->mNamespace==14 || $article->mNamespace==6) ) {
	        	// links to categories or images need an additional ":"
				$pagename = ':'.$pagename;
			}
			
			// Page transclusion: get contents and apply selection criteria based on that contents
			
			if ($this->mIncPage) {
				$matchFailed=false;
				if(empty($this->mIncSecLabels) || $this->mIncSecLabels[0]=='*') {        					// include whole article
					$title = $article->mTitle->getPrefixedText();
					if ($mode->name == 'userformat') $incwiki = '';
					else							 $incwiki = '<br/>';
					$text = $this->mParser->fetchTemplate(Title::newFromText($title));
					if ((count($this->mIncSecLabelsMatch)<=0 || $this->mIncSecLabelsMatch[0] == '' ||
						 !preg_match($this->mIncSecLabelsMatch[0],$text)==false) &&
						(count($this->mIncSecLabelsNotMatch)<=0 || $this->mIncSecLabelsNotMatch[0] == '' || 
						  preg_match($this->mIncSecLabelsNotMatch[0],$text)==false)) {
						if( $this->mIncMaxLen > 0 && (strlen($text) > $this->mIncMaxLen) ) {
							$text = DPLInclude::limitTranscludedText($text, $this->mIncMaxLen, ' [['.$title.'|..&rarr;]]');
						}
						$this->filteredCount = $this->filteredCount + 1;
	
						// update article if include=* and updaterules are given
						if ($updateRules!='') {
							$message = $this->updateArticleByRule($title,$text,$updateRules);
							// append update message to output
							$incwiki .= $message;
    					}
						else if ($deleteRules!='') {
							$message = $this->deleteArticleByRule($title,$text,$deleteRules);
							// append delete message to output
							$incwiki .= $message;
    					}
    					else {
	    					// append full text to output
	    					if (array_key_exists('0',$mode->sSectionTags)){
		    					$incwiki .= $this->substTagParm($mode->sSectionTags[0], $pagename, $article, $imageUrl, $this->filteredCount, $iTitleMaxLen);
		    					$pieces = array(0=>$text);
		    					$this->formatSingleItems($pieces, 0);
		    					$incwiki .= $pieces[0];
	    					}
	    					else $incwiki .= $text;
						}
					}
					else {
						continue;
					}
					
				} else {
					// identify section pieces
					$secPiece=array();
					$dominantPieces=false;
					// ONE section can be marked as "dominant"; if this section contains multiple entries
					// we will create a separate output row for each value of the dominant section
					// the values of all other columns will be repeated
					$secArray=array();
					
					foreach ($this->mIncSecLabels as $s => $sSecLabel) {
						$sSecLabel = trim($sSecLabel);
						if ($sSecLabel == '') break;
 						// if sections are identified by number we have a % at the beginning
 						if ($sSecLabel[0] == '%') $sSecLabel = '#'.$sSecLabel;
											
						$maxlen=-1;
						if($sSecLabel[0] != '{') {
							$limpos = strpos($sSecLabel,'[');
							$cutLink='default';
							if ($limpos>0 && $sSecLabel[strlen($sSecLabel)-1]==']') {
								$cutInfo=explode(" ",substr($sSecLabel,$limpos+1,strlen($sSecLabel)-$limpos-2),2);
								$sSecLabel=substr($sSecLabel,0,$limpos);
								$maxlen=intval($cutInfo[0]);
								if (isset($cutInfo[1])) $cutLink=$cutInfo[1];
							}
							if ($maxlen<0) $maxlen = -1;  // without valid limit include whole section
						}

						// find out if the user specified an includematch / includenotmatch condition
						if (count($this->mIncSecLabelsMatch)>$s && $this->mIncSecLabelsMatch[$s] != '') 
								$mustMatch = $this->mIncSecLabelsMatch[$s];
						else	$mustMatch = '';			
						if (count($this->mIncSecLabelsNotMatch)>$s && $this->mIncSecLabelsNotMatch[$s] != '')
								$mustNotMatch = $this->mIncSecLabelsNotMatch[$s];
						else	$mustNotMatch = '';			

						// if chapters are selected by number we get the heading from DPLInclude::includeHeading
						$sectionHeading[0]='';
						if($sSecLabel[0] == '#') {
							$sectionHeading[0]=substr($sSecLabel,1);
							// Uses DPLInclude::includeHeading() from LabeledSectionTransclusion extension to include headings from the page
							$secPieces = DPLInclude::includeHeading($this->mParser, $article->mTitle->getPrefixedText(), substr($sSecLabel, 1),'',
																$sectionHeading,false,$maxlen,$cutLink,$bIncludeTrim);
							if ($mustMatch!='' || $mustNotMatch!='') {
								$secPiecesTmp = $secPieces;
								$offset=0;
								foreach($secPiecesTmp as $nr => $onePiece ) {
									if (($mustMatch    !='' && preg_match($mustMatch   ,$onePiece)==false) ||
									    ($mustNotMatch !='' &&  preg_match($mustNotMatch,$onePiece)!=false) ) {
										array_splice($secPieces,$nr-$offset,1);
										$offset++;
									} 
								}	
							}
							$this->formatSingleItems($secPieces,$s);
							if (!array_key_exists(0,$secPieces)) break;  # to avoid matching against a non-existing array element
							$secPiece[$s] = $secPieces[0];
							for ($sp=1;$sp<count($secPieces);$sp++) {
								if (isset($mode->aMultiSecSeparators[$s])) { 
									$secPiece[$s] .= str_replace('%SECTION%',$sectionHeading[$sp],
																$this->substTagParm($mode->aMultiSecSeparators[$s], $pagename, $article, $imageUrl, 
																					$this->filteredCount, $iTitleMaxLen));
								}
								$secPiece[$s] .= $secPieces[$sp];
							}
 							if ($mode->iDominantSection>=0 && $s==$mode->iDominantSection && count($secPieces)>1)	$dominantPieces=$secPieces;
							if (($mustMatch!='' || $mustNotMatch!='') && count($secPieces)<=0) {
								$matchFailed=true; 	// NOTHING MATCHED
								break;
							}

						} else if($sSecLabel[0] == '{') {
							// Uses DPLInclude::includeTemplate() from LabeledSectionTransclusion extension to include templates from the page
 							$template1 = substr($sSecLabel,1,strpos($sSecLabel,'}')-1);
 							$template2 = str_replace('}','',substr($sSecLabel,1));
							$secPieces = DPLInclude::includeTemplate($this->mParser, $this, $s, $article, $template1, 
																	  $template2, $template2.$defaultTemplateSuffix,$mustMatch,
																	  $mustNotMatch,$this->mIncParsed,$iTitleMaxLen);
 							$secPiece[$s] = implode(isset($mode->aMultiSecSeparators[$s])? 
 								$this->substTagParm($mode->aMultiSecSeparators[$s], $pagename, $article, $imageUrl, $this->filteredCount, $iTitleMaxLen):'',$secPieces);
 							if ($mode->iDominantSection>=0 && $s==$mode->iDominantSection && count($secPieces)>1)	$dominantPieces=$secPieces;
							if (($mustMatch!='' || $mustNotMatch!='') && count($secPieces)<=1 && $secPieces[0]=='') {
								$matchFailed=true; 	// NOTHING MATCHED
								break;
							}
						} else {
							// Uses DPLInclude::includeSection() from LabeledSectionTransclusion extension to include labeled sections from the page
							$secPieces = DPLInclude::includeSection($this->mParser, $article->mTitle->getPrefixedText(), $sSecLabel,'', false, $bIncludeTrim);
 							$secPiece[$s] = implode(isset($mode->aMultiSecSeparators[$s])? 
 								$this->substTagParm($mode->aMultiSecSeparators[$s], $pagename, $article, $imageUrl, $this->filteredCount, $iTitleMaxLen):'',$secPieces);
 							if ($mode->iDominantSection>=0 && $s==$mode->iDominantSection && count($secPieces)>1)	$dominantPieces=$secPieces;
							if ( ($mustMatch    !='' && preg_match($mustMatch   ,$secPiece[$s])==false) ||
								 ($mustNotMatch !='' && preg_match($mustNotMatch,$secPiece[$s])!=false) ) {
								$matchFailed=true;
								break;
							}
						}
						
						// separator tags
						if (count($mode->sSectionTags)==1) {
							// If there is only one separator tag use it always
							$septag[$s*2] = str_replace('%SECTION%',$sectionHeading[0],$this->substTagParm($mode->sSectionTags[0], $pagename, $article, $imageUrl, $this->filteredCount, $iTitleMaxLen));
						}
						else if (isset($mode->sSectionTags[$s*2])) {
							$septag[$s*2] = str_replace('%SECTION%',$sectionHeading[0],$this->substTagParm($mode->sSectionTags[$s*2], $pagename, $article, $imageUrl, $this->filteredCount, $iTitleMaxLen));
						}
						else $septag[$s*2] = '';
						if (isset($mode->sSectionTags[$s*2+1])) {
							$septag[$s*2+1] = str_replace('%SECTION%',$sectionHeading[0],$this->substTagParm($mode->sSectionTags[$s*2+1], $pagename, $article, $imageUrl, $this->filteredCount, $iTitleMaxLen));
						}
						else $septag[$s*2+1]='';

					}
					
					// if there was a match condition on included contents which failed we skip the whole page
					if ($matchFailed) continue;	
					$this->filteredCount = $this->filteredCount + 1;

					// assemble parts with separators
					$incwiki='';
					if ($dominantPieces!=false) {
						foreach ($dominantPieces as $dominantPiece) {
							foreach ($secPiece as $s => $piece) {
								if ($s==$mode->iDominantSection) $incwiki.= $this->formatItem($dominantPiece,$septag[$s*2],$septag[$s*2+1]);
								else							 $incwiki.= $this->formatItem($piece        ,$septag[$s*2],$septag[$s*2+1]);
							}
						}
					}
					else {
						foreach ($secPiece as $s => $piece) {
							$incwiki.= $this->formatItem($piece,$septag[$s*2],$septag[$s*2+1]);
						}
					}
				}
			}
			else {
				$this->filteredCount = $this->filteredCount + 1;
			}			

			if($i > $iStart) $rBody .= $mode->sInline; //If mode is not 'inline', sInline attribute is empty, so does nothing
			
			// symbolic substitution of %PAGE% by the current article's name
			if ($mode->name == 'userformat') {
				$rBody .= $this->substTagParm($mode->sItemStart, $pagename, $article, $imageUrl, $this->filteredCount, $iTitleMaxLen);
			}
			else {
				$rBody .= $mode->sItemStart;
				if($article->mDate != '') {
					if ($article->myDate != '') {
						if($article->mRevision != '') 	$rBody 	.= ' <html>'.$sk->makeKnownLinkObj($article->mTitle, htmlspecialchars($article->myDate),'oldid='.$article->mRevision).'</html> ';
						else 							$rBody	.= $article->myDate.' ';
					} else {
						if($article->mRevision != '') 	$rBody 	.= ' <html>'.$sk->makeKnownLinkObj($article->mTitle, htmlspecialchars($wgLang->timeanddate($article->mDate, true)),'oldid='.$article->mRevision).'</html> : ';
						else 							$rBody	.= $wgLang->timeanddate($article->mDate, true) . ': ';
					}
				}
				// output the link to the article
				$rBody .= $article->mLink;
				if($article->mSize != '' && $mode->name != 'userformat') {
					if (strlen($article->mSize) > 3)	$rBody	.=  ' [' . substr($article->mSize,0,strlen($article->mSize)-3) . ' kB]';
					else								$rBody	.=  ' [' . $article->mSize . ' B]';
				}
				if($article->mCounter != '' && $mode->name != 'userformat') {
					// Adapted from SpecialPopularPages::formatResult()
					$nv = $this->msgExt( 'nviews', array( 'parsemag', 'escape'), $wgLang->formatNum( $article->mCounter ) );
					$rBody .=  ' ' . $wgContLang->getDirMark() . '(' . $nv . ')';
				}
				if($article->mUserLink != '')	$rBody .= ' . . [[User:' . $article->mUser .'|'.$article->mUser.']]';
				if($article->mContributor != '')$rBody .= ' . . [[User:' . $article->mContributor .'|'.$article->mContributor." $article->mContrib]]";
							
				if( !empty($article->mCategoryLinks) )	$rBody .= ' . . <SMALL>' . wfMsg('categories') . ': ' . implode(' | ', $article->mCategoryLinks) . '</SMALL>';
				if( $this->mAddExternalLink && $article->mExternalLink!= '') $rBody .= ' &rarr; ' . $article->mExternalLink;
			}
			
			// add included contents
			
			if ($this->mIncPage) {
				DPLInclude::open($this->mParser, $this->mParserTitle->getPrefixedText());
				$rBody .= $incwiki;
				DPLInclude::close($this->mParser, $this->mParserTitle->getPrefixedText());
			}			
				
			if ($mode->name == 'userformat') {
				$rBody .= $this->substTagParm($mode->sItemEnd, $pagename, $article, $imageUrl, $this->filteredCount, $iTitleMaxLen);
			}
			else {
				$rBody .= $mode->sItemEnd;
			}
		}
		// if requested we sort the table by the contents of a given column
		if ($iTableSortCol!=0) {
			$sortcol = abs($iTableSortCol) + 1;
			$rows=explode("\n|-",$rBody);
			foreach($rows as $row) {
				if (($word = explode("\n|",$row,$sortcol))!==false && count($word)>=$sortcol) {
					$rowsKey[] = $word[$sortcol - 1];
				} else {
					$rowsKey[] = $row;
				}
			}
			if ($iTableSortCol<0) 	krsort($rowsKey);
			else					ksort ($rowsKey);
			$rows=array_combine(array_values($rowsKey),$rows);
			ksort($rows);
			$rBody="\n|-".join("\n|-",$rows)."\n|-";	
		}
		
		// increase start value of ordered lists at multi-column output
		$actStart = $mode->sListStart;
		$start = preg_replace('/.*start=([0-9]+).*/','\1',$actStart);
		if ($start!='') {
			$start += $iCount;
			$mode->sListStart = preg_replace('/start=[0-9]+/',"start=$start",$actStart);
		}

		return $actStart . $rBody . $mode->sListEnd;
	}

	
	function updateArticleByRule($title,$text,$rulesText) {
		// we use ; as command delimiter; \; stands for a semicolon
		// \n is translated to a real linefeed
		$rulesText = str_replace(";",'°',$rulesText);
		$rulesText = str_replace('\°',';',$rulesText);
		$rulesText = str_replace("\\n","\n",$rulesText);
		$rules=split('°',$rulesText);
		$exec=false;
		$replaceThis='';
		$replacement='';
		$after='';
		$insertionAfter='';
		$before='';
		$insertionBefore='';
		$lastCmd='';
		$message= '';
		$summary='';
		// $message .= 'updaterules=<pre><nowiki>';
		foreach ($rules as $rule) {
			$cmd = preg_split("/ +/",$rule,2);
			if (count($cmd)>1) $arg = $cmd[1];
			else				$arg='';
			$cmd[0]=trim($cmd[0]);

			// after ... insert ...     ,   before ... insert ...			
			if ($cmd[0] == 'before') {
				// $message.= "before = $arg\n";
				$before=$arg;
				$lastCmd='B';
			}
			if ($cmd[0] == 'after') {
				// $message.= "after = $arg\n";
				$after=$arg;
				$lastCmd='A';
			}
			if ($cmd[0] == 'insert' && $lastCmd!='') {
				// $message.= "insert $lastCmd = $arg\n";
				if ($lastCmd=='A') $insertionAfter=$arg;
				if ($lastCmd=='B') $insertionBefore=$arg;
			}
			
			// replace ... by ...
			if ($cmd[0] == 'replace') {
				// $message.= "repl = $arg\n";
				$replaceThis=$arg;
			}
			if ($cmd[0] == 'by') {
				// $message.= "by   = $arg\n";
				$replacement=$arg;
			}

			if ($cmd[0] == 'summary') {
				// $message.= "summary = $arg\n";
				$summary=$arg;
			}
			
			// we execute only if "exec" is given, otherwise we merely show what would be done		
			if ($cmd[0] == 'exec') {
				// $message.= "exec = true\n";
				$exec=true; 
			}
			

		}
		if ($summary=='') {
			$summary .= "\nbulk update:";
			if ($replaceThis!='') $summary .= "\n replace $replaceThis\n by $replacement";
			if ($before!='')      $summary .= "\n before  $before\n insertionBefore";
			if ($after!='')       $summary .= "\n after   $after\n insertionAfter";
		}

		// $message.= '</nowiki></pre>';
		
		if ($replaceThis!='') {
			$text = preg_replace("$replaceThis",$replacement,$text);
		}

		if ($insertionBefore!='' && $before != '') {
			$text = preg_replace("/($before)/",$insertionBefore.'\1',$text);
		}
		
		if ($insertionAfter!='' && $after != '') {
			$text = preg_replace("/($after)/",'\1'.$insertionAfter,$text);
		}
		
		$titleX = Title::newFromText($title);
		global $wgArticle;
		$wgArticle = $articleX = new Article($titleX);
		if ($exec) $articleX->updateArticle($text, $summary, false, $titleX->userIsWatching());
		else $message .= "set 'exec yes' to perform the following modification to &nbsp; &nbsp; <big>'''$title'''</big>\n";
		$message .= "<pre><nowiki>"
			."\n".$text."</nowiki></pre>"; // <pre><nowiki>\n"; // .$text."\n</nowiki></pre>\n";
		return $message;
    }

  	function deleteArticleByRule($title,$text,$rulesText) {
		// we use ; as command delimiter; \; stands for a semicolon
		// \n is translated to a real linefeed
		$rulesText = str_replace(";",'°',$rulesText);
		$rulesText = str_replace('\°',';',$rulesText);
		$rulesText = str_replace("\\n","\n",$rulesText);
		$rules=split('°',$rulesText);
		$exec=false;
		$message= '';
		$reason='';
		foreach ($rules as $rule) {
			$cmd = preg_split("/ +/",$rule,2);
			if (count($cmd)>1) $arg = $cmd[1];
			else				$arg='';
			$cmd[0]=trim($cmd[0]);

			if ($cmd[0] == 'reason') {
				$reason=$arg;
			}
			
			// we execute only if "exec" is given, otherwise we merely show what would be done		
			if ($cmd[0] == 'exec') {
				$exec=true; 
			}
		}
		$reason .= "\nbulk delete by DPL query";
		
		$titleX = Title::newFromText($title);
		global $wgArticle;
		$wgArticle = $articleX = new Article($titleX);
		if ($exec) $articleX->doDelete($reason);
		else $message .= "set 'exec yes' to delete &nbsp; &nbsp; <big>'''$title'''</big>\n";
		$message .= "<pre><nowiki>"
			."\n".$text."</nowiki></pre>"; // <pre><nowiki>\n"; // .$text."\n</nowiki></pre>\n";
		return $message;
    }
	
	// generate a hyperlink to the article
	function articleLink($tag,$article,$iTitleMaxLen) {
		$pagename = $article->mTitle->getPrefixedText();
		if ($this->mEscapeLinks && ($article->mNamespace==14 || $article->mNamespace==6) ) {
	       	// links to categories or images need an additional ":"
			$pagename = ':'.$pagename;
		}
		return $this->substTagParm($tag, $pagename, $article, $this->filteredCount, '', $iTitleMaxLen);
 	}

	//format one item of an entry in the output list (i.e. the collection of occurences of one item from the include parameter)
	function formatItem($piece, $tagStart, $tagEnd) {
		return $tagStart.$piece.$tagEnd;
 	}
	
	//format one single item of an entry in the output list (i.e. one occurence of one item from the include parameter)
	function formatSingleItems(&$pieces, $s) {
		$firstCall=true;
		foreach ($pieces as $key => $val) {
			if (array_key_exists($s,$this->mTableRow)) {
				if ($s==0 || $firstCall) {
					$pieces[$key] = str_replace('%%',$val,$this->mTableRow[$s]);
				}
				else {
					$n=strpos($this->mTableRow[$s],'|');
					if ($n===false 	|| !(strpos(substr($this->mTableRow[$s],0,$n),'{')===false)
									|| !(strpos(substr($this->mTableRow[$s],0,$n),'[')===false)) {
						$pieces[$key] = str_replace('%%',$val,$this->mTableRow[$s]);
					}
					else {
						$pieces[$key] = str_replace('%%',$val,substr($this->mTableRow[$s],$n+1));
					}
				}
			}
			$firstCall=false;
		}
 	}

	//format one single template argument of one occurence of one item from the include parameter
	// is called via a backlink from DPLInclude::includeTemplate()
	function formatTemplateArg($arg, $s, $argNr, $firstCall, $maxlen) {
		// we could try to format fields differently within the first call of a template
		// currently we do not make such a difference
		if (array_key_exists("$s.$argNr",$this->mTableRow)) {
			if ($s>=1 && $argNr==0 && !$firstCall) {
				$n=strpos($this->mTableRow["$s.$argNr"],'|');
				if ($n===false 	|| !(strpos(substr($this->mTableRow["$s.$argNr"],0,$n),'{')===false)
								|| !(strpos(substr($this->mTableRow["$s.$argNr"],0,$n),'[')===false)) {
					return $this->cutAt($maxlen,str_replace('%%',$arg,$this->mTableRow["$s.$argNr"]));
				}
				else {
					return $this->cutAt($maxlen,str_replace('%%',$arg,substr($this->mTableRow["$s.$argNr"],$n+1)));
				}
			}
			else {
				return $this->cutAt($maxlen,str_replace('%%',$arg,$this->mTableRow["$s.$argNr"]));
			}
		}
		return $this->cutAt($maxlen,$arg);
 	}
	
	//return the total number of rows (filtered)
	function getRowCount() {
 		return $this->filteredCount;
 	}

	//cut wiki text around lim
	function cutAt($lim,$text) {
		if ($lim<0) return $text;
 		return DPLInclude::limitTranscludedText($text, $lim);
 	}

	//slightly different from CategoryViewer::formatList() (no need to instantiate a CategoryViewer object)
	function formatCategoryList($iStart, $iCount) {
		for($i = $iStart; $i < $iStart + $iCount; $i++) {
			$aArticles[] = $this->mArticles[$i]->mLink;
			$aArticles_start_char[] = $this->mArticles[$i]->mStartChar;
			$this->filteredCount = $this->filteredCount + 1;
		}
		require_once ('CategoryPage.php');
		if ( count ( $aArticles ) > ExtDynamicPageList::$categoryStyleListCutoff ) {
			return "__NOTOC____NOEDITSECTION__".CategoryViewer::columnList( $aArticles, $aArticles_start_char );
		} elseif ( count($aArticles) > 0) {
			// for short lists of articles in categories.
			return "__NOTOC____NOEDITSECTION__".CategoryViewer::shortList( $aArticles, $aArticles_start_char );
		}
		return '';
	}
	

	/**
	* Returns message in the requested format after parsing wikitext to html
	* This is meant to be equivalent to wfMsgExt() with parse, parsemag and escape as available options but using the DPL local parser instead of the global one (bugfix).
	*/
	function msgExt( $key, $options ) {
		$args = func_get_args();
		array_shift( $args );
		array_shift( $args );
	
		if( !is_array($options) ) {
			$options = array($options);
		}
	
		$string = wfMsgGetKey( $key, true, false, false );
	
		$string = wfMsgReplaceArgs( $string, $args );
	
		if( in_array('parse', $options) ) {
			$this->mParserOptions->setInterfaceMessage(true);
			$string = $this->mParser->recursiveTagParse( $string );
			$this->mParserOptions->setInterfaceMessage(false);
			//$string = $parserOutput->getText();
		} elseif ( in_array('parsemag', $options) ) {
			$parser = new Parser();
			$parserOptions = new ParserOptions();
			$parserOptions->setInterfaceMessage( true );
			$parser->startExternalParse( $this->mParserTitle, $parserOptions, OT_MSG );
			$string = $parser->transformMsg( $string, $parserOptions );
		}
	
		if ( in_array('escape', $options) ) {
			$string = htmlspecialchars ( $string );
		}
	
		return $string;
	}
	
	function getText() {
		return $this->mOutput;
	}
	
}
