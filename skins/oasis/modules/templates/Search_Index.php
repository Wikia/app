<?php $searchterm = isset($searchterm) ? $searchterm : ''; ?>
<?php $searchFormId = isset($searchFormId) ? $searchFormId : 'WikiaSearch'; ?>

<form id="<?= $searchFormId; ?>" class="WikiaSearch<?= empty($noautocomplete) ? '' : ' noautocomplete' ?>" action="<?= $specialSearchUrl; ?>" method="get">
	<input type="text" name="search" placeholder="<?= $placeholder ?>" autocomplete="off" accesskey="f" value="<?= Sanitizer::encodeAttribute( $searchterm ); ?>">
	<input type="hidden" name="fulltext" value="<?= $fulltext ?>">
	<?php foreach( $searchParams as $name => $value ) : ?>
		<input type="hidden" name="<?= $name ?>" value="<?= $value ?>">
	<?php endforeach; ?>
	<input type="submit">
	<button class="wikia-button"><img src="<?= $wg->BlankImgUrl ?>" class="sprite search" height="17" width="21"></button>
</form>
<?php if ( ( !$wg->WikiaSearchIsDefault ) && $wg->Title->isSpecial( 'Search' ) ): ?>
	<?php if ( $isCrossWikiaSearch ): ?>
	<h1><?= wfMessage( 'oasis-search-results-from-all-wikis' )->escaped(); ?></h1>
	<?php else: ?>
	<h1><?= wfMessage( 'oasis-search-results-from', $wg->Sitename )->escaped(); ?></h1>
	<?php endif; ?>
<?php endif; ?>
