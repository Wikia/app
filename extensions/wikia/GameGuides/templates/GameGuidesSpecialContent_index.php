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

				echo "<li class=tag><input value='{$tag['title']}'/></li>";

				foreach( $tag['categories'] as $category ): ?>
			<li class=category><input value="<?= $category['title']; ?>"/><input class=name value="<?= isset( $category['label'] ) ? $category['label'] : ''; ?>"/></li>
				<? endforeach;
			endforeach;
		else: ?>
		<? endif; ?>
		</ul>
    <button class=secondary id=addTag><?= $wf->Msg('wikiagameguides-content-add-tag');?></button>
    <button class=secondary id=addCategory><?= $wf->Msg('wikiagameguides-content-add-category');?></button>
	<button id=save disabled><?= $wf->Msg('wikiagameguides-content-save');?></button>
	<span id=status>&#10003;</span>
</div>
