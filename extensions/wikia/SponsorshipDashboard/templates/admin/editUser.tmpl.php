<!-- s:<?= __FILE__ ?> -->
<!-- MAIN-PAGE -->

<form class="sd-form sd-form-main" method="POST" action="<?=$userEditorPath; ?>">
	<h2><?=wfMsg('sponsorship-dashboard-Group');?></h2>
	<span>
		<a class="wikia-button sd-cancel" data-id="sd-cancel" style="float:right" href="<?=$userEditorPath; ?>"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite close"> <?=wfMsg('sponsorship-dashboard-cancel');?></a>
		<input class="wikia-button sd-save" style="float:right; margin-right:5px" id="wpSave" name="wpSave" type="submit" tabindex="3" value="<?=wfMsg('sponsorship-dashboard-save');?>">
	<div>
		<input id="mainId" name="<?=SponsorshipDashboardUser::ID; ?>" type="hidden" class="sd-fixedleft sd-long" value="<?=$userParams[ SponsorshipDashboardUser::ID ];?>">
		<input name="action" type="hidden" class="sd-fixedleft sd-long" value="save">
	</div>
	<div>
		<?=wfMsg('sponsorship-dashboard-users-name'); ?>
		<input name="<?=SponsorshipDashboardUser::NAME; ?>" type="text" class="sd-fixedleft sd-long" value="<?=$userParams[ SponsorshipDashboardUser::NAME ];?>">
	</div>
	<div>
		<?=wfMsg('sponsorship-dashboard-users-status'); ?>
		<input name="<?=SponsorshipDashboardUser::STATUS; ?>" <? if ( !empty( $userParams[ SponsorshipDashboardUser::STATUS ] ) ) echo 'checked="OK"'; ?> type="checkbox" class="sd-fixedleft sd-sshort" >
	</div>
	<div>
		<?=wfMsg('sponsorship-dashboard-users-type'); ?>
		<select name="<?=SponsorshipDashboardUser::TYPE; ?>" >
			<? foreach( $allowedTypes as $type ){
				?><option value="<?=$type; ?>"><?=wfMsg( 'sponsorship-dashboard-user-type-'.$type );?></option><?
			} ?>
		</select>
	</div>
	<div class="sd-higher">
		<?=wfMsg('sponsorship-dashboard-description'); ?><textarea name="<?=SponsorshipDashboardUser::DESCRIPTION; ?>"><?=$userParams[ SponsorshipDashboardUser::DESCRIPTION ];?></textarea>
	</div>
	<h3><?=wfMsg('sponsorship-dashboard-editor-Groups'); ?></h3>
	<ul id="userReports" class="simpleList">
		<?
			$sGroups = '';
			if ( !empty( $groups ) ){
				foreach( $groups as $group ){
					echo "<li> - {$group->name}</li>";
				}
			}
		?>
	</ul>
	
	<h3><?=wfMsg('sponsorship-dashboard-editor-Reports'); ?></h3>
	<ul id="userReports" class="simpleList">
		<?
			$sReports = '';
			if ( !empty( $reports ) ){
				foreach( $reports as $report ){
					echo "<li> - {$report->name}</li>";
				}
			}
		?>
	</ul>

	<div>
		<a class="wikia-button sd-cancel" data-id="sd-cancel" style="float:right" href="<?=$userEditorPath; ?>"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite close"> <?=wfMsg('sponsorship-dashboard-cancel');?></a>
		<input class="wikia-button sd-save" style="float:right; margin-right:5px" id="wpSave" name="wpSave" type="submit" tabindex="3" value="<?=wfMsg('sponsorship-dashboard-save');?>">
	</div>
</form>

<!-- END OF MAIN-PAGE -->
<!-- e:<?= __FILE__ ?> -->
