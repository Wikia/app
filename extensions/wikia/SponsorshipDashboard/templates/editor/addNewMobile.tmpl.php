<!-- s:<?= __FILE__ ?> -->
<!-- MAIN-PAGE -->

<form class="sd-form sd-sub-form">
	<input type="hidden" name="sourceType" value="<?=SponsorshipDashboardSourceMobile::SD_SOURCE_TYPE; ?>" />
	<a class="wikia-button sd-source-remove" style="float:right; margin-top:3px"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite close"> <?=wfMsg('sponsorship-dashboard-source-discard');?></a>
	<div class="sd-source-title"> <?=wfMsg('sponsorship-dashboard-source-datasource');?> <b>#1</b>: <?=wfMsg('sponsorship-dashboard-source-Mobile');?></div>
	<div style="font-weight:bold"> <?=wfMsg('sponsorship-dashboard-source-Actions');?> </div>
	<ul >
		<?
			foreach( SponsorshipDashboardSourceMobile::$allowedActions as $action ){

		?><li><label><input <? if( $action == $data[ SponsorshipDashboardSourceMobile::SD_ACTION ] ){ echo 'checked="checked" ';} ?> name="<?=SponsorshipDashboardSourceMobile::SD_ACTION; ?>" value="<?=$action;?>" type="radio" class="sd-checkbox"><?=wfMsg('sponsorship-dashboard-mobile-serie-'.$action);?> </label></li><?
		} ?>
	</ul>
	<div style="font-weight:bold"> <?=wfMsg('sponsorship-dashboard-source-OS');?> </div>
	<ul >
		<?
			foreach( SponsorshipDashboardSourceMobile::$allowedOS as $os ){

		?><li><label><input <? if( $os == $data[ SponsorshipDashboardSourceMobile::SD_OS ] ){ echo 'checked="checked" ';} ?> name="<?=SponsorshipDashboardSourceMobile::SD_OS; ?>" type="radio" class="sd-checkbox" value="<?=$os;?>"><?=wfMsg('sponsorship-dashboard-mobile-serie-'.$os);?> </label></li><?
		} ?>
	</ul>
	<div style="font-weight:bold"> <?=wfMsg('sponsorship-dashboard-source-App');?> </div>
	<ul >
		<?
			foreach( SponsorshipDashboardSourceMobile::$allowedApp as $app ){

		?><li><label><input <? if( $app == $data[ SponsorshipDashboardSourceMobile::SD_APP ] ){ echo 'checked="checked" ';} ?> name="<?=SponsorshipDashboardSourceMobile::SD_APP; ?>" type="radio" class="sd-checkbox" value="<?=$app;?>"><?=wfMsg('sponsorship-dashboard-mobile-serie-'.$app);?> </label></li><?
		} ?>
	</ul>
	<div class="sd-source-line"></div>
	<div style="font-weight:bold"> <?=wfMsg('sponsorship-dashboard-source-wiki-app-id');?> 
		<input name="<?=SponsorshipDashboardSourceMobile::SD_WIKI_APP_ID; ?>" type="text" value="<?=$data[ SponsorshipDashboardSourceMobile::SD_WIKI_APP_ID ]; ?>" class="sd-long">
	</div>
	<div style="font-weight:bold"> <?=wfMsg('sponsorship-dashboard-source-serie-name');?> 
		<input name="<?=SponsorshipDashboardSourceMobile::SD_SERIE_NAME; ?>" type="text" value="<?=$data[ SponsorshipDashboardSourceMobile::SD_SERIE_NAME ]; ?>" class="sd-long">
	</div>
	
</form>

<!-- END OF MAIN-PAGE -->
<!-- e:<?= __FILE__ ?> -->
