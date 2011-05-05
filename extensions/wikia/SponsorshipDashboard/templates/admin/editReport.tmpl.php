<!-- s:<?= __FILE__ ?> -->
<!-- MAIN-PAGE -->

<div id="progress">
	<progress value="0" max="100"></progress>
	<span> <div id="progressValue"></div><?=wfMsg("sponsorship-dashboard-compleat" ); ?> </span>
</div>
<div id="debug">
</div>
<h2> <?=wfMsg('sponsorship-dashboard-report-general-ptions'); ?> </h2>
<span>
	<a class="wikia-button sd-cancel" data-id="sd-cancel" style="float:right" href="<?=$reportEditorPath; ?>"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite close"> <?=wfMsg('sponsorship-dashboard-cancel');?></a>
	<a class="wikia-button sd-save-as-new" data-id="sd-save" style="float:right; margin: 0 5px"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite ok"> <?=wfMsg('sponsorship-dashboard-save-as-new');?></a>
	<a class="wikia-button sd-save" data-id="sd-save" style="float:right; margin: 0 5px"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite ok"> <?=wfMsg('sponsorship-dashboard-save');?></a>
	<a class="wikia-button sd-preview" data-id="sd-preview" style="float:right; margin: 0 5px"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite details"> <?=wfMsg('sponsorship-dashboard-preview');?></a>
</span>
<form class="sd-form sd-form-main">
	<div> <input id="mainId" name="mainId" type="hidden" class="sd-fixedleft sd-long" value="<?=$reportParams['id'];?>"> </div>
	<div><?=wfMsg("sponsorship-dashboard-report-title" ); ?><input name="mainTitle" type="text" class="sd-fixedleft sd-long" value="<?=$reportParams['name'];?>"> </div>
	<div class="sd-higher"><?=wfMsg("sponsorship-dashboard-report-description" ); ?><textarea name="mainDescription"><?=$reportParams['description'];?></textarea> </div>
	<div><?=wfMsg("sponsorship-dashboard-report-data-frequency" ); ?><select name="<?=SponsorshipDashboardSource::SD_PARAMS_FREQUENCY; ?>"><option <? if( $reportParams[ SponsorshipDashboardSource::SD_PARAMS_FREQUENCY ] == SponsorshipDashboardDateProvider::SD_FREQUENCY_DAY ) echo ' selected="yes" '; ?> value="<?=SponsorshipDashboardDateProvider::SD_FREQUENCY_DAY;?>"><?=wfMsg('sponsorship-dashboard-report-date-daily');?></option><option value="<?=SponsorshipDashboardDateProvider::SD_FREQUENCY_MONTH;?>" <? if( $reportParams[ SponsorshipDashboardSource::SD_PARAMS_FREQUENCY ] == SponsorshipDashboardDateProvider::SD_FREQUENCY_MONTH ) echo ' selected="yes" '; ?> ><?=wfMsg('sponsorship-dashboard-report-date-monthly');?></option></select> </div>
	<div><?=wfMsg("sponsorship-dashboard-report-max-date-units" ); ?><input name="<?=SponsorshipDashboardSource::SD_PARAMS_LASTUNITDATE; ?>" class="validate-number sd-short" type="text" value="<?=$reportParams[ SponsorshipDashboardSource::SD_PARAMS_LASTUNITDATE ];?>"> <?=wfMsg('sponsorship-dashboard-0-means-all');?></div>
</form>
<h2><?=wfMsg("sponsorship-dashboard-report-data-sources" ); ?></h2>
<span>
	<a class="wikia-button sd-addNewGapi" data-id="sd-addNewGapi"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite new"> <?=wfMsg('sponsorship-dashboard-report-new-source-gapi');?></a>
	<a class="wikia-button sd-addNewGapiCu" data-id="sd-addNewGapiCustom"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite new"> <?=wfMsg('sponsorship-dashboard-report-new-source-gapi-custom');?></a>
	<a class="wikia-button sd-addWikiStats" data-id="sd-addWikiStats"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite new"> <?=wfMsg('sponsorship-dashboard-report-new-source-stats');?></a>
	<a class="wikia-button sd-addOneDot" data-id="sd-addOneDot"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite new"> <?=wfMsg('sponsorship-dashboard-report-new-source-onedot');?></a>
	<a class="wikia-button sd-addMobile" data-id="sd-addMobile"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite new"> <?=wfMsg('sponsorship-dashboard-report-new-source-mobile');?></a>
	<a class="wikia-button sd-cancel" data-id="sd-cancel" style="float:right" href="<?=$reportEditorPath; ?>"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite close"> <?=wfMsg('sponsorship-dashboard-cancel');?></a>
	<a class="wikia-button sd-save-as-new" data-id="sd-save" style="float:right; margin: 0 5px"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite ok"> <?=wfMsg('sponsorship-dashboard-save-as-new');?></a>
	<a class="wikia-button sd-save" data-id="sd-save" style="float:right; margin: 0 5px"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite ok"> <?=wfMsg('sponsorship-dashboard-save');?></a>
	<a class="wikia-button sd-preview" data-id="sd-preview" style="float:right; margin: 0 5px"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite details"> <?=wfMsg('sponsorship-dashboard-preview');?></a>
</span>
<div id="sd-placeholder">
	<form class="sd-sub-form">
		<?=wfMsg("sponsorship-dashboard-report-no-source" ); ?>
	</form>
</div>
<div id="sd-source">
	<? if ( is_array( $menuItems ) ) foreach (  $menuItems as $item ){ echo $item;  } ?>
</div>
<span>
	<a class="wikia-button sd-addNewGapi" data-id="sd-addNewGapi"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite new"> <?=wfMsg('sponsorship-dashboard-report-new-source-gapi');?></a>
	<a class="wikia-button sd-addNewGapiCu" data-id="sd-addNewGapiCustom"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite new"> <?=wfMsg('sponsorship-dashboard-report-new-source-gapi-custom');?></a>
	<a class="wikia-button sd-addWikiStats" data-id="sd-addWikiStats"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite new"> <?=wfMsg('sponsorship-dashboard-report-new-source-stats');?></a>
	<a class="wikia-button sd-addOneDot" data-id="sd-addOneDot"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite new"> <?=wfMsg('sponsorship-dashboard-report-new-source-onedot');?></a>
	<a class="wikia-button sd-addMobile" data-id="sd-addMobile"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite new"> <?=wfMsg('sponsorship-dashboard-report-new-source-mobile');?></a>
	<a class="wikia-button sd-cancel" data-id="sd-cancel" style="float:right"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite close"> <?=wfMsg('sponsorship-dashboard-cancel');?></a>
	<a class="wikia-button sd-save-as-new" data-id="sd-save" style="float:right; margin: 0 5px"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite ok"> <?=wfMsg('sponsorship-dashboard-save-as-new');?></a>
	<a class="wikia-button sd-save" data-id="sd-save" style="float:right; margin: 0 5px"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite ok"> <?=wfMsg('sponsorship-dashboard-save');?></a>
	<a class="wikia-button sd-preview" data-id="sd-preview" style="float:right; margin: 0 5px"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite details"> <?=wfMsg('sponsorship-dashboard-preview');?></a>
</span>

<!-- END OF MAIN-PAGE -->
<!-- e:<?= __FILE__ ?> -->
