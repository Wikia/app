<table class="wikitable phalanx-stats-table">
	<thead>
		<tr>
			<th><?= wfMessage( 'phalanx-stats-table-id' )->escaped(); ?></th>
			<th><?= wfMessage( 'phalanx-stats-table-user' )->escaped(); ?></th>
			<th><?= wfMessage( 'phalanx-stats-table-type' )->escaped(); ?></th>
			<th><?= wfMessage( 'phalanx-stats-table-create' )->escaped(); ?></th>
			<th><?= wfMessage( 'phalanx-stats-table-expire' )->escaped(); ?></th>
			<th><?= wfMessage( 'phalanx-stats-table-exact' )->escaped(); ?></th>
			<th><?= wfMessage( 'phalanx-stats-table-regex' )->escaped(); ?></th>
			<th><?= wfMessage( 'phalanx-stats-table-case' )->escaped(); ?></th>
			<th><?= wfMessage( 'phalanx-stats-table-language')->escaped(); ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
		<?php foreach ( $firstRow as $entry ): ?>
			<td><?= htmlspecialchars( $entry ); ?></td>
		<?php endforeach; ?>
		</tr>
		<tr>
			<th><?= wfMessage( 'phalanx-stats-table-text' )->escaped(); ?></th>
			<td colspan="8"><?= htmlspecialchars( $text ); ?></td>
		</tr>
		<tr>
			<th><?= wfMessage( 'phalanx-stats-table-reason' )->escaped(); ?></th>
			<td colspan="8"><?= $reason ?></td>
		</tr>
		<tr>
			<th><?= wfMessage( 'phalanx-stats-table-comment' )->escaped(); ?></th>
			<td colspan="8"><?= $comment ?></td>
		</tr>
	</tbody>
</table>
<a href="<?= Sanitizer::encodeAttribute( $editUrl ); ?>" class="modify"><?= wfMessage( 'phalanx-link-modify' )->escaped(); ?></a> &#183;
<a href="#" class="unblock" data-id="<?= Sanitizer::encodeAttribute( $blockId ); ?>"><?= $wg->Lang->lcfirst( wfMessage( 'phalanx-link-unblock' )->escaped() ); ?></a>

<fieldset>
	<legend><?= wfMessage( 'phalanx-stats-results' )->escaped(); ?></legend>
<?= $statsPager ?>
</fieldset>
