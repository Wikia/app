<nav id=wkTopNav>
   <section id=wkTopBar>
   <? if( $wordmarkType == "graphic" ) :?>
	   <img<?= ( $searchOpen ) ? ' style="display:none"' : '' ;?> id=wkImgMark src="<?= $wordmarkUrl ;?>">
   <? else :?>
	   <div<?= ( $searchOpen ) ? ' style="display:none"' : '' ;?> id=wkWrdMark><?= $wikiName ;?></div>
   <? endif ;?>
		<div id=navigationSearch <?= ($searchOpen) ? 'style=display:block class=open' : '' ?>>
		   <form id=searchForm action=index.php method=post>
			   <input id=searchInput type=search name=search placeholder="<?= $wf->MsgExt( 'wikiamobile-search', array( 'parseinline' ) ); ?>..." required=required />
		   </form>
		</div>
	  <div id=searchToggle class="toggle<?= ($searchOpen) ? ' open': '' ?>"></div>
	  <div id=navToggle class=toggle><img src=/extensions/wikia/WikiaMobile/images/menuChev.png></div>
   </section>
   <section id=wkNav>
	  <ul id=wkTabs>
		 <li class=active>Menu
	  </ul>
	  <section id=wkWikiNav></section>
   </section>
</nav>