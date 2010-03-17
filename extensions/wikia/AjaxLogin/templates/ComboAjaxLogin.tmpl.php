<?php
global $wgAuth, $wgUser, $wgEnableEmail,$wgStylePath,$wgBlankImgUrl;

$titleObj = SpecialPage::getTitleFor( 'Userlogin' );
$link = $titleObj->getLocalUrl('type=signup');
?>
<div id="AjaxLoginBox" title="<?= wfMsg('comboajaxlogin-createlog') ?>">
    <div style="margin-left:10px;margin-top:10px;margin-bottom:10px;"><?= wfMsg('comboajaxlogin-actionmsg') ?></div>
    <? if (!$isReadOnly ) { ?> 
        <div id="AjaxLoginButtons" title="<?= wfMsg('login') ?>">
        	<input type="submit" id="wpGoLogin" value="<?= wfMsg("login") ?>" onclick="AjaxLogin.showLogin(this); return false;" />
        	<input type="submit" id="wpGoRegister" value="<?= wfMsg("nologinlink") ?>" onclick="AjaxLogin.showRegister(this); return false;" />
        </div>                                                                          
    <? } else {}?>
    <div id="AjaxLoginLoginForm" <? echo ($isReadOnly ? '':'style="display:none"'); ?> title="<?= wfMsg('login') ?>">    
    <div id="userloginErrorBox3" style="display: none;">
        <table>
        <tbody>
        <tr>
            <td style="vertical-align: top;">
                    <span style="position: relative; top: -1px;"><img src="<?php print $wgBlankImgUrl; ?>" alt="status"/></span>
            </td>
            <td>
                <div id="wpError"></div>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
        <form action="" method="post" name="userajaxloginform">
            <div style="margin: 10px;" >
	            <div id="wpError"></div>
	            <label for="wpName1" style="display: block; font-weight: bold;"><?= wfMsg("yourname") ?></label> 
	            <table>
	            <tr style="width:350px" >
	                <td id="ajaxlogin_username_cell">
	                    
	                </td>
	                <td><a id="wpAjaxRegister" href="<?= htmlspecialchars($link) ?>" style="font-size: 9pt;display:none;"><?= wfMsg('nologinlink') ?></a></td>
	            </tr>
	            </table>
	            <label for="wpPassword1" style="display: block; font-weight: bold; margin-top: 8px"><?= wfMsg("yourpassword") ?></label>
	            <table>
	            <tr>
	                <td id="ajaxlogin_password_cell">
	                    
	                </td>
	            <?php if( $wgEnableEmail && $wgAuth->allowPasswordChange() ) { ?>
	                <td><a id="wpMailmypassword" href="#" style="font-size: 9pt;" onclick="AjaxLogin.action='password'; AjaxLogin.form.submit();"><?= wfMsg('mailmypassword') ?></a></td>
	                </td>
	            <?php } ?>
	            </tr>
	            </table>
	            <div style="margin: 15px 0;">
	                <label for="wpRemember1" style="padding-left: 5px"><?= wfMsg('remembermypassword') ?></label>
	            </div>
	      	</div>
	        <div class="modalToolbar neutral">
	        	<input type="submit" id="wpLoginCombo" value="<?= wfMsg("login") ?>" onclick="AjaxLogin.action='login'; AjaxLogin.form.submit(); return false;" />
	        	<input type="submit" id="wpLoginCancel" class="secondary" value="<?= wfMsg("Cancel") ?> "onclick="AjaxLogin.close(); return false;" />
	        </div>
        </form>
    </div>
    <div id="AjaxLoginRegisterForm" style="display:none" title="<?= wfMsg('login') ?>">
        <?php if (!$isReadOnly){ echo $registerAjax; } ?>
    </div>
    <div id="AjaxLoginEndDiv" style=" <?php if (!$isReadOnly){ echo 'height: 10px;'; } ?> clear: both;" >
    </div>    
</div>
