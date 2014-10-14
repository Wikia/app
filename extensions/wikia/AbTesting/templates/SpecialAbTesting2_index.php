<? $app = F::app(); ?>
<div id="AbTestEditor">
	<table class="WikiaTable">
		<thead>
		<tr>
			<th class="arrow-nav"></th>
			<th><?= wfMsg( 'abtesting-heading-id' ) ?></th>
			<th><?= wfMsg( 'abtesting-heading-name' ) ?></th>
			<th colspan="2"><?= wfMsg( 'abtesting-heading-status' ) ?></th>
		</tr>
		</thead>
		<tbody>
		<? foreach( $experiments as $experiment ): ?>
			<?= $app->renderPartial( 'SpecialAbTesting2', 'experiment', array( 'experiment' => $experiment ) ) ?>
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
</div>
<div id="AbTestDetails">

</div>