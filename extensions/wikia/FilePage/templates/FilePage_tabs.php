<ul class="tabs">
	<? if($showmeta): ?>
		<li data-tab="metadata">
			<a><?= wfMessage('file-page-tab-metadata') ?></a>
		</li>
	<? endif; ?>
	<li data-tab="history">
		<a><?= wfMessage('file-page-tab-history') ?></a>
	</li>
	<li data-tab="about" class="selected">
		<a><?= wfMessage('file-page-tab-about') ?></a>
	</li>
</ul>