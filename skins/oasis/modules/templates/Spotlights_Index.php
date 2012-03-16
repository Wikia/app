<? if (!$wgNoExternals) { ?>
<section<? if (!empty($sectionId)) { ?> id="<?= $sectionId ?>"<? } ?>>
	<div class="header-container">
		<h1><?= wfMsg($titleMsg) ?></h1>
		<?= wfRenderModule('RandomWiki') ?>
	</div>
	<ul<? if (!empty($adGroupName)) { ?> id="<?= $adGroupName ?>"<? if ($useLazyLoadAdClass) { ?> class="<?= AdEngine::lazyLoadAdClass ?><?= $wgEnableSpotlightsV2_Footer ? ' SPOTLIGHT_FOOTER' : '' ?>"<? } } ?>>
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
<? } /* end !wgNoExternals */ ?>
