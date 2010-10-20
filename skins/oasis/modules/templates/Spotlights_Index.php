<? if (!$wgNoExternals) { ?>
<? if ($mode == 'FOOTER') { ?>
<section<? if (!empty($sectionId)) { ?> id="<?= $sectionId ?>"<? } ?>>
	<header>
		<? if ($wgSingleH1) { ?>
		<div class="headline-div"><?= wfMsg($titleMsg) ?></div>
		<? } else { ?>
		<h1><?= wfMsg($titleMsg) ?></h1>
		<? } ?>
		<?= wfRenderModule('RandomWiki') ?>
	</header>
	<ul<? if (!empty($adGroupName)) { ?> id="<?= $adGroupName ?>"<? if ($useLazyLoadAdClass) { ?> class="<?= AdEngine::lazyLoadAdClass ?><?= $mode == 'RAIL' ? ($wgEnableSpotlightsV2_Rail ? ' SPOTLIGHT_RAIL' : '') : ($wgEnableSpotlightsV2_Footer ? ' SPOTLIGHT_FOOTER' : '') ?>"<? } } ?>>
		<?= AdEngine::getInstance()->getLazyLoadableAdGroup($adGroupName, $adslots) ?>
		<? for ($i=0; $i<$n_adslots; $i++) { ?>
		<li class="WikiaSpotlight item-<?= $i+1 ?>" id="<?= $adslots[$i]?>">
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
<? } else if ($mode == 'RAIL') { ?>

<section <?= (!empty($sectionId) ? 'id="'.$sectionId.'"' : '') ?>>
	<header>
		<? if ($wgSingleH1) { ?>
			<div class="headline-div"><?= wfMsg($titleMsg) ?><img class="sprite logo" src="<?= $wgBlankImgUrl ?>" height="15" width="61"></div>
		<? } else { ?>
			<h1><?= wfMsg($titleMsg) ?><img src="<?= $wgBlankImgUrl ?>" height="15" width="61" class="sprite logo"></h1>
		<? } ?>
		<img src="<?= $wgBlankImgUrl ?>" class="banner-corner-left" height="0" width="0">
		<img src="<?= $wgBlankImgUrl ?>" class="banner-corner-right chevron" height="0" width="0">
	</header>
	<ul>
		<? for ($i = 0; $i < 3; $i++) {?>
		<li>
			<a href="#" class="highlight"><img height="95" width="95" src="/skins/oasis/images/placeholder1.png"></a>
			<em>The Sims Wiki</em>
			<p>Are you ready for the vamps in The Sims Late Night and such and such?</p>
			<a href="#" class="seemore"><?= wfMsg('oasis-more') ?></a>
		</li>
		<? } ?>
	</ul>
	<?= wfRenderModule('RandomWiki') ?>
</section>

<? } } /* end !wgNoExternals */ ?>
