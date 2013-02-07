	<ul class="tabs">
		<li <?= $currentTab === 'main' ? 'class="selected" ' : '' ?>data-tab="main"><a href="<?= $phalanxMainTitle->getLocalUrl()  ?>"><?php echo wfMsg( 'phalanx-tab-main' ) ?></a></li>
		<li <?= $currentTab === 'test' ? 'class="selected" ' : '' ?>data-tab="test"><a href="<?= $phalanxTestTitle->getLocalUrl() ?>"><?php echo wfMsg( 'phalanx-tab-secondary' ) ?></a></li>
	</ul>
