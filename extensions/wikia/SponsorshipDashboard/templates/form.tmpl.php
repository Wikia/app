<div class="sponsorship-dashboard-form">
	<div class="sponsorship-dashboard-form-text"><?=wfMsg('sponsorship-dashboard-city-select'); ?></div>
	<ul class="wikia-menu-button secondary">
		<li>
			<a id="sponsorship-dashboard-form-current" href="<?=$path; ?>"><?=$current['name']; ?></a>
			<img src="http://images1.wikia.nocookie.net/__cb27571/common/skins/common/blank.gif" class="chevron">
			<ul style="min-width: 116px; ">
			<? foreach ( $selectorItems as $key => $item ){?>
				<li<? if( $current['id'] == $item ){?> class="selected" <?}?>><a href="<?=$path; ?>?cityHub=<?=$item; ?>" id="sponsorship-dashboard-<?=$item; ?>"><?=$key; ?></a></li>
			<? } ?>
			</ul>
		</li>
	</ul>
</div>