<nav id="navigation">
	<?php if( $wordmarkType == "graphic" ) {
		echo "<img id='navigationWordMark' src='{$wordmarkUrl}'>";
	 } else { 
		echo "<span id='navigationWordMark'>{$wikiName}</span>";
	 }?>
	<div id="openNavigationContent">
		<ul id="navigationMenu">
			<li class="openMenu">Menu</li>
			<li>Explore</li>
			<li>Search</li>
			<li>Login</li>
		</ul>
		<div id="menuTab" class="openTab navigationTab">
			<ul>
				<li>News</li>
				<li>Games</li>
				<li>hubs</li>
				<li>Related</li>
			</ul>
		</div>
		<div id="exploreTab" class="navigationTab">
			Explore Wikia World!
		</div>
		<div id="searchTab" class="navigationTab">
			<form id="searchForm" action="#">
				<input type="search" placeholder="<?= $wf->MsgExt( 'wikiamobile-search', array( 'parseinline' ) ); ?>..." required="required" />
				<input type="submit" value="<?= $wf->MsgExt( 'wikiamobile-search', array( 'parseinline' ) ); ?>" />
			</form>
		</div>
		<div id="loginTab" class="navigationTab">
			<form id="loginForm" action="#">
				<input type="text" placeholder="<?= $wf->MsgExt( 'wikiamobile-login', array( 'parseinline' ) ); ?>" required="required" />
				<input type="password" placeholder="<?= $wf->MsgExt( 'wikiamobile-password', array( 'parseinline' ) ); ?>" required="required" />
				<input type="submit" value="<?= $wf->MsgExt( 'wikiamobile-login-submit', array( 'parseinline' ) ); ?>" />
			</form>
		</div>
	</div>
	<div id="openToggle"><span class="arrow"></span></div>
</nav>