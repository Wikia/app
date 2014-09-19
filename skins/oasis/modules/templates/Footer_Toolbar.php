<?= F::app()->renderView( 'Footer', 'Menu', array( 'format' => 'html', 'items' => $toolbar )); ?>
<li class="menu overflow-menu">
	<span class="arrow-icon-ctr"><span class="arrow-icon arrow-icon-top"></span><span class="arrow-icon arrow-icon-bottom"></span></span>
	<a href="#"><?= wfMsg('oasis-toolbar-more') ?></a>
	<ul class="tools-menu"></ul>
</li>
