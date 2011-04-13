<!-- s:<?= __FILE__ ?> -->
<!-- MAIN-PAGE -->

<table id="SDTable" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<td>
				<a href="<?=$path; ?>/<?=SponsorshipDashboard::ADMIN; ?>/EditGroup/" class="wikia-button sd-addNewGroup" data-id="sd-addNewGroup"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite new"><?=wfMsg('sponsorship-dashboard-group-new'); ?></a>
			</td>
			<td class="name">
				<?=wfMsg('sponsorship-dashboard-group-name'); ?>
			</td>
			<td class="desc">
				<?=wfMsg('sponsorship-dashboard-description'); ?>
			</td>
		</tr>
	</thead>
	<tbody>
		<? 
		$keys = array_keys( $data );
		$keys = array_reverse( $keys );
		foreach( $keys as $key ) { 
			$row = $data[$key];?>

		
		<tr>
			<td>
				<a data-id="<?=$row['id']; ?>" data-type="group" href="#" class="delete wikia-button secondary"><img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" class="sprite trash"></a>
				| <a href="<?=$path; ?>/<?=SponsorshipDashboard::ADMIN; ?>/EditGroup/<?=$row['id']; ?>" class="edit wikia-button secondary"><img class="sprite edit-pencil" src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>"><?=wfMsg('sponsorship-dashboard-Edit'); ?></a>
			</td>
			<td class="name">
				<p>
					<?=$row['name']; ?>
				</p>
			</td>
			<td class="desc">
				<?=$row['description']; ?>
			</td>
		</tr>
		<? } ?>
	</tbody>
</table>

<!-- END OF MAIN-PAGE -->
<!-- e:<?= __FILE__ ?> -->
