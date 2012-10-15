<div class='sub_module'>
	<h3><?= i18n( 'apigate-adminlinks-header' ); ?></h3>
	<ul>
	<?php
		foreach($links as $link){?>
			<li><a href='<?= $link['href'] ?>'><?= $link['text'] ?></a></li><?php
		} ?>
	</ul>
</div>
