<!-- TODO: remove this, only temp for styling before hook is done -->
<div class="veeseoRA2VWwikiaV1"></div>
<script src="http://rce.veeseo.com/code/wikia/veeseorcw.js" type="text/javascript"></script>

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
