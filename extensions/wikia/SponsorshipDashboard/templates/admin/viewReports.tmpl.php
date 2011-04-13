<!-- s:<?= __FILE__ ?> -->
<!-- MAIN-PAGE -->

<table id="SDTable" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<td class="short">
				<a href="<?=$path; ?>/<?=SponsorshipDashboard::ADMIN; ?>/EditReport/" class="wikia-button sd-addNewGroup" data-id="sd-addNewGroup"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite new"> <?=wfMsg('sponsorship-dashboard-report-new');?></a>
			</td>
			<td>
				<?=wfMsg('sponsorship-dashboard-report-name');?>
			</td>
			<td>
				<?=wfMsg('sponsorship-dashboard-report-description');?>
			</td>
		</tr>
	</thead>
	<tbody>
		<? $keys = array_keys( $data );
		$keys = array_reverse( $keys );
		foreach( $keys as $key ) {
			$row = $data[$key];?>

		<tr>
			<td class="short">
				<a data-id="<?=$row['id']; ?>" data-type="report" href="#" class="edit wikia-button secondary delete"><img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" class="sprite trash"></a>
				| <a href="<?=$path; ?>/<?=SponsorshipDashboard::ADMIN; ?>/EditReport/<?=$row['id']; ?>" class="edit wikia-button secondary"><img class="sprite edit-pencil" src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>"><?=wfMsg('sponsorship-dashboard-Edit');?></a>
			</td>
			<td class="name">
				<a  href="<?=$path; ?>/<?=SponsorshipDashboard::ADMIN; ?>/ViewReport/<?=$row['id']; ?>" class="wikia-button sd-preview secondary" data-id="sd-preview" style="float:left; margin: 0 5px"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite details"> </a>
				<p>
					<?=$row['name']; ?> [<?=$row['id']; ?>]
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
