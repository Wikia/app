<section class="partners">
	<h1 class="partners-title"><?= wfMessage( 'videohomepage-partner-section-title' )->plain() ?></h1>
	<ul class="small-block-grid-6">
		<? foreach( $partners as $partnerKey=>$partner ) { ?>
		<li>
			<a class="ico-<?= $partnerKey ?>" href="<?= $partner[ 'url' ] ?>"></a>
			<a class="partner-link" href="<?= $partner['url'] ?>"><?= wfMessage( 'videohomepage-partner-name-' . $partnerKey )->plain() ?></a>
		</li>
		<? } ?>
	</ul>
</section>
