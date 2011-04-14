<!-- s:<?= __FILE__ ?> -->
<!-- MAIN-PAGE -->

<form class="sd-form sd-sub-form">
	<input type="hidden" name="sourceType" value="<?= SponsorshipDashboardSourceGapiCu::SD_SOURCE_TYPE; ?>" />
	<a class="wikia-button sd-source-remove" style="float:right; margin-top:3px"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite close"> <?=wfMsg('sponsorship-dashboard-source-discard');?></a>
	<div class="sd-source-title"> <?=wfMsg('sponsorship-dashboard-source-datasource');?> <b>#1</b>: <?=wfMsg('sponsorship-dashboard-source-GoogleAnalytics');?></div>
	<div style="font-weight:bold"> <?=wfMsg('sponsorship-dashboard-source-Metrics');?> </div>
	<ul><?

		$metrics = ( isset( $data[ SponsorshipDashboardSourceGapi::SD_PARAMS_GAPI_METRICS ] )) ? explode(',', $data[SponsorshipDashboardSourceGapi::SD_PARAMS_GAPI_METRICS] ) : array();
		$metricsNames = ( isset( $data[ SponsorshipDashboardSourceGapi::SD_PARAMS_GAPI_METRICS_NAMES ] )) ? unserialize( $data[ SponsorshipDashboardSourceGapi::SD_PARAMS_GAPI_METRICS_NAMES ] ) : array();
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
	<div style="font-weight:bold"> <?=wfMsg('sponsorship-dashboard-source-query');?> </div>
	<div>
		<?=wfMsg('sponsorship-dashboard-source-gapi-force-account');?> <input name="<?=SponsorshipDashboardSourceGapi::SD_PARAMS_REP_FORCE_ACCOUNT; ?>" value="<?=$data[ SponsorshipDashboardSourceGapi::SD_PARAMS_REP_FORCE_ACCOUNT ]; ?>" type="text" class="sd-fixedleft sd-long" >
	</div>
	<div>
		<?=wfMsg('sponsorship-dashboard-source-gapi-url');?> <input name="<?=SponsorshipDashboardSourceGapi::SD_PARAMS_REP_URL; ?>" value="<?=$data[ SponsorshipDashboardSourceGapi::SD_PARAMS_REP_URL ]; ?>" type="text" class="sd-fixedleft sd-long" >
	</div>
	<div>
		<?=wfMsg('sponsorship-dashboard-source-gapi-name');?> <input name="<?=SponsorshipDashboardSourceGapi::SD_PARAMS_REP_SERIE_NAME; ?>" value="<?=$data[ SponsorshipDashboardSourceGapi::SD_PARAMS_REP_SERIE_NAME ]; ?>" type="text" class="sd-fixedleft sd-long" >
	</div>	
</form>

<!-- END OF MAIN-PAGE -->
<!-- e:<?= __FILE__ ?> -->
