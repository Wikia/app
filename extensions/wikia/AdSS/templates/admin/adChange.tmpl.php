<?php if( ( $ad->url != $adc->url ) || ( $ad->text != $adc->text ) ): ?>
<a href="http://<?php echo htmlspecialchars( $ad->url );?>" rel="nofollow"><strike><?php echo htmlspecialchars( $ad->text );?></strike></a>
<a href="http://<?php echo htmlspecialchars( $adc->url );?>" rel="nofollow"><?php echo htmlspecialchars( $adc->text );?></a>
<br />
<?php else: ?>
<a href="http://<?php echo htmlspecialchars( $ad->url );?>" rel="nofollow"><?php echo htmlspecialchars( $ad->text );?></a><br />
<?php endif; ?>
<?php if( $ad->desc != $adc->desc ): ?>
<strike><?php echo htmlspecialchars( $ad->desc );?></strike>
<?php echo htmlspecialchars( $adc->desc );?>
<?php else: ?>
<?php echo htmlspecialchars( $ad->desc );?>
<?php endif; ?>
