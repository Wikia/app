<ul>
	<? foreach($members as $member): ?>
	<li><?= $member['name'] ?>
		<?= $app->renderView('VenusTest', 'member_data', ['data' => $member['data']]) ?>
	</li>
	<? endforeach ?>
</ul>
