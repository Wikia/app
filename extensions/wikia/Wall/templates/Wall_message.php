<li class="SpeechBubble message" id="<? echo $linkid ?>" data-id="<? echo $id ?>" data-is-reply="<?= $isreply == true ?>" <? if($hide):?> style="display:none" <? endif;?> >
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
			<?php if($isWatched): ?>	
				<a <?php if(!$showFallowButton): ?>style="display:none"<?php endif;?> data-iswatched="1" class="follow wikia-button"><?= wfMsg('wall-message-following'); ?></a>
			<?php else: ?>	
				<a <?php if(!$showFallowButton): ?>style="display:none"<?php endif;?> data-iswatched="0" class="follow wikia-button secondary"><?= wfMsg('wall-message-follow'); ?></a>
			<?php endif;?>
			<div class="msg-title"><a href="<?= $fullpageurl; ?>"><? echo $feedtitle ?></a></div>
		<? endif; ?>
		<div class="edited-by">
			<a href="<?= $user_author_url ?>"><?= $displayname ?></a> 
			<a href="<?= $user_author_url ?>" class="subtle"><?= $displayname2 ?></a>
			<?php if( !empty($isStaff) ): ?> 
				<span class="stafflogo"></span>
			<?php endif; ?>
		</div>
		<div class="msg-body">
			<? echo $body ?>
		</div>

		<div class="timestamp" style="clear:both">
			<?php if($isEdited):?>
				<? echo wfMsg('wall-message-edited', array('$1' => $editorUrl, '$2' => $editorName, '$3' => $historyUrl )); ?>
			<?php endif; ?>
			<a  href="<?= $fullpageurl; ?>" class="permalink" tabindex="-1">
				<span class="timeago abstimeago" title="<?= $iso_timestamp ?>" alt="<?= $fmt_timestamp ?>">&nbsp;</span>
				<span class="timeago-fmt"><?= $fmt_timestamp ?></span>
			</a>
			
			<div class="buttons">
				<div data-delay='50' class="wikia-menu-button contribute secondary"> 
					<?= wfMsg('wall-message-more');?>
					<span class="drop">
						<img class="chevron"  src="<?=f::app()->getGlobal('wgBlankImgUrl'); ?>" >
					</span>
					<ul style="min-width: 95px;">
						<? if( $canEdit ): ?>
							<li>
								<a href="#" class="edit-message"><?= wfMsg('wall-message-edit'); ?></a> 
							</li>
						<? endif; ?>
						<? if( $canDelete ): ?>
							<li>
								<a href="#" class="delete-message"> <?= wfMsg('wall-message-delete'); ?> </a>
							</li>
						<? endif; ?>
						<li>
							<a href="#" class="source-message"> <?= wfMsg('wall-message-source'); ?> </a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	<?php /*
		<div class="buttons">
			<!-- only show this if it's user's own message --> 
			
				<span class="tools">
					
						<img src="<?= $wgBlankImgUrl ?>" class="sprite-small delete"><a href="#" class="delete-message"><?= wfMsg('wall-message-delete'); ?></a>
					
					
						<img src="<?= $wgBlankImgUrl ?>" class="sprite edit-pencil"><a href="#" class="edit-message"><?= wfMsg('wall-message-edit'); ?></a>
								
				</span>
		</div>
		
		*/ ?>
	</blockquote>
	<? if(!$isreply): ?>
		<ul class="replies">
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

