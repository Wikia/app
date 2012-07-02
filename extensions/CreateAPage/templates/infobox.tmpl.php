<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}
?>
<!-- s:<?php echo __FILE__ ?> -->
<fieldset id="cp-infobox-fieldset">
<legend><?php echo wfMsg( 'createpage-infobox-legend' ) ?> <span style="font-size: small; font-weight: normal; margin-left: 5px">[<a id="cp-infobox-toggle" title="toggle" href="#"><?php echo wfMsg( 'createpage-hide' ) ?></a>]</span></legend>
<div id="cp-infobox" style="display: block;">
<input type="hidden" id="wpInfoboxValue" name="wpInfoboxValue" value="<?php echo htmlspecialchars( $infoboxes ) ?>" />
<?php
$inf_par_num = 0;
$inf_image_num = 0;

foreach ( $inf_pars as $inf_par ) {
	$inf_par = preg_replace( "/=/", "<!---equals--->", $inf_par, 1 );
	$inf_par_pair = preg_split( "/<\!---equals--->/", $inf_par, -1 );
	if ( is_array( $inf_par_pair ) ) {
		if ( preg_match( IMAGEUPLOAD_TAG_SPECIFIC, $inf_par_pair[1], $match ) ) {
			$tmplImg = new EasyTemplate( dirname( __FILE__ ) );
			$tmplImg->set_vars(array(
				'image_num' => $inf_image_num,
				'image_helper' => $inf_par,
				'image_name' => $inf_par_pair[0]
			));
			$editimage = $tmplImg->render( 'editimage' );
			$inf_image_num++;
?>
<div id="createpage_upload_div<?php echo $inf_image_num ?>">
<label for="wpUploadFile" class="normal-label"><?php echo $inf_par_pair[0] ?></label><?php echo $editimage ?>
<?php
		} elseif( preg_match( INFOBOX_SEPARATOR, $inf_par_pair[1], $math ) ) {
			# Replace each template parameter with <!---separator---> as value with:
			?>
			<div class="createpage-separator">&nbsp;</div>
			<input type="hidden" name="wpInfoboxPar<?php echo $inf_par_num ?>" value="<!---separator--->" id="wpInfoboxPar<?php echo $inf_par_num ?>" />
			<?php
			$inf_par_num++;
		} else {
?>
<label for="wpInfoboxPar<?php echo $inf_par_num ?>" class="normal-label"><?php echo $inf_par_pair[0] ?></label><input type="text" id="wpInfoboxPar<?php echo $inf_par_num ?>" name="wpInfoboxPar<?php echo $inf_par_num ?>" value="<?php echo htmlspecialchars( trim( $inf_par_pair[1] ) ) ?>" class="normal-input" /><br />

<script type="text/javascript">
/*<![CDATA[*/
var ourInfoboxElement = jQuery( '#wpInfoboxPar<?php echo $inf_par_num ?>' );
if ( ourInfoboxElement.length > 0 ) {
	jQuery( document ).ready( function( e ) {
		CreateAPage.clearInput( e, {num: <?php echo $inf_par_num ?>} );
	});
}
/*]]>*/
</script>
<?php
		}
		$inf_par_num++;
	}
}
?>
</div>
</fieldset>
<!-- e:<?php echo __FILE__ ?> -->
