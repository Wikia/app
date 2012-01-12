<nav id=navigation>
<? if( $wordmarkType == "graphic" ) :?>
	<img<?= ( $searchOpen ) ? ' style="display:none"' : '' ;?> id=navigationWordMark src="<?= $wordmarkUrl ;?>"/>
<? else :?>
	<div<?= ( $searchOpen ) ? ' style="display:none"' : '' ;?> id=navigationWordMark><?= $wikiName ;?></div>
<? endif ;?>
	 <div id=navigationSearch <?php if($searchOpen) echo 'style=display:block class=open' ?>>
		<form id=searchForm action=index.php method=post>
			<input id=searchInput type=search name=search placeholder="<?= $wf->MsgExt( 'wikiamobile-search', array( 'parseinline' ) ); ?>..." required=required />
		</form>
	 </div>
   <div id=navToggle class=toggle></div>
   <div id=searchToggle class=<?= ($searchOpen) ? '"open toggle"': 'toggle' ?>></div>
</nav>
<nav id=wkNav>
   <ul id=wkTabs>
	  <li class=active>Menu</li>
   </ul>
   <section id=wkWikiNav class="navTab current1">
		 <header id=wkWNTopBar>
			<button id=wkNavBack><?= $wf->MsgExt( 'wikiamobile-back', array( 'parseinline' ) );?></button>
			<h1 id=topBarText>Top Bar text</h1>
			<a></a>
		 </header>
   </section>
</nav>