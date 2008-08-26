<!-- s:<?= __FILE__ ?> -->
<!-- css part -->
<style type="text/css">
/*<![CDATA[*/

#wa-title {margin: 1em; padding: 1em;}
#wa-upload {text-align: left;}
#wa-upload li {display: inline; padding-left: 2em;}

.firstHeading {
	padding-left:0px;
	margin: 0px 0px 10px 79px;
	z-index:1;
}
.user-image-avatar {
    border:0px none;
    color:#797979;
    float:left;
    font-weight:normal;
    height:75px;
    margin-top:-25px;
    padding-bottom:10px;
    position:relative;
    text-align:center;
    width:77px;
    z-index:3;
}

.user-feed-title{
    background-color:transparent;
    border-bottom:1px solid #DCDCDC;
    color:#000000;
    float:left;
    font-weight:bold;
    margin:-14px 0px 15px;
    padding-bottom:20px;
    position:relative;
    width:100%;
    z-index:2;
}

.user-feed-menu {
	float:left;
	vertical-align: top;
	margin: 5px 0px 0px 0px;
	padding: 0px 10px 2px 10px;
}

.user-feed-menu a {
 	text-decoration:none;
 	font-size:9pt;
}

#contentSub, #contentSub2 {
	font-size: 84%;
	line-height: 1.2em;
	margin: 0 0 1.4em 0em;
	color: #7d7d7d;
	width: auto;
	border: 0px;
	padding-top: 55px;
	position: absolute;
}

#siteSub {
	float:left;
	padding-top: 65px;
	position: absolute;
	width: auto;
}

.usermessage {
    margin:15px 0pt 1em 82px;
    padding:0.5em 0.6em;
    position:absolute;
    vertical-align:middle;
    z-index:10;    
}

/*]]>*/
</style>
<!-- js part -->
<script type="text/javascript">
/*<![CDATA[*/
YAHOO.namespace("Wikia.Avatar");

var YC = YAHOO.util.Connect;
var YD = YAHOO.util.Dom;
var YE = YAHOO.util.Event;
var WA = YAHOO.Wikia.Avatar;

YAHOO.Wikia.Avatar.UploadCallback = {
    upload: function( oResponse ) {
        // var aData = YAHOO.Tools.JSONParse(oResponse.responseText);
        YD.get("wa-upload-progress").innerHTML = oResponse.responseText;
    },
    failure: function( oResponse ) {
        //
        YD.get("wa-upload-progress").innerHTML="&nbsp;";
    }
};

YAHOO.Wikia.Avatar.Upload = function(e) {
    YE.preventDefault(e);
    var oForm = document.getElementById("wa-upload-form");
    YC.setForm(YAHOO.util.Dom.get("wa-upload-form"), true);
    YD.get("wa-upload-progress").innerHTML="&nbsp;<img src=\"/skins/common/progressbar_microsoft.gif\" />";
    YAHOO.util.Connect.asyncRequest('POST', "/index.php?action=ajax&rs=axWAvatarUpload", YAHOO.Wikia.Avatar.UploadCallback );
};

YAHOO.Wikia.Avatar.Submit = function(e) {
    YAHOO.util.Dom.get("wa-upload-form").submit();
}
// YE.addListener("wa-ajax-submit", "click", YAHOO.Wikia.Avatar.Upload);
// YE.addListener("wa-upload-file", "submit", YAHOO.Wikia.Avatar.Submit);
YE.addListener("wa-upload-file", "change", YAHOO.Wikia.Avatar.Submit);


/*]]>*/
</script>
<div class="user-feed-title">
    <span class="user-image-avatar"><?= $avatar->getAvatarImageLink("l", ($avatar->isDefault()) ? 0 : 2) ?></span>
    <span class="user-feed-menu">
        <div>
        <?php foreach ($links as $id => $link): ?>
            <?php if ($id !== 0) echo "-"; ?>
            <a href="<?= $link["link"] ?>"><?= $link["name"] ?></a>
        <?php endforeach ?>
        </div>
    </span>
</div>
<div id="wa-upload">
    <?= wfMsg("avatarupload_info") ?>
    <div style="text-align: center;">
        <br />
        <form id="wa-upload-form" enctype="multipart/form-data" action="<?= $title->getLocalUrl() ?>" method="post">
            <input type="hidden" name="action" value="upload" />
            <input type="file" id="wa-upload-file" name="wpUpload" size="20" />
            <noscript><input type="submit" id="wa-upload-submit" name="wpSubmit" value="<?= wfmsg("Upload") ?>" /></noscript>
        </form>
        <div id="wa-upload-progress">&nbsp;</div>
        <strong>
<?php
if ($is_posted) {
    switch($status) {
        case UPLOAD_ERR_OK:
            echo wfMsg("avatarupload_error_success");
            break;
        case UPLOAD_ERR_NO_FILE:
            echo wfMsg("avatarupload_error_toobig");
            break;
        case UPLOAD_ERR_EXTENSION:
            echo wfMsg("avatarupload_error_badext");
            break;
        case UPLOAD_ERR_CANT_WRITE:
            echo wfMsg("avatarupload_error_readonly");
            break;
        case WMSG_REMOVE_ERROR:
            echo wfMsg("avatarupload_cannotremoveforyou");
            break;
    }
}
?>
        </strong>
        <ul>
            <li><img src="<?= $avatar->getAvatarImage("l") ?>" alt="" /> <?= wfMsg("avatarupload_large") ?></li>
            <li><img src="<?= $avatar->getAvatarImage("m") ?>" alt="" /> <?= wfMsg("avatarupload_medium") ?></li>
            <li><img src="<?= $avatar->getAvatarImage("s") ?>" alt="" /> <?= wfMsg("avatarupload_small") ?></li>
        </ul>
    </div>
</div>
<div id="wa-result">
</div>

<!-- e:<?= __FILE__ ?> -->
