<section class="<?= $blogListingClass ?>">
	<?php // only display header block for the BlogListingBox
	if (strpos($blogListingClass, 'WikiaBlogListingBox') !== false) { ?>
	<?= Wikia::specialPageLink('CreateBlogPage', 'blog-create-post-label', 'wikia-button', 'blank.gif', 'blog-create-post-label', 'sprite blog') ?>
	<h3>
		<?= $title ?>
	</h3>
	<?php } // end BlogListingBox header ?>
	<ul>
		<?php
		foreach ($posts as $post) {
			$title = Title::newFromText($post['title'], $post['namespace']);
		?>
			<li class="WikiaBlogListingPost">
				<?= F::app()->renderView('CommentsLikes', 'Index', array('comments' => $post['comments'], 'bubble' => true, 'title' => $title, 'accesskey' => false)); ?>

				<?= $post['avatar'] ?>
				<div class="author-details">
					<h1><a href="<?= htmlspecialchars($title->getLocalUrl()) ?>"><?= htmlspecialchars(BlogTemplateClass::getSubpageText($title)) ?></a></h1>
					<span><?= wfMsg('blog-by', $post['date'], Xml::element('a', array('href' => htmlspecialchars($post['userpage'])), $post['username'], false)) ?></span>
				</div>

				<blockquote>
					<?php
					// handle proper rendering of "read more"
					$readMoreLink = Xml::openElement('span', array('class' => 'read-more')) .
							Wikia::link($title, wfMsg('blog-readfullpost') . ' &gt;') .
							Xml::closeElement('span');

					// if blog post rendered text ends with </p>
					if (!empty($post['readmore'])) {
						if (substr($post['text'], -4) == '</p>') {
							$post['text'] = substr($post['text'], 0, -4) . '<br>' . $readMoreLink . '</p>';
						} else {
							$post['text'] .=  '' .$readMoreLink;
						}
					} else {
						$post['text'] .= '';
					}

					echo $post['text'];
					?>
				</blockquote>
			</li>
<?php
		}
?>
	</ul>
	<?php  // only display more link for the bloglistingbox
		if (strpos($blogListingClass, 'WikiaBlogListingBox') !== false && !empty($seeMoreUrl)) {
			echo XML::element('a', array( 'href'=> $seeMoreUrl, 'class' => 'more'), wfMsg('oasis-more'));
		}
		if (isset($pager)) {
			echo "<div id='wk_blogs_loader2' style='float:right;'></div>";
			echo "<div class='wk_blogs_pager'>";
			echo $pager;
			echo "</div>";
		}
	?>
</section>
