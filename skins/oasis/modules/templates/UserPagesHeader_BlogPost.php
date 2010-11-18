<?php if ( empty( $isUserProfilePageExt ) ) { ?>
	<div id="WikiaUserPagesHeader" class="WikiaUserPagesHeader WikiaBlogPostHeader">
		<?= wfRenderModule('CommentsLikes', 'Index', array('comments' => $comments, 'likes' => $likes)); ?>
		<?php
			if (!empty($actionMenu['action'])) {
				echo wfRenderModule('MenuButton', 'Index', array(
					'action' => $actionMenu['action'],
					'dropdown' => $actionMenu['dropdown'],
					'image' => MenuButtonModule::EDIT_ICON,
				));
			}
		?>
		<h1><?= htmlspecialchars($title) ?></h1>

		<details>
			<?= $avatar ?>
			<span class="post-author"><a href="<?= htmlspecialchars($userPage) ?>"><?= htmlspecialchars($userName) ?></a></span>
			<span><?= $editTimestamp ?></span>
		</details>
	</div>
<?php } else { ?>
	<div id="WikiaUserPagesHeader" class="WikiaUserPagesHeader">
		<!-- UserProfilePage Extension /BEGIN -->
		<?= wfRenderModule( 'UserProfilePage', 'Masthead', array( 'userName' => $userName, 'userPage' => $userPage, 'avatarMenu' => $avatarMenu, 'displayTitle' => $displaytitle, 'title' => $title, 'actionButton' => $actionButton, 'actionImage' => $actionImage, 'actionName' => $actionName, 'actionMenu' => $actionMenu, 'comments' => $comments, 'likes' => $likes, 'stats' => $stats ) ); ?>
		<!-- UserProfilePage Extension /END -->
	</div>
<?php } // isUserProfilePageExt ?>
