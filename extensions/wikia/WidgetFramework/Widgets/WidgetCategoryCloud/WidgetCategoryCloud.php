<?php

if (!defined("MEDIAWIKI")) die(1);

global $wgWidgets;
$wgWidgets["WidgetCategoryCloud"] = array(
	"callback"  => "WidgetCategoryCloud",
	"title"     => "widget-title-categorycloud",
	"desc"      => "widget-desc-categorycloud",
	"closeable" => false,
	"editable"  => false,
	"listable"  => false,
);

function WidgetCategoryCloud($id, $params) {
	$output = "";

	wfProfileIn( __METHOD__ );

	global $wgMemc;
	$key = wfMemcKey("WidgetCategoryCloud", "data");
	$data = $wgMemc->get($key);
	if (is_null($data)) {
		$data = WidgetCategoryCloudCloudizeData(WidgetCategoryCloudGetData());
		$wgMemc->set($key, $data, 3600);
	}

	if (empty($data)) return wfMsgForContent("widget-categorycloud-empty");

	foreach ($data as $name => $value) {
		$category = Title::newFromText($name, NS_CATEGORY);
		if (is_object($category)) {
			$class = "cloud" . $value;
			$output .= Xml::openElement("li", array("class" => $class));
			// FIXME fix Wikia:link and use it here
			$output .= Xml::element("a", array("class" => $class, "href" => $category->getLocalURL(), "title" => $category->getFullText()), $category->getBaseText());
			$output .= Xml::closeElement("li");
			$output .= "\n";
		}
	}

	if (empty($output)) return wfMsgForContent("widget-categorycloud-empty");

	$output = Xml::openElement("ul") . $output . Xml::closeElement("ul");

	wfProfileOut(__METHOD__);
	return $output;
}

function WidgetCategoryCloudGetData() {
	$data = array();

	wfProfileIn( __METHOD__ );

	$dbr = wfGetDB( DB_SLAVE );
	$res = $dbr->select(
		"category",
		array("cat_title", "cat_pages", "cat_files"),
		array("(cat_pages > 0 OR cat_files > 0)", "cat_hidden" => 0), /* FIXME cat_hidden is never updated, fill in with pp_properties!=hiddencat (populateCategories.php?) */
		__METHOD__,
		array("ORDER BY" => "cat_title")
	);
	while ($row = $res->fetchObject()) {
		if (WidgetCategoryCloudSkipRow($row->cat_title)) continue;

		$data[$row->cat_title] = $row->cat_pages + $row->cat_files;
	}

	wfProfileOut(__METHOD__);
	return $data;
}

function WidgetCategoryCloudSkipRow($name) {
	/* TODO remove when cat_hidden is fixed */
	if (in_array($name, WidgetCategoryCloudGetHiddenCategories())) return true;

	global $wgBiggestCategoriesBlacklist;
	if (in_array($name, $wgBiggestCategoriesBlacklist)) return true;

	/* FIXME don't read each time, cache in static var (or class method...) */
	if (in_array($name, WidgetCategoryCloudMsgToArray("widget-categorycloud-blacklist-global"))) return true;
	if (in_array($name, WidgetCategoryCloudMsgToArray("widget-categorycloud-blacklist"))) return true;

	return false;
}

/* TODO remove when cat_hidden is fixed */
function WidgetCategoryCloudGetHiddenCategories() {
	$data = array();

	wfProfileIn( __METHOD__ );

	global $wgMemc;
	$key = wfMemcKey("WidgetCategoryCloud", "hidcats");
	$data = $wgMemc->get($key);
	if (is_null($data)) {
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			array("page", "page_props"),
			array("page_title"),
			array("page_id = pp_page", "page_namespace" => NS_CATEGORY, "pp_propname" => "hiddencat"),
			__METHOD__
		);
		while ($row = $res->fetchObject()) {
			$data[] = $row->page_title;
		}
		$wgMemc->set($key, $data, 300);
	}

	wfProfileOut(__METHOD__);
	return $data;
}

// FIXME move to global functions
function WidgetCategoryCloudMsgToArray($key) {
	$data = array();

	$msg = wfMsg($key);
	if (!wfEmptyMsg($msg, $key)) {
		$data = preg_split("/[*\s,]+/", $msg, null, PREG_SPLIT_NO_EMPTY); 
	}

	return $data;
}

function WidgetCategoryCloudCloudizeData($data) {
	$N = 10; // how many levels are needed

	$min    = min(array_values($data));
	$spread = max(array_values($data)) - $min;
	if ($spread == 0) $spread = 1;
	$s = $spread/($N - 1);

	$data2 = array();
	foreach ($data as $name => $value) {
		$data2[$name] = round(($value - $min) / $s);
	}

	return $data2;
}
