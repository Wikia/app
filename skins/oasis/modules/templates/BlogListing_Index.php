<section class="<?= $blogListingClass ?>">
	<?php // only display header block for the BlogListingBox
	if ( strpos( $blogListingClass, 'WikiaBlogListingBox' ) !== false ): ?>
	<a href="<?= Skin::makeSpecialUrl( 'CreateBlogPage' ); ?>" class="wikia-button">
		<img class="sprite blog" src="<?= $wg->BlankImgUrl ?>" alt="<?= wfMessage( 'blog-create-post-label' )->escaped(); ?>" />
		<?= wfMessage( 'blog-create-post-label' )->escaped(); ?>
	</a>
	<h2>
		<?= $title; ?>
	</h2>
	<?php endif; ?>
	<ul>
		<?php
		foreach ($posts as $post) {
			$title = Title::newFromText($post['title'], $post['namespace']);
		?>
			<li class="WikiaBlogListingPost">
				<?= $app->renderView( 'CommentsLikes', 'Index', [ 'comments' => $post['comments'], 'bubble' => true, 'title' => $title, 'accesskey' => false ] ); ?>

				<?= $post['avatar'] ?>
				<div class="author-details">
					<h2><a href="<?= Sanitizer::encodeAttribute( $title->getLocalURL() ) ?>"><?= htmlspecialchars( BlogTemplateClass::getSubpageText( $title ) ) ?></a></h2>
					<span><?= wfMessage( 'blog-by' )->params( $post['date'] )->rawParams( Xml::element( 'a', [ 'href' => htmlspecialchars( $post['userpage'] ) ], $post['username'], false ) )->escaped(); ?></span>
				</div>

				<div class='post-summary'>
					<?php
					// handle proper rendering of "read more"
					$readMoreLink = Xml::openElement( 'span', [ 'class' => 'read-more' ] ) .
						Linker::link( $title, wfMessage( 'blog-readfullpost' )->escaped() . ' &gt;' ) .
						Xml::closeElement( 'span' );

					// if blog post rendered text ends with </p>
					if (substr($post['text'], -4) == '</p>') {
						$post['text'] = substr($post['text'], 0, -4) . '<br>' . $readMoreLink . '</p>';
					} else {
						$post['text'] .=  '' .$readMoreLink;
					}

					echo $post['text'];
					?>
				</div>
			</li>
<?php
		}
?>
	</ul>
<?php  // only display more link for the bloglistingbox
if ( strpos( $blogListingClass, 'WikiaBlogListingBox' ) !== false && !empty( $seeMoreUrl ) ): ?>
	<a href="<?= $seeMoreUrl ?>" class="more"><?= wfMessage( 'oasis-more' )->escaped(); ?></a>
<?php endif; ?>
<?php if ( isset( $pager ) ): ?>
	<div id="wk_blogs_loader2" style="float:right;"></div>
	<div class="wk_blogs_pager">
		<?= $pager ?>
	</div>
<?php endif; ?>
</section>
