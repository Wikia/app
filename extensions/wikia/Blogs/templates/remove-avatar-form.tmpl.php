<!-- s:<?= __FILE__ ?> -->
<!-- css part -->
<style type="text/css">
/*<![CDATA[*/
#wba-upload {border: 1px solid lightgrey;margin: 1em; padding: 1em;}
#wba-upload li {display: inline; padding-left: 2em;}
/*]]>*/
</style>
<!-- js part -->
<script type="text/javascript">
/*<![CDATA[*/
YAHOO.namespace("Blog.Avatar");

var YC = YAHOO.util.Connect;
var YD = YAHOO.util.Dom;
var YE = YAHOO.util.Event;
var WA = YAHOO.Blog.Avatar;

YAHOO.Blog.Avatar.Submit = function(e) {
    YAHOO.util.Dom.get("wba-search-form").submit();
}

YAHOO.Blog.Avatar.SubmitRemove = function(e) {
	if (confirm("<?= wfMsg("blog-avatar-remove-confirm") ?>")) {
		YAHOO.util.Dom.get("wba-remove-form").submit();
	} else {
		YAHOO.util.Event.stopEvent(e);
	}
}
YE.addListener("wba-search-user", "click", YAHOO.Blog.Avatar.Submit);
YE.addListener("wba-remove-user", "click", YAHOO.Blog.Avatar.SubmitRemove);

/*]]>*/
</script>
<?
if (isset($status) && ($status == "WMSG_REMOVE_ERROR"))
{
?>
<div id="wba-upload">
    <div style="float:left;padding:2px;text-align:center;">
    	<?= wfMsg("blog-avatar-cannot-remove") ?>
    </div>	
</div>
<?
}
?>
<div id="wba-upload">
    <div style="float:left;padding:5px 2px;text-align:left;">
    	<?= wfMsg("blog-avatar-remove-info") ?>
    </div>	
	<div style="clear: both;"></div>    
	<div>
		<form id="wba-search-form" enctype="multipart/form-data" action="<?= $title->getLocalUrl() ?>" method="post">
			<input type="hidden" name="action" value="search_user" />
			<input type="text" name="av_user" size="25" value="<?= $search_user ?>">
			<input type="submit" name="wpSubmit" id="wba-search-user" value="<?= wfmsg("blog-avatar-getuser") ?>">
		</form>            
	</div>
</div>
<div style="clear: both;"></div>    
<? if ($user && $is_posted) { ?>
<div id="wba-upload">
    <div style="text-align: center;padding: 5px;">
        <div style="text-align:center;padding: 5px;font-weight:bold"><?= $user->getName() ?></div>
        <div style="text-align: center;"><?= $avatar->getImageTag( 100, 100 )?></div>
    </div>
	<div style="clear: both;"></div>
    <div style="text-align: center;padding: 5px;">
<?if (!$avatar->isDefault()) { ?>
        <form id="wba-remove-form" enctype="multipart/form-data" action="<?= $title->getLocalUrl() ?>" method="post">
            <input type="hidden" name="action" value="remove_avatar" />
            <input type="hidden" name="av_user" value="<?= $user->getName() ?>">
            <input type="submit" name="wpSubmit" id="wba-remove-user" value="<?= wfmsg("blog-avatar-removeavatar") ?>">
<? } ?>    
    		<input type="button" value="<?= wfMsg("blog-avatar-goto-userpage", $user->getName()) ?>" onclick="window.location='<?= Title::makeTitle( NS_USER, $user->getName() )->getLocalUrl(); ?>'" />
<?if (!$avatar->isDefault()) { ?>
		</form> 
<? } ?>    
	</div>
	<div style="clear: both;"></div>    
</div>
<? } else if ($is_posted) { ?>	
<div>
    <span style="float:left;padding:5px;text-align:center;">
    	<strong><?= wfMsg("blog-avatar-nouser") ?></strong>
    </span>
</div>    
<? } ?>

<div style="clear: both;"></div>    
<div id="wba-result">
</div>
<!-- e:<?= __FILE__ ?> -->
