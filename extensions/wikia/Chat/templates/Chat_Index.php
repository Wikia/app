<!doctype html>
<html lang="en">
<head>
	<title><?= $roomName ?>: <?= $roomTopic ?></title>

	<!-- Make IE recognize HTML5 tags. -->
	<!--[if IE]>
		<script>/*@cc_on'abbr article aside audio canvas details figcaption figure footer header hgroup mark menu meter nav output progress section summary time video'.replace(/\w+/g,function(n){document.createElement(n)})@*/</script>
	<![endif]-->

	<!-- CSS -->
	<link rel="stylesheet" href="<?= AssetsManager::getInstance()->getSassCommonURL('/extensions/wikia/Chat/css/Chat.scss')?>">
	
	<!-- JS -->
	<?= $globalVariablesScript ?>
	<script>
		var roomId = <?= $roomId ?>;
		var wgChatMod = <?= $isChatMod ?>;
		var WIKIA_NODE_HOST = '<?= $nodeHostname ?>'; // used in controllers.js to set up the socket connection.
	</script>
</head>
<body class="<?= $bodyClasses ?>">
	<div id="content">
		<script type='text/template' id='message-template'>
			<img class="avatar" src="<%= avatarSrc %>"/>
			<span class="user"><%= name %></span>
			<span class="message"><%= text %></span>
		</script>
		<script type='text/template' id='inline-alert-template'>
			<%= text %>
		</script>

		<section id="WikiaPage" class="WikiaPage">

			<div id="Chat" class="Chat">
				<ul></ul>
			</div>

			<script type='text/template' id='user-template'>
				<img src="<%= avatarSrc %>"/>
				<span class="user"><%= name %></span>
				<span class="status"><%= status %></span>
				<a href="#" class="kickban">k/b</a>
			</script>

			<div id="Users" class="Users">
				<ul></ul>
			</div>

			<form id="Write" class="Write" onsubmit="return false">
				<input type="text" name="message"/>
				<input type="submit" value="send" class="wikia-button"/>
			</form>

		</section>
	</div>

	<!-- Load these after the DOM is built -->
	<script src="<?= $wgStylePath ?>/common/jquery/jquery-1.5.js"></script>
	<!--<script src="<?= $wgExtensionsPath ?>/wikia/Chat/js/Chat.js"></script>-->
	<script src="<?= $wgExtensionsPath ?>/wikia/Chat/js/lib/underscore.js"></script>
	<script src="<?= $wgExtensionsPath ?>/wikia/Chat/js/lib/backbone.js"></script>
	<script src="<?= $wgExtensionsPath ?>/wikia/Chat/js/socket.io/socket.io.js"></script>
	<script src="<?= $wgExtensionsPath ?>/wikia/Chat/js/models/models.js"></script>
	<script src="<?= $wgExtensionsPath ?>/wikia/Chat/js/controllers/controllers.js"></script>
	<script src="<?= $wgExtensionsPath ?>/wikia/Chat/js/views/views.js"></script>

</body>
</html>
