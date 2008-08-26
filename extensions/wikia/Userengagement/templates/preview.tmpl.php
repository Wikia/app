<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
/*<![CDATA[*/
.btn-action { width:80px; }
#pages { width:100%; cellpadding:10px;}
#pages TD { border-bottom: 1px solid lightgray; height:25px;}
.ok {color:darkgreen;}
.notok {color:darkred;}

/*]]>*/
</style>

<script type="text/javascript">
/*<![CDATA[*/
	
	function submitSeed(id,pageUrl){
	
	  var handleSuccess = function(o){
		if(o.responseText !== undefined){
		   id = o.argument;
		   var div = document.getElementById('action_'+id);
		   var aData = YAHOO.Tools.JSONParse(o.responseText);	
		   div.innerHTML = '<img src="http://origin-images.wikia.com/common/common/tickIcon.gif" width="16" height="16" border="0" />';
		   var div = document.getElementById('status_'+id);
		   div.innerHTML = aData["response"];
		}
	  };
	
	var handleFailure = function(o){
	    if(o.responseText !== undefined){
	      id = o.argument;	
	      var div = document.getElementById('status_'+id);
		  div.innerHTML = "<?= wfMsg( 'Failure' ) ?>";
		}
	};
	
	var callback =
	{
	  success:handleSuccess,
	  failure:handleFailure,
	  argument:id,
	  timeout: 50000
	};
	
	var ajaxpath = "<?php echo $GLOBALS["wgScriptPath"]."/index.php";  ?>";	
		
	
		document.getElementById('btn_'+id).style.visibility="hidden";
		var div = document.getElementById('action_'+id);
		div.innerHTML = '<img src="http://images.wikia.com/common/progress_bar.gif" width="80" height="20" border="0" />';
		var postData = "?action=ajax&rs=UserengagementAjax&page="+pageUrl;
		var request = YAHOO.util.Connect.asyncRequest('POST', ajaxpath+postData, callback, postData);
	}
			
/*]]>*/
</script>

<table>
<tr><td valign="top"><?= wfMsg( 'ue.step1.i.1' ) ?></td></tr>
<tr><td valign="top"><?= $data['err'] ?></td></tr> 
<tr><td valign="top">
<table id="pages">
<tr><td><b>Message</b></td><td><b>On Hook</b></td><td><b>Description</b></td><td><b>Status</b></td></tr>
<form id="pages">
<?
foreach($data['preview'] as $key => $value){
 if($value['handle']!='ue_view'){
 ?>	
  <tr><td><?= str_replace('ue_','Ue-',$value['handle']) ?></td><td><?= $value['on_hook'] ?></td><td><div id="status_<?= $key ?>"><?= $value['description'] ?></div></td><td><div id="action_<?= $key ?>"><b><?= strtoupper($value['params']['status']); ?></b></div></form></td></tr>
 <?
 }
}
?>
</form>
</table>
</td></tr>
</table>
<!-- e:<?= __FILE__ ?> -->