<?
	if ( $staff ) echo $app->getView( 'GameGuidesSpecialContent', 'switch', array(
		'enabled' => $enabled
	));
?>
<div id=contentManagmentForm>
	<div class=header>
		<div>
			<?= $wf->Msg('wikiagameguides-content-category');?>
			<div><?= $wf->Msg('wikiagameguides-content-category-desc');?></div>
		</div>
		<div>
			<?= $wf->Msg('wikiagameguides-content-tag');?>
			<div><?= $wf->Msg('wikiagameguides-content-tag-desc');?></div>
		</div>
		<div>
			<?= $wf->Msg('wikiagameguides-content-name');?>
			<div><?= $wf->Msg('wikiagameguides-content-name-desc');?></div>
		</div>
	</div>
	<ul>
		<?
		if ( is_array( $tags ) ):
			foreach( $tags as $tag ):
				foreach( $tag['categories'] as $category ): ?>
			<li><input class=category placeholder="<?= $wf->Msg('wikiagameguides-content-category');?>" value="<?= $category['category']; ?>"/><input class=tag placeholder="<?= $wf->Msg('wikiagameguides-content-tag');?>" value="<?= $tag['name']; ?>"/><input class=name placeholder="<?= $wf->Msg('wikiagameguides-content-name');?>" value="<?= $category['name']; ?>"/><button class="remove secondary">X</button></li>
				<? endforeach;
			endforeach;
		else: ?>
			<li><input class=category placeholder="<?= $wf->Msg('wikiagameguides-content-category');?>" /><input class=tag placeholder="<?= $wf->Msg('wikiagameguides-content-tag');?>" /><input class=name placeholder="<?= $wf->Msg('wikiagameguides-content-name');?>" /><button class="remove secondary">X</button></li>
		<? endif; ?>
		</ul>
    <button class=secondary id=addCategory><?= $wf->Msg('wikiagameguides-content-add');?></button>
	<button id=save disabled><?= $wf->Msg('wikiagameguides-content-save');?></button>
	<span id=status>&#10003;</span>
</div>
