<ul>
	<caption><?=wfMsg('structureddata-listing-objects-caption', $objectType)?></caption>
<?php foreach ( $list as $obj ) { ?>
	<li>
		<a href="<?=SDElement::createSpecialPageUrl($obj)?>">
		<?=$obj['name']?>
		</a>
	</li>
<? } ?>
</ul>
<a href="<?=$specialPageUrl;?>/<?=$objectType;?>/?action=create" class="wikia-button" title="<?= wfMsg('structureddata-create-new-object-button') ?>"><?= wfMsg('structureddata-create-new-object-button') ?></a>
<a href="<?=$specialPageUrl;?>" class="wikia-button" title="<?= wfMsg('structureddata-back-to-list-of-classes') ?>"><?= wfMsg('structureddata-back-to-list-of-classes') ?></a>
