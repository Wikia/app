<!-- s:<?= __FILE__ ?> -->
<!-- MAIN-PAGE -->

<table class="sponsorship-dashboard-table" cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<td class="sponsorship-dashboard-collumn-date"><?=wfMsg('sponsorship-dashboard-table-collumn-date');?></td>
			<? foreach( $labels as $key => $val ){ ?>
			<td>
				<?=$val ;?>
			</td>
			<? } ?>
		</tr>
	</thead>
	<tbody>
		<?
		$i = 0;
		foreach( $data as $dataKey => $row ){
			$i++;
		?><tr>
			<td class="sponsorship-dashboard-collumn-date"><?=$row['date']; ?></td>
		<? foreach( $labels as $key => $val ){ ?>
			<td>
				<?=( isset( $row[ $key ] ) ) ? round( $row[ $key ], 2 ) : 0 ;?>
			</td>
			<? } ?>
		</tr>
		<? } ?>
	</tbody>
</table>

<!-- END OF MAIN-PAGE -->
<!-- e:<?= __FILE__ ?> -->
