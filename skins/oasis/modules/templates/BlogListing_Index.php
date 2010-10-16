<section class="<?= $blogListingClass ?>">
	<h3><?= View::specialPageLink('CreateBlogPage', 'blog-create-post-label', 'wikia-button', 'blank.gif', 'blog-create-post-label', 'sprite blog') ?>
		<?= $title ?>
		<span class="reload"><?= View::link($wgTitle, "<img src=\"$wgStylePath/oasis/images/reload_button.png\">", array(), array('action' => 'purge')); ?></span>
	</h3>
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
			<span><?= $post['date'] ?></span>
			<span> by <a href="<?= htmlspecialchars($post['userpage']) ?>"><?= $post['username'] ?></a></span>
		</details>

		<blockquote>
			<?php
			// handle proper rendering of "read more"
			$readMoreLink = Xml::openElement('span', array('class' => 'read-more')) .
					View::link($title, wfMsg('blog-readfullpost') . ' &gt;') .
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
	<?php
		if (strpos($blogListingClass, 'WikiaBlogListingBox') !== false) {
			echo View::link(Title::newFromText(wfMsg('blogs-recent-url')), wfMsg('oasis-more'), array('class' => 'more'));
		}
		if (isset($pager)) {
			echo "<div id='wk_blogs_loader2' style='float:right;'></div>";
			echo "<div class='wk_blogs_pager'>";
			echo $pager;
			echo "</div>";
	} ?>
</section>