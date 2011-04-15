<!-- s:<?= __FILE__ ?> -->
<!-- MAIN-PAGE -->

<form class="sd-form sd-sub-form">
	<input type="hidden" name="sourceType" value="<?=SponsorshipDashboardSourceGapi::SD_SOURCE_TYPE; ?>" />
	<a class="wikia-button sd-source-remove" style="float:right; margin-top:3px"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite close"> <?=wfMsg('sponsorship-dashboard-source-discard');?></a>
	<div class="sd-source-title"> <?=wfMsg('sponsorship-dashboard-source-datasource');?> <b>#1</b>: <?=wfMsg('sponsorship-dashboard-source-GoogleAnalytics');?></div>
	<div style="font-weight:bold"> <?=wfMsg('sponsorship-dashboard-source-Metrics');?> </div>
	<? var_dump( $data ); ?>
	<ul><?
		$metrics = explode(',', $data[SponsorshipDashboardSourceGapi::SD_PARAMS_GAPI_METRICS] );
		$metricsNames = unserialize( $data[ SponsorshipDashboardSourceGapi::SD_PARAMS_GAPI_METRICS_NAMES ] );
		foreach( SponsorshipDashboardSourceGapi::$SD_GAPI_ALLOWED_METRICS as $metric ){
			?><li>
				<label>
					<input <? if( in_array( $metric, $metrics ) ){ echo 'checked="checked" ';} ?> name="sourceMetric-<?=$metric;?>" type="checkbox" class="sd-checkbox">
					<input name="sourceMetricName-<?=$metric; ?>" class="sd-oneforty" type="text" data-default="<?=$metric; ?>" value="<?=( isset( $metricsNames[ $metric ] ) ? $metricsNames[ $metric ] : $metric ); ?>">
				</label>
				<a class="wikia-button sd-source-reload-default secondary" data-action="bringDefault" data-target="sourceMetricName-<?=$metric; ?>" style="float:right; margin-top:3px">
					<img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite error">
				</a>
			</li><?
		}
	?></ul>
	<div class="sd-source-line"></div>
	<div> <?=wfMsg('sponsorship-dashboard-source-additional-dimension');?>
		<select name="<?=SponsorshipDashboardSourceGapi::SD_PARAMS_GAPI_EXTRADIM; ?>" style="position:relative; left:0px; width: 100px; margin-right:20px;">
			<option value=""><?=wfMsg('sponsorship-dashboard-source-none');?></option>
		<? foreach( SponsorshipDashboardSourceGapi::$SD_GAPI_ALLOWED_DIMENSIONS as $dimension ){
			?><option value="<?=$dimension;?>" <? 
			echo ( isset( $data[ SponsorshipDashboardSourceGapi::SD_PARAMS_GAPI_EXTRADIM ] ) && ( $dimension == $data[ SponsorshipDashboardSourceGapi::SD_PARAMS_GAPI_EXTRADIM ] ) ) ? ' selected="selected" ' : ' ';
			?> ><?=$dimension;?></option><?
		} ?>
		</select>
		<?=wfMsg('sponsorship-dashboard-source-in-case-of-empty');?> <input name="<?=SponsorshipDashboardSourceGapi::SD_PARAMS_GAPI_EMPTYRES; ?>" type="text" value="" > <?=wfMsg('sponsorship-dashboard-source-leave-empty');?>
	</div>
	<div class="sd-source-line"></div>
	<div>
		<?=wfMsg('sponsorship-dashboard-source-gapi-force-account');?> <input name="<?=SponsorshipDashboardSourceGapi::SD_PARAMS_REP_FORCE_ACCOUNT; ?>" value="<?=$data[ SponsorshipDashboardSourceGapi::SD_PARAMS_REP_FORCE_ACCOUNT ]; ?>" type="text" class="sd-long" >
	</div>
	<div class="sd-source-line"></div>
	<div style="font-weight:bold"> <?=wfMsg('sponsorship-dashboard-source-wikis');?> </div>
	<ul class="sd-list">
		<li>
			<label>
				<input <? if ( $data[ SponsorshipDashboardSource::SD_PARAMS_REP_SOURCE_TYPE ] == SponsorshipDashboardSource::SD_SOURCE_LIST ) echo 'checked="checked"' ?> name="<?=SponsorshipDashboardSource::SD_PARAMS_REP_SOURCE_TYPE; ?>" value="<?=SponsorshipDashboardSource::SD_SOURCE_LIST;?>" type="radio" class="sd-checkbox"> <?=wfMsg('sponsorship-dashboard-source-list');?> <input name="<?=SponsorshipDashboardSource::SD_PARAMS_REP_CITYID; ?>" type="text" value="<?=$data[SponsorshipDashboardSource::SD_PARAMS_REP_CITYID]; ?>" class="validate-list sd-long">
			</label>
		</li>
		<li>
			<label>
				<input <? if ( $data[ SponsorshipDashboardSource::SD_PARAMS_REP_SOURCE_TYPE ] == SponsorshipDashboardSource::SD_SOURCE_COMPETITORS ) echo 'checked="checked"' ?> name="<?=SponsorshipDashboardSource::SD_PARAMS_REP_SOURCE_TYPE; ?>" value="<?=SponsorshipDashboardSource::SD_SOURCE_COMPETITORS;?>" type="radio" class="sd-checkbox">  <?=wfMsg('sponsorship-dashboard-top-x-competitors');?>
				<div style="display:inline-block; width:600px; margin-left: 50px;" >
					<?=wfMsg('sponsorship-dashboard-source-number-of-competitors');?> <input name="<?=SponsorshipDashboardSource::SD_PARAMS_REP_TOPX; ?>" type="text" class="sd-short validate-number min1" value="<?=$data[SponsorshipDashboardSource::SD_PARAMS_REP_TOPX]; ?>" style="display:inline-block; margin-right:20px;" >
					<?=wfMsg('sponsorship-dashboard-source-wiki-id');?> <input name="<?=SponsorshipDashboardSource::SD_PARAMS_REP_COMP_CITYID; ?>" type="text" value="<?=$data[SponsorshipDashboardSource::SD_PARAMS_REP_COMP_CITYID]; ?>" class="sd-short validate-number" style="margin-right:20px;" >
					<?=wfMsg('sponsorship-dashboard-source-hub-id');?>
					<select name="<?=SponsorshipDashboardSource::SD_PARAMS_REP_COMP_HUBID; ?>" style="position:relative; left:0px; width: 100px; margin-right:20px;">
						<option value=""><?=wfMsg('sponsorship-dashboard-source-none');?></option>
					<? foreach( $hubs as $hubId => $hubName ){
						?><option value="<?=$hubId;?>" <? if( $data[ SponsorshipDashboardSource::SD_PARAMS_REP_COMP_HUBID ] == $hubId ) echo 'selected="selected"' ?>><?=$hubName;?></option><?
					} ?>
					</select>
				</div>
			</label>
		</li>
	</ul>
</form>

<!-- END OF MAIN-PAGE -->
<!-- e:<?= __FILE__ ?> -->
