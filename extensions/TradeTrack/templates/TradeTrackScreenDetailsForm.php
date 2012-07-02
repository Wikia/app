<?php
class TradeTrackScreenDetailsForm extends TradeTrackScreen { public function execute() { ?>

<?php echo wfMsg( 'tradetrack-overview' ) ?>

<form method="post" action="<?php echo $this->data['tData']['formURL'] ?>" class="tradetrack-master" id="tradetrack-form">
  <input type="hidden" name="doaction" value="details" />
  <input type="hidden" name="tradetrack-purpose" value="<?php echo $this->data['tData']['purpose'] ?>" />
  <?php if ( isset ( $this->data['tData']['agreementType'] ) ) { ?>
  <input type="hidden" name="tradetrack-elements-agreement" value="<?php echo $this->data['tData']['agreementType'] ?>" />
  <?php } ?>
  
  <div id="tradetrack-screens">
	<p class="tradetrack-f-r"><?php echo wfMsg( 'tradetrack-all-fields-required' ) ?></p>
  	<?php if ( $this->data['errors'] ) { ?>
  	<div class="tradetrack-errornotice">
    	<?php echo wfMsg( 'tradetrack-errors-have-happened' ) ?>
    	<?php $this->showErrors( 'global' ) ?>
  	</div>
  	<?php } ?>

	<div class="<?php echo ( $this->hasError( 'tradetrack-elements-usage' ) ? 'tradetrack-element-error' : 'tradetrack-element' ) ?>">
      <label class="tradetrack-question-label"><?php echo wfMsg( 'tradetrack-usage-label' ) ?></label>
      <span class="tradetrack-field-hint"
      	  title="<?php echo wfMsg( 'tradetrack-usage-expanse' ) ?>"
    	  original-title="<?php echo wfMsg( 'tradetrack-usage-expanse' ) ?>"></span><br style="clear:both" />
      <?php $this->showErrors( 'tradetrack-elements-usage' ) ?>
      <textarea rows="5" id="tradetrack-elements-usage-textarea" name="tradetrack-elements-usage"><?php echo $this->data['tData']['usage'] ?></textarea><br />
      <div class="characters-remaining-box"><span id="tradetrack-elements-usage-count"></span> <?php echo wfMsg( 'tradetrack-characters-remaining-notice' ); ?></div>
    </div>
	<div class="<?php echo ( ( ( $this->hasError( 'tradetrack-element-list' ) ) || ( $this->hasError( 'tradetrack-elements-otherval' ) ) ) ? 'tradetrack-element-error' : 'tradetrack-element' ) ?>">
      <label class="tradetrack-question-label"><?php echo wfMsg( 'tradetrack-logo-which' ) ?></label><br />
      <?php $this->showErrors( 'tradetrack-element-list' ) ?>
      <?php $this->showErrors( 'tradetrack-elements-otherval' ) ?>
      <ul class="tradetrack-element-list">
  	  <?php foreach ( $this->data['tData']['TRADEMARK_LIST'] as $trademark ) { ?>

        <li><input type="checkbox" name="tradetrack-which-<?php echo $trademark ?>" value="true"
          <?php if ( ( isset( $this->data['tData']['trademarks'] ) )
                     &&  ( in_array( $trademark, $this->data['tData']['trademarks'] ) ) ) { ?>
      	    checked="checked"
      	  <?php } ?>

      	  /><?php echo wfMsg( "tradetrack-which-$trademark" ) ?>
      	  <?php if ( $trademark == 'other' ) { ?>
      	    <input type="text" name="tradetrack-elements-otherval" maxlength="200" value="<?php echo $this->data['tData']['otherval'] ?>" />
      	  <?php } ?>
        </li>
	  <?php } ?>
      </ul>
  	</div>

