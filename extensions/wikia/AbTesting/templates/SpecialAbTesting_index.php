<table class="WikiaTable AbTestEditor" id="AbTestEditor">
	<thead>
		<tr>
			<th class="arrow-nav"></th>
			<th><?= wfMsg( 'abtesting-heading-id' ) ?></th>
			<th><?= wfMsg( 'abtesting-heading-name' ) ?></th>
			<th><?= wfMsg( 'abtesting-heading-description' ) ?></th>
			<th class="actions"></th>
		</tr>
	</thead>
	<tbody>
		<? foreach( $experiments as $experiment ): ?>
			<?= F::app()->renderPartial( 'SpecialAbTesting', 'experiment', array( 'experiment' => $experiment ) ) ?>
		<? endforeach ?>
		<tr class="exp-add">
			<td colspan="5">
				<? foreach( $actions as $action ): ?>
					<button data-command="<?= $action[ 'cmd' ] ?>"><?= $action[ 'text' ] ?></button>
				<? endforeach ?>
			</td>
		</tr>
	</tbody>
</table>