<nav id="navigation">
<? if( $wordmarkType == "graphic" ) :?>
	<img<?= ( $searchOpen ) ? ' style="display:none"' : '' ;?> id="navigationWordMark" src="<?= $wordmarkUrl ;?>"/>
<? else :?>
	<div<?= ( $searchOpen ) ? ' style="display:none"' : '' ;?> id="navigationWordMark"><?= $wikiName ;?></div>
<? endif ;?>
	 <div id="navigationSearch" <?php if($searchOpen) echo 'style=display:block class=open' ?>>
		<form id="searchForm" action="index.php?useskin=wikiamobile" method="post">
			<input id="searchInput" type="search" name="search" placeholder="<?= $wf->MsgExt( 'wikiamobile-search', array( 'parseinline' ) ); ?>..." required="required" />
		</form>
	 </div>
	<div id="searchToggle" <?php if($searchOpen) echo 'class=open' ?>></div>
</nav>