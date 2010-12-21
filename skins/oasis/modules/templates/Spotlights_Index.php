<? if (!$wgNoExternals) { ?>
<? if ($mode == 'FOOTER') { ?>
<section<? if (!empty($sectionId)) { ?> id="<?= $sectionId ?>"<? } ?>>
	<header>
		<h1><?= wfMsg($titleMsg) ?></h1>
		<?= wfRenderModule('RandomWiki') ?>
	</header>
	<ul<? if (!empty($adGroupName)) { ?> id="<?= $adGroupName ?>"<? if ($useLazyLoadAdClass) { ?> class="<?= AdEngine::lazyLoadAdClass ?><?= $mode == 'RAIL' ? ($wgEnableSpotlightsV2_Rail ? ' SPOTLIGHT_RAIL' : '') : ($wgEnableSpotlightsV2_Footer ? ' SPOTLIGHT_FOOTER' : '') ?>"<? } } ?>>
		<?= AdEngine::getInstance()->getLazyLoadableAdGroup($adGroupName, $adslots) ?>
		<? for ($i=0; $i<$n_adslots; $i++) { ?>
		<li class="WikiaSpotlight item-<?= $i+1 ?>" id="<?= ( isset($adslots[$i]) ) ? $adslots[$i] : 'SPOTLIGHT_FOOTER_FORCED_'.$i; ?>">
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

<section <?= (!empty($sectionId) ? 'id="'.$sectionId.'"' : '') ?> class="module">
	<header>
		<h1><?= wfMsg($titleMsg) ?><img src="<?= $wgBlankImgUrl ?>" height="15" width="61" class="sprite logo"></h1>
		<img src="<?= $wgBlankImgUrl ?>" class="banner-corner-left" height="0" width="0">
		<img src="<?= $wgBlankImgUrl ?>" class="banner-corner-right chevron" height="0" width="0">
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
	<?= wfRenderModule('RandomWiki') ?>
</section>

<? } } /* end !wgNoExternals */ ?>
