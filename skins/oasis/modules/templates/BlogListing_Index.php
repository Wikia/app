<?php global $wgStylePath; //FIXME ?>
<section class="<?= $blogListingClass ?>" style="display: none">
	<h3><?= View::specialPageLink('CreateBlogPage', 'blog-create-post-label', 'wikia-button', 'blank.gif', 'oasis-add-blog-listing', 'osprite icon-add') ?>
		<?= $wgTitle ?>
		<span class="reload"><?= View::link(Title::newFromText($wgTitle), "<img src=\"$wgStylePath/oasis/images/reload_button.png\">", array(), array('action' => 'purge')); ?></span>
	</h3>
	<ul>
		<?php
		foreach ($posts as $post) {
			$title = Title::newFromText($post['title'], $post['namespace']);
		?>
			<li class="WikiaBlogListingPost">
			<?= wfRenderModule('CommentsLikes', 'Index', array('comments' => $post['comments'], 'likes' => $post['likes'], 'title' => $title)); ?>

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
</section>