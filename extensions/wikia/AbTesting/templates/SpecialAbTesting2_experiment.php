<?
/** @var $abTesting AbTesting */
$active = $experiment[ 'status' ] == AbTesting::STATUS_ACTIVE;
$has_next = $active ? $experiment[ 'next_deactivate' ] !== null : $experiment[ 'next_activate' ] !== null;
$classList = array('exp');
if ($active) {
	$status = wfMessage('abtesting-status-active')->text();
	$timeAgo = $experiment[ 'next_deactivate' ] ? wfTimestamp(TS_ISO_8601, $experiment[ 'next_deactivate' ] ) : '';
	$timeString = $experiment[ 'next_deactivate' ] ? $wg->Lang->timeanddate($experiment[ 'next_deactivate' ] ) : '';
	$classList[] = 'status-active';
} else {
	$status = $experiment[ 'next_activate' ] ? wfMessage('abtesting-status-planned')->text() : wfMessage('abtesting-status-inactive')->text();
	$timeAgo = $experiment[ 'next_activate' ] ? wfTimestamp(TS_ISO_8601, $experiment[ 'next_activate' ] ) : '';
	$timeString = $experiment[ 'next_activate' ] ? $wg->Lang->timeanddate($experiment[ 'next_activate' ] ) : '';
	$classList[] = 'status-inactive';
}
$class = implode(' ', $classList);
?>
<tr class="<?= $class ?>" data-row="0" data-id="<?= $experiment[ 'id' ] ?>">
	<td class="arrow-nav"><img class="arrow" src="<?= $wg->BlankImgUrl ?>" /></td>
	<td><?= $experiment[ 'id' ] ?></td>
	<td><?= htmlspecialchars( $experiment[ 'name' ] ) ?></td>
	<td class="column-status"><?= $status ?></td>
	<td>
		<? if ($active && $has_next): ?>
			Ends <span class="timeago" title="<?= $timeAgo ?>"><?= $timeString ?> </span>
		<? elseif (!$active && $has_next): ?>
			Starts <span class="timeago" title="<?= $timeAgo ?>"><?= $timeString ?> </span>
		<? endif; ?>
	</td>
	<td style="display:none" class="details">
		<div class="title">
			<?= htmlspecialchars( AbTesting::normalizeName($experiment[ 'name' ] ) ) ?>
		</div>
		<div class="content">
			<table>
				<tr>
					<th><?= wfMsg( 'abtesting-heading-id' ) ?></th>
					<td><?= $experiment[ 'id' ] ?></td>
				</tr>
				<tr>
					<th><?= wfMsg( 'abtesting-heading-description' ) ?></th>
					<td><?= htmlspecialchars( $experiment[ 'description' ] ) ?></td>
				</tr>
				<tr>
					<th><?= wfMsg( 'abtesting-heading-groups' ) ?></th>
					<td>
						<? foreach($experiment[ 'groups' ] as $g ): ?>
							<?= $g['id'] ?> &rarr; <?= AbTesting::normalizeName($g['name']) ?><br />
						<? endforeach; ?>
					</td>
				</tr>
				<tr>
					<th><?= wfMsg( 'abtesting-heading-schedule' ) ?></th>
					<td>
						<? foreach($experiment[ 'versions' ] as $v ): ?>
							<?= substr($v['start_time'],0,10) ?> <span class="subtle"><?= substr($v['start_time'],11) ?></span>
							&mdash;
							<?= substr($v['end_time'],0,10) ?> <span class="subtle"><?= substr($v['end_time'],11) ?></span>
						<? endforeach; ?>
					</td>
				</tr>
			</table>
		</div>
		<div class="actions">
			<? foreach( $experiment[ 'actions' ] as $action ): ?>
				<button data-command="<?= $action[ 'cmd' ] ?>" class="<?= $action[ 'class' ] ?>">
					<?= $action[ 'text' ] ?>
					<? if (!empty($action['spriteclass'])): ?>
						<span class="<?= $action[ 'spriteclass' ] ?>">&nbsp;</span>
					<? endif; ?>
				</button>
			<? endforeach ?>
		</div>
	</td>

</tr>
