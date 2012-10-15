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
class PiggybackTemplate extends QuickTemplate {
	function execute() {
?>
	<table>
		<tr>
			<td class="mw-label"><label for='wpName1'><?php $this->msg('piggyback-otherusername') ?></label></td>
			<td class="mw-input">
				<input type='text' class='loginText' name="wpOtherName" id="wpOtherName1"
					value="<?php $this->text('otherName') ?>" size='20' />
			</td>
		</tr>
	</table>
	<div id="piggyback_userloginprompt"><p><?php  $this->msgWiki('piggyback-loginprompt') ?></p></div>
	
<?php }
	public function __toString() {
		ob_start();
		$this->execute();
		$out = ob_get_contents();
		ob_end_clean();
		return $out;
	} 
}
