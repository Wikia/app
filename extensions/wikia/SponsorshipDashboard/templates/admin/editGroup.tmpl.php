<!-- s:<?= __FILE__ ?> -->
<!-- MAIN-PAGE -->

<form class="sd-form sd-form-main" method="POST" action="<?=$groupEditorPath; ?>">
	<h2> <?=wfMsg('sponsorship-dashboard-Group'); ?> </h2>
	<span>
		<a class="wikia-button sd-cancel" data-id="sd-cancel" style="float:right" href="<?=$groupEditorPath; ?>"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite close"> <?=wfMsg('sponsorship-dashboard-cancel');?></a>
		<input class="wikia-button sd-save" style="float:right; margin-right:5px" id="wpSave" name="wpSave" type="submit" tabindex="3" value="<?=wfMsg('sponsorship-dashboard-save');?>">
	<div> 
		<input id="mainId" name="<?=SponsorshipDashboardGroup::ID; ?>" type="hidden" class="sd-fixedleft sd-long" value="<?=$groupParams['id'];?>">
		<input name="action" type="hidden" class="sd-fixedleft sd-long" value="save">
	</div>
	<div>
		<?=wfMsg('sponsorship-dashboard-report-title'); ?>
		<input name="<?=SponsorshipDashboardGroup::NAME; ?>" type="text" class="sd-fixedleft sd-long" value="<?=$groupParams['name'];?>">
	</div>
	<div class="sd-higher"> 
		<?=wfMsg('sponsorship-dashboard-report-description'); ?> <textarea name="<?=SponsorshipDashboardGroup::DESCRIPTION; ?>"><?=$groupParams['description'];?></textarea>
	</div>
	<h3><?=wfMsg('sponsorship-dashboard-editor-Reports'); ?></h3>
	<span id="groupReportsDisplay" >
		<?
			$sReports = '';
			if ( !empty( $groupParams[ SponsorshipDashboardGroup::REPORTS ] ) ){
				foreach( $groupParams[ SponsorshipDashboardGroup::REPORTS ] as $report ){
					$sReports .= ','.$report->id.'|';
				}
			}
		?>
		<input type="hidden" id="groupReportsInput" name="<?=SponsorshipDashboardGroup::REPORTS; ?>" class="" value="<?=$sReports;?>" />
		<ul id="groupReports" class="simpleList"></ul>
	</span>
	<div>
		<select id="groupReportList">
			<option value="0"> --- </option>
			<? foreach( $reports as $report ){ ?>
			<option value="<?=$report['id']; ?>"><?=$report['name']; ?> [<?=$report['id']; ?>]</option>
			<? } ?>
		</select>
	</div>
	<h3><?=wfMsg('sponsorship-dashboard-editor-Users'); ?></h3>
	<span id="groupUsersDisplay" >
		<?
			$sUsers = '';
			if ( !empty( $groupParams[ SponsorshipDashboardGroup::USERS ] ) ){
				foreach( $groupParams[ SponsorshipDashboardGroup::USERS ] as $user ){
					$sUsers .= ','.$user->id.'|';
				}
			}
		?>
		<input type="hidden" id="groupUsersInput" name="<?=SponsorshipDashboardGroup::USERS; ?>" class="" value="<?=$sUsers;?>" />
		<ul id="groupUsers" class="simpleList"></ul>
	</span>
	<div>
		<select id="groupUserList">
			<option value="0"> --- </option>
			<? foreach( $users as $user ){ ?>
			<option value="<?=$user['id']; ?>"><?=$user['name']; ?> [<?=$user['id']; ?>]</option>
			<? } ?>
		</select>
	</div>
	<div>
		<a class="wikia-button sd-cancel" data-id="sd-cancel" style="float:right" href="<?=$groupEditorPath; ?>"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite close"> <?=wfMsg('sponsorship-dashboard-cancel');?></a>
		<input class="wikia-button sd-save" style="float:right; margin-right:5px" id="wpSave" name="wpSave" type="submit" tabindex="3" value="<?=wfMsg('sponsorship-dashboard-save');?>">
	</div>
</form>

<!-- END OF MAIN-PAGE -->
<!-- e:<?= __FILE__ ?> -->
