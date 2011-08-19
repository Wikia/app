<?= wfRenderModule( 'Footer', 'Menu', array( 'format' => 'html', 'items' => $toolbar )); ?>
<li class="menu overflow-menu" style="display:none">
	<span class="arrow-icon-ctr"><span class="arrow-icon arrow-icon-top"></span><span class="arrow-icon arrow-icon-bottom"></span></span>
	<span href="#"><?= wfMsg('oasis-toolbar-more') ?></span>
	<ul class="tools-menu"></ul>
</li>