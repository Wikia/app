<section id=wkTopNav <?= ($searchOpen) ? 'class=srhOpn' : ''?>>
   <section id=wkTopBar>
   <? if( $wordmarkType == "graphic" ) :?>
	   <img id=wkImgMrk src="<?= $wordmarkUrl ;?>">
   <? else :?>
	   <div id=wkWrdMrk><?= $wikiName ;?></div>
   <? endif ;?>
   <a href=#wkNavSrh id=wkSrhTgl class=tgl></a>
   <a href=#wkNavMenu id=wkNavTgl class=tgl><span></span></a>
   </section>
   <section id=wkNav>
	  <ul id=wkTabs>
		 <li class=act>Menu
	  </ul>
	  <nav id=wkWikiNav></nav>
   </section>
</section>