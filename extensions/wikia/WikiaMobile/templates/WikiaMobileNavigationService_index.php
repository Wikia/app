<nav id="navigation">
	<?php if( $wordmarkType == "graphic" ) {
		echo "<img id='navigationWordMark' src='{$wordmarkUrl}'>";
	 } else {
		echo "<div id='navigationWordMark'>{$wikiName}</div>";
	 }?>
	 <div id="navigationSearch">
		<form id="searchForm" action="index.php?useskin=wikiamobile" method="post">
			<input id="searchInput" type="search" name="search" placeholder="<?= $wf->MsgExt( 'wikiamobile-search', array( 'parseinline' ) ); ?>..." required="required" />
		</form>
	 </div>
	<div id="searchToggle"></div>
</nav>