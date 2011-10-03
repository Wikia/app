<li class="SpeechBubble message" data-id="<? echo $id ?>" is-reply="<?= $isreply == true ?>" <? if($hide):?> style="display:none" <? endif;?> >
	<div class="speech-bubble-avatar">
		<a href="/wiki/User:<?= $username ?>">
			<? if(!$isreply): ?>
				<?= AvatarService::renderAvatar($username, 50) ?>
			<? else: ?>
				<?= AvatarService::renderAvatar($username, 30) ?>
			<? endif ?>
		</a>
	</div>
	<blockquote class="speech-bubble-message">
		<? if(!$isreply): ?>
			<?php if($showFallowButton): ?>
				<?php if($isWatched): ?>	
					<a data-iswatched="1" class="follow wikia-button"><?= wfMsg('wall-message-following'); ?></a>
				<?php else: ?>	
					<a data-iswatched="0" class="follow wikia-button secondary"><?= wfMsg('wall-message-follow'); ?></a>
				<?php endif;?>
			<?php endif;?>
			<div class="msg-title"><a href="<?= $fullpageurl; ?>"><? echo $feedtitle ?></a></div>
		<? endif; ?>
		<div class="edited-by">
			<a href="<?= $user_author_url ?>"><?= $displayname ?></a> 
			<a href="<?= $user_author_url ?>" class="subtle"><?= $displayname2 ?></a>
		</div>
		<div class="msg-body">
			<? echo $body ?>
		</div>

		<div class="timestamp" style="clear:both">
			<a  href="<?= $fullpageurl; ?>" class='permalink'>
				<time class="timeago" datetime="<?= $iso_timestamp ?>">&nbsp;</time>
			</a>
		</div>

		<div class="buttons">
			<!-- only show this if it's user's own message --> 
			
				<span class="tools">
					<? if( $canDelete ): ?>
						<img src="<?= $wgBlankImgUrl ?>" class="sprite-small delete"><a href="#" class="delete-message"><?= wfMsg('wall-message-delete'); ?></a>
					<? endif; ?>
					<? if( $canEdit ): ?>
						<img src="<?= $wgBlankImgUrl ?>" class="sprite edit-pencil"><a href="#" class="edit-message"><?= wfMsg('wall-message-edit'); ?></a>
					<? endif; ?>			
				</span>
		</div>
	</blockquote>
	<? if(!$isreply): ?>
		<ul>
			<? if(!empty($replies)): ?>
				<? $i =0;?>
				<? if($showLoadMore): ?>
					<?= $app->renderView( 'WallController', 'loadMore', array('repliesNumber' => $repliesNumber) ); ?>
				<? endif; ?>	
				<? foreach( $replies as $key  => $val): ?>				
					<?= $app->renderView( 'WallController', 'message', array('title' => $title, 'comment' => $val, 'isreply' => true, 'repliesNumber' => $repliesNumber, 'showRepliesNumber' => $showRepliesNumber,  'current' => $i)  ) ; ?>
					<? $i++; ?>
				<? endforeach; ?>
			<? endif; ?>
			<?= $app->renderView( 'WallController', 'reply'); ?>
		</ul>
	<? endif; ?>
</li>

