<!-- s:<?= __FILE__ ?> -->
<!-- css part -->
<style type="text/css">
/*<![CDATA[*/
#wa-upload {border: 1px solid lightgrey;margin: 1em; padding: 1em;}
#wa-upload li {display: inline; padding-left: 2em;}
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

YAHOO.Wikia.Avatar.Submit = function(e) {
    YAHOO.util.Dom.get("wa-search-form").submit();
}

YAHOO.Wikia.Avatar.SubmitRemove = function(e) {
	if (confirm("<?= wfMsg("avatarupload_removeconfirm") ?>")) {
		YAHOO.util.Dom.get("wa-remove-form").submit();
	} else {
		YAHOO.util.Event.stopEvent(e);
	}
}
// YE.addListener("wa-ajax-submit", "click", YAHOO.Wikia.Avatar.Upload);
YE.addListener("wa-search-user", "click", YAHOO.Wikia.Avatar.Submit);
YE.addListener("wa-remove-user", "click", YAHOO.Wikia.Avatar.SubmitRemove);

/*]]>*/
</script>
<?
if (isset($status) && ($status == "WMSG_REMOVE_ERROR"))
{
?>
<div id="wa-upload">
    <div style="float:left;padding:2px;text-align:center;">
    	<?= wfMsg("avatarupload_cannotremove") ?>
    </div>	
</div>
<?
}
?>
<div id="wa-upload">
    <div style="float:left;padding:2px;text-align:center;">
    	<?= wfMsg("avatarupload_remove_info") ?> "<?= wfmsg("avatarupload_getuser") ?>"
    </div>	
	<div style="clear: both;"></div>    
	<div>
	<form id="wa-search-form" enctype="multipart/form-data" action="<?= $title->getLocalUrl() ?>" method="post">
		<input type="hidden" name="action" value="search_user" />
		<input type="text" name="av_user" size="25" value="<?= $search_user ?>">
		<input type="submit" name="wpSubmit" id="wa-search-user" value="<?= wfmsg("avatarupload_getuser") ?>">
	</form>            
	</div>
</div>
<div style="clear: both;"></div>    
<? if ($user && $is_posted) { ?>
<div id="wa-upload">
    <div style="text-align: center;padding: 1em;">
        <div id="wa-upload-progress">&nbsp;</div>
        <ul>
            <li><img src="<?= $avatar->getAvatarImage("l") ?>" alt="" /> <?= wfMsg("avatarupload_large") ?></li>
            <li><img src="<?= $avatar->getAvatarImage("m") ?>" alt="" /> <?= wfMsg("avatarupload_medium") ?></li>
            <li><img src="<?= $avatar->getAvatarImage("s") ?>" alt="" /> <?= wfMsg("avatarupload_small") ?></li>
        </ul>
    </div>
	<div style="clear: both;"></div>    
    <div style="text-align: center;padding: 1em;">
<?if (!$avatar->isDefault()) { ?>
        <form id="wa-remove-form" enctype="multipart/form-data" action="<?= $title->getLocalUrl() ?>" method="post">
            <input type="hidden" name="action" value="remove_avatar" />
            <input type="hidden" name="av_user" value="<?= $user->getName() ?>">
            <input type="submit" name="wpSubmit" id="wa-remove-user" value="<?= wfmsg("avatarupload_removeavatar") ?>">
<? } ?>    
    		<input type="button" value="<?= wfMsg("avatarupload_gotoprofile", $user->getName()) ?>" onclick="window.location='<?= Title::makeTitle( NS_USER_PROFILE , $user->getName()  )->getLocalUrl(); ?>'" />
<?if (!$avatar->isDefault()) { ?>
		</form> 
<? } ?>    
	</div>
	<div style="clear: both;"></div>    
</div>
<? } else if ($is_posted) { ?>	
<div>
    <span style="float:left;padding:5px;text-align:center;">
    	<strong><?= wfMsg("avatarupload_nouser") ?></strong>
    </span>
</div>    
<? } ?>

<div style="clear: both;"></div>    
<div id="wa-result">
</div>

<!-- e:<?= __FILE__ ?> -->
