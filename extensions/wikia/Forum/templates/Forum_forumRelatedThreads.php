<?php if ( $showModule ) { ?>
	<section class="module WikiaActivityModule ForumActivityModule">
		<h2><?= wfMessage( 'forum-related-module-heading' )->escaped() ?></h2>
		<ul>
			<?php foreach ( $messages as $message ) { ?>
			<li>
				<?php
				$messageLast = empty( $message['reply'] ) ? $message['message'] : $message['reply'];
				$user = Html::element(
					'a',
					[
						'href' => $messageLast->getUser()->getUserPage()->getFullUrl()
					],
					$messageLast->getUser()->getName()
				);
				$time = Html::element(
					'span',
					[
						'class' => 'timeago abstimeago',
						'title' => $messageLast->getCreateTime(),
						'alt' => $messageLast->getCreateTime( TS_MW )
					],
					'&nbsp;'
				);
				?>

				<?= AvatarService::renderAvatar( $messageLast->getUser()->getName(), 20 ); ?>

				<em>
					<a href="<?= Sanitizer::encodeAttribute( $message['message']->getMessagePageUrl() ); ?>" title="<?= Sanitizer::encodeAttribute( $message['message']->getMetaTitle() ); ?>"><?= htmlspecialchars( $message['message']->getMetaTitle() ); ?></a>
				</em>
				<div class="edited-by">
					<?= wfMessage( !empty( $message['reply'] ) ? 'forum-activity-module-posted' : 'forum-activity-module-started' )->rawParams( $user, $time )->escaped() ?>
				</div>
			</li>
			<?php } ?>
		</ul>
	</section>
<?php } ?>
