
<div>
	<input type="checkbox" id="show-past-experiments" name="show-past-experiments" checked />
	<label for="show-past-experiments"><?= wfMessage('abtesting-checkbox-show-past-experiments')->plain(); ?></label>
</div>
<? if ( strlen( $gaSlots ) ): ?>
	<div class="running">
		<?= wfMessage('abtesting-currently-used-ga-slots', $gaSlots)->plain(); ?>
	</div>
<? endif ?>
<? if ( strlen( $futureGaSlots ) ): ?>
	<div class="scheduled">
		<?= wfMessage('abtesting-future-used-ga-slots', $futureGaSlots)->plain(); ?>
	</div>
<? endif ?>
<table class="WikiaTable AbTestEditor" id="AbTestEditor">
	<thead>
		<tr>
			<th class="arrow-nav"></th>
			<th><?= wfMessage( 'abtesting-heading-id' )->plain() ?></th>
			<th><?= wfMessage( 'abtesting-heading-name' )->plain() ?></th>
			<th><?= wfMessage( 'abtesting-heading-description' )->plain() ?></th>
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
