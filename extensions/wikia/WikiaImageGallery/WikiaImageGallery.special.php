<?php
if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named WhatIsMyIP.\n";
	exit( 1 ) ;
}

extAddSpecialPage( dirname(__FILE__) . '/WikiaImageGallery.special.php', 'WIG', 'WIG' );
$wgSpecialPageGroups['WIG'] = 'other';

class WIG extends SpecialPage  {
	const thumbnailMaxWidth = 120;
	const thumbnailMaxHeight = 90;

	function  __construct() {
		global $wgMessageCache;
		$wgMessageCache->addMessage('wig', 'WIG test page - new image search');
		parent::__construct('WIG' /*class*/);
	}

	function execute() {
		global $wgMessageCache, $wgOut, $wgRequest, $wgTitle, $wgEnableWikiaSearchExt, $wgContentNamespaces;
		wfProfileIn( __METHOD__ );
		$wgOut->SetPageTitle('WIG test page - new image search');
		$query = $wgRequest->getVal('query');
		$nosort = $wgRequest->getVal('nosort', '0');
		$wgOut->addHTML('<form method="get" action="' . $wgTitle->getLocalUrl() . '">
			<input type="text" name="query" value="' . $query . '" />
			<label><input type="checkbox" name="nosort" value="1" ' . ($nosort ? 'checked="checked"' : '') . '" /> checked: article importance; unchecked: usage of image</label>
			<input type="submit" value="search" />
		</form>');

		if(!empty($query)) {
			$query_select = "SELECT il_to FROM imagelinks JOIN page ON page_id=il_from WHERE page_title = '%s' and page_namespace = %s";
			$query_glue = ' UNION DISTINCT ';
			$query_arr = array();
			$articles = $images = array();

			//get search result from API
			$oFauxRequest = new FauxRequest(
				array(
					'action' => 'query',
					'list' => 'search',
					'srnamespace' => implode('|', array_merge($wgContentNamespaces, array(NS_FILE))),
					'srlimit' => '20',
					'srsearch' => $query,
				)
			);
			$oApi = new ApiMain($oFauxRequest);
			$oApi->execute();
			$aResult =& $oApi->GetResultData();

			$dbr = wfGetDB(DB_SLAVE);

			if (count($aResult['query']['search']) > 0) {
				if (!empty($aResult['query']['search'])) {
					foreach ($aResult['query']['search'] as $aResult) {
						$query_arr[] = sprintf($query_select, $dbr->strencode(str_replace(' ', '_', $aResult['title'])), $aResult['ns']);
					}
				}
			}

			if (count($query_arr)) {
				$query_sql = implode($query_glue, $query_arr);
				$res = $dbr->query($query_sql, __METHOD__);

				if($res->numRows() > 0) {
					while( $row = $res->fetchObject() ) {
						$articles[] = $row->il_to;
					}
					$dbr->freeResult($res);

					foreach($articles as $title) {
						$oImageTitle = Title::makeTitleSafe(NS_FILE, $title);
						if ($oImageTitle instanceof Title) {
							$image = wfFindFile($oImageTitle);
							if ($image === false) {
								continue;
							}
							$thumb = $image->getThumbnail(min(self::thumbnailMaxWidth, $image->getWidth()), min(self::thumbnailMaxHeight, $image->getHeight()));
							$images[] = $thumb->toHtml();
						}
					}
				}
			}
			foreach ($images as $img) {
				$wgOut->addHTML($img);
			}
		}
		wfProfileOut( __METHOD__ );
	}
}