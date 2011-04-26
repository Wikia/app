<!-- s:<?= __FILE__ ?> -->
<!-- MAIN-PAGE -->

<form class="sd-form sd-sub-form">
	<input type="hidden" name="sourceType" value="Stats" />
	<a class="wikia-button sd-source-remove" style="float:right; margin-top:3px"> <img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite close"> <?=wfMsg('sponsorship-dashboard-source-discard');?></a>
	<div class="sd-source-title"> <?=wfMsg('sponsorship-dashboard-source-datasource');?> <b>#1</b>: <?=wfMsg('sponsorship-dashboard-source-WikiaStats');?></div>
	<div style="font-weight:bold"> <?=wfMsg('sponsorship-dashboard-source-Variables');?> </div>
	<ul class="sd-list">
		<?
		$series = explode(',', $data[SponsorshipDashboardSourceStats::SD_PARAMS_STATS_SERIES] );
		try {
			$seriesNames = @unserialize( $data[ SponsorshipDashboardSourceStats::SD_PARAMS_STATS_SERIES_NAMES ] );
		} catch ( MyException $e) {
			$seriesNames = array();
		}

		foreach( SponsorshipDashboardSourceStats::$allowedSeries as $baseSerie ){
			?><li>
				<input <? if( in_array( $baseSerie, $series ) ) echo 'checked="checked"'; ?> name="<?=SponsorshipDashboardSourceStats::SD_PARAMS_STATS_SERIES ;?><?=$baseSerie; ?>" type="checkbox" class="sd-checkbox">
				<input name="sourceSerieName-<?=$baseSerie; ?>" class="sd-very-long" type="text" data-default="<?=wfMsg('sponsorship-dashboard-serie-'.$baseSerie); ?>" data-default="<?=wfMsg('sponsorship-dashboard-serie-'.$baseSerie); ?>" value="<?=( isset( $seriesNames[ $baseSerie ] ) ? $seriesNames[ $baseSerie ] : wfMsg('sponsorship-dashboard-serie-'.$baseSerie) ); ?>" />
				<a class="wikia-button sd-source-reload-default secondary" data-action="bringDefault" data-target="sourceSerieName-<?=$baseSerie; ?>" style="float:right; margin-top:3px">
					<img src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" height="0" width="0" class="sprite error">
				</a>
			</li><?
		} ?>
	</ul>
	<div>
		<?=wfMsg('sponsorship-dashboard-source-pageviews-namespaces');?> <input name="<?=SponsorshipDashboardSourceStats::SD_PARAMS_STATS_NAMESPACES ;?>" type="text" value="" class="sd-long" style="left:200px;">
	</div>
	<div class="sd-source-line"></div>
	<div style="font-weight:bold"> <?=wfMsg('sponsorship-dashboard-source-wikis');?> </div>
	<ul class="sd-list">
		<li>
			<input <? if ( $data[ SponsorshipDashboardSource::SD_PARAMS_REP_SOURCE_TYPE ] == SponsorshipDashboardSource::SD_SOURCE_LIST ) echo 'checked="checked"' ?> name="<?=SponsorshipDashboardSource::SD_PARAMS_REP_SOURCE_TYPE; ?>" value="<?=SponsorshipDashboardSource::SD_SOURCE_LIST;?>" type="radio" class="sd-checkbox"> <?=wfMsg('sponsorship-dashboard-source-list');?> <input name="<?=SponsorshipDashboardSource::SD_PARAMS_REP_CITYID; ?>" type="text" value="<?=$data[SponsorshipDashboardSource::SD_PARAMS_REP_CITYID]; ?>" class="validate-list sd-long">
		</li>
		<li>
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
		</li>
		<li>
			<input <? if ( $data[ SponsorshipDashboardSource::SD_PARAMS_REP_SOURCE_TYPE ] == SponsorshipDashboardSource::SD_SOURCE_GLOBAL ) echo 'checked="checked"' ?> name="<?=SponsorshipDashboardSource::SD_PARAMS_REP_SOURCE_TYPE; ?>" value="<?=SponsorshipDashboardSource::SD_SOURCE_GLOBAL;?>" type="radio" class="sd-checkbox"> <?=wfMsg('sponsorship-dashboard-source-global');?>
		</li>
	</ul>
</form>

<!-- END OF MAIN-PAGE -->
<!-- e:<?= __FILE__ ?> -->
