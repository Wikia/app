<header id="WikiHeader" class="WikiHeader">
	<nav>
		<ul>
			<li>
				<img src="<?= $wgBlankImgUrl ;?>" class="chevron" width="0" height="0"><?= wfMsg('mobileproducts-language') ;?>
				<ul class="subnav">
					<? foreach ( $languages as $lang ) :?>
						<li>
							<a href="<?= $lang['href'] ;?>"><?= $lang['language'] ;?></a>
						</li>
					<? endforeach ;?>
				</ul>
			</li>
		</ul>
	</nav>
</header>