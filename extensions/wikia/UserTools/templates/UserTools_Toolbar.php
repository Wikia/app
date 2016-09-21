<?= F::app()->renderView( 'UserTools', 'Menu', [ 'format' => 'html', 'type' => 'main', 'items' => $toolbar ] ); ?>
<li class="menu overflow-menu">
	<span class="arrow-icon-ctr"><span class="arrow-icon arrow-icon-top"></span><span class="arrow-icon arrow-icon-bottom"></span></span>
	<a href="#"><?= wfMessage('user-tools-more')->escaped() ?></a>
	<ul class="tools-menu"></ul>
</li>
