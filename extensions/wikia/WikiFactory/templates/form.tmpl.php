<?php
	global $wgExtensionsPath, $wgStyleVersion;

	$StaticChute = new StaticChute('js');
	$StaticChute->useLocalChuteUrl();
	$YUIPackageURL = $StaticChute->getChuteUrlForPackage('yui');
?>
<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
/*<![CDATA[*/
<?php
	// use "build-in" styling for tabs on Oasis
	if (!Wikia::isOasis()) {
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
#wiki-factory ul.tabs li.active {
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
}

#wiki-factory .active {
	font-weight: bold;
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
#wk-busy-div {
    position:fixed;
    top:1em;
    right:1em;
    z-index: 9000;
}

.wf-variable-form .perror {color: #fe0000; font-weight: bold; }
.wf-variable-form .success {color: darkgreen; font-weight: bold; }
.wf-variable-form textarea { width: 90%; height: 8em; }
.wf-variable-form input.input-string { width: 90%; }

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
<script type="text/javascript">
/*<![CDATA[*/

var $Factory = {};
$Factory.Domain = {};
$Factory.Variable = {};

var ajaxpath = wgServer + wgScript;
$Factory.city_id = <?php echo $wiki->city_id ?>;


$Factory.VariableCallback = {
    success: function( aData ) {
    	$("#" + aData["div-name"]).html(aData["div-body"]);
        //--- now add listeners and events
		$.getScript(stylepath+'/common/jquery/jquery.autocomplete.js', function() {
			$('#tagName').autocomplete({
				serviceUrl: wgServer+wgScript+'?action=ajax&rs=WikiFactoryTags::axQuery',
				minChars:3,
				deferRequestBy: 0
			});
		});
        $Factory.Busy(0);
    },
    failure: function( aData ) {
        $().log( "simple replace failure" );
        $Factory.Busy(0);
    }
};

$Factory.ReplaceCallback = {
    success: function( Data ) {
        $( "#" + Data["div-name"] ).html(Data["div-body"]);

        $Factory.Busy(0);
        // other conditions
        if ( Data["div-name"] == "wf-clear-cache") {
            setTimeout("var alink = function(){ $('#wf-clear-cache').html('<?php echo wfMsg("wikifactory_removevariable") ?>');};alink();",2000);
        }
    },
    failure: function( oResponse ) {
        $Factory.Busy(0);
    },
    timeout: 50000
};

$Factory.Busy = function (state) {
    if (state == 0) {
        $("#wk-busy-div" ).css( "display", "none");
    }
    else {
    	$("#wk-busy-div" ).css( "display", "block");
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
    $Factory.Domain.CRUD("add", $( "#wk-domain-add" ).val(), "" );
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
    
    
    var change = $("<input/>")
    	.attr('value', "Change")
    	.attr('type', "button")
    	.click(jQuery.proxy(function() {
            var newdomain = $( "#wk-change-input" ).val();
            var params = "&newdomain="+newdomain;
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
		.append(change)
		.append(cancel)
		.appendTo("#"+this.element);	
	return false;
};

$Factory.Domain.confirm = function(question,element,callback) {
	$('.prompt').remove();
	var cancel = $("<a>[Cancel]<a/>").click(
			function(e) {
				$(e.target).closest("span").remove();
				return false;
			}	
    );

    var yes = $("<a>[Yes]<a/>").click(callback);
    
    $("<span><span/>")
		.html(question)
		.attr("class","prompt")
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
			    $Factory.Domain.CRUD("remove", this.domain, "");
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
				    $Factory.Domain.CRUD("setmain", this.domain, "");
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
    values += "&defined=" + $("#wf-only-defined").attr("checked");
    values += "&editable=" + $("#wf-only-editable").attr("checked");
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
    $Factory.Busy(1);
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

/*]]>*/
</script>
<div id="wiki-factory">
	<h2>
		Wiki info: <span class="wiki-sitename"><?php echo $wiki->city_title ?></span> <sup><small><a href="<?php echo $wikiFactoryUrl . '/' . $wiki->city_id; ?>/variables/wgSitename">edit</a></small></sup>
	</h2>
	<div id="wk-busy-div" style="display: none;">
		<img src="http://images.wikia.com/common/progress_bar.gif" width="100" height="9" alt="Wait..." border="0" />'
	</div>
	<div id="wk-wf-info">
		<?php echo $wiki->city_description ?>
		<table border="1" cellpadding="3" cellspacing="0">
			<thead class="wf-tinyhead">
				<tr>
					<th>id</th>
					<th>database</th>
					<th>cluster</th>
					<th>language</th>
					<th>hub</th>
					<th>status</th>
				</tr>
			</thead>
			<tr>
				<td><?php echo $wiki->city_id ?></td>
				<td><?php echo $wiki->city_dbname ?></td>
				<td><?php echo empty( $cluster ) ? "c1<acronym title='default'>*</acronym>" : $cluster ?></td>
				<td><?php echo $wiki->city_lang ?></td>
				<td><?php
					$cats = $hub->getBreadCrumb( $wiki->city_id );
					if( is_array( $cats ) ):
						foreach( $cats as $cat ):
							echo "<acronym title=\"id:{$cat["id"]}\">{$cat["name"]}</acronym>";
						endforeach;
					endif;
				?></td>
				<td><?php echo $statuses[ $wiki->city_public ] ?></td>
			</tr>
		</table>
		<ul>
			<?php  #hide tags in upper area when on tags tab, so people dont get confused by non-updating data
				if( $tab !== "domains" ): ?><li>
				Wiki domain: <strong><a href="<?php echo $wiki->city_url ?>"><?php echo $wiki->city_url ?></a></strong>
				<sup><a href="<?php echo "{$wikiFactoryUrl}/{$wiki->city_id}"; ?>/domains">edit</a></sup>
			</li><?php endif; ?>
			<li>
				Wiki was created on <strong><?php echo $wiki->city_created ?></strong>
			</li>
			<li>
				Founder name: <strong><?php echo $user_name ?></strong> (id <?php echo $wiki->city_founding_user ?>)
					<? if($wiki->city_founding_user): ?>
					<sup><a href="<?php echo $wikiFactoryUrl; ?>/Metrics?founder=<?php echo urlencode($user_name); ?>">more by user</a></sup><? endif; ?>
			</li>
			<li>
				Founder email: <?php if( empty( $wiki->city_founding_email) ) :
					print "<i>empty</i>";
				else:
					print "<strong>" . $wiki->city_founding_email . "</strong>";
					print " <sup><a href=\"{$wikiFactoryUrl}/Metrics?email=". urlencode($wiki->city_founding_email) . "\">more by email</a></sup>";
				endif; ?>
			</li>
			<?php  #hide tags in upper area when on tags tab, so people dont get confused by non-updating data
				if( $tab !== "tags" ): ?><li>
				Tags: <?php if( is_array( $tags ) ): echo "<strong>"; foreach( $tags as $id => $tag ): echo "{$tag} "; endforeach; echo "</strong>"; endif; ?>
				<sup><a href="<?php echo "{$wikiFactoryUrl}/{$wiki->city_id}"; ?>/tags">edit</a></sup>
			</li><?php endif; ?>
			<?php if ($statuses[$wiki->city_public] == 'disabled') : ?><li>
				<div>Disabled reason: <?=wfMsg('closed-reason')?> (<?=$wiki->city_additional?>)</div>
			</li><?php endif ?>
		</ul>
		<br/>
		<ul>
			<li>
				<button class="wikia-button" id="wf-clear-cache"><?php echo wfMsg("wikifactory_removevariable") ?></button>
			</li>
			<li>
				<a href="<?php echo $wikiFactoryUrl; ?>"><?php echo wfMsg( "wikifactory-label-return" ); ?></a>
			</li>
		</ul>
	</div>
	<div id="wiki-factory-panel">
		<?php
			$subVariables = in_array($tab, array("variables", "ezsharedupload", "eznamespace") );
			$subTags = in_array($tab, array('tags', 'masstags', 'findtags') );
		?>
		<ul class="tabs" id="wiki-factory-tabs">
			<li <?php echo ( $subVariables ) ? 'class="active"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "variables", ( ($subVariables)?'variables':$tab ), $wiki->city_id ); ?>
			</li>
			<li <?php echo ( $tab === "domains" ) ? 'class="active"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "domains", $tab, $wiki->city_id ); ?>
			</li>
			<li <?php echo ( $subTags ) ? 'class="active"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "tags", ( ($subTags)?'tags':$tab ), $wiki->city_id ); ?>
			</li>
			<li <?php echo ( $tab === "hubs" ) ? 'class="active"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "hubs", $tab, $wiki->city_id ); ?>
			</li>
			<li <?php echo ( $tab === "clog" ) ? 'class="active"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "clog", $tab, $wiki->city_id ); ?>
			</li>
			<li <?php echo ( $tab === "close" ) ? 'class="active"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "close", $tab, $wiki->city_id ); ?>
			</li>
		</ul>
<?php
	if( $subVariables ) {
?>
		<ul class="tabs second-row" id="wiki-factory-tabs-second">
			<li <?php echo ( $tab === "variables" ) ? 'class="active"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "variables", $tab, $wiki->city_id, 'variables2' ); ?>
			</li>
			<li <?php echo ( $tab === "ezsharedupload" ) ? 'class="active"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "ezsharedupload", $tab, $wiki->city_id ); ?>
			</li>
			<?php /* hiding this for now
			<li <?php echo ( $tab === "eznamespace" ) ? 'class="active"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "eznamespace", $tab, $wiki->city_id ); ?>
			</li> */ ?>
		</ul>
<?php
	}
	if( $subTags ) {
?>
		<ul class="tabs second-row" id="wiki-factory-tabs-second">
			<li <?php echo ( $tab === "tags" ) ? 'class="active"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "tags", $tab, $wiki->city_id, 'tags2' ); ?>
			</li>
			<li <?php echo ( $tab === "masstags" ) ? 'class="active"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "masstags", $tab, $wiki->city_id ); ?>
			</li>
			<li <?php echo ( $tab === "findtags" ) ? 'class="active"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "findtags", $tab, $wiki->city_id ); ?>
			</li>
		</ul>
<?php
	}
	switch( $tab ):
		case "variables":
			include_once( "form-variables.tmpl.php" );
		break;

			case "ezsharedupload":
				include_once( "form-shared-upload.tmpl.php" );
			break;

			#case "eznamespace":
			#	print "coming soon!\n";
			#break;

		case "domains":
			include_once( "form-domains.tmpl.php" );
		break;

		case "hubs":
			include_once( "form-hubs.tmpl.php" );
		break;

		case "clog":
			include_once( "form-clog.tmpl.php" );
		break;

		case "tags":
			include_once( "form-tags.tmpl.php" );
		break;

			case "masstags":
				include_once( "form-tags-mass.tmpl.php" );
			break;

			case "findtags":
				include_once( "form-tags-find.tmpl.php" );
			break;

		case "close":
			include_once( "form-close.tmpl.php" );
		break;

	endswitch;
?>
	</div>
</div>
<!-- e:<?= __FILE__ ?> -->
