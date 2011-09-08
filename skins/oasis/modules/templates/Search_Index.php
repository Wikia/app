<form id="WikiaSearch" class="WikiaSearch" action="index.php?title=Special:Search" method="get">
	<input type="text" name="search" placeholder="<?= $placeholder ?>" autocomplete="off" accesskey="f" value="<?= $searchterm ?>">
	<input type="hidden" name="fulltext" value="<?= $fulltext ?>">
	<input type="submit">
	<button class="secondary"><img src="<?= $wgBlankImgUrl ?>" class="sprite search" height="17" width="21"></button>
	<?php if( $crossWikiaSearchOptionEnabled ) { ?>
		<div><input type="checkbox" value="1" name="crossWikiaSearch" <?= $isCrossWikiaSearch ? 'checked' : ''; ?> /><?= wfMsg('wikiasearch-search-all-wikia'); ?></div>
	<?php } ?>
</form>
<?php
if ($wgTitle->isSpecial('Search')) {
	if( $isCrossWikiaSearch ) {
		echo Xml::element('h1', array(), wfMsg('oasis-search-results-from-all-wikis'));
	}
	else {
		echo Xml::element('h1', array(), wfMsg('oasis-search-results-from', $wgSitename));
	}
}
?>