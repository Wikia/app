<!-- s:<?= __FILE__ ?> -->
<style>
.dt-creator h4 {
	font-weight:normal;
	font-size:110%;
}
.dt-creator select {
	font-size:98%;
}
.dt-creator input {
	font-size:98%;
}
.dt-creator {
	font-size:96%;
}
.dt-creator textarea {
	font-size:98%;
}
.dt-creator td {
	padding:5px;
}
.dt-creator th {
	padding:5px;
}
#dt-task-1step {
	margin: 10px;
}
#dt-task-2step {
	margin: 10px;
}
#dt-task-3step {
	margin: 10px;
}
#dt-task-steps {
	text-align: right;
	font-size:12pt;
	vertical-align:middle;
}

#dt-span-steps {
	font-size:13pt;
	vertical-align:middle;
}

.dt-steps {
	width:30px;
	height:30px;
	vertical-align:middle;
	text-align:center;
	font-size:14pt;
	color: #EFEFEF;
}

.dt-steps-arrows {
	width:30px;
	height:30px;
	vertical-align:middle;
	text-align:center;
	font-size:16pt;
	color: #EFEFEF;
}

</style>
<form method="post" action="">
<input type="hidden" name="dt_action" id="dt_action" value="savetask">
<div class="dt-creator">
<div id="dt-creator-loader" style="padding-right:10px;float:left;"></div>
<div id="dt-task-steps">
	<span id="dt-span-steps"><?= wfMsg( 'daemonloader_steps' ) . wfMsg( 'word-separator' ) ?></span>
	<span id="dt-span-1step" class="dt-steps"> 1 </span>
	<span id="dt-span-1step-arrow" class="dt-steps-arrows"> &rarr; </span>
	<span id="dt-span-2step" class="dt-steps"> 2 </span>
	<span id="dt-span-2step-arrow" class="dt-steps-arrows"> &rarr; </span>
	<span id="dt-span-3step" class="dt-steps"> 3 </span>
</div>
<?php if (!empty($aDaemons)) : ?>
<div id="dt-task-1step">
	<h2><?=wfMsg('daemonloader_1step')?></h2>
	<h4><?=wfMsg('daemonloader_selectdaemon')?></h4>
	<div>
		<select id="dt-daemons-list" style="min-width:200px" name="dt-daemons">
			<option value="0" selected><?=wfMsg('daemonloader_selectlist')?></option>
<?php 
foreach ($aDaemons as $dt_id => $values) {
?>
			<option value="<?=$dt_id?>"><?=$values['dt_name']?></option>
<?php 
}
?>
		</select>
		<span><input type="button" id="dt-load-task" value="<?=wfMsg('daemonloader_gonextstep')?>" /></span>
	</div>
	<div id="dt-daemon-info"></div>
</div>	
<div id="dt-task-2step"></div>
<div id="dt-task-3step"></div>
<?php 
endif;
?>
</div>
</form>
<script type="text/javascript">
var loadImg = "<img src=\"/skins/common/images/ajax.gif\" />";
var divCreatorLoader = YAHOO.util.Dom.get("dt-creator-loader");
var divDaemonInfo = YAHOO.util.Dom.get("dt-daemon-info");
var loadDiv = null;
var loadId = null;

function getResponseData(res) {
	resData = "";
	if (YAHOO.Tools) {
		resData = YAHOO.Tools.JSONParse(res);
	} else if ((YAHOO.lang) && (YAHOO.lang.JSON)) {
		resData = YAHOO.lang.JSON.parse(res);
	} else {
		resData = eval('(' + res + ')');
	}
	return resData;
}

function setPreviousStep(i) {
	// set previous step color
	YAHOO.util.Dom.get("dt-span-" + i + "step").style.color = '#000000';
	
	YAHOO.util.Dom.get("dt-span-" + i + "step-arrow").style.color = '#000000';
}

function setCurrentStep(i) {
	// set previous step color
	YAHOO.util.Dom.get("dt-span-" + i + "step").style.color = '#BF002C';
}

function DTGetWikis(element, value, name) {
	var func = function() { loadWikiList(value, name) };

	if ( element.zid ) {
		clearTimeout(element.zid);
	}
	element.zid = setTimeout(func,800);
}

