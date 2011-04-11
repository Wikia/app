<section class="ChatModule empty module">
	<h1><?= $chatHeadline ?></h1>
	<div class="chat-live"><?= wfMsg('chat-live') ?></div>

	<? if ( !empty($totalInRoom) ) { ?>
	<div class="chat-whos-here">
		<h2><?= wfMsg('chat-whos-here', $totalInRoom) ?></h2>
		<?php if(!empty($avatarsInRoom)){ ?>
		<ul>
			<? foreach($avatarsInRoom as $avatarInRoom) { 
				echo "<li><img src='$avatarInRoom' class='avatar'/></li>";
			} ?>
		</ul>
		<?php } ?>
	</div>
	<? } ?>

	<div class="chat-join">
		<?= $profileAvatar ?>
		<button onclick="window.open('<?= $linkToSpecialChat ?>', 'wikiachat', '<?= $windowFeatures ?>')">
			<img src="<?= $buttonIconUrl ?>">
			<?= $buttonText ?>
		</button>
	</div>
</section>