<ul>
	<li><strong>Age:</strong> <?= $data['age'] ?></li>
	<li><strong>Gender:</strong> <?= $data['gender'] ?></li>
	<li><strong>Food:</strong><ul>
			<? foreach($data['food'] as $food): ?>
			<li><?= $food ?></li>
			<? endforeach ?>
		</ul>
	</li>
</ul>
