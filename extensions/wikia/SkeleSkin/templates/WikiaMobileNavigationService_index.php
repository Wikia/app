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
		
	</div>
	<div id="openToggle"><span id="arrow"></span></div>
</nav>