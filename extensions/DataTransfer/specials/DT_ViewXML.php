<?php
/**
 * Shows list of all forms on the site.
 *
 * @author Yaron Koren
 */

if (!defined('MEDIAWIKI')) die();

class DTViewXML extends SpecialPage {

	/**
	 * Constructor
	 */
	public function DTViewXML() {
		global $wgLanguageCode;
		SpecialPage::SpecialPage('ViewXML');
		dtfInitContentLanguage($wgLanguageCode);
		wfLoadExtensionMessages('DataTransfer');
	}

	function execute($query = '') {
		$this->setHeaders();
		doSpecialViewXML($query);
	}
}

function getCategoriesList() {
	global $wgContLang, $dtgContLang;
	$dt_props = $dtgContLang->getSpecialPropertiesArray();
	$exclusion_cat_name = str_replace(' ', '_', $dt_props[DT_SP_IS_EXCLUDED_FROM_XML]);
	$exclusion_cat_full_name = $wgContLang->getNSText(NS_CATEGORY) . ':' . $exclusion_cat_name;
	$dbr = wfGetDB( DB_SLAVE );
	$categorylinks = $dbr->tableName( 'categorylinks' );
	$res = $dbr->query("SELECT DISTINCT cl_to FROM $categorylinks");
	$categories = array();
	while ($row = $dbr->fetchRow($res)) {
		$cat_name = $row[0];
		// add this category to the list, if it's not the
		// "Excluded from XML" category, and it's not a child of that
		// category
		if ($cat_name != $exclusion_cat_name) {
			$title = Title::newFromText($cat_name, NS_CATEGORY);
			$parent_categories = $title->getParentCategoryTree(array());
			if (! treeContainsElement($parent_categories, $exclusion_cat_full_name))
				$categories[] = $cat_name;
		}
	}
	$dbr->freeResult($res);
	sort($categories);
	return $categories;
}

function getNamespacesList() {
	$dbr = wfGetDB( DB_SLAVE );
	$page = $dbr->tableName( 'page' );
	$res = $dbr->query("SELECT DISTINCT page_namespace FROM $page");
	$namespaces = array();
	while ($row = $dbr->fetchRow($res)) {
		$namespaces[] = $row[0];
	}
	$dbr->freeResult($res);
	return $namespaces;
}

function getGroupings() {
  global $dtgContLang;

  $dt_props = $dtgContLang->getSpecialPropertiesArray();
  $xml_grouping_prop = str_replace(' ', '_', $dt_props[DT_SP_HAS_XML_GROUPING]);

  global $smwgIP;
  if (! isset($smwgIP)) {
    return array();
  } else {
    $smw_version = SMW_VERSION;
    if ($smw_version{0} == '0') {
      return array();
    } else {
      $groupings = array();
      $store = smwfGetStore();
      $grouping_prop = Title::makeTitle(SMW_NS_PROPERTY, $xml_grouping_prop);
      $grouped_props = $store->getAllPropertySubjects($grouping_prop);
      foreach ($grouped_props as $grouped_prop) {
        // the type of $grouped_prop depends on the version of SMW
        if ($grouped_prop instanceof SMWWikiPageValue) {
          $grouped_prop = $grouped_prop->getTitle();
        }
        $res = $store->getPropertyValues($grouped_prop, $grouping_prop);
        $num = count($res);
        if ($num > 0) {
          $grouping_label = $res[0]->getTitle()->getText();
          $groupings[] = array($grouped_prop, $grouping_label);
        }
      }
      return $groupings;
    }
  }
}