function showSecondStep(data) {
	__ShowTaskParamsCallback = {
		success: function( oResponse )
		{
			var YD = YAHOO.util.Dom;
			YD.get("dt-task-3step").innerHTML = oResponse.responseText;
			divCreatorLoader.innerHTML = "";
			setPreviousStep(2);
			setCurrentStep(3);
			if (data && typeof data == "object") {
				if (YD.get('dt_start')) {
					YD.get('dt_start').value = data.start.replace(/\-/g, "");
				}
				if (YD.get('dt_end')) {
					YD.get('dt_end').value = data.end.replace(/\-/g, "");
				}
				if (YD.get('dt_frequency')) {
					YD.get('dt_frequency').value = data.frequency;
				}
				if (YD.get('dt_emails')) {
					YD.get('dt_emails').value = data.result_emails;
				}
			}
		},
		failure: function( oResponse )
		{
			divCreatorLoader.innerHTML = "";
			YAHOO.util.Dom.get("dt-task-3step").innerHTML = "";
		}		
	}

	divCreatorLoader.innerHTML = loadImg;
	//---
	var baseurl = wgScript + "?action=ajax&rs=DaemonLoader::axGetTaskParams";
	YAHOO.util.Connect.asyncRequest( "GET", baseurl, __ShowTaskParamsCallback );	
}

function loadDaemonById(formValues) { 
	var showTaskParams = function (e, args) {
		showSecondStep();
	}
	
	__ShowDaemonParamsCallback = {
		success: function( oResponse )
		{
			var resData = getResponseData(oResponse.responseText);
			var divTxt = document.createElement('div');
			if (resData['nbr_records']) {
				var params  = resData['data']['dt_params'];
				row = 0;
				// h2 (title)
				var h2 = document.createElement('h2');
				h2.innerHTML = "<?=wfMsg('daemonloader_2step')?>";
				divTxt.appendChild(h2);
				// h4
				var span1 = document.createElement('h4'); 
				span1.innerHTML = "<?=addslashes(wfMsg('daemonloader_setparams'))?>";
				divTxt.appendChild(span1);
				// table
				var tbl = document.createElement('table');
				//tbl.setAttribute('class', "TablePager");
				tbl.style.margin = "2px 15px 2px 0";
				for (i in params) {
					if (i) {
						var tr = tbl.appendChild(document.createElement('tr'));
						//<th>
						var th = tr.appendChild(document.createElement('td'));
						th.innerHTML = "<i>" + params[i].desc + "</i>";
						th.setAttribute('valign', 'top');
						th.setAttribute('align', 'left');
						th.style.fontFamily = 'Arial';
						th.style.fontSize = '1.1em';
						th.style.fontWeight = 'normal';
						th.style.padding = '2px 0px 2px 10px';
						// <td>
						var tr2 = tbl.appendChild(document.createElement('tr'));
						var td1 = tr2.appendChild(document.createElement('td'));
						td1.style.textAlign = 'left';
						td1.style.padding = '2px 0px 2px 35px';
						
						switch (params[i].type) {
							case "1" : { // string
								var input = createInput(td1, i, params[i].default, 40);
								break;
							}
							case "6" : { // wikilist
								createWikiListTxtArea( td1, i, params[i].default) ;
								break;
							}
							default : {
								var input = createInput(td1, i, params[i].default, 15);
								break;
							}
						};
						
						// <td>
						/*var td2 = tr.appendChild(document.createElement('td'));
						td2.innerHTML = params[i].desc;*/
						row++;
					}
				}
				divTxt.appendChild(tbl);
				// next button 
				var btnDiv = document.createElement('div');
				btnDiv.style.textAlign = 'left';
				btnDiv.style.padding = '5px';
				
				var nextBtn = btnDiv.appendChild(document.createElement('input')); 
				nextBtn.setAttribute('type', 'button');
				nextBtn.value = "<?=wfMsg('daemonloader_gonextstep')?>";
				nextBtn.setAttribute('id', 'dt-load-2step');
				divTxt.appendChild(btnDiv);
				
				YAHOO.util.Event.addListener('dt-load-2step', "click", showTaskParams);
			} 
			YAHOO.util.Dom.get("dt-task-2step").innerHTML = divTxt.innerHTML;
			divCreatorLoader.innerHTML = "";
			setPreviousStep(1);
			setCurrentStep(2);

			// Show values 
			if (formValues) {
				for (key in formValues) {
					if ( YAHOO.util.Dom.get('dt-txtArea-' + key) ) {
						YAHOO.util.Dom.get('dt-txtArea-' + key).value = formValues[key];
					} else if ( YAHOO.util.Dom.get('dt-input-' + key) ) {
						YAHOO.util.Dom.get('dt-input-' + key).value = formValues[key];
					}
				}
			}
		},
		failure: function( oResponse )
		{
			divCreatorLoader.innerHTML = "";
			YAHOO.util.Dom.get("dt-task-2step").innerHTML = "";
		}
	};

	
	divCreatorLoader.innerHTML = loadImg;
	if (YAHOO.util.Dom.get("dt-daemons-list").value == 0) {
		divCreatorLoader.innerHTML = "";
		return 0; 
	} else {
		var params = "&rsargs[0]=" + YAHOO.util.Dom.get("dt-daemons-list").value;
		//---
		var baseurl = wgScript + "?action=ajax&rs=DaemonLoader::axShowDaemon" + params;
		YAHOO.util.Connect.asyncRequest( "GET", baseurl, __ShowDaemonParamsCallback);
	}	
}

