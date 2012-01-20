<section id=wkTopNav <?= ($searchOpen) ? 'class=searchOpen' : ''?>>
   <section id=wkTopBar>
   <? if( $wordmarkType == "graphic" ) :?>
	   <img id=wkImgMark src="<?= $wordmarkUrl ;?>">
   <? else :?>
	   <div id=wkWrdMark><?= $wikiName ;?></div>
   <? endif ;?>
		<div id=navigationSearch>
		   <form id=searchForm action=index.php method=post>
			   <input id=searchInput type=search name=search placeholder="<?= $wf->MsgExt( 'wikiamobile-search', array( 'parseinline' ) ); ?>..." required=required />
		   </form>
		</div>
	  <div id=searchToggle class=toggle></div>
	  <div id=navToggle class=toggle><img src=/extensions/wikia/WikiaMobile/images/menuChev.png></div>
   </section>
   <section id=wkNav>
	  <ul id=wkTabs>
		 <li class=active>Menu
	  </ul>
	  <nav id=wkWikiNav></nav>
   </section>
</section>