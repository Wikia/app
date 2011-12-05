<li id="comm-<?=$commentId?>" class="SpeechBubble <?=$rowClass?>" data-user="<?=$comment['username']?>">
	<div class="speech-bubble-avatar">
		<a href="<?= $comment['userurl'] ?>"><?= $comment['avatar'] ?></a>
	</div>
	<blockquote class="speech-bubble-message">
		<div class="comment-by">
			<?= $comment['sig'] ;?>
			<? if( !empty( $comment['isStaff'] ) ) :?>
			<span class="stafflogo"><img src="http://images.wikia.com/wikia/images/e/e9/WikiaStaff.png" alt="@wikia"/></span>
			<? endif ;?>
		</div>
		<div class="comment-text" id="comm-text-<?= $comment['articleId'] ?>"><?= $comment['text'] ?></div>
		<div class="comment-date"><?= $comment['timestamp'] ;?></div>
	</blockquote>
</li>