function getSubpagesForPageGrouping($page_name, $relation_name) {
	$dbr = wfGetDB( DB_SLAVE );
	$smw_relations = $dbr->tableName( 'smw_relations' );
	$smw_attributes = $dbr->tableName( 'smw_attributes' );
	$res = $dbr->query("SELECT subject_title FROM $smw_relations WHERE object_title = '$page_name' AND relation_title = '$relation_name'");
	$subpages = array();
	while ($row = $dbr->fetchRow($res)) {
		$subpage_name = $row[0];
		$query_subpage_name = str_replace("'", "\'", $subpage_name);
		// get the display order
		$res2 = $dbr->query("SELECT value_num FROM $smw_attributes WHERE subject_title = '$query_subpage_name' AND attribute_title = 'Display_order'");
		if ($row2 = $dbr->fetchRow($res2)) {
			$display_order = $row2[0];
		} else {
			$display_order = -1;
		}
		$dbr->freeResult($res2);
		// HACK - page name is the key, display order is the value
		$subpages[$subpage_name] = $display_order;
	}
	$dbr->freeResult($res);
	uasort($subpages, "cmp");
	return array_keys($subpages);
}


/*
 * Get all the pages that belong to a category and all its subcategories,
 * down a certain number of levels - heavily based on SMW's
 * SMWInlineQuery::includeSubcategories()
 */
  function getPagesForCategory($top_category, $num_levels) {
    if (0 == $num_levels) return $top_category;

    $db = wfGetDB( DB_SLAVE );
    $fname = "getPagesForCategory";
    $categories = array($top_category);
    $checkcategories = array($top_category);
    $titles = array();
    for ($level = $num_levels; $level > 0; $level--) {
      $newcategories = array();
      foreach ($checkcategories as $category) {
        $res = $db->select( // make the query
          array('categorylinks', 'page'),
          array('page_id', 'page_title', 'page_namespace'),
          array('cl_from = page_id',
          'cl_to = '. $db->addQuotes($category)),
          $fname);
        if ($res) {
          while ($res && $row = $db->fetchRow($res)) {
            if (array_key_exists('page_title', $row)) {
              $page_namespace = $row['page_namespace'];
              if ($page_namespace == NS_CATEGORY) {
                $new_category = $row[ 'page_title' ];
                if (!in_array($new_category, $categories)) {
                  $newcategories[] = $new_category;
                }
              } else {
                $titles[] = Title::newFromID($row['page_id']);
              }
            }
          }
          $db->freeResult( $res );
        }
      }
      if (count($newcategories) == 0) {
        return $titles;
      } else {
        $categories = array_merge($categories, $newcategories);
      }
      $checkcategories = array_diff($newcategories, array());
    }
    return $titles;
  }

/*
function getPagesForCategory($category) {
	$dbr = wfGetDB( DB_SLAVE );
	$categorylinks = $dbr->tableName( 'categorylinks' );
	$res = $dbr->query("SELECT cl_from FROM $categorylinks WHERE cl_to = '$category'");
	$titles = array();
	while ($row = $dbr->fetchRow($res)) {
		$titles[] = Title::newFromID($row[0]);
	}
	$dbr->freeResult($res);
	return $titles;
}
*/

function getPagesForNamespace($namespace) {
	$dbr = wfGetDB( DB_SLAVE );
	$page = $dbr->tableName( 'page' );
	$res = $dbr->query("SELECT page_id FROM $page WHERE page_namespace = '$namespace'");
	$titles = array();
	while ($row = $dbr->fetchRow($res)) {
		$titles[] = Title::newFromID($row[0]);
	}
	$dbr->freeResult($res);
	return $titles;
}

/**
 * Helper function for getXMLForPage()
 */
function treeContainsElement($tree, $element) {
	// escape out if there's no tree (i.e., category)
	if ($tree == null)
		return false;

	foreach ($tree as $node => $child_tree) {
		if ($node === $element) {
			return true;
		} elseif (count($child_tree) > 0) {
			if (treeContainsElement($child_tree, $element)) {
				return true;
			}
		}
	}
	// no match found
	return false;
}

