<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
/*<![CDATA[*/
<?php
	// use "built-in" styling for tabs on Oasis
	if ( !( F::app()->checkSkin( 'oasis' ) ) ) {
	//start non-oasis tab styling
?>
#wiki-factory ul.tabs {
	width: 100%;
	margin: 0;
	margin-bottom: 1em;
	border-bottom: 1px solid gray;
}
#wiki-factory ul.tabs li {
	display: inline;
	margin: 0;
	margin-left: 1em;
	text-align: center;
	padding: 0.2em 0.4em 0.2em 0.4em;
	width: 100%;
	border: 1px solid gray;
	border-bottom: none;
}
#wiki-factory ul.tabs li.selected {
	font-weight: bold;
	padding-bottom: 4px;
	background-color: #ffffff;
	font-size: 110%;
}
#wiki-factory ul.tabs li.inactive {
	background-color: #f7f7f7;
	font-size: 90%;
}
<?php
//end non-oasis tab styling
	}
	else {
//start oasis tabs styling
?>
#wiki-factory .tabs {
	list-style: none;
	margin-left: 0.5em;
}

#wiki-factory .selected {
	font-weight: bold;
}

.errorbox, .successbox {
font-size: larger;
border: 2px solid;
padding: .5em 1em;
float: left;
margin-bottom: 2em;
color: #000;
}
.errorbox {
border-color: red;
background-color: #fff2f2;
}
.successbox {
border-color: green;
background-color: #dfd;
}
.errorbox h2, .successbox h2 {
font-size: 1em;
font-weight: bold;
display: inline;
margin: 0 .5em 0 0;
border: none;
}

<?php
//end oasis tab styling
	}
?>
#wiki-factory-panel {
	border: 1px dotted lightgray;
	background: #f9f9f9;
	padding: 0.2em;
	margin-top: 1em;
}
#wk-wf-variables, #wk-wf-domains, #wk-wf-info {
    border: 1px dotted lightgray; background: #f9f9f9; padding: 4px;
}
#wk-busy-bar {
    position:fixed;
    top:1em;
    right:1em;
    z-index: 9000;
}

#wf-category fieldset { border: 1px dotted lightgray; background: #f9f9f9; padding: 0.4em; }
#wf-category label { display: inline-block; width: 75px; }

