<?php foreach ($items as $item) { ?>
<?php switch ($item['type']) { ?>
<?php case 'share': ?>
<li id="ca-share_feature" class="overflow">
	<a id="control_share_feature" href="#" data-name="<?= $item['tracker-name']; ?>"><?= $item['caption']; ?></a>
</li>
<?php     break; ?>
<?php case 'follow': ?>
<li class="overflow">
	<a accesskey="w" id="<?= $item['link-id']; ?>" href="<?= $item['href']; ?>" data-name="<?= $item['tracker-name']; ?>"><?= $item['caption']; ?></a>
</li>
<?php     break; ?>
<?php case 'menu': ?>
<li class="mytools menu">
	<span class="arrow-icon-ctr"><span class="arrow-icon arrow-icon-single"></span></span>
	<a href="#"><?= $item['caption']; ?></a>
	<ul id="my-tools-menu" class="tools-menu">
		<?= F::app()->renderView( 'Footer', 'Menu', array( 'format' => 'html', 'items' => $item['items'] ) ); ?>
	</ul>
</li>
<?php     break; ?>
<?php case 'link': ?>
<li class="overflow">
	<a href="<?= $item['href']; ?>" data-name="<?= $item['tracker-name']; ?>"><?= $item['caption']; ?></a>
</li>
<?php     break; ?>
<?php case 'html': ?>
<li>
	<?= $item['html']; ?>
</li>
<?php     break; ?>
<?php case 'customize': ?>
<li>
	<img height="16" width="16" class="sprite gear" src="<?= $wg->BlankImgUrl; ?>">
	<a class="tools-customize" href="#" data-name="customize"><?= wfMsg( 'oasis-toolbar-customize' ); ?></a>
</li>
<?php     break; ?>
<?php case 'devinfo': /* Temporary, BugId:5497; TODO: call getPerformanceStats in DevInfoUserCommand.php rather than here */ ?>
<li class="loadtime">
    <span><?= wfGetPerformanceStats(); ?></span>
</li>
<?php     break; ?>
<?php case 'disabled': ?>
<li class="overflow">
	<span title="<?= $item['error-message']; ?>"><?= $item['caption']; ?></span>
</li>
<?php     break; ?>
<?php } ?>
<?php } ?>
