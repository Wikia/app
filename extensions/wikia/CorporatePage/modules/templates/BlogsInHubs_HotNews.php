	<section id="hub-hot-news">
		<h1><?= wfMsg('hub-hot-news') ?></h1>
		<h2><?= Xml::element('a', array('href' => $blogPost['url']), $blogPost['title'], false); ?></h2>
		<div class="details">
			<?= wfMsg('hub-hot-news-post-details', array(
				Xml::element('a', array('href' => $blogPost['creatorUrl'], 'class' => 'author'), $blogPost['creator'], false),
				Xml::element('a', array('href' => $blogPost['wikiUrl'], 'class' => 'wikiname'), $blogPost['wikiname'], false),
				'<time class="timeago" datetime="'.$blogPost['created'].'">'.$blogPost['created'].'</time>'
			)) ?>
		</div>
		<blockquote>
			<? if ($blogPost['image']): ?>
				<a href="<?= $blogPost['url'] ?>" class="snippetImage">
					<img src="<?= $blogPost['image'] ?>" width="220" height="140" alt="post" />
				</a>
			<? endif; ?>
			<span class="snippet">
				<?= $blogPost['snippet'] ?>
				<?= Xml::element('a', array('href' => $blogPost['url']), wfMsg('blog-readfullpost'), false); ?>
			</span>
		</blockquote>
	</section><!-- END: #hub-hot-news -->