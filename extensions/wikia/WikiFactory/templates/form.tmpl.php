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
	padding: 0.2em 1em 0.2em 1em;
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
                document.createTextNode("]")
            ]);
            $Event.addListener(id + "change", "click", $Factory.Domain.change, [id, 1, aDomains[i]]);
            $Event.addListener(id + "remove", "click", $Factory.Domain.remove, [id, 1, aDomains[i]]);
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

// data[0] - selector, data[1] - which one
$Factory.Variable.select = function ( e, data ) {
    $Factory.Busy(1);
    var values = "";
    values += "&varid=" + $Dom.get( "wk-variable-select" ).value;
    values += "&wiki=" + <?php echo $wiki->city_id ?>;
    $Connect.asyncRequest( 'GET', ajaxpath+"?action=ajax&rsargs[0]="+data[1]+"&rs=axWFactoryGetVariable" + values, $Factory.VariableCallback );
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
	values += "&string=" + YAHOO.util.Dom.get( "wfOnlyWithString" ).value;
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

YAHOO.util.Event.addListener("wf-only-defined", "click", $Factory.Variable.filter );
YAHOO.util.Event.addListener("wf-only-editable", "click", $Factory.Variable.filter );
YAHOO.util.Event.addListener("wfOnlyWithString", "keypress", $Factory.Variable.filter );
YAHOO.util.Event.addListener("wk-group-select", "change", $Factory.Variable.filter );

YAHOO.util.Event.addListener("wk-variable-select", "click", $Factory.Variable.select, [ "wk-variable-select", 1] );
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
                Wiki founder identifier is <strong><?php echo $wiki->city_founding_user ?></strong>
                and his/her email is <strong><?php echo empty( $wiki->city_founding_email) ? "empty" : $wiki->city_founding_email ?></strong>
            </li>
            <li>
                This wiki is <strong><?php echo $statuses[ $wiki->city_public ] ?></strong>.
				            <? if(($statuses[$wiki->city_public] == 'disabled') && is_object($wikiRequest)): ?>
				            	(<a href="/index.php?title=Special:CreateWiki&request=<?=$wikiRequest->request_id;?>&action=delete&doit=1">delete request for this wiki</a>)
				            <? elseif(($statuses[$wiki->city_public] == 'disabled') && ($wikiRequest != null)): ?>
				             (<i>no wiki request were found with name: <?=$wikiRequest;?></i>)
				            <? endif; ?>
            </li>
            <li><a href="#" id="wf-clear-cache"><?php echo wfMsg("wikifactory_removevariable") ?></a></li>
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

	endswitch;
?>
	</div>
</div>
<!-- e:<?= __FILE__ ?> -->
