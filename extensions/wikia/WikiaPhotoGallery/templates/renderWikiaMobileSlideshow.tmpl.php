<section class=wkImgStk data-img-count=<?=$count;?>
		<?php
		foreach ( $images as $key => $val) {
			echo " data-img-{$key}='{$val[0]}'" . ( $val[1]  ? " data-cap-{$key}='{$val[1]}'" : "");
		}
		?>>
<img class=wkPlcImg src=<?=$images[0][0]?>><footer><?=$footerText?></footer></section>