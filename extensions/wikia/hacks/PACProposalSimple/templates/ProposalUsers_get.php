<h2>List of users for Wiki #ID=<?= $wikiId; ?>:</h2>
<ul>
	<?php foreach( $users as $userData ):?>
		<li><?= $userData['userName']; ?></li>
	<?php endforeach; ?>
</ul>

<i>I'm a template from "ProposalSimple" extension!</i>