.wf-variable-form .perror {color: #fe0000; font-weight: bold; }
.wf-variable-form .success {color: darkgreen; font-weight: bold; }
.wf-variable-form textarea { width: 90%; height: 8em; }
.wf-variable-form input.input-string { width: 90%; }
.wf-variable-form label { display: block; padding-top: 1em; }
.wf-variable-form-inline-group { width: 45%; }
.wf-variable-form-left { float: left; }
.wf-variable-form-right { float: right; }

.prompt {
	color: #fe0000;
	display: block;
}

div.wf-info {
    border-left: 2px solid darkgreen; background: #CFC;
    font-style: italic;
    margin: 0.4em; padding: 0.4em;
}


.wf-tinyhead th { font-size: x-small; }
#wk-domain-ol a { cursor: pointer; }

/*]]>*/
</style>
<script>
var $Factory = {};
$Factory.Domain = {};
$Factory.Variable = {};

var ajaxpath = wgServer + wgScript;
$Factory.city_id = <?php echo $wiki->city_id ?>;


$Factory.VariableCallback = {
    success: function( aData ) {
    	$("#" + aData["div-name"]).html(aData["div-body"]);
        //--- now add listeners and events
		$.loadJQueryAutocomplete(function() {
			$('#tagName').autocomplete({
				serviceUrl: wgServer+wgScript+'?action=ajax&rs=WikiFactoryTags::axQuery',
				minChars:3,
				deferRequestBy: 0
			});
		});
        $Factory.Busy(0);
    },
    failure: function( aData ) {
        $().log( "failure in VariableCallback" );
		$().log( aData["responseText"] );
        $Factory.Busy(0);
    }
};

$Factory.ReplaceCallback = {
    success: function( Data ) {
        $( "#" + Data["div-name"] ).html(Data["div-body"]);

        $Factory.Busy(0);
        // other conditions
        if ( Data["div-name"] == "wf-clear-cache") {
            $Factory.BusyCache(0);
            setTimeout("var alink = function(){ $('#wf-clear-cache').html('<?php echo wfMsg("wikifactory_removevariable") ?>');};alink();",2000);
        }
    },
    failure: function( oResponse ) {
        $Factory.Busy(0);
        $Factory.BusyCache(0);
    },
    timeout: 50000
};

$Factory.Busy = function (state) {
	if (state == 0) {
		$("#wk-busy-bar").css( "display", "none");
		//console.log('busy->OFF');
	}
	else {
		$("#wk-busy-bar").css( "display", 'block');
		//console.log('busy->ON');
	}
};

$Factory.BusyCache = function (state) {
	if (state == 0) {
		$("#wk-busy-cache").css( "display", "none");
		//console.log('cachebusy->OFF');
	}
	else {
		$("#wk-busy-cache").css( "display", 'inline');
		//console.log('cachebusy->ON');
	}
};

$Factory.Domain.CRUD = function(mode, domain, addparams) {
	$Factory.Busy(1);
	var params = "&cityid=" + $Factory.city_id + "&domain=" + domain + addparams;
	$.ajax({
    	type:"POST",
    	dataType: "json",
    	url: ajaxpath+"?action=ajax&rs=axWFactoryDomainCRUD&rsargs[0]=" + mode + params,
    	success: $Factory.Domain.Callback.success,
    	error: $Factory.Domain.Callback.failure,
    	timeout: 20000
    });
}

$Factory.Domain.Callback = {
    success: function( oReturn ) {
        var aDomains = oReturn["domains"];
        var sInfo = oReturn["info"];

        $( "#wk-domain-ol" ).empty();
        for (var i=0;i<aDomains.length;i++) {
            var id = "wk-domain-li-" + i;
			var li = $("<li></li>").attr("id", id).html(aDomains[i])
				.append($("<a>[change]</a>").attr("id",  id + "change"))
				.append($("<a>[remove]</a>").attr("id",  id + "remove"))
				.append($("<a>[setmain]</a>").attr("id", id + "setmain"));

            $Factory.Domain.listEvents(aDomains[i], i);
            $( "#wk-domain-ol" ).append(li);
        }
        var info = $("<div></div>").html(sInfo);
        $( "#wk-domain-ol" ).append(info);
        $Factory.Busy(0);
    },
    failure: function( oResponse ) {
        $Factory.Busy(0);
    }
};

$Factory.Domain.listEvents = function(domain, key) {
	setTimeout(function() {
		var params = { key: key, domain:domain, element: "wk-domain-li-" + key };
		$("#wk-domain-li-" + key + "remove").click( jQuery.proxy( $Factory.Domain.remove, params ) );
		$("#wk-domain-li-" + key + "change").click( jQuery.proxy( $Factory.Domain.change, params ) );
		$("#wk-domain-li-" + key + "setmain").click( jQuery.proxy( $Factory.Domain.setmain, params ) );
	},500);
}

$Factory.Domain.add = function ( e ) {
    $Factory.Busy(1);
    var reason = $( "#wk-domain-reason" ).val();
    var params = "&reason=" + encodeURIComponent(reason);
    $Factory.Domain.CRUD("add", $( "#wk-domain-add" ).val(), params );
    return false;
};

// data[0] - div we change, data[1] - step, data[2] - domainname
$Factory.Domain.change = function ( e, data ) {
	$('.prompt').remove();
    var input = $("<input/>")
    	.attr("id", "wk-change-input")
    	.attr("name", "wk-change-input")
    	.attr( "type", "text")
    	.attr("value", this.domain)
    	.attr("size", 20)
    	.attr("maxlength", 255);

    var reason = $("<input/>")
		.attr('value', '')
		.attr('type', 'text')
		.attr('name', 'wk-change-reason')
		.attr('size', 20)
		.attr('id', 'wk-change-reason');

    var change = $("<input/>")
    	.attr('value', "Change")
    	.attr('type', "button")
    	.click(jQuery.proxy(function() {
            var newdomain = $( "#wk-change-input" ).val();
	    var reason = $( "#wk-change-reason" ).val();
            var params = "&newdomain="+newdomain+"&reason="+encodeURIComponent(reason);
            $Factory.Domain.CRUD("change", this.domain, params);
			return false;
		}, this));

    var cancel = $("<input/>")
		.attr('value', "Cancel")
		.attr('type', "button")
		.click(function(e){
			$(e.target).closest("span").remove();
			return false;
    	});


    $("<span>New domain name: <span/>")
    	.attr("class","prompt")
		.append(input)
		.append('&nbsp;Reason:&nbsp;')
		.append(reason)
		.append(change)
		.append(cancel)
		.appendTo("#"+this.element);
	return false;
};

$Factory.Domain.confirm = function(question,element,callback) {
	$('.prompt').remove();
	var cancel = $("<a>[Cancel]</a>").click(
			function(e) {
				$(e.target).closest("span").remove();
				return false;
			}
    );

    var reason = $("<input/>")
		.attr('value', '')
		.attr('type', 'text')
		.attr('name', 'reason')
		.attr('size', 20)
		.attr('id', 'wk-remove-setmain-reason');


    var yes = $("<a>[Yes]</a>").click(callback);

    $("<span><span/>")
		.html(question)
		.attr("class","prompt")
		.append('&nbsp;Reason:&nbsp;')
		.append(reason)
		.append(yes)
		.append(cancel)
		.appendTo("#"+element);
}

$Factory.Domain.remove = function ( e, data ) {
	$Factory.Domain.confirm(
		"Remove "+this.domain+"?",
		this.element,
		jQuery.proxy(
			function(e) {
				var reason = $( "#wk-remove-setmain-reason" ).val();
				var params = "&reason=" + encodeURIComponent(reason);
				$Factory.Domain.CRUD("remove", this.domain, params);
				return false;
		}, this)
	);
    return false;
};

$Factory.Domain.setmain = function ( e, data ) {
	$Factory.Domain.confirm(
			"Set "+this.domain + " as main ?",
			this.element,
			jQuery.proxy(
				function(e) {
					var reason = $( "#wk-remove-setmain-reason" ).val();
					var params = "&reason=" + encodeURIComponent(reason);
					$Factory.Domain.CRUD("setmain", this.domain, params);
					return false;
			}, this)
	);
	return false;
};


$Factory.Variable.selectChange = function ( e, data, type ) {
    $Factory.Busy(1);
    var values = "";
    values += "&varid=" + $( "#wk-variable-select" ).val();
    values += "&wiki=" + $Factory.city_id;
	$.ajax({
    	type:"GET",
    	dataType: "json",
    	url: ajaxpath+"?action=ajax&rsargs[0]="+data[1]+"&rs=" + type + values,
    	success: $Factory.VariableCallback.success,
    	error: $Factory.VariableCallback.failure,
    	timeout: 50000
    });
}

$Factory.Variable.select = function ( e, data ) {
	$Factory.Variable.selectChange( e, data, 'axWFactoryGetVariable' );
};


// For editing the variable itself (not its value).
$Factory.Variable.change = function ( e, data ) {
	$Factory.Variable.selectChange( e, data, 'axWFactoryChangeVariable' );
};

// For editing the variable itself (not its value).
$Factory.Variable.submitChangeVariable = function ( e, data ) {
	$Factory.Busy(1);

    var values = "";

	// TODO: FILL THE VALUES WITH EVERYTHING FROM THE FORM.
	values += "&cv_variable_id=" + encodeURIComponent($('#wk-change-cv_variable_id').val());
	values += "&cv_name=" + encodeURIComponent($('#wk-change-cv_name').val());
	values += "&cv_variable_type=" + encodeURIComponent($('#wk-change-cv_variable_type').val());
	values += "&cv_access_level=" + encodeURIComponent($('#wk-change-cv_access_level').val());
	values += "&cv_variable_group=" + encodeURIComponent($('#wk-change-cv_variable_group').val());
	values += "&cv_description=" + encodeURIComponent($('#wk-change-cv_description').val());

	// For restoring to the original form afterwards.
    values += "&wiki=" + $Factory.city_id;

	$.ajax({
    	type:"POST",
    	dataType: "json",
    	url: ajaxpath+"?action=ajax&rsargs[0]="+data[1]+"&rs=axWFactorySubmitChangeVariable" + values,
    	success: $Factory.VariableCallback.success,
    	error: $Factory.VariableCallback.failure,
    	timeout: 50000
    });
	return false;
};

// filter variable selector
$Factory.Variable.filter = function ( e ) {
    $Factory.Busy(1);

    // disable variable selector
    $("#wk-variable-select").attr('disabled', true);

    // read data from form
    var values = "";
    values += "&defined=" + $("#wf-only-defined").prop("checked");
    values += "&editable=" + $("#wf-only-editable").prop("checked");
    values += "&group=" + $("#wk-group-select").val();
    values += "&wiki=" + $Factory.city_id;
	values += "&string=" + $( "#wfOnlyWithString" ).val();

    $.ajax({
    	type:"POST",
    	dataType: "json",
    	url: ajaxpath+"?action=ajax&rs=axWFactoryFilterVariables" + values,
    	success: function( aData ) {
    		$('#wk-variable-select').html(aData['selector']);
    	    $( "#wk-variable-select" ).attr("disabled", false);
            $Factory.Busy(0);
    	},
    	error: function( aData ) {
    		 $Factory.Busy(0);
             $("#wk-variable-select").attr("disabled", false);
    	},
    	timeout: 50000
    });
};

// clear data in memcached
$Factory.Variable.clear = function ( e ) {
    $Factory.BusyCache(1);
    var params = "&cityid=" + $Factory.city_id;
	$.ajax({
    	type:"POST",
    	dataType: "json",
    	url: ajaxpath+"?action=ajax&rs=axWFactoryClearCache" + params,
    	success: $Factory.ReplaceCallback.success,
    	error:  $Factory.ReplaceCallback.failure,
    	timeout: 50000
    });
    return false;
};

// submit form with new variable data

$Factory.Variable.post = function (form, mode) {
    if (form == null) {
        form = "wf-variable-form";
   }

   $Factory.Busy(1);
   var params = $("#" + form).serialize();

	$.ajax({
		type:"POST",
		dataType: "json",
		url: ajaxpath,
		data: "action=ajax&rs=" + mode + "&" + params,
		success: $Factory.ReplaceCallback.success,
		error:  $Factory.ReplaceCallback.failure,
		timeout: 50000
   });
}


$Factory.Variable.submit = function (form, mode) {
	$Factory.Variable.post(form, 'axWFactorySaveVariable');
	return false;
};


//submit form with new variable data
$Factory.Variable.remove_submit = function ( confirm, form ) {
	if ( ( confirm == true ) && !window.confirm('Are You sure?') ) {
		return false;
	}
	$Factory.Variable.post(form, 'axWFactoryRemoveVariable');
	return false;
};

$Factory.Variable.tagCheck = function ( submitType ) {
	$( '#wf-tag-parse' ).empty();
	var tagName = $('#tagName').val();
	if ( tagName == '' ) {
		if( submitType == 'remove' ) {
			$Factory.Variable.remove_submit(true);
		}
		else {
			$Factory.Variable.submit();
		}
	}
	else {
		$.ajax({
	 	  	type:"POST",
	 	  	dataType: "json",
	 	  	url: ajaxpath,
	 	  	data: "action=ajax&rs=axWFactoryTagCheck&tagName="+tagName,
			success: function( oResponse ) {
				var data = oResponse;
				if( data.wikiCount == 0 ) {
					$( '#wf-tag-parse' ).get("<span style=\"color: red; font-weight: bold;\">tag doesn't exists</span>");
				}
				else {
					if( !window.confirm('This change will apply to all "'+tagName+'" tagged wikis ('+data.wikiCount+' in total). Are you really, really sure?') ) {
						return false;
					}
					if( submitType == 'remove' ) {
						$Factory.Variable.remove_submit(false);
					}
					else {
						$Factory.Variable.submit();
					}
				}
			},
			timeout: 50000
		});
	}
};

$Factory.Variable.close_submit = function (opt) {
	$Factory.Busy(1);
	var oForm = $('#wf-close-form');
	submitField = document.createElement("input");
	submitField.type = "hidden";
	submitField.name = "submit" + opt;
	submitField.value = opt;

	oForm.append(submitField);
	oForm.submit();
};

$(function() {
	$('#wf-only-defined').click( $Factory.Variable.filter );
	$('#wf-only-editable').click( $Factory.Variable.filter );
	$('#wfOnlyWithString').keyup( $Factory.Variable.filter );
	$('#wk-group-select').change( $Factory.Variable.filter );
	$('#wk-domain-add-submit').click( $Factory.Domain.add );
	$("#wf-clear-cache").click($Factory.Variable.clear);

	$("#wk-variable-select").click( function(e) {
		return $Factory.Variable.select(e, [ "wk-variable-select", 1]);
	});
});
</script>
<div id="wiki-factory">
	<div id="wk-busy-bar" style="display: none;"><img src="http://images.wikia.com/common/progress_bar.gif" width="70" height="11" alt="Wait..." border="0" /></div>
	<h2>
		Wiki info: <span class="wiki-sitename"><?php echo $wiki->city_title ?></span> <sup><small><a href="<?php echo $wikiFactoryUrl . '/' . $wiki->city_id; ?>/variables/wgSitename">edit</a></small></sup>
	</h2>
	<div id="wk-wf-info">
		<table><tr><td>
		<table class="WikiaTable" style="margin:0">
			<thead class="wf-tinyhead">
				<tr>
					<th>id</th>
					<th>database</th>
					<th>cluster</th>
					<th>language</th>
					<th>category(legacy)</th>
					<th>vertical</th>
					<th>status</th>
				</tr>
			</thead>
			<tr>
				<td><?php echo $wiki->city_id ?></td>
				<td><?php echo $wiki->city_dbname ?></td>
				<td><?php echo empty( $cluster ) ? "c1<acronym title='default'>*</acronym>" : $cluster ?></td>
				<td><?php echo $wiki->city_lang ?></td>
				<td><?php
					$wgHub = WikiFactory::getCategory( $wiki->city_id );
					if ($wgHub) echo "<acronym title=\"id:{$wgHub->cat_id}\">{$wgHub->cat_name}</acronym>";
				?></td>
				<td><?php
					$factory = new WikiFactoryHub();
					$wgHub = $factory->getWikiVertical( $wiki->city_id );
					if ($wgHub) echo "<acronym title=\"id:{$wgHub['id']}\">{$wgHub['name']}</acronym>";
				?></td>
				<td data-status="<?php echo $wiki->city_public; ?>"><?php echo "<acronym title=\"{$wiki->city_public}\">{$statuses[ $wiki->city_public ]}</acronym>" ?></td>
			</tr>
		</table>
		</td>
		<td><button class="wikia-button" id="wf-clear-cache"><?php echo wfMsg("wikifactory_removevariable") ?></button><?
				?><div id="wk-busy-cache" style="margin-left:1em; display: none;">
					<img src="<?= $wgStylePath ?>/common/images/ajax.gif" width="16" height="16" alt="Wait..." border="0" />
				</div></td>
		</tr></table>
		<ul>
			<?php  #hide domain in upper area when on domain tab, so people dont get confused by non-updating data
				if( $tab !== "domains" ): ?><li>
				Wiki domain: <strong><a href="<?php echo $wiki->city_url ?>"><?php echo $wiki->city_url ?></a></strong>
				<sup><a href="<?php echo "{$wikiFactoryUrl}/{$wiki->city_id}"; ?>/domains">edit</a></sup>
			</li><?php endif; ?>
			<li>
				<a href="<?php echo $wikiFactoryUrl; ?>"><?php echo wfMsg( "wikifactory-label-return" ); ?></a>
			</li>
		</ul>
	</div>
	<div id="wiki-factory-panel">
		<?php
			$subVariables = in_array($tab, array("variables", "ezsharedupload", "eznamespace", 'compare') );
			$subTags = in_array($tab, array('tags', 'masstags', 'findtags') );
		?>
		<ul class="tabs" id="wiki-factory-tabs">
			<li <?php echo ( $tab === "info" ) ? 'class="selected"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "info", $tab, $wiki->city_id ); ?>
			</li>
			<li <?php echo ( $subVariables ) ? 'class="selected"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "variables", ( ($subVariables)?'variables':$tab ), $wiki->city_id ); ?>
			</li>
			<li <?php echo ( $tab === "domains" ) ? 'class="selected"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "domains", $tab, $wiki->city_id ); ?>
			</li>
			<li <?php echo ( $subTags ) ? 'class="selected"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "tags", ( ($subTags)?'tags':$tab ), $wiki->city_id ); ?>
			</li>
			<li <?php echo ( $tab === "hubs" ) ? 'class="selected"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "hubs", $tab, $wiki->city_id ); ?>
			</li>
			<li <?php echo ( $tab === "clog" ) ? 'class="selected"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "clog", $tab, $wiki->city_id ); ?>
			</li>
			<li <?php echo ( $tab === "google" ) ? 'class="selected"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "google", $tab, $wiki->city_id ); ?>
			</li>
			<li <?php echo ( $tab === "close" ) ? 'class="selected"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "close", $tab, $wiki->city_id ); ?>
			</li>
		</ul>
<?php
	if( $subVariables ) {
?>
		<ul class="tabs second-row" id="wiki-factory-tabs-second">
			<li <?php echo ( $tab === "compare" ) ? 'class="selected"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "compare", $tab, $wiki->city_id ); ?>
			</li>
			<li <?php echo ( $tab === "variables" ) ? 'class="selected"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "variables", $tab, $wiki->city_id, 'variables2' ); ?>
			</li>
			<li <?php echo ( $tab === "ezsharedupload" ) ? 'class="selected"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "ezsharedupload", $tab, $wiki->city_id ); ?>
			</li>
			<li <?php echo ( $tab === "eznamespace" ) ? 'class="selected"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "eznamespace", $tab, $wiki->city_id ); ?>
			</li>
		</ul>
<?php
	}
	if( $subTags ) {
?>
		<ul class="tabs second-row" id="wiki-factory-tabs-second">
			<li <?php echo ( $tab === "tags" ) ? 'class="selected"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "tags", $tab, $wiki->city_id, 'tags2' ); ?>
			</li>
			<li <?php echo ( $tab === "masstags" ) ? 'class="selected"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "masstags", $tab, $wiki->city_id ); ?>
			</li>
			<li <?php echo ( $tab === "findtags" ) ? 'class="selected"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "findtags", $tab, $wiki->city_id ); ?>
			</li>
		</ul>
<?php
	}

	switch( $tab ):
		# INFO
			case "info":
				include_once( "form-info.tmpl.php" );
				break;

		# VARIABLES
			case "compare":
				include_once( "form-variables-compare.tmpl.php" );
				break;

			case "variables":
				include_once( "form-variables.tmpl.php" );
				break;

			case "ezsharedupload":
				include_once( "form-shared-upload.tmpl.php" );
				break;

			case "eznamespace":
				include_once( "form-namespace.tmpl.php" );
				break;

		# DOMAINS
			case "domains":
				include_once( "form-domains.tmpl.php" );
				break;

		# HUBS
			case "hubs":
				include_once( "form-hubs.tmpl.php" );
				break;

		# LOGS
			case "clog":
				include_once( "form-clog.tmpl.php" );
				break;

		# TAGS
			case "tags":
				include_once( "form-tags.tmpl.php" );
				break;

			case "masstags":
				include_once( "form-tags-mass.tmpl.php" );
				break;

			case "findtags":
				include_once( "form-tags-find.tmpl.php" );
				break;

		# GOOGLE
			case "google":
				include_once( "form-google.tmpl.php" );
				break;

		# CLOSE
			case "close":
				include_once( "form-close.tmpl.php" );
				break;

		default:
			print "unknown tab value [{$tab}]\n";

	endswitch;
?>
	</div>
</div>
<!-- e:<?= __FILE__ ?> -->
