<section id=wkPage>
	<?= $pageHeaderContent ;?>
	<article id=wkMainCnt>
		<?= $bodyContent ;?>
		<footer id=wkMainCntFtr>
			<nav id=wkRltdCnt>
			<?= $relatedPages ;?>
			<?= $categoryLinks ;?>
			</nav>
			<? if ( !empty( $afterContentHookText ) || !empty( $afterBodyContent ) || !empty( $comments ) ) :?>
			<aside>
			<?= $afterContentHookText ;?>
			<?= $afterBodyContent ;?>
			<?= $comments ;?>
			</aside>
			<? endif ;?>
			<div id=wkNavSrh><form id=wkSrhFrm action=index.php method=post>
				<input id=wkSrhInp type=search name=search placeholder="<?= $wf->MsgExt( 'wikiamobile-search', array( 'parseinline' ) ); ?>..." required=required>
				<input id=wkSrhSub type=submit>
			</form></div>
			<?= $navMenu ;?>
		</footer>
	</article>
</section>
<div id=wkMdlWrp>
	<div id=wkMdlTB>
		<div id=wkMdlTlBar></div>
		<div id=wkMdlClo class=clsIco></div>
	</div>
	<div id=wkMdlCnt></div>
	<div id=wkMdlFtr></div>
</div>