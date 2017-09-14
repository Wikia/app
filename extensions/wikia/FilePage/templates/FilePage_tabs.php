<ul class="tabs">
	<li data-tab="about" class="selected">
		<a><?= wfMessage( 'file-page-tab-about' )->escaped(); ?></a>
	</li>
	<li data-tab="history">
		<a><?= wfMessage( 'file-page-tab-history' )->escaped(); ?></a>
	</li>
	<? if($showmeta): ?>
		<li data-tab="metadata">
			<a><?= wfMessage( 'file-page-tab-metadata' )->escaped(); ?></a>
		</li>
	<? endif; ?>
</ul>
