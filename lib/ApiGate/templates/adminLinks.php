<div class='sub_module'>
	<h2><?= i18n( 'apigate-adminlinks-header' ); ?></h2>
	<ul>
	<?php
		foreach($links as $link){?>
			<li><a href='<?= $link['href'] ?>'><?= $link['text'] ?></a></li><?php
		} ?>
	</ul>
</div>
