<?php
/*
	
 Purpose:       outputs a bulleted list of most recent
                items residing in a category, or a union
                of several categories.

 Contributors: n:en:User:IlyaHaykinson n:en:User:Amgine
 http://en.wikinews.org/wiki/User:Amgine
 http://en.wikinews.org/wiki/User:IlyaHaykinson

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License along
 with this program; if not, write to the Free Software Foundation, Inc.,
 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 http://www.gnu.org/copyleft/gpl.html

 Current feature request list
	 1. Unset cached of calling page
	 2. Alternative formatting (not just unordered list)
	 3. Configurable sort order, ascending/descending
	 4. RSS feed output?

 To install, add following to LocalSettings.php
   include("extensions/intersection/DynamicPageList.php");

*/

$wgDLPminCategories = 1;                // Minimum number of categories to look for
$wgDLPmaxCategories = 6;                // Maximum number of categories to look for
$wgDLPMinResultCount = 1;               // Minimum number of results to allow
$wgDLPMaxResultCount = 50;              // Maximum number of results to allow
$wgDLPAllowUnlimitedResults = true;     // Allow unlimited results
$wgDLPAllowUnlimitedCategories = false; // Allow unlimited categories

if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
	$wgHooks['ParserFirstCallInit'][] = 'wfDynamicPageList';
} else {
	$wgExtensionFunctions[] = 'wfDynamicPageList';
}

