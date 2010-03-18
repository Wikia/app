<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
/*<![CDATA[*/
#wiki-factory ul.tabs {
	width: 100%;
	margin: 0;
	margin-bottom: 1em;
	border-bottom: 1px solid gray;
}
#wiki-factory ul.tabs li {
	display: inline;
	margin: 0;
	text-align: center;
	padding: 0.2em 0.4em 0.2em 0.4em;
	width: 100%;
}
#wiki-factory ul.tabs li.active {
	font-weight: bold;
	border: 1px solid gray;
	border-bottom: none;
	background-color: #f9f9f9;
}
#wiki-factory ul.tabs li.inactive {
	font-weight: bold;
	border: 1px solid gray;
	background-color: #f9f9f9;
}

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

#wf-variable-form .perror {color: #fe0000; font-weight: bold; }
#wf-variable-form .success {color: darkgreen; font-weight: bold; }
.prompt { color: #fe0000 }

div.wf-info {
    border-left: 2px solid darkgreen; background: #CFC;
    font-style: italic;
    margin: 0.4em; padding: 0.4em;
}
/*]]>*/
</style>
<script type="text/javascript">
/*<![CDATA[*/
YAHOO.namespace("Wiki.Factory");
YAHOO.namespace("Wiki.Factory.Domain");
YAHOO.namespace("Wiki.Factory.Variable");

var $Connect = YAHOO.util.Connect;
var $Dom = YAHOO.util.Dom;
var $Event = YAHOO.util.Event;
var $Factory = YAHOO.Wiki.Factory;
var ajaxpath = "<?php echo $GLOBALS["wgScriptPath"]."/index.php"; ?>";

// return 10digits random id
$Factory.randid = function(){var a=""; for(var i=0; i<10; i++){var d=Math.floor(Math.random()*10);a += d+"";}return a;};

$Factory.VariableCallback = {
    success: function( oResponse ) {
        var aData = YAHOO.Tools.JSONParse(oResponse.responseText);
        var div = $Dom.get( aData["div-name"] );
        div.innerHTML = aData["div-body"];
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
    failure: function( oResponse ) {
        YAHOO.log( "simple replace failure " + oResponse.responseText );
        $Factory.Busy(0);
    },
    timeout: 50000
};

$Factory.FilterCallback = {
    success: function( oResponse ) {
        var aData = YAHOO.Tools.JSONParse( oResponse.responseText );
        $Dom.get( "wk-variable-select" ).innerHTML = aData["selector"];
        $Dom.get( "wk-variable-select" ).disabled = false;
        $Factory.Busy(0);

    },
    failure: function( oResponse ) {
        $Factory.Busy(0);
        $Dom.get("wk-variable-select").disabled = false;
    },
    timeout: 50000
};

$Factory.ReplaceCallback = {
    success: function( oResponse ) {
        var Data = YAHOO.Tools.JSONParse(oResponse.responseText);
        $Dom.get( Data["div-name"] ).innerHTML = Data["div-body"];

        $Factory.Busy(0);
        // other conditions
        if ( Data["div-name"] == "wf-clear-cache") {
            setTimeout("var alink = function(){$Dom.get('wf-clear-cache').innerHTML ='<?php echo wfMsg("wikifactory_removevariable") ?>';};alink();",2000);
        }
    },
    failure: function( oResponse ) {
        $Factory.Busy(0);
    },
    timeout: 50000
};

$Factory.Busy = function (state) {
    if (state == 0) {
        $Dom.setStyle("wk-busy-div", "display", "none");
    }
    else {
        $Dom.setStyle("wk-busy-div", "display", "block");
    }
};

$Factory.Domain.Callback = {
    success: function( oResponse ) {
        var oReturn = YAHOO.Tools.JSONParse(oResponse.responseText);
        var aDomains = oReturn["domains"];
        var sInfo = oReturn["info"];

        var sHTML = "";
        document.getElementById( "wk-domain-ol" ).innerHTML = "";
        for (var i=0;i<aDomains.length;i++) {
            var id = $Factory.randid();
            var li = $Dom.create("li", aDomains[i], {id: id},[
                document.createTextNode( " [" ),
                $Dom.create("a", "change", {id: id + "change", href: "#"}),
                document.createTextNode("] ["),
                $Dom.create("a", "remove", {id: id + "remove", href: "#"}),
                document.createTextNode("] ["),
                $Dom.create("a", "setmain", {id: id + "setmain", href: "#"}),
                document.createTextNode("]")
            ]);
            $Event.addListener(id + "change", "click", $Factory.Domain.change, [id, 1, aDomains[i]]);
            $Event.addListener(id + "remove", "click", $Factory.Domain.remove, [id, 1, aDomains[i]]);
            $Event.addListener(id + "setmain", "click", $Factory.Domain.setmain, [id, 1, aDomains[i]]);
            $Dom.get( "wk-domain-ol" ).appendChild(li);
        }
        var info = $Dom.create("div", "", {});
        info.innerHTML = sInfo;
        $Dom.get( "wk-domain-ol" ).appendChild(info);
        $Factory.Busy(0);
    },
    failure: function( oResponse ) {
        $Factory.Busy(0);
    },
    timeout: 20000
};

$Factory.Domain.add = function ( e ) {
    $Factory.Busy(1);
    var input = document.getElementById( "wk-domain-add" );
    var params = "&domain="+input.value+"&cityid="+<?php echo $wiki->city_id ?>;
    $Connect.asyncRequest( "GET", ajaxpath+"?action=ajax&rs=axWFactoryDomainCRUD&rsargs[0]=add" + params, $Factory.Domain.Callback );
};

// data[0] - div we change, data[1] - step, data[2] - domainname
$Factory.Domain.change = function ( e, data ) {
    $Event.preventDefault(e);
    switch ( data[1] ) {
        case 1:
            var id = $Factory.randid();
            $Dom.get( data[0] ).innerHTML = "";
            var prompt = $Dom.create("span", "New domain name: ", {},[
                $Dom.create("input", "", { id: "wk-change-input", name: "wk-change-input", type: "text", value: data[2], size: "20", maxlength: "255" }),
                $Dom.create("input", "", { id: id+"change", name: id+"change", value: "Change", type: "button" }),
                $Dom.create("input", "", { id: id+"cancel", name: id+"cancel", value: "Cancel", type: "button" })
            ]);
            $Dom.get( data[0] ).appendChild(prompt);
            $Event.addListener(id+"cancel", "click", $Factory.Domain.change, [data[0], 2, data[2]]);
            $Event.addListener(id+"change", "click", $Factory.Domain.change, [data[0], 3, data[2]]);
            break;
        case 2:
            $Factory.Busy(1);
            var params = "&cityid="+<?php echo $wiki->city_id ?>;
            $Connect.asyncRequest( "GET", ajaxpath+"?action=ajax&rs=axWFactoryDomainCRUD&rsargs[0]=cancel" + params, $Factory.Domain.Callback );
            break;
        case 3:
            $Factory.Busy(1);
            var newdomain = document.getElementById( "wk-change-input" ).value;
            var params = "&cityid="+<?php echo $wiki->city_id ?>+"&domain="+data[2]+"&newdomain="+newdomain;
            $Connect.asyncRequest( "GET", ajaxpath+"?action=ajax&rs=axWFactoryDomainCRUD&rsargs[0]=change" + params, $Factory.Domain.Callback );
            break;
    }
};
// data[0] - div we change, data[1] - step, data[2] - domainname
$Factory.Domain.remove = function ( e, data ) {
    $Event.preventDefault(e);
    switch ( data[1] ) {
        case 1:
            var id = $Factory.randid();
            document.getElementById( data[0] ).innerHTML = "";
            var prompt = $Dom.create("span", "Remove "+data[2]+"?", {className: "prompt"},[
                document.createTextNode(" ["),
                $Dom.create("a", "Yes", {id: id+"remove", href: "#"}),
                document.createTextNode("] ["),
                $Dom.create("a", "Cancel", {id: id+"cancel", href: "#"}),
                document.createTextNode("]")
            ]);
            document.getElementById( data[0] ).appendChild(prompt);
            $Event.addListener(id+"cancel", "click", $Factory.Domain.remove, [data[0], 2, data[2]]);
            $Event.addListener(id+"remove", "click", $Factory.Domain.remove, [data[0], 3, data[2]]);
            break;
        case 2:
            $Factory.Busy(1);
            var params = "&cityid="+<?php echo $wiki->city_id ?>;
            $Connect.asyncRequest( "GET", ajaxpath+"?action=ajax&rs=axWFactoryDomainCRUD&rsargs[0]=cancel" + params, $Factory.Domain.Callback );
            break;
        case 3:
            $Factory.Busy(1);
            var params = "&cityid="+<?php echo $wiki->city_id ?>+"&domain="+data[2];
            $Connect.asyncRequest( "GET", ajaxpath+"?action=ajax&rs=axWFactoryDomainCRUD&rsargs[0]=remove" + params, $Factory.Domain.Callback );
            break;
    }
};
// data[0] - div we change, data[1] - step, data[2] - domainname
$Factory.Domain.setmain = function ( e, data ) {
    $Event.preventDefault(e);
    switch ( data[1] ) {
        case 1:
            var id = $Factory.randid();
            document.getElementById( data[0] ).innerHTML = "";
            var prompt = $Dom.create("span", "Set "+data[2]+" as main?", {className: "prompt"},[
                document.createTextNode(" ["),
                $Dom.create("a", "Yes", {id: id+"setmain", href: "#"}),
                document.createTextNode("] ["),
                $Dom.create("a", "Cancel", {id: id+"cancel", href: "#"}),
                document.createTextNode("]")
            ]);
            document.getElementById( data[0] ).appendChild(prompt);
            $Event.addListener(id+"cancel", "click", $Factory.Domain.setmain, [data[0], 2, data[2]]);
            $Event.addListener(id+"setmain", "click", $Factory.Domain.setmain, [data[0], 3, data[2]]);
            break;
        case 2:
            $Factory.Busy(1);
            var params = "&cityid="+<?php echo $wiki->city_id ?>;
            $Connect.asyncRequest( "GET", ajaxpath+"?action=ajax&rs=axWFactoryDomainCRUD&rsargs[0]=cancel" + params, $Factory.Domain.Callback );
            break;
        case 3:
            $Factory.Busy(1);
            var params = "&cityid="+<?php echo $wiki->city_id ?>+"&domain="+data[2];
            $Connect.asyncRequest( "GET", ajaxpath+"?action=ajax&rs=axWFactoryDomainCRUD&rsargs[0]=setmain" + params, $Factory.Domain.Callback );
            break;
    }
};

// data[0] - selector, data[1] - which one
$Factory.Variable.select = function ( e, data ) {
    $Factory.Busy(1);
    var values = "";
    values += "&varid=" + $Dom.get( "wk-variable-select" ).value;
    values += "&wiki=" + <?php echo $wiki->city_id ?>;
    $Connect.asyncRequest( 'GET', ajaxpath+"?action=ajax&rsargs[0]="+data[1]+"&rs=axWFactoryGetVariable" + values, $Factory.VariableCallback );
};

// For editing the variable itself (not its value).
$Factory.Variable.change = function ( e, data ) {
    $Factory.Busy(1);
    var values = "";
    values += "&varid=" + $Dom.get( "wk-variable-select" ).value;
    values += "&wiki=" + <?php echo $wiki->city_id ?>;
    $Connect.asyncRequest( 'GET', ajaxpath+"?action=ajax&rsargs[0]="+data[1]+"&rs=axWFactoryChangeVariable" + values, $Factory.VariableCallback );
};

// For editing the variable itself (not its value).
$Factory.Variable.submitChangeVariable = function ( e, data ) {
	$Factory.Busy(1);

    var values = "";

	// TODO: FILL THE VALUES WITH EVERYTHING FROM THE FORM.
	values += "&cv_variable_id=" + encodeURIComponent($Dom.get('wk-change-cv_variable_id').value);
	values += "&cv_name=" + encodeURIComponent($Dom.get('wk-change-cv_name').value);
	values += "&cv_variable_type=" + encodeURIComponent($Dom.get('wk-change-cv_variable_type').value);
	values += "&cv_access_level=" + encodeURIComponent($Dom.get('wk-change-cv_access_level').value);
	values += "&cv_variable_group=" + encodeURIComponent($Dom.get('wk-change-cv_variable_group').value);
	values += "&cv_description=" + encodeURIComponent($Dom.get('wk-change-cv_description').value);

	// For restoring to the original form afterwards.
    values += "&wiki=" + <?php echo $wiki->city_id ?>;
    $Connect.asyncRequest( 'POST', ajaxpath+"?action=ajax&rsargs[0]="+data[1]+"&rs=axWFactorySubmitChangeVariable" + values, $Factory.VariableCallback );
	return false;
};

// filter variable selector
$Factory.Variable.filter = function ( e ) {
    $Factory.Busy(1);

    // disable variable selector
    $Dom.get("wk-variable-select").disabled = true;

    // read data from form
    var values = "";
    values += "&defined=" + $Dom.get("wf-only-defined").checked;
    values += "&editable=" + $Dom.get("wf-only-editable").checked;
    values += "&group=" + $Dom.get("wk-group-select").value;
    values += "&wiki=" + <?php echo $wiki->city_id ?>;
	values += "&string=" + $Dom.get( "wfOnlyWithString" ).value;
    $Connect.asyncRequest( 'GET', ajaxpath+"?action=ajax&rs=axWFactoryFilterVariables" + values, $Factory.FilterCallback );
};

// clear data in memcached
$Factory.Variable.clear = function ( e ) {
    $Event.preventDefault(e);
    $Factory.Busy(1);
    var params = "&cityid=" + <?php echo $wiki->city_id ?>;
    $Connect.asyncRequest( 'GET', ajaxpath+"?action=ajax&rs=axWFactoryClearCache" + params, $Factory.ReplaceCallback );
};

$Factory.Variable.remove = function ( e, step ) {
    $Event.preventDefault(e);
    switch ( step ) {
        case 1:
            break;
        case 2:
            break;
    }
    $Factory.Busy(1);
};

// submit form with new variable data
$Factory.Variable.submit = function () {
    $Factory.Busy(1);
    var oForm = $Dom.get('wf-variable-form');
    $Connect.setForm(oForm, false);
    $Connect.asyncRequest( 'POST', ajaxpath+"?action=ajax&rs=axWFactorySaveVariable", $Factory.ReplaceCallback );
};

$Factory.Variable.tagCheck = function ( submitType ) {
	$Dom.get( 'wf-tag-parse' ).innerHTML = '';
	var tagName = $Dom.get('tagName').value;
	if ( tagName == '' ) {
		if( submitType == 'remove' ) {
			$Factory.Variable.remove_submit(true);
		}
		else {
			$Factory.Variable.submit();
		}
	}
	else {
		$Connect.asyncRequest( 'POST', ajaxpath+"?action=ajax&rs=axWFactoryTagCheck&tagName="+tagName, {
			success: function( oResponse ) {
				var data = YAHOO.Tools.JSONParse(oResponse.responseText);
				if( data.wikiCount == 0 ) {
					$Dom.get( 'wf-tag-parse' ).innerHTML = "<span style=\"color: red; font-weight: bold;\">tag doesn't exists</span>";
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

// submit form with new variable data
$Factory.Variable.remove_submit = function ( confirm ) {
	if ( ( confirm == true ) && !window.confirm('Are You sure?') ) {
		return false;
	}

	$Factory.Busy(1);
	var oForm = $Dom.get('wf-variable-form');
	$Connect.setForm(oForm, false);
	$Connect.asyncRequest( 'POST', ajaxpath+"?action=ajax&rs=axWFactoryRemoveVariable", $Factory.ReplaceCallback );
};

$Factory.Variable.close_submit = function (opt) {
    $Factory.Busy(1);
    var oForm = $Dom.get('wf-close-form');
	submitField = document.createElement("input");
	submitField.type = "hidden";
	submitField.name = "submit" + opt;
	submitField.value = opt;
	oForm.appendChild(submitField);
	oForm.submit();
};

YAHOO.util.Event.addListener("wf-only-defined", "click", $Factory.Variable.filter );
YAHOO.util.Event.addListener("wf-only-editable", "click", $Factory.Variable.filter );
YAHOO.util.Event.addListener("wfOnlyWithString", "keypress", $Factory.Variable.filter );
YAHOO.util.Event.addListener("wk-group-select", "change", $Factory.Variable.filter );

YAHOO.util.Event.addListener("wk-variable-select", "click", $Factory.Variable.select, [ "wk-variable-select", 1] );
//YAHOO.util.Event.addListener("wk-variable-change", "click", $Factory.Variable.change, [ "wk-variable-select", 1] ); // only works for first load.
YAHOO.util.Event.addListener("wk-domain-add-submit", "click", $Factory.Domain.add, "wk-domain-add");
YAHOO.util.Event.addListener("wf-clear-cache", "click", $Factory.Variable.clear);

/*]]>*/
</script>
<div id="wiki-factory">
    <h2>
        Wiki info: <?php echo $wiki->city_title ?>
    </h2>
    <div id="wk-busy-div" style="display: none;">
        <img src="http://images.wikia.com/common/progress_bar.gif" width="100" height="9" alt="Wait..." border="0" />'
    </div>
    <div id="wk-wf-info">
        <?php echo $wiki->city_description ?>
        <ul>
            <li>
				Wiki identifier is <strong><?php echo $wiki->city_id ?></strong>
			</li>
            <li>
				Wiki uses database <strong><?php echo $wiki->city_dbname ?></strong>
				on cluster <strong><?php echo empty( $cluster ) ? "c1 (DEFAULT)" : $cluster ?></strong>
			</li>
            <li>
				Wiki language is <strong><?php echo $wiki->city_lang ?></strong>
			</li>
            <li>
				Wiki Hub is <strong>
				<?php
					$cats = $hub->getBreadCrumb( $wiki->city_id );
					if( is_array( $cats ) ):
						foreach( $cats as $cat ):
							echo "<a href=\"{$cat["url"]}\">{$cat["name"]}</a>";
						endforeach;
					endif;
				?>
				</strong>
			</li>
            <li>
			    Wiki founder name is <strong><?php echo $user_name ?></strong> (id <?php echo $wiki->city_founding_user ?>)
                   <? if($wiki->city_founding_user): ?>
                   <sup><a href="/index.php?title=Special:WikiFactory/Metrics&founder=<?php echo urlencode($user_name); ?>">more by user</a></sup>
                   <? endif; ?>
                and his/her email is <strong><?php if( empty( $wiki->city_founding_email) ) :
                   ?><i>empty</i><? else: ?>
                   <? echo $wiki->city_founding_email; ?>
                   <sup><a href="/index.php?title=Special:WikiFactory/Metrics&email=<?php echo urlencode($wiki->city_founding_email); ?>">more by email</a></sup>
                   <? endif; ?></strong>
            </li>
			<li>
				Wiki was created on <strong><?php echo $wiki->city_created ?></strong>
			</li>
            <li>
                This wiki is <strong><?php echo $statuses[ $wiki->city_public ] ?></strong>.
<?php if(($statuses[$wiki->city_public] == 'disabled') && is_object($wikiRequest)): ?>
				(<a href="/index.php?title=Special:CreateWiki&request=<?=$wikiRequest->request_id;?>&action=delete&doit=1">delete request for this wiki</a>)
<?php elseif(($statuses[$wiki->city_public] == 'disabled') && ($wikiRequest != null)): ?>
				(<i>no wiki request were found with name: <?=$wikiRequest;?></i>)
<?php endif;
	  if ($statuses[$wiki->city_public] == 'disabled') : ?>
            <div>
            	(<?=wfMsg('closed-reason')?> <?=$wiki->city_additional?>)
            </div>
<?php endif ?>
            </li>
			<li>
				Tags: <?php if( is_array( $tags ) ): foreach( $tags as $id => $tag ): echo "<strong>{$tag}</strong> "; endforeach; endif; ?>
				<sup>
					<a href="<?php echo $GLOBALS[ "wgScript" ] ?>?title=Special:WikiFactory/<?php echo $wiki->city_id ?>/tags">edit</a>
				</sup>
			</li>
            <li>
				<a href="#" id="wf-clear-cache"><?php echo wfMsg("wikifactory_removevariable") ?></a>
			</li>
        </ul>
    </div>
	<div id="wiki-factory-panel">
		<ul class="tabs">
			<li>
				&nbsp;
			</li>
			<li <?php echo ( $tab === "variables" ) ? 'class="active"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "variables", $tab, $wiki->city_id ); ?>
			</li>
			<li>
				&nbsp;
			</li>
			<li <?php echo ( $tab === "domains" ) ? 'class="active"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "domains", $tab, $wiki->city_id ); ?>
			</li>
			<li>
				&nbsp;
			</li>
			<li <?php echo ( $tab === "tags" ) ? 'class="active"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "tags", $tab, $wiki->city_id ); ?>
			</li>
			<li>
				&nbsp;
			</li>
			<li <?php echo ( $tab === "hubs" ) ? 'class="active"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "hubs", $tab, $wiki->city_id ); ?>
			</li>
			<li>
				&nbsp;
			</li>
			<li <?php echo ( $tab === "clog" ) ? 'class="active"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "clog", $tab, $wiki->city_id ); ?>
			</li>
			<li>
				&nbsp;
			</li>
			<li <?php echo ( $tab === "ezsharedupload" ) ? 'class="active"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "ezsharedupload", $tab, $wiki->city_id ); ?>
			</li>
				&nbsp;
			<li>
			<li <?php echo ( $tab === "close" ) ? 'class="active"' : 'class="inactive"' ?> >
				<?php echo WikiFactoryPage::showTab( "close", $tab, $wiki->city_id ); ?>
			</li>
				&nbsp;
			</li>
			<li class="inactive">
				<a href="<?php echo Title::newFromText( "WikiFactory", NS_SPECIAL )->getLocalUrl(); ?>">
					<?php echo wfMsg( "wikifactory-label-return" ) ?>
				</a>
			</li>
		</ul>
<?php
	switch( $tab ):
		case "variables":
			include_once( "form-variables.tmpl.php" );
		break;

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

		case "ezsharedupload":
			include_once( "form-shared-upload.tmpl.php" );
		break;

		case "close":
			include_once( "form-close.tmpl.php" );
		break;

	endswitch;
?>
	</div>
</div>
<!-- e:<?= __FILE__ ?> -->
