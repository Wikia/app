<?php if( empty($skipRendering) ) { ?>
	<nav class="RelatedPagesModule noprint"<?= !is_null($addAfterSection) ? " data-add-after-section=\"{$addAfterSection}\"" : '' ?>>
		<h2><?= wfMsgForContent('wikiarelatedpages-heading') ?></h2>
		<ul>
		<?php foreach($pages as $page) { ?>
			<li>
				<?php if( isset( $page['imgUrl'] ) ) { ?>
				<a href="<?= $page['url']; ?>"><img <?= $srcAttrName ?>="<?= $page['imgUrl']; ?>" width="200" height="100"></a>
				<?php } else { ?>
				<div class="articleSnippet"><p><?= $page['text']; ?></p></div>
				<?php } ?>
				<a href="<?= $page['url']; ?>" class="more"><?= $page['title'] ?></a>
			</li>
		<?php } ?>
		</ul>
	</nav>
<?php } // !skipRendering ?>
