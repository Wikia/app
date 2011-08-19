<?php foreach ($items as $item) { ?>
<?php switch ($item['type']) { ?>
<?php case 'share': ?>
<li id="ca-share_feature" class="overflow">
	<a id="control_share_feature" href="#" data-name="<?= $item['tracker-name']; ?>"><?= $item['caption']; ?></a>
</li>
<?php     break; ?>
<?php case 'follow': ?>
<li class="overflow" id="<?= $item['link-id']; ?>"><span data-name="<?= $item['tracker-name']; ?>"><?= $item['caption']; ?></span><a href="#" id="follow-accesskey" accesskey="w"></a></li>
<?php     break; ?>
<?php case 'menu': ?>
<li class="mytools menu">
	<span class="arrow-icon-ctr"><span class="arrow-icon arrow-icon-single"></span></span>
	<span><?= $item['caption']; ?></span>
	<ul id="my-tools-menu" class="tools-menu">
		<?= wfRenderModule( 'Footer', 'Menu', array( 'format' => 'html', 'items' => $item['items'] ) ); ?>
	</ul>
</li>
<?php     break; ?>
<?php case 'link': ?>
<li class="overflow">
	<span data-href="<?= $item['href']; ?>" data-name="<?= $item['tracker-name']; ?>"><?= $item['caption']; ?></span>
</li>
<?php     break; ?>
<?php case 'customize': ?>
<li>
	<img height="16" width="16" class="gear-icon" src="<?= $wgBlankImgUrl; ?>">
	<span class="tools-customize" href="#" data-name="customize"><?= wfMsg( 'oasis-toolbar-customize' ); ?></span>
</li>
<?php     break; ?>
<?php case 'devinfo': /* Temporary, BugId:5497; TODO: call getPerformanceStats in DevInfoUserCommand.php rather than here */ ?>
<li class="loadtime">
    <span><?= F::app()->wf->getPerformanceStats(); ?></span>
</li>
<?php     break; ?>
<?php case 'disabled': ?>
<li class="overflow">
	<span title="<?= $item['error-message']; ?>"><?= $item['caption']; ?></span>
</li>
<?php     break; ?>
<?php } ?>
<?php } ?>