function loadWikiList(value, txtname) {
	__ShowWikiListCallback = {
		success: function( oResponse )
		{
			var resData = oResponse.responseText;
			var resDiv = 'dt-wikia-search-result';

			var input = document.createElement('input');
			input.setAttribute('type', 'button');
			input.value = '...';
			input.setAttribute('id', 'dt-btn-add-wiki');

			YAHOO.util.Dom.get(resDiv).innerHTML = resData;
			YAHOO.util.Dom.get(resDiv).appendChild(input);
			YAHOO.util.Event.addListener('dt-btn-add-wiki', "click", function (e, args) {
				var txtName = args[0];
				var txtArea = YAHOO.util.Dom.get('dt-txtArea-' + txtName);
				var select = YAHOO.util.Dom.get('dt-select-' + txtName);
				txtArea.value = txtArea.value + ((txtArea.value != '') ? ', ' + select.value : select.value);
			}, [txtname]);
		},
		failure: function( oResponse )
		{
			YAHOO.util.Dom.get('dt-wikia-search-result').innerHTML = oResponse.responseText;
		}
	}

	YAHOO.util.Dom.get("dt-wikia-search-result").innerHTML = loadImg;
	var params = "&rsargs[0]=" + txtname + "&rsargs[1]=" + value;
	//---
	var baseurl = wgScript + "?action=ajax&rs=DaemonLoader::axGetWikiList" + params;
	YAHOO.util.Connect.asyncRequest( "GET", baseurl, __ShowWikiListCallback);
}

function createInput(el, name, value, size) {
	var input = el.appendChild(document.createElement('input'));
	input.setAttribute('type', 'text');
	input.setAttribute('size', size);
	input.setAttribute('name', name);
	input.setAttribute('id', "dt-input-" + name);
	input.setAttribute('value', value);
	
	return input;
}

function createWikiListTxtArea( el, name, value ) {
	var hdr = el.appendChild(document.createElement('div'));
	var txtAreaId = 'dt-txtArea-' + name;
	
	hdr.style.height = "25px";
	hdr.style.textAlign = "left";
	hdr.setAttribute('id', 'dt-list-' + name);
	sInfo = '<div style="font-size:0.99em;"><span><?=wfMsg("daemonloader_search")?> <input type="text" id="dt-wikia-search" value="" size="15" autocomplete="off" onkeyup = "DTGetWikis(this, this.value, \''+name+'\');"></span>';
	sInfo += '<span id="dt-wikia-search-result" style="white-space:nowrap;"></span></div>';
	hdr.innerHTML = sInfo;

	var bottom = el.appendChild(document.createElement('div'));
	var inputText = bottom.appendChild(document.createElement('textarea'));
	inputText.style.width = '550px';
	inputText.setAttribute('rows', '7');
	inputText.setAttribute('wrap', 'on');
	inputText.setAttribute('id', txtAreaId);
	inputText.setAttribute('name', name);
}

YAHOO.util.Event.onDOMReady(function() {

	__ShowDaemonInfoCallback = {
		success: function( oResponse ) {
			var resData = getResponseData(oResponse.responseText);
			if (resData['nbr_records']) {
				divDaemonInfo.innerHTML = "<fieldset style='padding:4px 12px 4px;margin:5px 30px;'><legend><?=wfMsg('daemonloader_daemoninfo')?></legend>" + resData['data'].dt_desc + "</fieldset>";
			} else {
				divDaemonInfo.innerHTML = "";
			}
			divCreatorLoader.innerHTML = "";
		},
		failure: function( oResponse ) {
			divCreatorLoader.innerHTML = "";
			divDaemonInfo.innerHTML = "";
		}
	};
		
	var addDBToList = function (e, args) {
		var id = args[0];
		var txtArea = YAHOO.util.Dom.get('dt-txtArea-' + id);
		var select = YAHOO.util.Dom.get('dt-select-' + id);
		txtArea.value = txtArea.value + ((txtArea.value != '') ? ',' + select.value : select.value);
	}

	var infoDaemon = function (e, args) {
		divCreatorLoader.innerHTML = loadImg;
		var params = "&rsargs[0]=" + YAHOO.util.Dom.get("dt-daemons-list").value;
		//---
		var baseurl = wgScript + "?action=ajax&rs=DaemonLoader::axShowDaemon" + params;
		YAHOO.util.Connect.asyncRequest( "GET", baseurl, __ShowDaemonInfoCallback);
	}

	var loadDaemonTask = function (e, args) {
		loadDaemonById();
	}
	
	YAHOO.util.Event.addListener("dt-load-task", "click", loadDaemonTask);
	YAHOO.util.Event.addListener("dt-daemons-list", "change", infoDaemon);

	setCurrentStep(1);
});
</script>
<!-- e:<?= __FILE__ ?> -->
