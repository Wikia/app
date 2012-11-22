<ul>
<?php foreach ( $list as $obj ) { ?>
	<li>
		<a href="<?=SDElement::createSpecialPageUrl($obj)?>">
		<?=$obj['name']?>
		</a>
	</li>
<? } ?>
</ul>
<a href="<?=$specialPageUrl;?>/<?=$objectType;?>/?action=create" class="wikia-button" title="Create new SDS
Object">Create new object</a>
