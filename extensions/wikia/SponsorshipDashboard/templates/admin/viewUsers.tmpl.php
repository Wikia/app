<!-- s:<?= __FILE__ ?> -->
<!-- MAIN-PAGE -->

<? if( !empty( $errorMsg ) ){ ?><div class="sponsorship-dashboard-error-msg"><?=$errorMsg;?></div><? };?>

<table id="SDTable" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<td class="short" style="width:100px;" >
				<a href="<?=$path; ?>/<?=SponsorshipDashboard::ADMIN; ?>/EditUser/" class="wikia-button sd-addNewGroup" data-id="sd-addNewUser"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite new"><?=wfMsg('sponsorship-dashboard-user-new'); ?></a>
			</td>
			<td class="short" >
				<?=wfMsg('sponsorship-dashboard-users-user-id'); ?>
			</td>
			<td>
				<?=wfMsg('sponsorship-dashboard-user-name'); ?>
			</td>
			<td class="desc">
				<?=wfMsg('sponsorship-dashboard-description'); ?>
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
				<a data-id="<?=$row['id']; ?>" data-type="user" href="#" class="delete wikia-button secondary"><img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" class="sprite trash"></a>
				| <a href="<?=$path; ?>/<?=SponsorshipDashboard::ADMIN; ?>/EditUser/<?=$row['id']; ?>" class="edit wikia-button secondary"><img class="sprite edit-pencil" src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>">Edit</a>
			</td>
			<td class="short">
				<?=$row[ SponsorshipDashboardUser::USER_ID ]; ?>
			</td>
			<td class="name">
				<p>
					<?=$row[ SponsorshipDashboardUser::NAME ]; ?>
				</p>
			</td>
			<td class="desc">
				<?=$row[ SponsorshipDashboardUser::DESCRIPTION ]; ?>
			</td>
		</tr>
		<? } ?>
	</tbody>
</table>

<!-- END OF MAIN-PAGE -->
<!-- e:<?= __FILE__ ?> -->
