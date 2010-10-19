<? if (!$wgNoExternals) { ?>
<section<? if (!empty($sectionId)) { ?> id="<?= $sectionId ?>"<? } ?>>
	<header>
		<? if ($wgSingleH1) { ?>
		<div class="headline-div"><?= wfMsg($titleMsg) ?></div>
		<? } else { ?>
		<h1><?= wfMsg($titleMsg) ?></h1>
		<? } ?>
		<? if ($mode=='RAIL') { ?>
		<img src="<?= $wgBlankImgUrl; ?>" class="banner-corner-left" height="0" width="0">
		<img src="<?= $wgBlankImgUrl; ?>" class="banner-corner-right" height="0" width="0">
		<? } elseif ($mode=='FOOTER') { ?>
		<?= wfRenderModule('RandomWiki') ?>
		<? } ?>
	</header>
	<? if ($wgEnableOpenXSPC) { ?>
	<ul>
	<? } else { ?>
	<ul<? if (!empty($adGroupName)) { ?> id="<?= $adGroupName ?>"<? if ($useLazyLoadAdClass) { ?> class="<?= AdEngine::lazyLoadAdClass ?><?= $mode == 'RAIL' ? ($wgEnableSpotlightsV2_Rail ? ' SPOTLIGHT_RAIL' : '') : ($wgEnableSpotlightsV2_Footer ? ' SPOTLIGHT_FOOTER' : '') ?>"<? } } ?>>
		<?= AdEngine::getInstance()->getLazyLoadableAdGroup($adGroupName, $adslots) ?>
	<? } ?>
		<? for ($i=0; $i<$n_adslots; $i++) { ?>
		<li class="WikiaSpotlight item-<?= $i+1 ?><? if ($wgEnableOpenXSPC && $useLazyLoadAdClass) { echo ' ' . AdEngine::lazyLoadAdClass; } ?>" id="<?= $adslots[$i]?>">
			<?
			if ( empty( $forceContent[$i] ) ) {
				echo AdEngine::getInstance()->getAd( $adslots[$i] );
			} else {
				echo $forceContent[$i];
			}  ?>
		</li>
		<? } ?>
	</ul>
</section>
<? } ?>
