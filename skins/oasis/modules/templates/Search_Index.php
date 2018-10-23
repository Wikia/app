<?php $searchterm = isset($searchterm) ? $searchterm : ''; ?>
<?php $searchFormId = isset($searchFormId) ? $searchFormId : 'WikiaSearch'; ?>

<form id="<?= Sanitizer::encodeAttribute($searchFormId); ?>" class="WikiaSearch<?= empty($noautocomplete) ? '' : ' noautocomplete' ?>" action="<?= Sanitizer::encodeAttribute($specialSearchUrl); ?>" method="get">
	<input type="text" name="search" placeholder="<?= Sanitizer::encodeAttribute($placeholder); ?>" autocomplete="off" accesskey="f" value="<?= Sanitizer::encodeAttribute($searchterm) ?>">
	<input type="hidden" name="fulltext" value="<?= Sanitizer::encodeAttribute($fulltext); ?>">
	<?php foreach( $searchParams as $name => $value ) : ?>
		<input type="hidden" name="<?= Sanitizer::encodeAttribute($name); ?>" value="<?= Sanitizer::encodeAttribute($value); ?>">
	<?php endforeach; ?>
	<input type="submit">
	<button class="wikia-button"><img src="<?= Sanitizer::encodeAttribute($wg->BlankImgUrl); ?>" class="sprite search" height="17" width="21"></button>
</form>
<?php
if ((!$wg->WikiaSearchIsDefault) && $wg->Title->isSpecial('Search')) {
	if( $isCrossWikiaSearch ) {
		echo Xml::element('h1', array(), wfMsg('oasis-search-results-from-all-wikis'));
	}
	else {
		echo Xml::element('h1', array(), wfMsg('oasis-search-results-from', $wg->Sitename));
	}
} 
?>
