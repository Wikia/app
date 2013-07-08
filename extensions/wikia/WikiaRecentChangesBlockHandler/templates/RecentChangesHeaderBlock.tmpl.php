<table class="mw-collapsible mw-collapsed mw-enhanced-rc <?= Sanitizer::escapeClass( 'mw-changeslist-ns' . $title->getNamespace() . '-' . $title->getText() ) ?>">
	<tr>
		<td>
			<span class="mw-collapsible-toggle">
				<span class="mw-rc-openarrow">
					<a title="<?= htmlspecialchars( wfMsg( 'rc-enhanced-expand' ) )?>" href="#">
						<img width="12" height="12" title="<?=htmlspecialchars( wfMsg( 'rc-enhanced-expand' ) )?>" alt="+" src="<?= $wgStylePath ?>/common/images/Arr_r.png">
					</a>
				</span>
				<span class="mw-rc-closearrow">
					<a title="<?= htmlspecialchars( wfMsg( 'rc-enhanced-hide' ) )?>" href="#">
						<img width="12" height="12" title="<?=htmlspecialchars( wfMsg( 'rc-enhanced-hide' ) )?>" alt="-" src="<?= $wgStylePath ?>/common/images/Arr_d.png">
					</a>
				</span>
			</span>
		</td>
		<td class="mw-enhanced-rc">&#160;&#160;&#160;&#160;&#160;<?= $timestamp ?>&#160;</td>
		<td><?= $hdrtitle ?>&nbsp;(<?= $cntChanges ?>) . . [<?= implode("; ", $users) ?>]</td>
	</tr>
	<?php //the table will be closed by MediaWiki code which could be found in ChangeList.php ?>