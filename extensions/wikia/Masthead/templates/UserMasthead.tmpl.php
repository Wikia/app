<?php
global $wgStyleVersion, $wgExtensionsPath, $wgTitle, $wgUser;
?>

<div id="user_masthead" class="accent reset clearfix">
	<?= $avatar ?>

<?php if (count($avatarActions)) { ?>
	<div class="avatarOverlay" style="visibility: hidden;" id="wk-avatar-change" onmouseover="this.style.visibility='visible';" onmouseout="this.style.visibility='hidden';">
		<div id="wk-avatar-arrow"></div>
		<div id="wk-avatar-border-blocker"></div>
		<div id="wk-avatar-menu">
			<div id="wk-avatar-username"><?=$data['userspace']?></div>
			<ul>
<?php	foreach ($avatarActions as $action) { ?>
				<li onclick="WET.byStr('usermasthead/<?= $action['tracker'] ?>');"><a href="<?= $action['href'] ?>"><?= $action['text'] ?></a></li>
<?php	} ?>
			</ul>
		</div>
	</div>
<?php } ?>

	<div id="user_masthead_head" class="clearfix">
		<h2><?= $username ?>
<?php if ($anonymousUser) { ?>
		<small id="user_masthead_anon"><?= $anonymousUser ?></small>
<?php } else { ?>
		<small><?= $data['edit_counter'] ?> <?= $data['edit_since'] ?> <?= $data['edit_date'] ?></small>
<?php } ?>
		</h2>
	</div>
<?php if (!$anonymousUser) { ?>
	<div id="user_masthead_scorecard" class="dark_text_1"><?= $data['edit_counter'] ?></div>
<?php } ?>
	<ul class="nav_links">
		<?php
		foreach ($data['nav_links'] as $navLink) {
					echo "<li class=\"color1". ( ( $current  == $navLink[ "dbkey" ]) ? ' selected' : "" ) . '"><a href="'. $navLink['href'] .'" onclick="WET.byStr(\'usermasthead/' . $navLink['tracker'] . '\')" rel="nofollow">'. $navLink['text'] .'</a></li>';
		}
		?>
	</ul>
</div>
