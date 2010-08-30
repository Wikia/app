<form id="WikiaSearch" class="WikiaSearch" action="index.php?title=Special:Search" method="get">
	<input type="search" name="search" placeholder="<?= $placeholder ?>" autocomplete="off" accesskey="f">
	<input type="hidden" name="fulltext" value="<?= $fulltext ?>">
	<input type="submit">
	<button class="wikia-chiclet-button"><img src="<?= $wgBlankImgUrl ?>"></button>
</form>
<?php
if ($wgTitle->isSpecial('Search')) {
	echo Xml::element('h1', array(), wfMsg('oasis-search-results-from', $wgSitename));
}
?>