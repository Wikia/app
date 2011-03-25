<div style="width: 45%; border: 1px dotted gray; padding: 10px;" id="dashboardUsers">
	<h3>Users:</h3>
	<ul>
		<?php foreach( $users as $userData ):?>
			<li><a href="?wikiId=<?= $wikiId; ?>&userId=<?= $userData['userId']; ?>" class="proposalUserLink" id="proposalUserId<?= $userData['userId']; ?>"><?= $userData['userName']; ?></a></li>
		<?php endforeach; ?>
	</ul>
</div>
<div style="width: 45%; border: 1px dotted gray; padding: 10px; float left;" id="dashboardPages">
	<h3>Pages for User #ID=<?= $userId; ?>:</h3>
	<ul>
		<?php foreach( $pages as $pageData ):?>
			<li><a href="<?= $pageData['pageUrl']; ?>"><?= $pageData['pageName']; ?></a></li>
		<?php endforeach; ?>
	</ul>
</div>
