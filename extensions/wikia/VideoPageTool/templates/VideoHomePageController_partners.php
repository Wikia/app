<section class="partners">
	<h2 class="partners-title"><?= wfMessage( 'videohomepage-partner-section-title' )->plain() ?></h2>
	<ul class="small-block-grid-6">
		<? foreach( $partners as $partnerKey=>$partner ) { ?>
		<li>
			<a class="ico-<?= $partnerKey ?>" href="<?= $partner[ 'url' ] ?>"></a>
			<a class="partner-link" href="<?= $partner['url'] ?>"><?= wfMessage( 'videohomepage-partner-name-' . $partnerKey )->plain() ?></a>
		</li>
		<? } ?>
	</ul>
</section>
