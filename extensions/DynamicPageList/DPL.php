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

	function __construct($headings, $bHeadingCount, $iColumns, $iRows, $iRowSize, $sRowColFormat, $articles, $headingtype, $hlistmode,
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
		$this->mLogger = $logger;
		$this->mReplaceInTitle = $replaceInTitle;
		$this->mTableRow = $aTableRow;

		// cloning the parser in the following statement leads in some cases to a php error in MW 1.15
		// 	You must apply the following patch to avoid this:
		// add in LinkHoldersArray.php at the beginning of function 'merge' the following code lines:
		//		if (!isset($this->interwikis)) {
		//			$this->internals = array();
		//			$this->interwikis = array();
		//			$this->size = 0;
		//			$this->parent  = $other->parent;
		//		}
		$this->mParser = clone $parser;
		// clear state of cloned parser; if the above patch of LinkHoldersArray is not made this
		// can lead to links not being shown in the original document (probably the UIQ_QINU-tags no longer
		// get replaced properly; in combination with the patch however, it does not do any harm.

		// The CITE extension registers a hook on parser->clearState
		// We must UNDO the effect of that call (Cite->clearState) because otherwise all Cititations would be lost
		// that were made before a DPL call; we borrow a handle to the cite object from the parser´s tag hooks

		$citeObject = null;
		// store current state of Cite Object
		if (isset($parser->mTagHooks['references'])) {
			$citeObject	=	$parser->mTagHooks['references'][0];
			$tmpCiteGroupCnt			= $citeObject->mGroupCnt;
			$tmpCiteOutCnt				= $citeObject->mOutCnt;
			$tmpCiteCallCnt				= $citeObject->mCallCnt;
			$tmpCiteRefs				= $citeObject->mRefs;
			$tmpCiteReferencesErrors	= $citeObject->mReferencesErrors;
			$tmpCiteRefCallStack		= $citeObject->mRefCallStack;
		}
		// now clear the state
		$this->mParser->clearState();  // eliminated to avoid conflicht with CITE extension
		// restore Cite Object
		if ($citeObject != null) {
			$citeObject->mGroupCnt			= $tmpCiteGroupCnt;
			$citeObject->mOutCnt			= $tmpCiteOutCnt;
			$citeObject->mCallCnt			= $tmpCiteCallCnt;
			$citeObject->mRefs				= $tmpCiteRefs;
			$citeObject->mReferencesErrors	= $tmpCiteReferencesErrors;
			$citeObject->mRefCallStack		= $tmpCiteRefCallStack;
		}

		$this->mParserOptions = $parser->mOptions;
		$this->mParserTitle = $parser->mTitle;

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
				foreach($headings as $headingCount) {
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
				foreach($headings as $headingCount) {
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
		return '<p>' . $this->msgExt( $message, array(), $numart) . '</p>';
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
		$sTag = str_replace('%EDITSUMMARY%',$article->mComment,$sTag);

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
	    if (strpos($sTag,"%CAT")>=0 ) {
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
		}
		return $sTag;
	}

	function formatList($iStart, $iCount, $iTitleMaxLen, $defaultTemplateSuffix, $bIncludeTrim, $iTableSortCol, $updateRules, $deleteRules) {
		global $wgUser, $wgLang, $wgContLang;

		$mode = $this->mListMode;
		//categorypage-style list output mode
		if($mode->name == 'category') return $this->formatCategoryList($iStart, $iCount);

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
				// $img = Image::newFromName($article->mTitle->getText());
				$img = wfFindFile(Title::makeTitle(NS_IMAGE, $article->mTitle->getText()));
				if ($img && $img->exists()) {
					$imageUrl = $img->getURL();
					$imageUrl= preg_replace('~^.*images/(.*)~','\1',$imageUrl);
				}
				else {
					$iTitle   = Title::makeTitleSafe(6,$article->mTitle->getDBKey());
					$imageUrl = preg_replace('~^.*images/(.*)~','\1',RepoGroup::singleton()->getLocalRepo()->newFile($iTitle)->getPath());
				}
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
							$text = DPLInclude::limitTranscludedText($text, $this->mIncMaxLen, ' [['.$title.'|..→]]');
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
		    					$this->formatSingleItems($pieces, 0, $article);
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

					foreach ($this->mIncSecLabels as $s => $sSecLabel) {
						$sSecLabel = trim($sSecLabel);
						if ($sSecLabel == '') break;
 						// if sections are identified by number we have a % at the beginning
 						if ($sSecLabel[0] == '%') $sSecLabel = '#'.$sSecLabel;

						$maxlen=-1;
						if($sSecLabel=='-') {
							// '-' is used as a dummy parameter which will produce no output
							// if maxlen was 0 we suppress all output; note that for matching we used the full text
							$secPieces=array('');
							$this->formatSingleItems($secPieces,$s,$article);

						} else if($sSecLabel[0] != '{') {
							$limpos = strpos($sSecLabel,'[');
							$cutLink='default';
							$skipPattern=array();
							if ($limpos>0 && $sSecLabel[strlen($sSecLabel)-1]==']') {
								// regular expressions which define a skip pattern may precede the text
								$fmtSec=explode('~',substr($sSecLabel,$limpos+1,strlen($sSecLabel)-$limpos-2));
								$sSecLabel=substr($sSecLabel,0,$limpos);
								$cutInfo=explode(" ",$fmtSec[count($fmtSec)-1],2);
								$maxlen=intval($cutInfo[0]);
								if (array_key_exists('1',$cutInfo)) $cutLink=$cutInfo[1];
								foreach( $fmtSec as $skipKey => $skipPat) {
									if ($skipKey==count($fmtSec)-1) continue;
									$skipPattern[]=$skipPat;
								}
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

						// if chapters are selected by number, text or regexp we get the heading from DPLInclude::includeHeading
						$sectionHeading[0]='';
						if($sSecLabel=='-') {
							$secPiece[$s] = $secPieces[0];

						} else if($sSecLabel[0] == '#' || $sSecLabel[0] == '@') {
							$sectionHeading[0]=substr($sSecLabel,1);
							// Uses DPLInclude::includeHeading() from LabeledSectionTransclusion extension to include headings from the page
							$secPieces = DPLInclude::includeHeading($this->mParser, $article->mTitle->getPrefixedText(), substr($sSecLabel, 1),'',
																$sectionHeading,false,$maxlen,$cutLink,$bIncludeTrim,$skipPattern);
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
							// if maxlen was 0 we suppress all output; note that for matching we used the full text
							if ($maxlen==0) $secPieces=array('');

							$this->formatSingleItems($secPieces,$s,$article);
							if (!array_key_exists(0,$secPieces)) {
								// avoid matching against a non-existing array element
								// and skip the article if there was a match condition
								if ($mustMatch!='' || $mustNotMatch!='') $matchFailed=true;
								break;
							}
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
							// primary syntax {template}suffix
 							$template1 = trim(substr($sSecLabel,1,strpos($sSecLabel,'}')-1));
 							$template2 = trim(str_replace('}','',substr($sSecLabel,1)));
							// alternate syntax: {template|surrogate}
							if ($template2==$template1 && strpos($template1,'|')>0) {
								$template1=preg_replace('/\|.*/' ,'',$template1);
								$template2=preg_replace('/^.+\|/','',$template2);
							}
							$secPieces = DPLInclude::includeTemplate($this->mParser, $this, $s, $article, $template1,
																	  $template2, $template2.$defaultTemplateSuffix,$mustMatch,
																	  $mustNotMatch,$this->mIncParsed,$iTitleMaxLen,implode(', ', $article->mCategoryLinks));
 							$secPiece[$s] = implode(isset($mode->aMultiSecSeparators[$s])?
 								$this->substTagParm($mode->aMultiSecSeparators[$s], $pagename, $article, $imageUrl, $this->filteredCount, $iTitleMaxLen):'',$secPieces);
 							if ($mode->iDominantSection>=0 && $s==$mode->iDominantSection && count($secPieces)>1)	$dominantPieces=$secPieces;
							if (($mustMatch!='' || $mustNotMatch!='') && count($secPieces)<=1 && $secPieces[0]=='') {
								$matchFailed=true; 	// NOTHING MATCHED
								break;
							}
						} else {
							// Uses DPLInclude::includeSection() from LabeledSectionTransclusion extension to include labeled sections from the page
							$secPieces = DPLInclude::includeSection($this->mParser, $article->mTitle->getPrefixedText(), $sSecLabel,'', false, $bIncludeTrim, $skipPattern);
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
					if ($article->myDate != '') 	$rBody .= $article->myDate.' ';
					else							$rBody .= $wgLang->timeanddate($article->mDate, true) .' ';
					if($article->mRevision != '') 	$rBody .= '[{{fullurl:'.$article->mTitle.'|oldid='.$article->mRevision.'}} '.htmlspecialchars($article->mTitle).']';
					else							$rBody .= $article->mLink;
				}
				else {
					// output the link to the article
					$rBody .= $article->mLink;
				}
				if($article->mSize != '' && $mode->name != 'userformat') {
					if (strlen($article->mSize) > 3)	$rBody	.=  ' [' . substr($article->mSize,0,strlen($article->mSize)-3) . ' kB]';
					else								$rBody	.=  ' [' . $article->mSize . ' B]';
				}
				if($article->mCounter != '' && $mode->name != 'userformat') {
					// Adapted from SpecialPopularPages::formatResult()
					// $nv = $this->msgExt( 'nviews', array( 'parsemag', 'escape'), $wgLang->formatNum( $article->mCounter ) );
					$nv = $this->msgExt( 'nviews', array('escape'), $wgLang->formatNum( $article->mCounter ) );
					$rBody .=  ' ' . $wgContLang->getDirMark() . '(' . $nv . ')';
				}
				if($article->mUserLink != '')	{
					$rBody .= ' . . [[User:' . $article->mUser .'|'.$article->mUser.']]';
					if($article->mComment != '')$rBody .= ' { '.$article->mComment.' }';
				}
				if($article->mContributor != '')$rBody .= ' . . [[User:' . $article->mContributor .'|'.$article->mContributor." $article->mContrib]]";



				if( !empty($article->mCategoryLinks) )	$rBody .= ' . . <SMALL>' . wfMsg('categories') . ': ' . implode(' | ', $article->mCategoryLinks) . '</SMALL>';
				if( $this->mAddExternalLink && $article->mExternalLink!= '') $rBody .= ' → ' . $article->mExternalLink;
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
			$sortcol = abs($iTableSortCol);
			$rows=explode("\n|-",$rBody);
			foreach($rows as $index => $row) {
				if (strlen($row) > 0) {
					if ((($word = explode("\n|",$row,$sortcol+2))!==false) && (count($word)>$sortcol)) {
						$rowsKey[$index] = $word[$sortcol];
					} else {
						$rowsKey[$index] = $row;
					}
				}
			}
			if ($iTableSortCol<0) 	arsort($rowsKey);
			else					asort ($rowsKey);
			$rBody="";
			foreach($rowsKey as $index => $val)
				$rBody.="\n|-".$rows[$index];
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

	/**
	 * this fucntion hast three tasks (depending on $exec):
	 * (1) show an edit dialogue for template fields (exec = edit)
	 * (2) set template parameters to  values specified in the query (exec=set)v
     * (2) preview the source code including any changes of these parameters made in the edit form or with other changes (exec=preview)
	 * (3) save the article with the changed value set or with other changes (exec=save)

	 * "other changes" means that a regexp can be applied to the source text or arbitrary text can be
	 * inserted before or after a pattern occuring in the text
	*/

	function updateArticleByRule($title,$text,$rulesText) {
		// we use ; as command delimiter; \; stands for a semicolon
		// \n is translated to a real linefeed
		$rulesText = str_replace(";",'°',$rulesText);
		$rulesText = str_replace('\°',';',$rulesText);
		$rulesText = str_replace("\\n","\n",$rulesText);
		$rules=explode('°',$rulesText);
		$exec='edit';
		$replaceThis='';
		$replacement='';
		$after='';
		$insertionAfter='';
		$before='';
		$insertionBefore='';
		$template='';
		$parameter=array();
		$value=array();
		$afterparm=array();
		$format=array();
		$preview=array();
		$save=array();
		$tooltip=array();
		$optional=array();

		$lastCmd='';
		$message= '';
		$summary='';
		$editForm=false;
		$action='';
		$hidden=array();
		$legendPage='';
		$instructionPage='';
		$table='';
		$fieldFormat='';

		// $message .= 'updaterules=<pre><nowiki>';
		$nr = -1;
		foreach ($rules as $rule) {
			if (preg_match('/^\s*#/',$rule)>0) continue;  // # is comment symbol

			$rule=preg_replace('/^[\s]*/','',$rule); // strip leading white space
			$cmd = preg_split("/ +/",$rule,2);
			if (count($cmd)>1) $arg = $cmd[1];
			else				$arg='';
			$cmd[0]=trim($cmd[0]);

			// after ... insert ...     ,   before ... insert ...
			if ($cmd[0] == 'before') {
				$before=$arg;
				$lastCmd='B';
			}
			if ($cmd[0] == 'after') {
				$after=$arg;
				$lastCmd='A';
			}
			if ($cmd[0] == 'insert' && $lastCmd!='') {
				if ($lastCmd=='A') $insertionAfter=$arg;
				if ($lastCmd=='B') $insertionBefore=$arg;
			}
			if ($cmd[0] == 'template') 	$template = $arg;

			if ($cmd[0] == 'parameter') {
				$nr++;
				$parameter[$nr] = $arg;
				if ($nr>0) {
					$afterparm[$nr] = array($parameter[$nr-1]);
					$n=$nr-1;
					while ($n>0 && array_key_exists($n,$optional)) {
						$n--;
						$afterparm[$nr][]=$parameter[$n];
					}
				}
			}
			if ($cmd[0] == 'value') 		$value[$nr] = $arg;
			if ($cmd[0] == 'format') 		$format[$nr] = $arg;
			if ($cmd[0] == 'tooltip') 		$tooltip[$nr]=$arg;
			if ($cmd[0] == 'optional') 		$optional[$nr]=true;
			if ($cmd[0] == 'afterparm') 	$afterparm[$nr] = array($arg);
			if ($cmd[0] == 'legend') 		$legendPage = $arg;
			if ($cmd[0] == 'instruction')	$instructionPage = $arg;
			if ($cmd[0] == 'table') 		$table = $arg;
			if ($cmd[0] == 'field') 		$fieldFormat = $arg;

			if ($cmd[0] == 'replace') 		$replaceThis=$arg;
			if ($cmd[0] == 'by') 			$replacement=$arg;

			if ($cmd[0] == 'editform') 		$editForm=$arg;
			if ($cmd[0] == 'action') 		$action=$arg;
			if ($cmd[0] == 'hidden') 		$hidden[]=$arg;
			if ($cmd[0] == 'preview') 		$preview[]=$arg;
			if ($cmd[0] == 'save') 			$save[]=$arg;

			if ($cmd[0] == 'summary') 		$summary=$arg;
			if ($cmd[0] == 'exec') 			$exec=$arg; 	// desired action (set or edit or preview)
		}

		if ($summary=='') {
			$summary .= "\nbulk update:";
			if ($replaceThis!='') $summary .= "\n replace $replaceThis\n by $replacement";
			if ($before!='')      $summary .= "\n before  $before\n insertionBefore";
			if ($after!='')       $summary .= "\n after   $after\n insertionAfter";
		}

		// $message.= '</nowiki></pre>';

		// perform changes to the wiki source text =======================================

		if ($replaceThis!='') {
			$text = preg_replace("$replaceThis",$replacement,$text);
		}

		if ($insertionBefore!='' && $before != '') {
			$text = preg_replace("/($before)/",$insertionBefore.'\1',$text);
		}

		if ($insertionAfter!='' && $after != '') {
			$text = preg_replace("/($after)/",'\1'.$insertionAfter,$text);
		}

		// deal with template parameters =================================================

		global $wgRequest, $wgUser;

		if ($template!='') {

			if ($exec=='edit') {
				$tpv = $this->getTemplateParmValues($text,$template);
				$legendText='';
				if ($legendPage!='') {
					$legendTitle='';
					global $wgParser, $wgUser;
					$parser = clone $wgParser;
					DPLInclude::text($parser, $legendPage, $legendTitle, $legendText);
					$legendText = preg_replace('/^.*?\<section\s+begin\s*=\s*legend\s*\/\>/s','',$legendText);
					$legendText = preg_replace('/\<section\s+end\s*=\s*legend\s*\/\>.*/s','',$legendText);
				}
				$instructionText='';
				$instructions=array();
				if ($instructionPage!='') {
					$instructionTitle='';
					global $wgParser, $wgUser;
					$parser = clone $wgParser;
					DPLInclude::text($parser, $instructionPage, $instructionTitle, $instructionText);
					$instructions = $this->getTemplateParmValues($instructionText,'Template field');
				}
				// construct an edit form containing all template invocations
				$form="<html><form method=post action=\"$action\" $editForm>\n";
				foreach ($tpv as $call => $tplValues) {
					$form .= "<table $table>\n";
					foreach ($parameter as $nr => $parm) {
						// try to extract legend from the docs of the template
						$myToolTip='';  if (array_key_exists($nr,$tooltip)) $myToolTip = $tooltip[$nr];
						$myInstruction = '';
						$myType='';
						foreach($instructions as $instruct) {
							if (array_key_exists('field',$instruct) && $instruct['field']==$parm) {
								if (array_key_exists('doc',$instruct)) $myInstruction = $instruct['doc'];
								if (array_key_exists('type',$instruct)) $myType = $instruct['type'];
								break;
							}
						}
						$myFormat='' ;  if (array_key_exists($nr,$format)) $myFormat = $format[$nr];
						$myOptional=array_key_exists($nr,$optional);
						if ($legendText !='' && $myToolTip=='') {
							$myToolTip=preg_replace('/^.*\<section\s+begin\s*=\s*'.preg_quote($parm,'/').'\s*\/\>/s','',$legendText);
							if (strlen($myToolTip)==strlen($legendText)) {
								$myToolTip='';
							} else {
								$myToolTip=preg_replace('/\<section\s+end\s*=\s*'.preg_quote($parm,'/').'\s*\/\>.*/s','',$myToolTip);
							}
						}
						$myValue='';
						if (array_key_exists($parm,$tpv[$call])) $myValue=$tpv[$call][$parm];
						$form .= $this->editTemplateCall($text,$template,$call,$parm,$myType,$myValue,$myFormat,$myToolTip,$myInstruction,$myOptional,$fieldFormat);
					}
					$form .= "</table>\n<br/><br/>";
				}
				foreach($hidden as $hide) {
					$form.=	"<input type=hidden ".$hide." />";
				}
				$form.=	"<input type=hidden name=\"token\" value=\"".$wgUser->editToken()."\" />";
				foreach($preview as $prev) {
					$form.=	"<input type=submit ".$prev." /> ";
				}
				$form .= "</form></html>\n";
				return $form;
			}
			else if ($exec=='set' || $exec=='preview') {
				// loop over all invocations and parameters, this could be improved to enhance performance
				$matchCount=10;
				for ($call=0; $call<10; $call++) {
					foreach ($parameter as $nr => $parm) {
						// set parameters to values specified in the dpl source or get them from the http request
						if ($exec=='set')	$myvalue=$value[$nr];
						else {
							if ($call>= $matchCount) break;
							$myValue= $wgRequest->getVal(urlencode($call.'_'.$parm),'');
						}
						$myOptional= array_key_exists($nr,$optional);
						$myAfterParm=array(); if (array_key_exists($nr,$afterparm)) $myAfterParm = $afterparm[$nr];
						$text = $this->updateTemplateCall($matchCount,$text,$template,$call,$parm,$myValue,$myAfterParm,$myOptional);
					}
					if ($exec=='set') break;  // values taken from dpl text only populate the first invocation
				}
			}
		}

		if 	($exec=='set')	{
			return $this->updateArticle($title,$text,$summary);
		}
		else if ($exec=='preview'){
			global $wgScriptPath,$wgRequest;
			$titleX = Title::newFromText($title);
			$articleX = new Article($titleX);
			$form ='<html><form id="editform" name="editform" method="post" action="'.$wgScriptPath . '/index.php?title='.urlencode($title).'&action=submit" '
			.'enctype="multipart/form-data">'."\n"
			.'<input type="hidden" value="" name="wpSection" />'."\n"
			.'<input type="hidden" value="'. wfTimestampNow() . '" name="wpStarttime" />'."\n"
			.'<input type="hidden" value="'.$articleX->getTimestamp() .'" name="wpEdittime" />'."\n"
			.'<input type="hidden" value="" name="wpScrolltop" id="wpScrolltop" />'."\n"
			.'<textarea tabindex="1" accesskey="," name="wpTextbox1" id="wpTextbox1" rows="'.$wgUser->getIntOption( 'rows' )
			.'" cols="'.$wgUser->getIntOption( 'cols' ).'" >'
			.htmlspecialchars($text)
			.'</textarea>'."\n"
			.'<input type="hidden" name="wpSummary value="'.$summary.'" id="wpSummary" />'
			.'<input name="wpAutoSummary" type="hidden" value="" />'
			.'<input id="wpSave" name="wpSave" type="submit" value="Save page" accesskey="s" title="Save your changes [s]" />'
			.'<input type="hidden" value="'.$wgRequest->getVal('token').'" name="wpEditToken" />'."\n"
			.'</form></html>'."\n";
			return $form;
		}
		return "exec must be one of the following: edit, preview, set";
    }

	function updateArticle($title, $text, $summary) {
		global $wgUser, $wgRequest, $wgOut;

		if (!$wgUser->matchEditToken($wgRequest->getVal('token'))) {
			$wgOut->addWikiMsg( 'sessionfailure' );
			return 'session failure';
		}

		$titleX = Title::newFromText($title);
		$permission_errors = $titleX->getUserPermissionsErrors( 'edit', $wgUser );
		if (count($permission_errors)==0) {
			$articleX = new Article($titleX);
			$articleX->doEdit( $text, $summary, EDIT_UPDATE | EDIT_DEFER_UPDATES | EDIT_AUTOSUMMARY );
			$wgOut->redirect( $titleX->getFullUrl( $articleX->isRedirect() ? 'redirect=no' : '' ) );
			return '';
		}
		else {
			$wgOut->showPermissionsErrorPage( $permission_errors );
			return 'permission error';
		}
	}

  	function editTemplateCall($text,$template,$call,$parameter,$type,$value,$format,$legend,$instruction,$optional,$fieldFormat) {
		$matches=array();
		$nlCount = preg_match_all('/\n/',$value,$matches);
		if ($nlCount>0) $rows= $nlCount+1;
		else $rows = floor(strlen($value) / 50) + 1;
		if (preg_match('/rows\s*=/',$format)<=0) $format.= " rows=$rows";
		$cols=50;
		if (preg_match('/cols\s*=/',$format)<=0) $format.= " cols=$cols";
		$textArea = "<textarea name=\"".urlencode($call.'_'.$parameter)."\" $format/>".htmlspecialchars($value)."</textarea>";
		return str_replace('%NAME%', htmlspecialchars(str_replace('_',' ',$parameter)),
				str_replace('%TYPE%', $type,
					str_replace('%INPUT%', $textArea,
						str_replace('%LEGEND%', "</html>".htmlspecialchars($legend)."<html>",
							str_replace('%INSTRUCTION%', "</html>".htmlspecialchars($instruction)."<html>",$fieldFormat)))));
    }

	/**
	* return an array of template invocations; each element is an associative array of parameter and value
	*/
  	function getTemplateParmValues($text,$template) {
		$matches=array();
		$noMatches = preg_match_all('/\{\{\s*'.preg_quote($template,'/').'\s*[|}]/i',$text,$matches,PREG_OFFSET_CAPTURE);
		if ($noMatches<=0) return '';
		$textLen = strlen($text);
		$tval=array(); // the result array of template values
		$call=-1;      // index for tval

		foreach($matches as $matchA) {
			foreach($matchA as $matchB) {
				$match=$matchB[0];
				$start=$matchB[1];
				$tval[++$call]=array();
				$nr=0;  // number of parameter if no name given
				$parmValue='';
				$parmName='';
				$parm='';

				if ($match[strlen($match)-1]=='}') break; 	// template was called without parameters, continue with next invocation

				// search to the end of the template call
				$cbrackets=2;
				for ($i=$start+strlen($match); $i<$textLen;$i++) {
					$c = $text[$i];
					if ($c == '{' || $c=='[') $cbrackets++; // we count both types of brackets
					if ($c == '}' || $c==']') $cbrackets--;
					if (($cbrackets==2 && $c=='|') || ($cbrackets==1 && $c=='}')) {
						// parameter (name or value) found
						if ($parmName=='') 	$tval[$call][++$nr]     = trim($parm);
						else				$tval[$call][$parmName] = trim($parmValue);
						$parmName='';
						$parmValue='';
						$parm='';
						continue;
					}
					else {
						if ($parmName=='') {
							if ($c=='=') $parmName = trim($parm);
						}
						else {
							$parmValue.=$c;
						}
					}
					$parm.=$c;
					if ($cbrackets==0) break;  // end of parameter list
				}
			}
		}
		return $tval;
    }

	/*
	* Changes a single parameter value within a certain call of a tempplate
	*/
  	function updateTemplateCall(&$matchCount, $text,$template,$call,$parameter,$value,$afterParm,$optional) {

		// if parameter is optional and value is empty we leave everything as it is (i.e. we do not remove the parm)
		if ($optional && $value=='') return $text;

		$matches=array();
		$noMatches = preg_match_all('/\{\{\s*'.preg_quote($template,'/').'\s*[|}]/i',$text,$matches,PREG_OFFSET_CAPTURE);
		if ($noMatches<=0) return $text;
		$beginSubst=-1;
		$endSubst=-1;
		$posInsertAt=0;
		$apNrLast=1000; // last (optional) predecessor

		foreach($matches as $matchA) {
			$matchCount=count($matchA);
			foreach($matchA as $occurence => $matchB) {
				if ($occurence < $call) continue;
				$match=$matchB[0];
				$start=$matchB[1];

				if ($match[strlen($match)-1]=='}') {
					// template was called without parameters, add new parameter and value
					// append parameter and value
					$beginSubst=$i;
					$endSubst=$i;
					$substitution="|$parameter = $value";
					break;
				}
				else {
					// there is already a list of parameters; we search to the end of the template call
					$cbrackets=2;
					$parm='';
					$pos=$start+strlen($match)-1;
					$textLen = strlen($text);
					for ($i=$pos+1; $i<$textLen;$i++) {
						$c = $text[$i];
						if ($c == '{' || $c=='[') $cbrackets++; // we count both types of brackets
						if ($c == '}' || $c==']') $cbrackets--;
						if (($cbrackets==2 && $c=='|') || ($cbrackets==1 && $c=='}')) {
							// parameter (name / value) found

							$token = explode('=',$parm,2);
							if (count($token)==2) {
								// we need a pair of name / value
								$parmName=trim($token[0]);
								if ($parmName == $parameter) {
									// we found the parameter, now replace the current value
									$parmValue=trim($token[1]);
									if ($parmValue==$value) break; // no need to change when values are identical
									// keep spaces;
									if ($parmValue=='') {
										if (strlen($token[1])>0 && $token[1][strlen($token[1])-1]=="\n") {
											$substitution=str_replace ("\n",$value."\n",$token[1]);
										}
										else {
											$substitution=$value.$token[1];
										}
									}
									else {
										$substitution = str_replace($parmValue,$value,$token[1]);
									}
									$beginSubst=$pos+strlen($token[0])+2;
									$endSubst=$i;
									break;
								}
								else {
									foreach ($afterParm as $apNr => $ap) {
									// store position for insertion
										if ($parmName==$ap && $apNr<$apNrLast) {
											$posInsertAt = $i;
											$apNrLast = $apNr;
											break;
										}
									}
								}
							}

							if ($c=='}') {
								// end of template call reached, insert at stored position or here
								if ($posInsertAt !=0) 	$beginSubst=$posInsertAt;
								else					$beginSubst=$i;
								$substitution= "|$parameter = $value";
								if ($text[$beginSubst-1]=="\n") {
									--$beginSubst;
									$substitution="\n".$substitution;
								}
								$endSubst=$beginSubst;
								break;
							}

							$pos=$i;
							$parm='';
						}
						else {
							$parm .= $c;
						}
						if ($cbrackets==0) {
							break;
						}
					}
				}
				break;
			}
			break;
		}

		if ($beginSubst<0) return $text;

		return  substr($text,0,$beginSubst).$substitution.substr($text,$endSubst);

    }

  	function deleteArticleByRule($title,$text,$rulesText) {

		global $wgUser, $wgOut;

		// return "deletion of articles by DPL is disabled.";


		// we use ; as command delimiter; \; stands for a semicolon
		// \n is translated to a real linefeed
		$rulesText = str_replace(";",'°',$rulesText);
		$rulesText = str_replace('\°',';',$rulesText);
		$rulesText = str_replace("\\n","\n",$rulesText);
		$rules=explode('°',$rulesText);
		$exec=false;
		$message= '';
		$reason='';


		foreach ($rules as $rule) {
			if (preg_match('/^\s*#/',$rule)>0) continue;  // # is comment symbol

			$rule=preg_replace('/^[\s]*/','',$rule); // strip leading white space
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
		if ($exec) {
			# Check permissions
			$permission_errors = $titleX->getUserPermissionsErrors( 'delete', $wgUser );
			if (count($permission_errors)>0) {
				$wgOut->showPermissionsErrorPage( $permission_errors );
				return 'permission error';
			}
			else if ( wfReadOnly() ) {
				$wgOut->readOnlyPage();
				return 'DPL: read only mode';
			}
			else {
				$articleX = new Article($titleX);
				$articleX->doDelete($reason);
			}
		}
		else $message .= "set 'exec yes' to delete &#160; &#160; <big>'''$title'''</big>\n";
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
	function formatSingleItems(&$pieces, $s, $article) {
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
				$pieces[$key] = str_replace('%IMAGE%',self::imageWithPath($val),$pieces[$key]);
				$pieces[$key] = str_replace('%PAGE%',$article->mTitle->getPrefixedText(),$pieces[$key]);
			    if (strpos($pieces[$key],"%CAT")>=0 ) {
					if (!empty($article->mCategoryLinks)) {
						$pieces[$key] = str_replace('%'.'CATLIST%',implode(', ', $article->mCategoryLinks),$pieces[$key]);
						$pieces[$key] = str_replace('%'.'CATBULLETS%','* '.implode("\n* ", $article->mCategoryLinks),$pieces[$key]);
						$pieces[$key] = str_replace('%'.'CATNAMES%',implode(', ', $article->mCategoryTexts),$pieces[$key]);
					}
					else {
						$pieces[$key] = str_replace('%'.'CATLIST%','',$pieces[$key]);
						$pieces[$key] = str_replace('%'.'CATBULLETS%','',$pieces[$key]);
						$pieces[$key] = str_replace('%'.'CATNAMES%','',$pieces[$key]);
					}
				}
			}
			$firstCall=false;
		}
 	}

	//format one single template argument of one occurence of one item from the include parameter
	// is called via a backlink from DPLInclude::includeTemplate()
	function formatTemplateArg($arg, $s, $argNr, $firstCall, $maxlen, $article) {
		// we could try to format fields differently within the first call of a template
		// currently we do not make such a difference

		// if the result starts with a '-' we add a leading space; thus we avoid a misinterpretation of |- as
		// a start of a new row (wiki table syntax)
		if (array_key_exists("$s.$argNr",$this->mTableRow)) {
			$n=-1;
			if ($s>=1 && $argNr==0 && !$firstCall) {
				$n=strpos($this->mTableRow["$s.$argNr"],'|');
				if ($n===false 	|| !(strpos(substr($this->mTableRow["$s.$argNr"],0,$n),'{')===false)
								|| !(strpos(substr($this->mTableRow["$s.$argNr"],0,$n),'[')===false)) {
					$n= -1;
				}
			}
			$result = str_replace('%%',$arg,substr($this->mTableRow["$s.$argNr"],$n+1));
			$result = str_replace('%PAGE%',$article->mTitle->getPrefixedText(),$result);
			$result = str_replace('%IMAGE%',self::imageWithPath($arg),$result);
			$result = $this->cutAt($maxlen,$result);
			if (strlen($result)>0 && $result[0]=='-') 	return ' '.$result;
			else 										return     $result;
		}
		$result = $this->cutAt($maxlen,$arg);
		if (strlen($result)>0 && $result[0]=='-') 	return ' '.$result;
		else 										return     $result;
 	}

	//return the total number of rows (filtered)
	function getRowCount() {
 		return $this->filteredCount;
 	}

	/**
	 * Truncate a portion of wikitext so that ..
	 * ... it is not larger that $lim characters
	 * ... it is balanced in terms of braces, brackets and tags
	 * ... can be used as content of a wikitable field without spoiling the whole surrounding wikitext structure
	 * @param  $lim     limit of character count for the result
 	 * @param  $text    the wikitext to be truncated
	 * @return the truncated text; note that in some cases it may be slightly longer than the given limit
	 *         if the text is alread shorter than the limit or if the limit is negative, the text
	 *         will be returned without any checks for balance of tags
	 */
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
	 * Prepends an image name with its hash path.
	 *
	 * @param  $imgName name of the image (may start with Image: or File:)
	 * @return $uniq_prefix
	 */
	static function imageWithPath($imgName) {
		$title = Title::newfromText('Image:'.$imgName);
		if( !is_null($title) )	{
			$iTitle   = Title::makeTitleSafe(6,$title->getDBKey());
			$imageUrl = preg_replace('~^.*images/(.*)~','\1',RepoGroup::singleton()->getLocalRepo()->newFile($iTitle)->getPath());
		}
		else {
			$imageUrl = '???';
		}
		return $imageUrl;
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

		$string = wfMsgNoTrans( $key );

		$string = wfMsgReplaceArgs( $string, $args );

		$this->mParserOptions->setInterfaceMessage(true);
		$string = $this->mParser->recursiveTagParse( $string );
		$this->mParserOptions->setInterfaceMessage(false);

		if ( in_array('escape', $options) ) $string = htmlspecialchars ( $string );

		return $string;
	}

	function getText() {
		return $this->mOutput;
	}

}