$wgExtensionCredits['parserhook'][] = array(
	'name'           => 'DynamicPageList',
	'description'    => 'outputs a bulleted list of the most recent items residing in a category, or a union of several categories',
	'descriptionmsg' => 'intersection-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Intersection',
	'author'         => array( '[http://en.wikinews.org/wiki/User:Amgine Amgine]', '[http://en.wikinews.org/wiki/User:IlyaHaykinson IlyaHaykinson]' ),
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['DynamicPageList'] = $dir . 'DynamicPageList.i18n.php';

function wfDynamicPageList() {
	global $wgParser;
	wfLoadExtensionMessages( 'DynamicPageList' );
	$wgParser->setHook( "DynamicPageList", "DynamicPageList" );
	return true;
}

// The callback function for converting the input text to HTML output
function DynamicPageList( $input ) {
	global $wgUser;
	global $wgLang;
	global $wgContLang;
	global $wgDLPminCategories, $wgDLPmaxCategories,$wgDLPMinResultCount, $wgDLPMaxResultCount;
	global $wgDLPAllowUnlimitedResults, $wgDLPAllowUnlimitedCategories;

	$aParams = array();
	$bCountSet = false;

	$sStartList = '<ul>';
	$sEndList = '</ul>';
	$sStartItem = '<li>';
	$sEndItem = '</li>';

	$sOrderMethod = 'categoryadd';
	$sOrder = 'descending';
	$sRedirects = 'exclude';
	$sStable = $sQuality = 'include';

	$bNamespace = false;
	$iNamespace = 0;
	
	$bShowCurId = false;

	$bSuppressErrors = false;
	$bShowNamespace = true;
	$bAddFirstCategoryDate = false;

	$aCategories = array();
	$aExcludeCategories = array();

	$aParams = explode("\n", $input);

	$parser = new Parser;
	$poptions = new ParserOptions;

	foreach($aParams as $sParam)
	{
		$aParam = explode("=", $sParam);
		if( count( $aParam ) < 2 )
			continue;
		$sType = trim($aParam[0]);
		$sArg = trim($aParam[1]);
		if ($sType == 'category')
		{
			$title = Title::newFromText( $parser->transformMsg($sArg, $poptions) );
			if( is_null( $title ) )
				continue;
			$aCategories[] = $title;
		}
		else if ($sType == 'notcategory')
		{
			$title = Title::newFromText( $parser->transformMsg($sArg, $poptions) );
			if( is_null( $title ) )
				continue;
			$aExcludeCategories[] = $title;
		}
		else if ('namespace' == $sType)
		{
			$ns = $wgContLang->getNsIndex($sArg);
			if (NULL != $ns)
			{
				$iNamespace = $ns;
				$bNamespace = true;
			}
			else
			{
				$iNamespace = intval($sArg);
				if ($iNamespace >= 0)
				{
					$bNamespace = true;
				}
				else
				{
					$bNamespace = false;
				}
			}
		}
		else if ('count' == $sType)
		{
			//ensure that $iCount is a number;
			$iCount = IntVal( $sArg );
			$bCountSet = true;
		}
		else if ('mode' == $sType)
		{
			switch ($sArg)
			{
			case 'none':
				$sStartList = '';
				$sEndList = '';
				$sStartItem = '';
				$sEndItem = '<br />';
				break;
			case 'ordered':
				$sStartList = '<ol>';
				$sEndList = '</ol>';
				$sStartItem = '<li>';
				$sEndItem = '</li>';
				break;
			case 'unordered':
			default:
				$sStartList = '<ul>';
				$sEndList = '</ul>';
				$sStartItem = '<li>';
				$sEndItem = '</li>';
				break;
			}
		}
		else if ('order' == $sType)
		{
			switch ($sArg)
			{
			case 'ascending':
				$sOrder = 'ascending';
				break;
			case 'descending':
			default:
				$sOrder = 'descending';
				break;
			}
		}
		else if ('ordermethod' == $sType)
		{
			switch ($sArg)
			{
			case 'lastedit':
				$sOrderMethod = 'lastedit';
				break;
			case 'categoryadd':
			default:
				$sOrderMethod = 'categoryadd';
				break;
			}
		}
		else if ('redirects' == $sType)
		{
			switch ($sArg)
			{
			case 'include':
				$sRedirects = 'include';
				break;
			case 'only':
				$sRedirects = 'only';
				break;
			case 'exclude':
			default:
				$sRedirects = 'exclude';
				break;
			}
		}
		else if ('stablepages' == $sType)
		{
			switch ($sArg)
			{
			case 'include':
				$sStable = 'include';
				break;
			case 'only':
				$sStable = 'only';
				break;
			case 'exclude':
			default:
				$sStable = 'exclude';
				break;
			}
		}
		else if ('qualitypages' == $sType)
		{
			switch ($sArg)
			{
			case 'include':
				$sQuality = 'include';
				break;
			case 'only':
				$sQuality = 'only';
				break;
			case 'exclude':
			default:
				$sQuality = 'exclude';
				break;
			}
		}
		else if ('suppresserrors' == $sType)
		{
			if ('true' == $sArg)
				$bSuppressErrors = true;
			else
				$bSuppressErrors = false;
		}
		else if ('addfirstcategorydate' == $sType)
		{
			if ('true' == $sArg)
				$bAddFirstCategoryDate = true;
			else
				$bAddFirstCategoryDate = false;
		}
		else if ('shownamespace' == $sType)
		{
			if ('false' == $sArg)
				$bShowNamespace = false;
			else
				$bShowNamespace = true;
		}
		else if ('showcurid' == $sType )
		{
			if ('false' == $sArg)
				$bShowCurId = false;
			else
				$bShowCurId = true;
		}
	}

	$iCatCount = count($aCategories);
	$iExcludeCatCount = count($aExcludeCategories);
	$iTotalCatCount = $iCatCount + $iExcludeCatCount;

	if ($iCatCount < 1 && false == $bNamespace)
	{
		if (false == $bSuppressErrors)
	return htmlspecialchars( wfMsg( 'intersection_noincludecats' ) ); // "!!no included categories!!";
		else
	return '';
	}

	if ($iTotalCatCount < $wgDLPminCategories)
	{
		if (false == $bSuppressErrors)
	return htmlspecialchars( wfMsg( 'intersection_toofewcats' ) ); // "!!too few categories!!";
		else
	return '';
	}

	if ( $iTotalCatCount > $wgDLPmaxCategories && !$wgDLPAllowUnlimitedCategories )
	{
		if (false == $bSuppressErrors)
	return htmlspecialchars( wfMsg( 'intersection_toomanycats' ) ); // "!!too many categories!!";
		else
	return '';
	}

	if ($bCountSet)
	{
		if ($iCount < $wgDLPMinResultCount)
			$iCount = $wgDLPMinResultCount;
		if ($iCount > $wgDLPMaxResultCount)
			$iCount = $wgDLPMaxResultCount;
	}
	else
	{
		if (!$wgDLPAllowUnlimitedResults)
		{
			$iCount = $wgDLPMaxResultCount;
			$bCountSet = true;
		}
	}

	//disallow showing date if the query doesn't have an inclusion category parameter
	if ($iCatCount < 1)
		$bAddFirstCategoryDate = false;


	//build the SQL query
	$dbr =& wfGetDB( DB_SLAVE );
	$sPageTable = $dbr->tableName( 'page' );
	$categorylinks = $dbr->tableName( 'categorylinks' );
	$sSqlSelectFrom = "SELECT page_namespace, page_title, page_id, c1.cl_timestamp FROM $sPageTable";

	if (true == $bNamespace)
		$sSqlWhere = ' WHERE page_namespace='.$iNamespace.' ';
	else
		$sSqlWhere = ' WHERE 1=1 ';
		
	// Bug 14943 - Allow filtering based on FlaggedRevs stability.
	// Check if the extension actually exists before changing the query...
	if( function_exists('efLoadFlaggedRevs') ) {
		$flaggedpages = $dbr->tableName( 'flaggedpages' );
		$filterSet = array('only','exclude');
		# Either involves the same JOIN here...
		if( in_array($sStable,$filterSet) || in_array($sQuality,$filterSet) ) {
			$sSqlSelectFrom .= " LEFT JOIN $flaggedpages ON page_id = fp_page_id";
		}
		switch( $sStable )
		{
			case 'only':
				$sSqlWhere .= ' AND fp_stable IS NOT NULL ';
				break;
			case 'exclude':
				$sSqlWhere .= ' AND fp_stable IS NULL ';
				break;
		}
		switch( $sQuality )
		{
			case 'only':
				$sSqlWhere .= ' AND fp_quality >= 1';
				break;
			case 'exclude':
				$sSqlWhere .= ' AND fp_quality = 0';
				break;
		}
	}

	switch ($sRedirects)
	{
		case 'only':
			$sSqlWhere .= ' AND page_is_redirect = 1 ';
			break;
		case 'exclude':
			$sSqlWhere .= ' AND page_is_redirect = 0 ';
			break;
	}

	$iCurrentTableNumber = 0;

	for ($i = 0; $i < $iCatCount; $i++) {
		$sSqlSelectFrom .= " INNER JOIN $categorylinks AS c" . ($iCurrentTableNumber+1);
		$sSqlSelectFrom .= ' ON page_id = c'.($iCurrentTableNumber+1).'.cl_from';
		$sSqlSelectFrom .= ' AND c'.($iCurrentTableNumber+1).'.cl_to='.
			$dbr->addQuotes( $aCategories[$i]->getDBkey() );

		$iCurrentTableNumber++;
	}

	for ($i = 0; $i < $iExcludeCatCount; $i++) {
		$sSqlSelectFrom .= " LEFT OUTER JOIN $categorylinks AS c" . ($iCurrentTableNumber+1);
		$sSqlSelectFrom .= ' ON page_id = c'.($iCurrentTableNumber+1).'.cl_from';
		$sSqlSelectFrom .= ' AND c'.($iCurrentTableNumber+1).'.cl_to='.
			$dbr->addQuotes( $aExcludeCategories[$i]->getDBkey() );

		$sSqlWhere .= ' AND c'.($iCurrentTableNumber+1).'.cl_to IS NULL';

		$iCurrentTableNumber++;
	}

	if ('descending' == $sOrder)
		$sSqlOrder = 'DESC';
	else
		$sSqlOrder = 'ASC';

	if ('lastedit' == $sOrderMethod)
		$sSqlWhere .= ' ORDER BY page_touched ';
	else
		$sSqlWhere .= ' ORDER BY c1.cl_timestamp ';

	$sSqlWhere .= $sSqlOrder;


	if ($bCountSet)
	{
		$sSqlWhere .= ' LIMIT ' . $iCount;
	}

	//DEBUG: output SQL query
	//$output .= 'QUERY: [' . $sSqlSelectFrom . $sSqlWhere . "]<br />";

	// process the query
	$res = $dbr->query($sSqlSelectFrom . $sSqlWhere);

	$sk =& $wgUser->getSkin();

	if ($dbr->numRows( $res ) == 0)
	{
		if (false == $bSuppressErrors)
			return htmlspecialchars( wfMsg( 'intersection_noresults' ) );
		else
			return '';
	}

	//start unordered list
	$output = $sStartList . "\n";

	//process results of query, outputing equivalent of <li>[[Article]]</li> for each result,
	//or something similar if the list uses other startlist/endlist
	while ($row = $dbr->fetchObject( $res ) ) {
		$title = Title::makeTitle( $row->page_namespace, $row->page_title);
		$output .= $sStartItem;
		if (true == $bAddFirstCategoryDate)
			$output .= $wgLang->date($row->cl_timestamp) . ': ';

		$query = array();
		if (true == $bShowCurId)
			$query['curid'] = intval($row->page_id);

		if (true == $bShowNamespace)
			$titleText = $title->getPrefixedText();
		else
			$titleText = $title->getText();

		$output .= $sk->link($title, htmlspecialchars($titleText), array(), $query, array( 'forcearticlepath', 'known' ) );

		$output .= $sEndItem . "\n";
	}

	//end unordered list
	$output .= $sEndList . "\n";

	return $output;
}
