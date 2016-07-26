<!doctype html>
<html lang="en">
<head>
	<title><?= $pageTitle ?></title>
	<link rel="shortcut icon" href="<?= $wg->Favicon ?>">

	<!-- Make IE recognize HTML5 tags. -->
	<!--[if IE]>
		<script>/*@cc_on'abbr article aside audio canvas details figcaption figure footer header hgroup mark menu meter nav output progress section summary time video'.replace(/\w+/g,function(n){document.createElement(n)})@*/</script>
	<![endif]-->

	<!-- CSS -->
	<link rel="stylesheet" href="<?= AssetsManager::getInstance()->getSassCommonURL( '/extensions/wikia/Chat2/css/Chat.scss' )?>">
	<link rel="stylesheet" href="/load.php?lang=en&mode=articles&articles=MediaWiki%3AChat.css%7CUser%3A<?php echo $wg->User->getName(); ?>%2Fchat.css&only=styles">

	<!-- JS -->
	<?php
		$srcs = AssetsManager::getInstance()->getGroupCommonURL( 'oasis_blocking', array() );
	?>
	<?php foreach ( $srcs as $src ): ?>
		<script src="<?php echo $src ?>"></script>
	<?php endforeach; ?>

	<!-- temporary hack -->
	<script src="<?= AssetsManager::getInstance()->getOneCommonURL( '/extensions/wikia/Chat2/js/lib/socket.io-1.3.5.js' ); ?>"></script>
	<?= $globalVariablesScript ?>
	<?php // TODO: use js var?>

</head>
<body class="<?= $bodyClasses ?> ChatWindow">

	<header id="ChatHeader" class="ChatHeader">
		<h1 class="public wordmark">
			<a href="<?= $mainPageURL ?>">
			<? if ( $themeSettings['wordmark-type'] == 'graphic' ) { ?>
			<img width="<?= ChatController::CHAT_WORDMARK_WIDTH ?>" height="<?= ChatController::CHAT_WORDMARK_HEIGHT ?>" src="<?= $wordmarkThumbnailUrl ?>">
			<? } else { ?>
			<span class="font-<?= $themeSettings['wordmark-font']?>"><?= $themeSettings['wordmark-text'] ?></span>
			<? } ?>
			</a>
		</h1>
		<h1 class="private"></h1>
		<div class="User"></div>
	</header>

	<section id="WikiaPage" class="WikiaPage">

		<div id="Rail" class="Rail">
			<h1 class="public wordmark selected">
				<img src="<?= $wg->BlankImgUrl ?>" class="chevron">
				<? if ( $themeSettings['wordmark-type'] == 'graphic' ) { ?>
				<img width="<?= ChatController::CHAT_WORDMARK_WIDTH ?>" height="<?= ChatController::CHAT_WORDMARK_HEIGHT ?>" src="<?= $wordmarkThumbnailUrl ?>" class="wordmark">
				<? } else { ?>
				<span class="font-<?= $themeSettings['wordmark-font']?>"><?= $themeSettings['wordmark-text'] ?></span>
				<? } ?>
				<span id="MsgCount_<?php echo $roomId ?>" class="splotch">0</span>
			</h1>
			<ul id="WikiChatList" class="WikiChatList"></ul>
			<h1 class="private"><?= wfMessage( 'chat-private-messages' )->escaped() ?></h1>
			<ul id="PrivateChatList" class="PrivateChatList"></ul>
		</div>

		<form id="Write" class="Write" onsubmit="return false">
			<div class="remaining"></div>
			<img width="<?= ChatController::CHAT_AVATAR_DIMENSION ?>" height="<?= ChatController::CHAT_AVATAR_DIMENSION ?>" src="<?= $avatarUrl ?>">
			<div class="message">
				<textarea name="message"></textarea>
			</div>
			<input type="submit">
		</form>

	</section>

	<div id="UserStatsMenu" class="UserStatsMenu"></div>

	<!-- HTML Templates -->
	<script type='text/template' id='message-template'>
		<img width="<?= ChatAjax::CHAT_AVATAR_DIMENSION ?>" height="<?= ChatAjax::CHAT_AVATAR_DIMENSION ?>" class="avatar" src="<%= avatarSrc %>"/>
		<span class="time"><%= timeStamp %></span>
		<span class="username"><%= name %></span>
		<span class="message"><%= text %></span>
	</script>
	<script type='text/template' id='me-message-template'>
		<img width="<?= ChatAjax::CHAT_AVATAR_DIMENSION ?>" height="<?= ChatAjax::CHAT_AVATAR_DIMENSION ?>" class="avatar" src="<%= avatarSrc %>"/>
		<span class="time"><%= timeStamp %></span>
		<span class="username"><%= name %></span>
		<span class="message me-message"><span class="me-username">* <span><%= name %></span></span> <%= text %></span>
	</script>
	<script type='text/template' id='inline-alert-template'>
		<%= text %>
	</script>
	<script type='text/template' id='user-template'>
		<img src="<%= avatarSrc %>"/>
		<span class="username"><%= name %></span>
		<div class="details">
			<span class="status"><?= wfMessage( 'chat-status-away' )->escaped(); ?></span>
		</div>
		<% if(isPrivate) { %>
			<span id="MsgCount_<%= roomId %>" class="splotch">0</span>
		<% } %>
		<div class="UserStatsMenu">
			<div class="info">
				<img src="<%= avatarSrc %>"/>
				<ul>
					<li class="username"><%= name %></li>
					<li class="edits"><?= wfMessage( 'chat-edit-count' )->rawParams("<%= editCount %>")->escaped() ?></li>
					<% if (since) { %>
						<li class="since"><?= wfMessage( 'chat-member-since' )->rawParams("<%= since %>")->escaped() ?></li>
					<% } %>
				</ul>
			</div>
			<div class="actions"></div>
		</div>
	</script>
	<script type='text/template' id='user-action-template'>
		<li class="<%= actionName %>">
			<a href="<%= actionUrl %>">
				<span class="icon">&nbsp;</span>
				<span class="label"><%= actionDesc %></span>
			</a>
		</li>
	</script>
	<script type='text/template' id='user-action-template-no-url'>
		<li class="<%= actionName %>">
			<span class="icon">&nbsp;</span>
			<span class="label"><%= actionDesc %></span>
		</li>
	</script>
	<!-- Load these after the DOM is built -->
	<?php
		$srcs = AssetsManager::getInstance()->getGroupCommonURL( 'chat_js2', array() );
	?>
	<?php foreach ( $srcs as $src ): ?>
		<script src="<?php echo $src ?>"></script>
	<?php endforeach; ?>
	<script type="text/javascript" src="/load.php?lang=en&mode=articles&articles=MediaWiki%3AChat.js%7CUser%3A<?php echo $wg->User->getName(); ?>%2Fchat.js&only=scripts"></script>
</body>
</html>
