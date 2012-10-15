<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
/*<![CDATA[*/
/*]]>*/
</style>

<h2>EZ Namespace Adder</h2>
<div id="eznsContainer">

<?php
	$write = array();

	$ens = WikiFactory::getVarValueByName('wgExtraNamespaces', $wiki->city_id);
	$ensl = WikiFactory::getVarValueByName('wgExtraNamespacesLocal', $wiki->city_id);

	if( $ens == false ) { $ens = array(); }
	if( $ensl == false ) { $ensl = array(); }
	
	$write['ens'] = false;
	$write['ensl'] = false;
	
	global $wgRequest;
	if( $wgRequest->wasPosted() )
	{
		#debug
		// print "<fieldset><legend>was posted!</legend>\n";
		// print_pre($_POST);
		// print "</fieldset>\n";
		
		$reason = $wgRequest->getVal('reason');
		#get the rest of the vars we're likely to be managing
		$cns = WikiFactory::getVarValueByName('wgContentNamespaces', $wiki->city_id);
		$nssd = WikiFactory::getVarValueByName('wgNamespacesToBeSearchedDefault', $wiki->city_id);
		$nssub = WikiFactory::getVarValueByName('wgNamespacesWithSubpagesLocal', $wiki->city_id);
		$write['cns'] = false;
		$write['nssd'] = false;
		$write['nssub'] = false;

		if( $cns == false ) {
			#print "asserting default (int)\n";
			$cns = array ( 0 => 0 );
		}

		/*
		    [ezns_ans_id] => 114
			[ezns_ans_text] => a
			[ezns_ans_content] => on
			[ezns_ans_search] => on
			[ezns_ans_sub] => on
			
			[ezns_tns_id] => 115
			[ezns_tns_text] => b
				[ezns_tns_lazy] => on
			[ezns_tns_content] => on
			[ezns_tns_search] => on
			[ezns_tns_sub] => on
		*/
		
		/***********************************************************************************************/
		$ezns_ans_id = $wgRequest->getVal('ezns_ans_id');
		$ezns_ans_text = $wgRequest->getVal('ezns_ans_text');
		#did we get a new article namespace id and text?
		if($ezns_ans_id > 0 && $ezns_ans_text != '')
		{
			#we did!
			
			#remove it from the array, incase it exists (trust me, theres a reason)
			unset($ensl[$ezns_ans_id]);

			#clean it (dont trust anyone)
			$ezns_ans_text = ucfirst($ezns_ans_text);
			$ezns_ans_text = str_replace(" ", "_", $ezns_ans_text);
			
			#set it
			$ensl[$ezns_ans_id] = $ezns_ans_text;
			$write['ensl'] = true;
			
			#since we know this was valid, lets check the other checkboxes
			
			$ezns_ans_content = $wgRequest->getVal('ezns_ans_content');
			#do they want it to be content namespace?
			if($ezns_ans_content == 'on') {
				#they do
				$cns[] = $ezns_ans_id;
				$write['cns'] = true;
			}
			
			$ezns_ans_search = $wgRequest->getVal('ezns_ans_search');
			#do they want it to be in the default search?
			if($ezns_ans_search == 'on') {
				#they do
				if( !is_array( $nssd ) ) { //fix for nonset default
					$nssd = array( 0 => true, 500 => true, 502 => true );
				}
				$nssd[$ezns_ans_id] = true;
				$write['nssd'] = true;
			}
			
			$ezns_ans_sub = $wgRequest->getVal('ezns_ans_sub');
			#do they want it to be in the default search?
			if($ezns_ans_sub == 'on') {
				#they do
				$nssub[$ezns_ans_id] = true;
				$write['nssub'] = true;
			}
		}
		/***********************************************************************************************/
		$ezns_tns_id = $wgRequest->getVal('ezns_tns_id');
		$ezns_tns_text = $wgRequest->getVal('ezns_tns_text');
		$ezns_tns_lazy = $wgRequest->getVal('ezns_tns_lazy');
		if($ezns_tns_lazy == 'on'){
			#gogo lazy mode!
			if($ezns_ans_text != '' ) { #check to make sure we have something to be lazy with
				#we do!
				$ezns_tns_text = $ezns_ans_text . '_talk';
			}
		}
		#did we get a new talk namespace id and text (one way or an other)?
		if($ezns_tns_id > 0 && $ezns_tns_text != '')
		{
			#we did!
			
			#remove it from the array, incase it exists (trust me, theres a reason here)
			unset($ensl[$ezns_tns_id]);

			#clean it (dont trust anyone)
			$ezns_tns_text = ucfirst($ezns_tns_text);
			$ezns_tns_text = str_replace(" ", "_", $ezns_tns_text);
			
			#set it
			$ensl[$ezns_tns_id] = $ezns_tns_text;
			$write['ensl'] = true;
			
			#since we know this was valid, lets check the other checkboxes
			
			$ezns_tns_content = $wgRequest->getVal('ezns_tns_content');
			#do they want it to be content namespace?
			if($ezns_tns_content == 'on') {
				#they do
				$cns[] = $ezns_tns_id;
				$write['cns'] = true;
			}
			
			$ezns_tns_search = $wgRequest->getVal('ezns_tns_search');
			#do they want it to be in the default search?
			if($ezns_tns_search == 'on') {
				#they do
				if( !is_array( $nssd ) ) { //fix for nonset default, var is not local additive.
					$nssd = array( 0 => true, 500 => true, 502 => true );
				}
				$nssd[$ezns_tns_id] = true;
				$write['nssd'] = true;
			}
			
			$ezns_tns_sub = $wgRequest->getVal('ezns_tns_sub');
			#do they want it to be in the default search?
			if($ezns_tns_sub == 'on') {
				#they do
				$nssub[$ezns_tns_id] = true;
				$write['nssub'] = true;
			}
		}
		/***********************************************************************************************/
		if($write['ensl']) {
			#print "have to write [ensl]<br/>\n";
			ksort($ensl);
			WikiFactory::setVarByName('wgExtraNamespacesLocal', $wiki->city_id, $ensl, $reason);
			print Wikia::successbox("wgExtraNamespacesLocal saved");
		}
		if($write['cns']) {
			#print "have to write [cns]<br/>\n";
			ksort($cns);
			WikiFactory::setVarByName('wgContentNamespaces', $wiki->city_id, $cns, $reason);
			print Wikia::successbox("wgContentNamespaces saved");
		}
		if($write['nssd']) {
			#print "have to write [nssd]<br/>\n";
			ksort($nssd);
			WikiFactory::setVarByName('wgNamespacesToBeSearchedDefault', $wiki->city_id, $nssd, $reason);
			print Wikia::successbox("wgNamespacesToBeSearchedDefault saved");
		}
		if($write['nssub']) {
			#print "have to write [nssub]<br/>\n";
			ksort($nssub);
			WikiFactory::setVarByName('wgNamespacesWithSubpagesLocal', $wiki->city_id, $nssub, $reason);
			print Wikia::successbox("wgNamespacesWithSubpagesLocal saved");
		}
		/***********************************************************************************************/
	}
