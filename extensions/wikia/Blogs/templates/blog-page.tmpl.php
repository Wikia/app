<!-- s:<?= __FILE__ ?> -->
<?
#---
$loop = 0;
$cities_list = "";
if (!empty($aRows)) {
	foreach ($aRows as $pageId => $aRow) {
		$title = Title::newFromText($aRow['title'], $aRow['namespace']);
?>
		<a href="<?=$title->getLocalUrl()?>"><?=$title->getText()?></a>
<?
	}
}
?>
<?=$cities_list?>
<!-- e:<?= __FILE__ ?> -->
