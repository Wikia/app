<div id=contentManagmentForm>
	<div class=header><span><?= $wf->Msg('wikiagameguides-content-category');?></span><span><?= $wf->Msg('wikiagameguides-content-tag');?></span><span><?= $wf->Msg('wikiagameguides-content-name');?></span></div>
	<ul>
		<?
		if ( is_array( $categories ) ):
			foreach( $categories as $categoryName => $data ): ?>
			<li><input class=category placeholder="<?= $wf->Msg('wikiagameguides-content-category');?>" value="<?=$categoryName; ?>"/><input class=tag placeholder="<?= $wf->Msg('wikiagameguides-content-tag');?>" value="<?= $data['tag']; ?>"/><input class=name placeholder="<?= $wf->Msg('wikiagameguides-content-name');?>" value="<?= $data['name']; ?>"/><button class="remove secondary">-</button></li>
			<? endforeach;
		else: ?>
			<li><input class=category placeholder="<?= $wf->Msg('wikiagameguides-content-category');?>" /><input class=tag placeholder="<?= $wf->Msg('wikiagameguides-content-tag');?>" /><input class=name placeholder="<?= $wf->Msg('wikiagameguides-content-name');?>" /><button class="remove secondary">-</button></li>
		<? endif; ?>
		</ul>
    <button class=secondary id=addCategory><?= $wf->Msg('wikiagameguides-content-add');?></button>
	<button id=save disabled><?= $wf->Msg('wikiagameguides-content-save');?></button>
	<span id=status>&#10003;</span>
</div>
