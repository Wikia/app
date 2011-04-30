<h1><?php echo wfMsg('plb-helpbox-title'); ?></h1>
<div id="plbHelpBox">
	<div class='info1' >
	<h1><?php echo wfMsg( 'plb-helpbox-bigimage-title' ); ?></h1>
	<?php echo wfMsg( 'plb-helpbox-bigimage-desc' ); ?>
	</div>
	<div class='info2' >
		<?php echo wfMsg( 'plb-helpbox-buttton-head1' ); ?> <br>
		<?php echo wfMsg( 'plb-helpbox-buttton-head2' ); ?><br>
		<input type="button" id="getStarted1" value="<?php echo wfMsg( 'plb-helpbox-getstarted' ); ?>" /> <br>
		<input type="checkbox" id="getStartedBlock1" /> <span class='checkboxinfo' > <?php echo wfMsg('plb-helpbox-checkboxinfo1'); ?> </span>
	</div>
	
	<div class="infoAdmin" >
		<div class='blueBox' >
			<?php echo wfMsg('plb-helpbox-box1'); ?>
			<img src="<?php echo $arrow; ?>" />
		</div>
		<img src="<?php echo $s1; ?>" />
	</div>
	<div class="infoForm" >
		<div class='blueBox' >
			<?php echo wfMsg('plb-helpbox-box2'); ?>
			<img src="<?php echo $arrow; ?>" />
		</div>
		<img src="<?php echo $s2; ?>" />
	</div>
	<div class="infoArticle" >
		<div class='blueBox' >
			<?php echo wfMsg('plb-helpbox-box3'); ?>
			<img src="<?php echo $arrow; ?>" />
		</div>
		<img src="<?php echo $s3; ?>" />
	</div>	
	
	<div class="footerclearfix" >
		<br>
	</div>
	
	<div class="footer1">
		<br>
	</div>
	
	<div class="footer2">
		<span><?php echo wfMsg( 'plb-helpbox-help-button-head3' ); ?></span>
		<div class="buttondiv" > 
			<input id="getStarted2" type="button" value="<?php echo wfMsg( 'plb-helpbox-getstarted' ); ?>" /> <br>
			<input type="checkbox" id="getStartedBlock2"   />  <span class='checkboxinfo' > <?php echo wfMsg('plb-helpbox-checkboxinfo2'); ?> </span>
		</div>
	</div>
	
	<div class="footer3">
		<span class="helpicon"><?php echo wfMsg( 'plb-helpbox-help-desc' ); ?></span>
		<span class="link" ><a href="<?php echo $helplink; ?>"><?php echo wfMsg( 'plb-helpbox-help-link' ); ?> </a></span>
	</div>
	    
</div>