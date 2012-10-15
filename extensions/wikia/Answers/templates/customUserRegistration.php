<?php
/**
 * @defgroup Templates Templates
 * @file
 * @ingroup Templates
 */
if( !defined( 'MEDIAWIKI' ) ) die( -1 );

/**
 * HTML template for Special:Userlogin form
 * @ingroup Templates
 */

/**
 * @ingroup Templates
 */
class customUsercreateTemplate extends QuickTemplate {
	function addInputItem( $name, $value, $type, $msg ) {
		$this->data['extraInput'][] = array(
			'name' => $name,
			'value' => $value,
			'type' => $type,
			'msg' => $msg,
		);
	}

	function execute() {

		global $wgOut, $wgStylePath;

		$wgOut->addScript('<link rel="stylesheet" type="text/css" href="'. $wgStylePath . '/wikia/common/NewUserRegister.css' . "\" />\n");

		if (!array_key_exists('message', $this->data)) {
			$this->data['message'] = "";
		}
		if (!array_key_exists('ajax', $this->data)) {
			$this->data['ajax'] = "";
		}
		if( $this->data['message'] && !$this->data['ajax'] ) {
?>
	<div class="<?php $this->text('messagetype') ?>box">
		<?php if ( $this->data['messagetype'] == 'error' ) { ?>
			<h2><?php $this->msg('loginerror') ?>:</h2>
		<?php } ?>
		<?php $this->html('message') ?>
	</div>
	<div class="visualClear"></div>
<?php } ?>
<div id="userlogin<?php if ($this->data['ajax']) { ?>Ajax<?php } ?>">
<form name="userlogin2" id="userlogin2" method="post" action="<?php $this->text('action') ?>" >
<?php		if( $this->data['message'] && $this->data['ajax'] ) { ?>
	<div class="<?php $this->text('messagetype') ?>box" style="margin:0">
		<?php if ( $this->data['messagetype'] == 'error' ) { ?>
			<h2><?php $this->msg('loginerror') ?>:</h2>
		<?php } ?>
		<?php $this->html('message') ?>
	</div>
	<div class="visualClear"></div>
<?php } ?>
	<p id="userloginlink"><?php $this->html('link') ?></p>
	<?php $this->html('header'); /* pre-table point for form plugins... */ ?>
	<?php if( @$this->haveData( 'languages' ) ) { ?><div id="languagelinks"><p><?php $this->html( 'languages' ); ?></p></div><?php } ?>

	<table width="100%">
		<colgroup>
			<col width="*" />
		</colgroup>
		<tr>
			<td class="mw-input" id="wpNameTD">
				<label for='wpName2'><?php $this->msg('yourname') ?></label><br/>
				<input type='text' class='loginText' name="wpName" id="wpName2"	value="<?php $this->text('name') ?>" size='20' />
				<span id="wpName2error" class="inputError"><?= wfMsg('noname') ?></span>
			</td>
		</tr>
		<tr>
			<?php if( $this->data['useemail'] ) { ?>
			<td class="mw-input" id="wpEmailTD">
				<label for='wpEmail'><?php $this->msg('youremail') ?></label><br/>
				<input type='text' class='loginText' name="wpEmail" id="wpEmail" value="<?php $this->text('email') ?>" size='20' />
				<div>
                                        <?php $this->msgWiki('prefs-help-email'); ?>
	                        </div>
			</td>
			<?php } ?>
		</tr>
		<tr>
			<td class="mw-input" id="wpPasswordTD">
				<label for='wpPassword2'><?php $this->msg('yourpassword') ?></label><br/>
				<input type='password' class='loginPassword' name="wpPassword" id="wpPassword2" value="" size='20' />
			</td>
		</tr>
	<?php if( $this->data['usedomain'] ) {
		$doms = "";
		foreach( $this->data['domainnames'] as $dom ) {
			$doms .= "<option>" . htmlspecialchars( $dom ) . "</option>";
		}
	?>
		<tr>
			<td class="mw-input">
				<?php $this->msg( 'yourdomainname' ) ?><br/>
				<select name="wpDomain" value="<?php $this->text( 'domain' ) ?>">
					<?php echo $doms ?>
				</select>
			</td>
		</tr>
	<?php } ?>
		<tr>
			<td class="mw-input" id="wpRetypeTD">
				<label for='wpRetype'><?php $this->msg('yourpasswordagain') ?></label><br/>
				<input type='password' class='loginPassword' name="wpRetype" id="wpRetype" value="" size='20' />
			</td>
		</tr>


	<?php if($this->haveData('captcha')) { ?>
		<tr>
			<td class="mw-input">
				<?php $this->html('captcha'); ?>
			</td>
		</tr>
	<?php } ?>
		<tr>
			<td class="mw-input">
				<input type='checkbox' name="wpRemember" value="1" id="wpRemember" <?php if( $this->data['remember'] ) { ?>checked="checked"<?php } ?>/>
				<label for="wpRemember"><?php $this->msg('remembermypassword') ?></label>
			</td>
		</tr>
<?php
		$tabIndex = 8;
		if ( isset( $this->data['extraInput'] ) && is_array( $this->data['extraInput'] ) ) {
			foreach ( $this->data['extraInput'] as $inputItem ) { ?>
		<tr>
			<td class="mw-input">
			<?php
				if ( !empty( $inputItem['msg'] ) && $inputItem['type'] != 'checkbox' ) {
					?><label for="<?php
					echo htmlspecialchars( $inputItem['name'] ); ?>"><?php
					$this->msgWiki( $inputItem['msg'] ) ?></label><?php
				}
			?><br/>
				<input type="<?php echo htmlspecialchars( $inputItem['type'] ) ?>" name="<?php
				echo htmlspecialchars( $inputItem['name'] ); ?>"
					tabindex="<?php echo $tabIndex++; ?>"
					value="<?php
				if ( $inputItem['type'] != 'checkbox' ) {
					echo htmlspecialchars( $inputItem['value'] );
				} else {
					echo '1';
				}
					?>" id="<?php echo htmlspecialchars( $inputItem['name'] ); ?>"
					<?php
				if ( $inputItem['type'] == 'checkbox' && !empty( $inputItem['value'] ) )
					echo 'checked="checked"';
					?> /> <?php
					if ( $inputItem['type'] == 'checkbox' && !empty( $inputItem['msg'] ) ) {
						?>
				<label for="<?php echo htmlspecialchars( $inputItem['name'] ); ?>"><?php
					$this->msg( $inputItem['msg'] ) ?></label><?php
					}
				?>
			</td>
		</tr>
<?php

			}
		}
?>
		<tr>
			<td class="mw-submit">
				<input type='submit' name="wpCreateaccount" id="wpCreateaccount"
					value="<?php $this->msg('createaccount') ?>" />
				<?php if( $this->data['createemail'] ) { ?>
				<input type='submit' name="wpCreateaccountMail" id="wpCreateaccountMail"
					value="<?php $this->msg('createaccountmail') ?>" />
				<?php } ?>
				<span id="wpFormerror" class="inputError"><?= wfMsg('userlogin-form-error') ?></span>

			</td>
		</tr>
		<?php if( $this->data['useemail'] ) { ?>
		<tr>
			<td class="mw-input" id="wpEmailTD">
				<div>
					<?php $this->msgWiki('prefs-help-terms'); ?>
				</div>
			</td>
		</tr>
		<?php } ?>
	</table>


<?php if( @$this->haveData( 'uselang' ) ) { ?><input type="hidden" name="uselang" value="<?php $this->text( 'uselang' ); ?>" /><?php } ?>
</form>
</div>
<div id="signupWhyProvide"></div>
<div id="signupend" style="clear: both;"><?php $this->msgWiki( 'signupend' ); ?></div>
<?php

	}
}
