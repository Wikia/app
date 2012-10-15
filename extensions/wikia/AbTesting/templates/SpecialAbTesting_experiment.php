<tr class="exp<?= empty( $showDetails ) ? ' collapsed' : '' ?>" data-id="<?= $experiment[ 'id' ] ?>">
    <td class="arrow-nav"><img class="arrow" src="<?= $wg->BlankImgUrl ?>" /></td>
    <td><?= $experiment[ 'id' ] ?></td>
    <td><?= htmlspecialchars( $experiment[ 'name' ] ) ?></td>
    <td><?= htmlspecialchars( $experiment[ 'description' ] ) ?></td>
    <td class="actions">
		<? foreach( $experiment[ 'actions' ] as $action ): ?>
        	<button data-command="<?= $action[ 'cmd' ] ?>"><?= $action[ 'text' ] ?></button>
		<? endforeach ?>
    </td>
</tr>
<tr class="details" data-exp-id="<?= $experiment[ 'id' ] ?>">
    <td class="exp-details" colspan="5">
		<table class="versions WikiaTable">
			<thead>
		    	<th><?= wfMsg( 'abtesting-heading-start-time' ) ?></th>
		        <th><?= wfMsg( 'abtesting-heading-end-time' ) ?></th>
		        <th><?= wfMsg( 'abtesting-heading-ga-slot' ) ?></th>
				<? foreach( $experiment[ 'groups' ] as $grp ): ?>
		    		<th><?= $grp[ 'name' ] ?></th>
				<? endforeach ?>
			</thead>
			<tbody>
				<? foreach( $experiment[ 'versions' ] as $ver ): ?>
					<tr class="ver" data-id="<?= $ver[ 'id' ] ?>">
			            <td><?= htmlspecialchars( $ver[ 'start_time' ] ) ?></td>
			            <td><?= htmlspecialchars( $ver[ 'end_time' ] ) ?></td>
			            <td><?= htmlspecialchars( $ver[ 'ga_slot' ] ) ?></td>
						<? foreach( $experiment[ 'groups' ] as $grp ): ?>
							<? $grn = @$ver[ 'group_ranges' ][ $grp[ 'id' ] ] ?>
				            <td><?= htmlspecialchars( $grn[ 'ranges' ] ) ?></td>
						<? endforeach ?>
					</tr>
				<? endforeach ?>
				<? if ( 0 && !empty( $experiment[ 'actions_versions' ] ) ): ?>
					<tr>
						<td colspan="<?= 4 + count( $experiment[ 'groups' ] ) ?>">
							<? foreach( $experiment[ 'actions_versions' ] as $action ): ?>
			                	<a href="#" data-command="<?= $action[ 'cmd' ] ?>"><span class="<?= $action[ 'class' ] ?>"></span><?= $action[ 'text' ] ?></a>
							<? endforeach ?>
						</td>
					</tr>
				<? endif ?>
		    </tbody>
		</table>
	</td>
</tr>