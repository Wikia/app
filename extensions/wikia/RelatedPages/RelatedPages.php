<?php
$wgExtensionFunctions[] = 'RelatedPages_Setup';

function RelatedPages_Setup() {
	global $wgHooks;
	$wgHooks['OutputPageMakeCategoryLinks'][] = 'RelatedPages_GetInCategories';
}

function RelatedPages_GetInCategories($a, $categories, $b) {
	if(count($categories) > 0) {
		global $wgHooks;
		$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'RelatedPages_Display';
		Wikia::setVar('InCategories', array_keys($categories));
	}
	return true;
}

function RelatedPages_Compare($a, $b) {
	if($a == $b) {
		return rand(-1,1);
	}
	return ($a > $b) ? -1 : 1;
}

function RelatedPages_Display( &$template, &$templateEngine ) {
	global $wgUser;

	if(!$wgUser->isAllowed('wikifactory')) {
		//return true;
	}

	$skin = $wgUser->getSkin();
	if($skin && isset($skin->skinname) && $skin->skinname != 'monaco') {
		return true;
	}

	if($templateEngine->data['catlinks']) {
		global $wgArticle;

		$categories = Wikia::getVar('InCategories');

		$dbr = wfGetDB(DB_SLAVE);

		$out = array();
		$results = array();

		$query1 = 'SELECT /* RelatedPages Query 1 */ cl_from, COUNT(cl_to) AS count FROM categorylinks USE KEY(cl_from) WHERE cl_to IN ("'.join('","', $categories).'") GROUP BY 1';

		if(count($categories) > 1) {
			$query1 .= ' HAVING COUNT(cl_to) > 1';
		} else {
			$query1 .= ' LIMIT 100';
		}

		$res1 = $dbr->query($query1);
		while($row1 = $dbr->fetchObject($res1)) {
			$results[$row1->cl_from] = $row1->count;
		}

		unset($results[$wgArticle->getID()]);

		if(count($categories) > 1) {
			arsort($results);
			uasort($results, 'RelatedPages_Compare');
			$out = array_slice(array_keys($results), 0, 5);
		} else {
			$out = array_rand($results, 5);
		}

		if(count($categories) > 1 && count($out) < 5) {
			$results = array();
			$query2 = 'SELECT /* RelatedPages Query 2 */ cl_from FROM categorylinks USE KEY(cl_from) WHERE cl_to IN ("'.join('","', $categories).'") GROUP BY 1 HAVING COUNT(cl_to) = 1 LIMIT 100';
			$res2 = $dbr->query($query2);
			while($row2 = $dbr->fetchObject($res2)) {
				if(!in_array($row2->cl_from, $out)) {
					$results[] = $row2->cl_from;
				}
			}
			if(!empty($results)) {
				unset($results[$wgArticle->getID()]);
				$out = array_merge($out, array_rand($results, 5 - count($out)));
			}
		}

		if(count($out) > 0) {
			$templateEngine->data['bodytext'] .= '<style>.RelatedPages li { font-weight: bold; float: left; background: transparent url("http://images.wikia.com/common/skins/monobook/bullet.gif") no-repeat 0px 50%; padding-left: 21px; margin-right: 16px; }</style>';
			$templateEngine->data['bodytext'] .= '<div style="clear:both;"></div><div class="widget" style="margin-top: 10px;"><div class="accent" style="padding: 6px; font-weight: bold;">Check out these related pages:</div><div style="padding: 10px;"><ul class="reset clearfix RelatedPages" style="margin: 0">';
			for($i = 0; $i < count($out); $i++) {
				$title = Title::newFromId($out[$i]);
				if($title->exists()) {
					$templateEngine->data['bodytext'] .= '<li'.($i == 0 ? ' style="background: none; padding-left: 0;"' : '').'><a href="'.htmlspecialchars($title->getFullUrl()).'">'.htmlspecialchars($title->getPrefixedText()).'</a></li>';
				}
			}
			$templateEngine->data['bodytext'] .= '</ul></div></div>';
		}
	}

	return true;
}