	<div class="<?php echo ( $this->hasError( 'tradetrack-elements-mailingaddress' ) ? 'tradetrack-element-error' : 'tradetrack-element' ) ?>">
      <label class="tradetrack-question-label"><?php echo wfMsg( 'tradetrack-about-label-mailingaddress' ) ?></label>
      <span class="tradetrack-field-hint"
    	  title="<?php echo wfMsg( 'tradetrack-about-expanse-mailingaddress' ) ?>"
    	  original-title="<?php echo wfMsg( 'tradetrack-about-expanse-mailingaddress' ) ?>"></span><br style="clear:both" />
      <?php $this->showErrors( 'tradetrack-elements-mailingaddress' ) ?>
      <textarea rows="5" id="tradetrack-elements-mailingaddress-textarea" name="tradetrack-elements-mailingaddress"><?php echo $this->data['tData']['mailingaddress'] ?></textarea><br />
      <div class="characters-remaining-box"><span id="tradetrack-elements-mailingaddress-count"></span> <?php echo wfMsg( 'tradetrack-characters-remaining-notice' ); ?></div>
    </div>
	<div class="<?php echo ( $this->hasError( 'tradetrack-elements-name' ) ? 'tradetrack-element-error' : 'tradetrack-element' ) ?>">
      <label class="tradetrack-question-label"><?php echo wfMsg( 'tradetrack-about-label-yourname' ) ?></label><br />
      <?php $this->showErrors( 'tradetrack-elements-name' ) ?>
      <input type="text" name="tradetrack-elements-name" maxlength="200" value="<?php echo $this->data['tData']['name'] ?>" /><br />
    </div>
	<div class="<?php echo ( $this->hasError( 'tradetrack-elements-orgname' ) ? 'tradetrack-element-error' : 'tradetrack-element' ) ?>">
      <label class="tradetrack-question-label"><?php echo wfMsg( 'tradetrack-about-label-orgname' ) ?></label>
      <span class="tradetrack-field-hint"
    	  title="<?php echo wfMsg( 'tradetrack-about-expanse-orgname' ) ?>"
    	  original-title="<?php echo wfMsg( 'tradetrack-about-expanse-orgname' ) ?>"></span><br style="clear:both" />
      <?php $this->showErrors( 'tradetrack-elements-orgname' ) ?>
      <input type="text" name="tradetrack-elements-orgname" maxlength="200" value="<?php echo $this->data['tData']['orgname'] ?>" /><br />
    </div>
	<div class="<?php echo ( $this->hasError( 'tradetrack-elements-email' ) ? 'tradetrack-element-error' : 'tradetrack-element' ) ?>">
      <label class="tradetrack-question-label"><?php echo wfMsg( 'tradetrack-about-label-e-mail' ) ?></label>
      <span class="tradetrack-field-hint"
    	  title="<?php echo wfMsg( 'tradetrack-about-expanse-e-mail' ) ?>"
    	  original-title="<?php echo wfMsg( 'tradetrack-about-expanse-e-mail' ) ?>"></span><br style="clear:both" />
      <?php $this->showErrors( 'tradetrack-elements-email' ) ?>
      <input type="text" name="tradetrack-elements-email" maxlength="200" value="<?php echo $this->data['tData']['email'] ?>" /><br />
    </div>
	<div class="<?php echo ( $this->hasError( 'tradetrack-elements-confirme-mail' ) ? 'tradetrack-element-error' : 'tradetrack-element' ) ?>">
      <label class="tradetrack-question-label"><?php echo wfMsg( 'tradetrack-about-label-confirme-mail' ) ?></label>
      <span class="tradetrack-field-hint"
    	  title="<?php echo wfMsg( 'tradetrack-about-expanse-confirme-mail' ) ?>"
    	  original-title="<?php echo wfMsg( 'tradetrack-about-expanse-confirme-mail' ) ?>"></span><br style="clear:both" />
      <?php $this->showErrors( 'tradetrack-elements-confirmemail' ) ?>
      <input type="text" name="tradetrack-elements-confirmemail" maxlength="200" value="<?php echo $this->data['tData']['confirmemail'] ?>" /><br />
    </div>
	<div class="<?php echo ( $this->hasError( 'tradetrack-elements-phone' ) ? 'tradetrack-element-error' : 'tradetrack-element' ) ?>">
      <label class="tradetrack-question-label"><?php echo wfMsg( 'tradetrack-about-label-phone' ) ?></label><br style="clear:both" />
      <?php $this->showErrors( 'tradetrack-elements-phone' ) ?>
      <input type="text" name="tradetrack-elements-phone" maxlength="200" value="<?php echo $this->data['tData']['phone'] ?>" /><br />
    </div>
	<div class="<?php echo ( $this->hasError( 'tradetrack-statement-value' ) ? 'tradetrack-element-error' : 'tradetrack-element' ) ?>">
      <label class="tradetrack-question-label"><?php echo wfMsg( 'tradetrack-statement-label' ) ?></label><br />
      <span class="tradetrack-question-expanse"><?php echo wfMsg( 'tradetrack-statement-expanse' ) ?></span><br />
      <?php $this->showErrors( 'tradetrack-statement-value' ) ?>
      <ul class="tradetrack-element-list">
        <li><input type="checkbox"
      			name="tradetrack-elements-statementagreement"
      			value="true"
      			<?php echo ( $this->data['tData']['statementagreement'] == "true" ) ? 'checked="checked"' : "" ?>
      			/>
      			<?php echo wfMsg( 'tradetrack-statement-checkboxlabel' ) ?>
        </li>
      </ul>
    </div>
    <div class="tradetrack-button-box">
      <button type="submit" class="tradetrack-button"><?php echo wfMsg( 'tradetrack-button-submit' ) ?></button>
    </div> <!--  buttonbox -->
  </div> <!--  close screen -->
</form>

<?php } }