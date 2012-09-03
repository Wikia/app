<? if (!$wg->NoExternals) { ?>
<section<? if (!empty($sectionId)) { ?> id="<?= $sectionId ?>"<? } ?>>
	<div class="header-container">
		<h1><?= wfMsg($titleMsg) ?></h1>
		<?= F::app()->renderView('RandomWiki', 'Index') ?>
	</div>
	<?= AdEngine::getInstance()->getLazyLoadableAdGroup($adGroupName, $adslots) ?>
	<ul<? if (!empty($adGroupName)) { ?> id="<?= $adGroupName ?>"<? if ($useLazyLoadAdClass) { ?> class="<?= AdEngine::lazyLoadAdClass ?><?= $wg->EnableSpotlightsV2_Footer ? ' SPOTLIGHT_FOOTER' : '' ?>"<? } } ?>>
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
