<?php
	if($wg->Title == 'Special:Search') {
		$searchOpen = true;
	} else {
		$searchOpen = false;
	}
?>
<nav id="navigation">
	<?php if( $wordmarkType == "graphic" ) {
		echo "<img " . ($searchOpen ? "style=display:none" : "") . " id=navigationWordMark src={$wordmarkUrl}>";
	 } else {
		echo "<div " . ($searchOpen ? "style=display:none" : "") . " id='navigationWordMark'>{$wikiName}</div>";
	 }?>
	 <div id="navigationSearch" <?php if($searchOpen) echo 'style=display:block class=open' ?>>
		<form id="searchForm" action="index.php?useskin=wikiamobile" method="post">
			<input id="searchInput" type="search" name="search" placeholder="<?= $wf->MsgExt( 'wikiamobile-search', array( 'parseinline' ) ); ?>..." required="required" />
		</form>
	 </div>
	<div id="searchToggle" <?php if($searchOpen) echo 'class=open' ?>></div>
</nav>