function getXMLForPage($title, $simplified_format, $groupings, $depth=0) {
  if ($depth > 5) {return ""; }

  global $wgContLang, $dtgContLang;

  $namespace_labels = $wgContLang->getNamespaces();
  $template_label = $namespace_labels[NS_TEMPLATE];
  $namespace_str = str_replace(' ', '_', wfMsgForContent('dt_xml_namespace'));
  $page_str = str_replace(' ', '_', wfMsgForContent('dt_xml_page'));
  $field_str = str_replace(' ', '_', wfMsgForContent('dt_xml_field'));
  $name_str = str_replace(' ', '_', wfMsgForContent('dt_xml_name'));
  $title_str = str_replace(' ', '_', wfMsgForContent('dt_xml_title'));
  $id_str = str_replace(' ', '_', wfMsgForContent('dt_xml_id'));
  $free_text_str = str_replace(' ', '_', wfMsgForContent('dt_xml_freetext'));

  // if this page belongs to the exclusion category, exit
  $parent_categories = $title->getParentCategoryTree(array());
  $dt_props = $dtgContLang->getSpecialPropertiesArray();
  //$exclusion_category = $title->newFromText($dt_props[DT_SP_IS_EXCLUDED_FROM_XML], NS_CATEGORY);
  $exclusion_category = $wgContLang->getNSText(NS_CATEGORY) . ':' . str_replace(' ', '_', $dt_props[DT_SP_IS_EXCLUDED_FROM_XML]);
  if (treeContainsElement($parent_categories, $exclusion_category))
    return "";
  $article = new Article($title);
  $page_title = str_replace('"', '&quot;', $title->getText());
  $page_title = str_replace('&', '&amp;', $page_title);
  if ($simplified_format)
    $text = "<$page_str><$id_str>{$article->getID()}</$id_str><$title_str>$page_title</$title_str>\n";
  else
    $text = "<$page_str $id_str=\"" . $article->getID() . "\" $title_str=\"" . $page_title . '" >';

  // traverse the page contents, one character at a time
  $uncompleted_curly_brackets = 0;
  $page_contents = $article->getContent();
  // escape out variables like "{{PAGENAME}}"
  $page_contents = str_replace('{{PAGENAME}}', '&#123;&#123;PAGENAME&#125;&#125;', $page_contents);
  // escape out parser functions
  $page_contents = preg_replace('/{{(#.+)}}/', '&#123;&#123;$1&#125;&#125;', $page_contents);
  // escape out transclusions
  $page_contents = preg_replace('/{{(:.+)}}/', '&#123;&#123;$1&#125;&#125;', $page_contents);
  // escape out variable names
  $page_contents = str_replace('{{{', '&#123;&#123;&#123;', $page_contents);
  $page_contents = str_replace('}}}', '&#125;&#125;&#125;', $page_contents);
  // escape out tables
  $page_contents = str_replace('{|', '&#123;|', $page_contents);
  $page_contents = str_replace('|}', '|&#125;', $page_contents);
  $free_text = "";
  $free_text_id = 1;
  $template_name = "";
  $field_name = "";
  $field_value = "";
  $field_has_name = false;
  for ($i = 0; $i < strlen($page_contents); $i++) {
    $c = $page_contents[$i];
    if ($uncompleted_curly_brackets == 0) {
      if ($c == "{" || $i == strlen($page_contents) - 1) {
        if ($i == strlen($page_contents) - 1)
          $free_text .= $c;
        $uncompleted_curly_brackets++;
        $free_text = trim($free_text);
        $free_text = str_replace('&', '&amp;', $free_text);
        $free_text = str_replace('[', '&#91;', $free_text);
        $free_text = str_replace(']', '&#93;', $free_text);
        $free_text = str_replace('<', '&lt;', $free_text);
        $free_text = str_replace('>', '&gt;', $free_text);
        if ($free_text != "") {
          $text .= "<$free_text_str id=\"$free_text_id\">$free_text</$free_text_str>";
          $free_text = "";
          $free_text_id++;
        }
      } elseif ($c == "{") {
        // do nothing
      } else {
        $free_text .= $c;
      }
    } elseif ($uncompleted_curly_brackets == 1) {
      if ($c == "{") {
        $uncompleted_curly_brackets++;
        $creating_template_name = true;
      } elseif ($c == "}") {
        $uncompleted_curly_brackets--;
        // is this needed?
        //if ($field_name != "") {
        //  $field_name = "";
        //}
        if ($page_contents[$i - 1] == '}') {
          if ($simplified_format)
            $text .= "</" . $template_name . ">";
          else
            $text .= "</$template_label>";
        }
        $template_name = "";
      }
    } else { // 2 or greater - probably 2
      if ($c == "}") {
        $uncompleted_curly_brackets--;
      }
      if ($c == "{") {
        $uncompleted_curly_brackets++;
      } else {
        if ($creating_template_name) {
          if ($c == "|" || $c == "}") {
            $template_name = str_replace(' ', '_', trim($template_name));
            $template_name = str_replace('&', '&amp;', $template_name);
            if ($simplified_format) {
              $text .= "<" . $template_name . ">";
            } else
              $text .= "<$template_label $name_str=\"$template_name\">";
            $creating_template_name = false;
            $creating_field_name = true;
            $field_id = 1;
          } else {
            $template_name .= $c;
          }
        } else {
          if ($c == "|" || $c == "}") {
            if ($field_has_name) {
              $field_value = str_replace('&', '&amp;', $field_value);
              if ($simplified_format) {
                $field_name = str_replace(' ', '_', trim($field_name));
                $text .= "<" . $field_name . ">";
                $text .= trim($field_value);
                $text .= "</" . $field_name . ">";
              } else {
                $text .= "<$field_str $name_str=\"" . trim($field_name) . "\">";
                $text .= trim($field_value);
                $text .= "</$field_str>";
              }
              $field_value = "";
              $field_has_name = false;
            } else {
              // "field_name" is actually the value
              if ($simplified_format) {
                $field_name = str_replace(' ', '_', $field_name);
                // add "Field" to the beginning of the file name, since
                // XML tags that are simply numbers aren't allowed
                $text .= "<" . $field_str . '_' . $field_id . ">";
                $text .= trim($field_name);
                $text .= "</" . $field_str . '_' . $field_id . ">";
              } else {
                $text .= "<$field_str $name_str=\"$field_id\">";
                $text .= trim($field_name);
                $text .= "</$field_str>";
              }
              $field_id++;
            }
            $creating_field_name = true;
            $field_name = "";
          } elseif ($c == "=") {
            // handle case of = in value
            if (! $creating_field_name) {
              $field_value .= $c;
            } else {
              $creating_field_name = false;
              $field_has_name = true;
            }
          } elseif ($creating_field_name) {
            $field_name .= $c;
          } else {
            $field_value .= $c;
          }
        }
      }
    }
  }

  // handle groupings, if any apply here; first check if SMW is installed
  global $smwgIP;
  if (isset($smwgIP)) {
    $store = smwfGetStore();
    foreach ($groupings as $pair) {
      list($property, $grouping_label) = $pair;
      $store = smwfGetStore();
      $wiki_page = SMWDataValueFactory::newTypeIDValue('_wpg', $page_title);
      $options = new SMWRequestOptions();
      $options->sort = "subject_title";
      $res = $store->getPropertySubjects($property, $wiki_page, $options);
      $num = count($res);
      if ($num > 0) {
        $text .= "<$grouping_label>\n";
        foreach ($res as $subject) {
          // the type of $subject depends on the version of SMW
          if ($subject instanceof SMWWikiPageValue) {
            $subject = $subject->getTitle();
          }
          $text .= getXMLForPage($title, $simplified_format, $groupings, $depth + 1);
        }
        $text .= "</$grouping_label>\n";
      }
    }
  }

  $text .= "</$page_str>\n";
  // escape back the curly brackets that were escaped out at the beginning
  $text = str_replace('&amp;#123;', '{', $text);
  $text = str_replace('&amp;#125;', '}', $text);
  return $text;
}

