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

	if (empty($data)) {
		wfProfileOut( __METHOD__ );
		return wfMsgForContent("widget-categorycloud-empty");
	}

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

	if (empty($output)) {
		wfProfileOut( __METHOD__ );
		return wfMsgForContent("widget-categorycloud-empty");
	}

	$output = Xml::openElement("ul") . $output . Xml::closeElement("ul");

	wfProfileOut(__METHOD__);
	return $output;
}

/* old version, not used anymore */
function REMOVE_WidgetCategoryCloudGetData() {
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

function WidgetCategoryCloudGetData() {
	$LIMIT = 40; // rt#56586

	$data = array();

	wfProfileIn( __METHOD__ );

	$class = new MostpopularcategoriesSpecialPage();
	$class->setList( false );
	foreach ($class->getResult() as $name => $value) {
		if (WidgetCategoryCloudSkipRow($name)) continue;

		$data[$name] = $value;
	}

	$data = array_slice($data, 0, $LIMIT, true);
	ksort($data);

	wfProfileOut(__METHOD__);
	return $data;
}

function WidgetCategoryCloudSkipRow($name) {
	/* TODO remove when cat_hidden is fixed */
	if (in_array($name, Wikia::categoryCloudGetHiddenCategories())) return true;

	global $wgBiggestCategoriesBlacklist;
	if (in_array($name, $wgBiggestCategoriesBlacklist)) return true;

	/* FIXME don't read each time, cache in static var (or class method...) */
	if (in_array($name, Wikia::categoryCloudMsgToArray("widget-categorycloud-blacklist-global"))) return true;
	if (in_array($name, Wikia::categoryCloudMsgToArray("widget-categorycloud-blacklist"))) return true;

	return false;
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
