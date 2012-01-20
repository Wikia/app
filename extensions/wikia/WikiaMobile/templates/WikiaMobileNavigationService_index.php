<section id=wkTopNav <?= ($searchOpen) ? 'class=srhOpn' : ''?>>
   <section id=wkTopBar>
   <? if( $wordmarkType == "graphic" ) :?>
	   <img id=wkImgMrk src="<?= $wordmarkUrl ;?>">
   <? else :?>
	   <div id=wkWrdMrk><?= $wikiName ;?></div>
   <? endif ;?>
		<div id=wkNavSrh>
		   <form id=wkSrhFrm action=index.php method=post>
			   <input id=wkSrhInp type=search name=search placeholder="<?= $wf->MsgExt( 'wikiamobile-search', array( 'parseinline' ) ); ?>..." required=required />
		   </form>
		</div>
	  <div id=wkSrhTgl class=tgl></div>
	  <div id=wkNavTgl class=tgl><img src=/extensions/wikia/WikiaMobile/images/menuChev.png></div>
   </section>
   <section id=wkNav>
	  <ul id=wkTabs>
		 <li class=act>Menu
	  </ul>
	  <nav id=wkWikiNav></nav>
   </section>
</section>