function doSpecialViewXML() {
	global $wgOut, $wgRequest, $wgUser, $wgCanonicalNamespaceNames, $wgContLang;
	$skin = $wgUser->getSkin();
	$namespace_labels = $wgContLang->getNamespaces();
	$category_label = $namespace_labels[NS_CATEGORY];
	$template_label = $namespace_labels[NS_TEMPLATE];
	$name_str = "name";
	$namespace_str = wfMsg('dt_xml_namespace');

	$form_submitted = false;
	$page_titles = array();
	$cats = $wgRequest->getArray('categories');
	$nses = $wgRequest->getArray('namespaces');
	if (count($cats) > 0 || count($nses) > 0) {
		$form_submitted = true;
	}

	if ($form_submitted) {
		$wgOut->disable();

		// Cancel output buffering and gzipping if set
		// This should provide safer streaming for pages with history
		wfResetOutputBuffers();
		header( "Content-type: application/xml; charset=utf-8" );

		$groupings = getGroupings();
		$simplified_format = $wgRequest->getVal('simplified_format');
		$text = "<Pages>";
		if ($cats) {
			foreach ($cats as $cat => $val) {
				if ($simplified_format)
					$text .= '<' . str_replace(' ', '_', $cat) . ">\n";
				else
					$text .= "<$category_label $name_str=\"$cat\">\n";
				$titles = getPagesForCategory($cat, 10);
				foreach ($titles as $title) {
					$text .= getXMLForPage($title, $simplified_format, $groupings);
				}
				if ($simplified_format)
					$text .= '</' . str_replace(' ', '_', $cat) . ">\n";
				else
					$text .= "</$category_label>\n";
			}
		}

		if ($nses) {
			foreach ($nses as $ns => $val) {
		 		if ($ns == 0) {
					$ns_name = "Main";
				} else {
					$ns_name = $wgCanonicalNamespaceNames[$ns];
				}
				if ($simplified_format)
					$text .= '<' . str_replace(' ', '_', $ns_name) . ">\n";
				else
					$text .= "<$namespace_str $name_str=\"$ns_name\">\n";
				$titles = getPagesForNamespace($ns);
				foreach ($titles as $title) {
					$text .= getXMLForPage($title, $simplified_format, $groupings);
				}
				if ($simplified_format)
					$text .= '</' . str_replace(' ', '_', $ns_name) . ">\n";
				else
					$text .= "</$namespace_str>\n";
			}
		}
		$text .= "</Pages>";
		print $text;
	} else {
	$text = "<form action=\"\" method=\"get\">\n";
	$text .= "<p>" . wfMsg('dt_viewxml_docu') . "</p>\n";
	$text .= "<h2>" . wfMsg('dt_viewxml_categories') . "</h2>\n";
	$categories = getCategoriesList();
	foreach ($categories as $category) {
		$title = Title::makeTitle( NS_CATEGORY, $category );
		$link = $skin->makeLinkObj( $title, $title->getText() );
		$text .= "<input type=\"checkbox\" name=\"categories[$category]\" /> $link <br />\n";
	}
	$text .= "<h2>" . wfMsg('dt_viewxml_namespaces') . "</h2>\n";
	$namespaces = getNamespacesList();
	foreach ($namespaces as $namespace) {
		if ($namespace == 0) {
			$ns_name = "Main";
		} else {
			$ns_name = $wgCanonicalNamespaceNames["$namespace"];
		}
		$ns_name = str_replace('_', ' ', $ns_name);
		$text .= "<input type=\"checkbox\" name=\"namespaces[$namespace]\" /> $ns_name <br />\n";
	}
	$text .= "<br /><p><input type=\"checkbox\" name=\"simplified_format\" /> " . wfMsg('dt_viewxml_simplifiedformat') . "</p>\n";
	$text .= "<input type=\"submit\" value=\"" . wfMsg('viewxml') . "\">\n";
	$text .= "</form>\n";

	$wgOut->addHTML($text);

	}
}
