<section class="<?= $blogListingClass ?>">
	<?php // only display header block for the BlogListingBox
	if (strpos($blogListingClass, 'WikiaBlogListingBox') !== false) { ?>
	<?= Wikia::specialPageLink('CreateBlogPage', 'blog-create-post-label', 'wikia-button', 'blank.gif', 'blog-create-post-label', 'sprite blog') ?>
	<h3>
		<?= $title ?> 
		<span class="reload"><?= Wikia::link($wgTitle, "<img src=\"$wgStylePath/oasis/images/reload_button.png\">", array(), array('action' => 'purge')); ?></span>
	</h3>
	<?php } // end BlogListingBox header ?>
	<ul>
		<?php
		foreach ($posts as $post) {
			$title = Title::newFromText($post['title'], $post['namespace']);
		?>
			<li class="WikiaBlogListingPost">
			<?= wfRenderModule('CommentsLikes', 'Index', array('comments' => $post['comments'], 'bubble' => true, 'title' => $title)); ?>

			<h1><a href="<?= htmlspecialchars($title->getLocalUrl()) ?>"><?= htmlspecialchars(BlogTemplateClass::getSubpageText($title)) ?></a></h1>

		<details>
			<?= $post['avatar'] ?>
			<span><?= wfMsg('blog-by', $post['date'], Xml::element('a', array('href' => htmlspecialchars($post['userpage'])), $post['username'], false)) ?></span>
		</details>

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
					$post['text'] .=  '<br>' .$readMoreLink;
				}
			} else {
				$post['text'] .= '<br>';
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
		if (strpos($blogListingClass, 'WikiaBlogListingBox') !== false) {
			echo Wikia::link(Title::newFromText(wfMsg('blogs-recent-url')), wfMsg('oasis-more'), array('class' => 'more'));
		}
		if (isset($pager)) {
			echo "<div id='wk_blogs_loader2' style='float:right;'></div>";
			echo "<div class='wk_blogs_pager'>";
			echo $pager;
			echo "</div>";
	} ?>
</section>