?>
<form name="eznsForm" method="POST">
<table class='WikiaTable'>
	<caption>current namespace settings</caption>
	<tr>
		<th>wgExtraNamespaces</th>
		<th>wgExtraNamespacesLocal</th>
	</tr>
	<tr>
		<td style='vertical-align: top;'>
		<?php
			if( !empty($ens) ){
					print "<ul>\n";
				foreach($ens as $nsi=>$nst)
				{
					print "<li>[{$nsi}] => {$nst}</li>\n";
				}
					print "</ul>\n";
			}
		?>
		</td>
		<td style='vertical-align: top;'>
		<?php
			if( !empty($ensl) ){
					print "<ul>\n";
				foreach($ensl as $nsi=>$nst)
				{
					print "<li>[{$nsi}] => {$nst}</li>\n";
				}
					print "</ul>\n";
			}
		?>
		</td>
	</tr>
</table>
<hr/>	

<?php	
	$suggest = 112;
	$done = false;
	$combined = $ens + $ensl;
	

	while(!$done)
	{
		if( array_key_exists($suggest, $combined) )
		{
			//its in-use
			$done = false;
			$suggest += 2;
		}
		else
		{
			$done = true;
		}
	}
	print "next available namespace is: {$suggest}<br/>\n";
	
?>

<table class="WikiaTable">
<tr>
<th></th>
<th>id</th>
<th>text</th>
<th>is content?</th>
<th>default search?</th>
<th>has subpages?</th>
</tr>

<tr>
<td>namespace</td>
<td><input type="text" name="ezns_ans_id" value="<?php echo $suggest; ?>" size="5" /></td>
<td><input type="text" name="ezns_ans_text" value="<?php  ?>" /></td>
<td><input type="checkbox" name="ezns_ans_content" /></td>
<td><input type="checkbox" name="ezns_ans_search" /></td>
<td><input type="checkbox" name="ezns_ans_sub" /></td>
</tr>

<tr style="vertical-align: top;">
<td>talkspace</td>
<td><input type="text" name="ezns_tns_id" value="<?php echo $suggest+1; ?>" size="5" /></td>
<td><input type="text" id="ezns_tns_text" name="ezns_tns_text"/><br/>
<input type="checkbox" id="ezns_tns_lazy" name="ezns_tns_lazy" checked="checked" /><small style="border-bottom:1px dashed black; cursor: help;" title="just append 'talk' to the end of the namespace (EN only)">'lazy' mode</small></td>
<td><input type="checkbox" name="ezns_tns_content" /></td>
<td><input type="checkbox" name="ezns_tns_search" /></td>
<td><input type="checkbox" name="ezns_tns_sub" /></td>
</tr>

<tr style="vertical-align: top;">
<td>reason</td>
<td colspan="5"><input type="text" name="reason" size="50" /></td>
</tr>

</table>
 
	<input type="submit" id="eznsSave" value="Save" />
</form>
</div>
<script type="text/javascript"> 
function toggle_lazy(){
    if ($('#ezns_tns_lazy').is(':checked')) {
        $('#ezns_tns_text').attr('disabled', true);
    } else {
        $('#ezns_tns_text').removeAttr('disabled');
    }   
}

$('#ezns_tns_lazy').click( toggle_lazy );
toggle_lazy();
</script>
<!-- e:<?= __FILE__ ?> -->
