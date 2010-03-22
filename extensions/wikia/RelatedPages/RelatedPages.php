<?php

$wgExtensionFunctions[] = 'RelatedPages_Setup';

function RelatedPages_Setup() {
	global $wgHooks;
	$wgHooks['OutputPageMakeCategoryLinks'][] = 'RelatedPages_GetInCategories';
}

function RelatedPages_GetInCategories($a, $categories, $b) {
	global $wgTitle, $wgContentNamespaces, $wgHooks;

	if(!empty($wgTitle) && in_array($wgTitle->getNamespace(), $wgContentNamespaces)) {
		if(count($categories) > 0) {
			$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'RelatedPages_Display';
			Wikia::setVar('InCategories', array_keys($categories));
		}
	}

	return true;
}

function RelatedPages_Compare($a, $b) {
	if($a == $b) {
		return rand(-1,1);
	}
	return ($a > $b) ? -1 : 1;
}

function RelatedPages_Display(&$template, &$templateEngine) {
	global $wgUser, $wgRequest, $wgMemc, $wgContentNamespaces, $wgArticle;

	if($wgRequest->getVal('action') == 'submit') {
		return true;
	}
	$skin = $wgUser->getSkin();
	if($skin && isset($skin->skinname) && $skin->skinname != 'monaco') {
		return true;
	}

	if($templateEngine->data['catlinks']) {
		$categories = Wikia::getVar('InCategories');

		if($categories) {
			sort($categories);

			$cacheKey = wfMemcKey(__CLASS__, join(':', $categories), 1);

			$out = $wgMemc->get($cacheKey);

			if(!is_array($out)) {
				if(count($wgContentNamespaces) > 0) {
					$joinSql = ' JOIN page ON page_id = cl_from AND page_namespace';
					if(count($wgContentNamespaces) == 1) {
						$joinSql .= ' = ' . array_shift($wgContentNamespaces) . ' ';
					} else {
						$joinSql .= ' IN ('.join(',', $wgContentNamespaces).') ';
					}
				} else {
					$joinSql = '';
				}

				$dbr = wfGetDB(DB_SLAVE, 'stats');
				$out = array();
				$results = array();
				$query1 = 'SELECT /* RelatedPages Query 1 */ cl_from, COUNT(cl_to) AS count FROM categorylinks USE KEY(cl_from)'.$joinSql.' WHERE cl_to IN ("'.join('","', $categories).'") GROUP BY 1';

				if(count($categories) > 1) {
					$query1 .= ' HAVING COUNT(cl_to) > 1';
				} else {
					$query1 .= ' LIMIT 100';
				}
				$res1 = $dbr->query($query1);
				while($row1 = $dbr->fetchObject($res1)) {
					$results[$row1->cl_from] = $row1->count;
				}
				if(count($categories) > 1) {
					arsort($results);
					uasort($results, 'RelatedPages_Compare');
					$out = array_slice(array_keys($results), 0, 5);
				} else {
					if(count($results) > 0) {
						$out = array_rand($results, min(count($results), 5));
						if(!is_array($out)){
							$out = array($out);
						}
					}
				}
				if(count($categories) > 1 && count($out) < 5) {
					$results = array();
					$query2 = 'SELECT /* RelatedPages Query 2 */ cl_from FROM categorylinks USE KEY(cl_from)'.$joinSql.' WHERE cl_to IN ("'.join('","', $categories).'") GROUP BY 1 LIMIT 100';
					$res2 = $dbr->query($query2);
					while($row2 = $dbr->fetchObject($res2)) {
						if(!in_array($row2->cl_from, $out)) {
							$results[] = $row2->cl_from;
						}
					}
					if(!empty($results)) {
						$randOut = array_rand(array_flip($results), min(count($results), 5 - count($out)));
						if(!is_array($randOut)){ // array_rand will return a single element instead of an array of size 1
							$randOut = array($randOut);
						}
						$out = array_merge($out, $randOut);
					}
				}

				$wgMemc->set($cacheKey, $out, 60 * 60 * 6);
			}

			if(count($out) > 0) {
				unset($out[array_search($wgArticle->getID(), $out)]);

				// quit if we have no data after removing current page
				if ( empty( $out ) ) {
					return true;
				}

				$i = 0;

                                $templateEngine->data['bodytext'] .= '<div style="clear:both;"></div><div id="RelatedPages" class="widget" style="margin-top: 10px;"><div class="accent" style="padding: 6px; font-weight: bold;">Check out these related pages:</div><div style="padding: 10px; text-align: center; line-height: 1.5em;">';

				foreach($out as $item) {
					$title = Title::newFromId($item);
					if(!empty($title) && $title->exists() && $i < 4) {

						$templateEngine->data['bodytext'] .= '<a href="'.htmlspecialchars($title->getFullUrl()).'">'.htmlspecialchars($title->getPrefixedText()).'</a>';

						if($i % 2 == 0) {
							global $wgCdnStylePath;
							$templateEngine->data['bodytext'] .= '<img src="'.$wgCdnStylePath.'/skins/monobook/bullet.gif" style="margin: 0 15px"/>';
						}
						if($i % 2 == 1 && $i < 3) {
							$templateEngine->data['bodytext'] .= '<br />';
						}

						$i++;
					}
				}

				$templateEngine->data['bodytext'] .= '</div></div>';
			}
		}

	}
	return true;
}
