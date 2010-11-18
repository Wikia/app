<div class="wikia-avatar">
	<a href="<?= htmlspecialchars($data['userPage']) ?>" class="avatar-link"><?= $avatar ?></a>
	<? if (!empty($data['avatarMenu'])) :?>
		<div class="avatar-menu">
			<? foreach( $data['avatarMenu'] as $item ) :?>
				<span>
					<img class="sprite edit-pencil" src="<?= wfBlankImgUrl() ;?>"/>
					<?= $item ?>
				</span>
			<? endforeach ;?>
		</div>
	<? endif ;?>
</div>
<? if(!empty($userRights)) :?>
	<ul class="user-groups">
		<? foreach ( $userRights as $rightName ) :?>
			<li><a title="<?= wfMsg("userprofilepage-user-group-{$rightName}-tooltip") ;?>"><?= wfMsg('userprofilepage-user-group-' . $rightName) ;?></a></li>
		<? endforeach ;?>
	</ul>
<? endif ;?>
<h1><?= $data['displayTitle'] != "" ? $data['title'] : htmlspecialchars($data['title']) ?></h1>
<?= wfRenderModule('CommentsLikes', 'Index', array( 'comments' => ( isset($data['comments']) ? $data['comments'] : null ), 'likes' => $data['likes'] )); ?>

<?php
	// render edit button / dropdown menu
	if (!empty($data['actionButton'])) {
		echo wfRenderModule('MenuButton', 'Index', array(
			'action' => $data['actionButton'],
			'image' => $data['actionImage'],
			'name' => $data['actionName'],
		));
	}
	else if (!empty($data['actionMenu'])) {
		echo wfRenderModule('MenuButton', 'Index', array(
			'action' => $data['actionMenu']['action'],
			'image' => $data['actionImage'],
			'dropdown' => $data['actionMenu']['dropdown'],
			'name' => $data['actionName'],
		));
	}
?>

<? if (!empty($data['stats'])) :?>
	<div class="edits-info">
		<span class="count"><?= $data['stats']['edits']; ?></span>
		<span class="date"><?= wfMsg( 'userprofilepage-edits-since', $data['stats']['date'] ) ;?></span>
	</div>
	<?php if( count($lastActionData) ): ?>
		<div class="last-action">
			<img src="<?= wfBlankImgUrl() ;?>" class="sprite <?= $lastActionData['changeicon'] ?>" height="20" width="20">
			<span class="last-action-title"><?= $lastActionData['changemessage']; ?></span>
			<span class="last-action-snippet"><i><?= $lastActionData['intro']; ?></i></span>
		</div>
	<?php endif; ?>
<? endif ;?>
