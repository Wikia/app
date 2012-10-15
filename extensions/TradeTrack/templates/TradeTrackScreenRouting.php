<?php

class TradeTrackScreenRouting extends TradeTrackScreen { public function execute() { ?>

<?php echo wfMsg( 'tradetrack-overview' ) ?>


<form method="post" action="<?php echo $this->data['tData']['formURL'] ?>" class="tradetrack-master" id="tradetrack-form">
  <input type="hidden" name="doaction" value="route" />
  <div id="tradetrack-screens">

	<p class="tradetrack-f-r"><?php echo wfMsg( 'tradetrack-all-fields-required' ) ?></p>
  	<?php if ( $this->data['errors'] ) { ?>
  	<div class="tradetrack-errornotice">
    	<?php echo wfMsg( 'tradetrack-errors-have-happened' ) ?>
    	<?php $this->showErrors( 'global' ) ?>
  	</div>
  	<?php } ?>
	<div class="<?php echo ( $this->hasError( 'tradetrack-purpose' ) ? 'tradetrack-element-error' : 'tradetrack-element' ) ?>">
      <label class="tradetrack-question-label"><?php echo wfMsg( 'tradetrack-purpose-question' ) ?></label><br style="clear:both" />
      <?php $this->showErrors( 'tradetrack-purpose' ) ?>
      <ul class="tradetrack-element-list">
        <li><input type="radio" name="tradetrack-purpose" value="Commercial" />
            <?php echo wfMsg( 'tradetrack-purpose-label-commercial' ) ?> <?php echo wfMsg( 'tradetrack-purpose-expanse-commercial' ) ?></li>
        <li><input type="radio" name="tradetrack-purpose" value="Non-Commercial" />
            <?php echo wfMsg( 'tradetrack-purpose-label-noncommercial' ) ?> <?php echo wfMsg( 'tradetrack-purpose-expanse-noncommercial' ) ?></li>
        <li><input type="radio" name="tradetrack-purpose" value="Media" />
            <?php echo wfMsg( 'tradetrack-purpose-label-media' ) ?> <?php echo wfMsg( 'tradetrack-purpose-expanse-media' ) ?></li>
      </ul>
    </div>
    <div class="tradetrack-button-box">
      <button type="submit" class="tradetrack-button"><?php echo wfMsg( 'tradetrack-button-continue' ) ?></button>
    </div> <!--  buttonbox -->
  </div> <!--  close screens -->
</form>

<?php } }