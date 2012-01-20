<li id="comm<?=$commentId?>" class="comment" data-user="<?=$comment['username']?>">
	<div class="avatar">
		<a href="<?= $comment['userurl'] ?>"><?= $comment['avatar'] ?></a>
	</div>
	<blockquote class="msg">
		<div class="by">
			<?= $comment['sig'] ;?>
			<? if( !empty( $comment['isStaff'] ) ) :?>
			<img class="staff" src="http://images.wikia.com/wikia/images/e/e9/WikiaStaff.png" alt="@wikia"/></span>
			<? endif ;?>
		</div>
		<div class="txt"><?= $comment['text'] ?></div>
		<div class="date"><?= $comment['timestamp'] ;?></div>
	</blockquote>
</li>
