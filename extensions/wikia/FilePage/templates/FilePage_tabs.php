<ul class="tabs">
	<li data-tab="about" class="selected">
		<a><?= wfMessage('file-page-tab-about') ?></a>
	</li>
	<li data-tab="history">
		<a><?= wfMessage('file-page-tab-history') ?></a>
	</li>
	<? if($showmeta): ?>
		<li data-tab="metadata">
			<a><?= wfMessage('file-page-tab-metadata') ?></a>
		</li>
	<? endif; ?>
</ul>
