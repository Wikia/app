<?php global $wgBlankImgUrl; ?>
<div class='plb-manager'>
	<ul class="plb-add-element wikia-menu-button wikia-menu-button-no-auto">
		<li>
			<span>
			<img height="16" width="22" src="http://images1.wikia.nocookie.net/__cb27571/common/skins/common/blank.gif" class="osprite icon-edit" alt="">
			<?php echo wfMsg('plb-editor-add-element'); ?></span>
			<img src="<?php echo $wgBlankImgUrl; ?>" class="chevron">
			<ul>
			</ul>
		</li>
	</ul>
</div>
<div class="plb-widgets">
	<span class="plb-widgets-summary">
		<span class="plb-widgets-count">0</span>
		<span class="plb-brick"></span>
		<span class="plb-widgets-count-text"><?php echo wfMsg('plb-editor-elements-in-the-editor'); ?></span>
	</span>
	<ul class='plb-widget-list' style="display: hidden">
	</ul>
</div>