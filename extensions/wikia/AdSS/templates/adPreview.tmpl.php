<?php echo wfMsgWikiHtml( 'adss-preview-header' ); ?>
<table>
  <tr><td><?php echo wfMsgHtml( 'adss-form-type' ); ?></td><td><?php echo wfMsgHtml( 'adss-per-'.$type ); ?></td></tr>
  <?php if($title): ?>
  <tr><td><?php echo wfMsgHtml( 'adss-form-page' ); ?></td><td><?php echo $title->getText(); ?></td></tr>
  <?php endif; ?>
  <tr><td><?php echo wfMsgHtml( 'adss-form-price' ); ?></td><td><?php echo AdSS_AdForm::formatPrice( $priceConf ); ?></td></tr>
  <tr><td><?php echo wfMsgHtml( 'adss-form-email' ); ?></td><td><?php echo htmlspecialchars( $ad->email ); ?></td></tr>
</table>
<?php echo wfMsgWikiHtml( 'adss-preview-prompt' ); ?>
<form method="post" action="<?php echo $action; ?>">
  <input type="hidden" name="wpToken" value="<?php echo $token; ?>" />
  <input type="hidden" name="wpUrl" value="<?php echo htmlspecialchars( $ad->url ); ?>" />
  <input type="hidden" name="wpText" value="<?php echo htmlspecialchars( $ad->text ); ?>" />
  <input type="hidden" name="wpDesc" value="<?php echo htmlspecialchars( $ad->desc ) ; ?>" />
  <input type="hidden" name="wpType" value="<?php echo htmlspecialchars( $type ) ; ?>" />
  <?php if($title): ?>
  <input type="hidden" name="wpPage" value="<?php echo htmlspecialchars( $title->getText() ) ; ?>" />
  <?php endif; ?>
  <input type="hidden" name="wpEmail" value="<?php echo htmlspecialchars( $ad->email ) ; ?>" />
  <input type="submit" name="wpSubmit" value="<?php echo $submit_edit; ?>" />
  <input type="submit" name="wpSubmit" value="<?php echo $submit_save; ?>" />
</form>
<?php echo wfMsgWikiHtml( 'adss-ad-header' ); ?>
<ul>
<?php echo $ad->render(); ?>
</ul>
