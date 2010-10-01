<form id="WikiaSearch" class="WikiaSearch" action="index.php?title=Special:Search" method="get">
	<input type="text" name="search" placeholder="<?= $placeholder ?>" autocomplete="off" accesskey="f">
	<input type="hidden" name="fulltext" value="<?= $fulltext ?>">
	<input type="submit">
	<button class="secondary"><img src="<?= $wgBlankImgUrl ?>" height="17" width="21"></button>
</form>
<?php
if ($wgTitle->isSpecial('Search')) {
	echo Xml::element('h1', array(), wfMsg('oasis-search-results-from', $wgSitename));
}
?>