<!-- s:<?= __FILE__ ?> -->
<style>
.dt-creator h4 {
	font-weight:normal;
	font-size:110%;
}
.dt-creator select {
	font-size:95%;
}
.dt-creator input {
	font-size:95%;
}
.dt-creator {
	font-size:93%;
}
.dt-creator textarea {
	font-size:95%;
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
	<span id="dt-span-steps"><?=wfMsg('daemonloader_steps')?></span>
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
<script>
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

YAHOO.util.Event.onDOMReady(function() {
	var loadImg = "<img src=\"/skins/monaco/images/widget_loading.gif\" />";
	var divCreatorLoader = YAHOO.util.Dom.get("dt-creator-loader");
	var divDaemonInfo = YAHOO.util.Dom.get("dt-daemon-info");
	var loadDiv = null;
	var loadId = null;

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

	__ShowWikiListCallback = {
		success: function( oResponse )
		{
			var resData = oResponse.responseText;
			var input = document.createElement('input');
			var resDiv = 'dt-list-' + loadDiv;
			input.setAttribute('type', 'button');
			input.value = '...';
			input.setAttribute('id', 'dt-btn-' + loadDiv);
			YAHOO.util.Dom.get(resDiv).innerHTML = resData;
			YAHOO.util.Dom.get(resDiv).appendChild(input);
			YAHOO.util.Event.addListener('dt-btn-' + loadDiv, "click", addDBToList, [loadDiv]);
			loadDiv = null;
		},
		failure: function( oResponse )
		{
			var resDiv = 'dt-list-' + loadDiv;
			YAHOO.util.Dom.get(resDiv).innerHTML = oResponse.responseText;
		}
	}
		
	function createInput(el, name, value, size) {
		var input = el.appendChild(document.createElement('input'));
		input.setAttribute('type', 'text');
		input.setAttribute('size', size);
		input.setAttribute('name', name);
		input.setAttribute('value', value);
		
		return input;
	}
	
	function createWikiListTxtArea( el, name, value ) {
		var hdr = el.appendChild(document.createElement('div'));
		var txtAreaId = 'dt-txtArea-' + name;
		
		hdr.style.height = "25px";
		hdr.style.textAlign = "right";
		hdr.setAttribute('id', 'dt-list-' + name);
		hdr.innerHTML = '<a id="dt-wikia-list-' + name + '" style="cursor:pointer"><?=wfMsg('daemonloader_selectlist')?></a>';
		YAHOO.util.Event.addListener("dt-wikia-list-" + name, "click", loadWikiList, [name]);

		var bottom = el.appendChild(document.createElement('div'));
		var inputText = bottom.appendChild(document.createElement('textarea'));
		inputText.setAttribute('cols', '40');
		inputText.setAttribute('rows', '7');
		inputText.setAttribute('id', txtAreaId);
		inputText.setAttribute('name', name);
	}

	__ShowTaskParamsCallback = {
		success: function( oResponse )
		{
			YAHOO.util.Dom.get("dt-task-3step").innerHTML = oResponse.responseText;
			divCreatorLoader.innerHTML = "";
			setPreviousStep(2);
			setCurrentStep(3);
		},
		failure: function( oResponse )
		{
			divCreatorLoader.innerHTML = "";
			YAHOO.util.Dom.get("dt-task-3step").innerHTML = "";
		}		
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
				tbl.setAttribute('class', "TablePager");
				tbl.style.margin = "2px 15px 2px 0";
				for (i in params) {
					if (i) {
						var tr = tbl.appendChild(document.createElement('tr'));
						//<th>
						var th = tr.appendChild(document.createElement('th'));
						th.innerHTML = i;
						th.setAttribute('valign', 'top');
						// <td>
						var td1 = tr.appendChild(document.createElement('td'));
						td1.style.textAlign = 'left';
						td1.style.padding = '2px 15px';
						
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
								var input = createInput(td1, i, params[i].default, 20);
								break;
							}
						};
						// <td>
						var td2 = tr.appendChild(document.createElement('td'));
						td2.innerHTML = params[i].desc;
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
		},
		failure: function( oResponse )
		{
			divCreatorLoader.innerHTML = "";
			YAHOO.util.Dom.get("dt-task-2step").innerHTML = "";
		}
	};

	var addDBToList = function (e, args) {
		var id = args[0];
		var txtArea = YAHOO.util.Dom.get('dt-txtArea-' + id);
		var select = YAHOO.util.Dom.get('dt-select-' + id);
		txtArea.value = txtArea.value + ((txtArea.value != '') ? ',' + select.value : select.value);
	}

	var loadWikiList = function (e, args) {
		var divList = args[0];
		YAHOO.util.Dom.get(this.id).innerHTML = loadImg;
		var params = "&rsargs[0]=" + divList;
		loadDiv = divList;
		//---
		var baseurl = wgScript + "?action=ajax&rs=DaemonLoader::axGetWikiList" + params;
		YAHOO.util.Connect.asyncRequest( "GET", baseurl, __ShowWikiListCallback);
	}

	var showTaskParams = function (e, args) {
		divCreatorLoader.innerHTML = loadImg;
		//---
		var baseurl = wgScript + "?action=ajax&rs=DaemonLoader::axGetTaskParams";
		YAHOO.util.Connect.asyncRequest( "GET", baseurl, __ShowTaskParamsCallback);	
	}

	var infoDaemon = function (e, args) {
		divCreatorLoader.innerHTML = loadImg;
		var params = "&rsargs[0]=" + YAHOO.util.Dom.get("dt-daemons-list").value;
		//---
		var baseurl = wgScript + "?action=ajax&rs=DaemonLoader::axShowDaemon" + params;
		YAHOO.util.Connect.asyncRequest( "GET", baseurl, __ShowDaemonInfoCallback);
	}

	var loadDaemonTask = function (e, args) {
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
	
	YAHOO.util.Event.addListener("dt-load-task", "click", loadDaemonTask);
	YAHOO.util.Event.addListener("dt-daemons-list", "change", infoDaemon);
	
	setCurrentStep(1);
});
</script>
<!-- e:<?= __FILE__ ?> -->
