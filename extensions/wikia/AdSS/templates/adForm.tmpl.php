<form method="post" action="<?php echo $action; ?>">
  <input name="wpToken" type="hidden" value="<?php echo $token; ?>" />
  <input name="wpType" type="hidden" value="site" />
  <table>
    <tr>
      <td class="mw-label"><label for="wpUrl"><?php echo wfMsgHtml( 'adss-form-url' ); ?></label></td>
      <td class="mw-input"><?php $ad->error( 'wpUrl' ); ?>http://<input type="text" name="wpUrl" size="30" value="<?php $ad->output( 'wpUrl' ); ?>" /></td>
    </tr>
    <tr>
      <td class="mw-label"><label for="wpText"><?php echo wfMsgHtml( 'adss-form-linktext' ); ?></label></td>
      <td class="mw-input"><?php $ad->error( 'wpText' ); ?><input type="text" name="wpText" size="30" value="<?php $ad->output( 'wpText' ); ?>" /></td>
    </tr>
    <tr>
      <td class="mw-label"><label for="wpDesc"><?php echo wfMsgHtml( 'adss-form-additionaltext' ); ?></label></td>
      <td class="mw-input"><?php $ad->error( 'wpDesc' ); ?><textarea name="wpDesc" cols="30"><?php $ad->output( 'wpDesc' ); ?></textarea></td>
    </tr>
    <tr>
      <td class="mw-label"><label><?php echo wfMsgHtml( 'adss-form-price' ); ?></label></td>
      <td id="wpPrice"><?php echo $ad->formatPrice( $priceConf ); ?></td>
    </tr>
    <tr>
      <td class="mw-label"><label for="wpEmail"><?php echo wfMsgHtml( 'adss-form-email' ); ?></label></td>
      <td class="mw-input"><?php $ad->error( 'wpEmail' ); ?><input type="text" name="wpEmail" value="<?php $ad->output( 'wpEmail' ); ?>" /></td>
    </tr>
    <tr>
      <td></td>
      <td class="mw-submit"><input type="submit" name="wpSubmit" value="<?php echo $submit; ?>" /></td>
    </tr>
  </table>
</form>

