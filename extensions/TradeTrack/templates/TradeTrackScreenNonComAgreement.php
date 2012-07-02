<?php
class TradeTrackScreenNonComAgreement extends TradeTrackScreen { public function execute() { ?>

<?php echo wfMsg( 'tradetrack-overview' ) ?>

<form method="post" action="<?php echo $this->data['tData']['formURL'] ?>" class="tradetrack-master" id="tradetrack-form">
  <input type="hidden" name="doaction" value="noncomroute" />
  <input type="hidden" name="tradetrack-purpose" value="<?php echo $this->data['tData']['purpose'] ?>" />
  
  <div id="tradetrack-screens">

	<p class="tradetrack-f-r"><?php echo wfMsg( 'tradetrack-all-fields-required' ) ?></p>
  	<?php if ( $this->data['errors'] ) { ?>
  	<div class="tradetrack-errornotice">
    	<?php echo wfMsg( 'tradetrack-errors-have-happened' ) ?>
    	<?php $this->showErrors( 'global' ) ?>
  	</div>
  	<?php } ?>
	<div class="<?php echo ( $this->hasError( 'tradetrack-elements-agreement' ) ? 'tradetrack-element-error' : 'tradetrack-element' ) ?>">

      <label class="tradetrack-question-label"><?php echo wfMsg( 'tradetrack-nonprofit-preexisting-agreement-question' ) ?></label>
      <br style="clear:both" />
      <?php $this->showErrors( 'tradetrack-elements-agreement' ) ?>
    
      <ul class="tradetrack-element-list">
        <li><input type="radio" name="tradetrack-elements-agreement" value="Yes" />
            <?php echo wfMsg( 'tradetrack-nonprofit-preexisting-agreement-yes' ) ?></li>
        <li><input type="radio" name="tradetrack-elements-agreement" value="No" />
            <?php echo wfMsg( 'tradetrack-nonprofit-preexisting-agreement-no-unaffilliated' ) ?></li>
        <li><input type="radio" name="tradetrack-elements-agreement" value="Mistake" />
            <?php echo wfMsg( 'tradetrack-nonprofit-preexisting-agreement-no-mistake' ) ?></li>
      </ul>
    </div>
    <div class="tradetrack-button-box">
      <button id="tradetrack-elements-back" class="tradetrack-button"><?php echo wfMsg( 'tradetrack-button-back' ) ?></button>
      <button type="submit" class="tradetrack-button"><?php echo wfMsg( 'tradetrack-button-continue' ) ?></button>
    </div> <!--  buttonbox -->
  </div> <!--  close screens -->
</form>

<?php } }