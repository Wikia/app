<?php 
$numSteps = 4;
require dirname(__FILE__) . '/header.php';
?>
<ul>

<script type="text/javascript">
NWB.type = "answers";
var wgAdminSkin = '<?php echo $wgAdminSkin?>';
NWB.changeTheme("Sapphire", false);
</script>


</script>

<!-- ##############  Add a description to main page ############## -->
<li id="step1" class="step">
<h1 class="headline"><?php echo wfMsgForContent("anwb-step1-headline")?></h1>
<div class="wrapper clearfix">
	<div id="step1_example">
		<div class="accent note">
			<?php echo wfMsgForContent("anwb-step1-example")?>
		</div>
	</div>
	<?php echo wfMsgForContent("anwb-step1-text")?>
	<br />
	<br />
	<form id="step1_form" name="step1_form" onsubmit=""><!-- Name needed for selenium tests -->
		<textarea name="tagline" id="tagline_textarea"></textarea>
	</form>

	<script type="text/javascript">
	// Pull in existing tagline
        Mediawiki.apiCall({action: "query", meta: "allmessages", ammessages: "tagline"}, 
		function (result){
			$("#tagline_textarea").val(result.query.allmessages[0]['*']);
		}
	);

	function saveTagline(){
           Mediawiki.waiting();
	   Mediawiki.editArticle({
                  "title": "MediaWiki:Tagline",
                  "section": 0,
                  "text": $("#tagline_textarea").val()},
                  function(result){
                          var cresult = Mediawiki.checkResult(result);
                          if (cresult !== true) {
                                if (result.error.code == "readonly"){
                                        NWB.updateStatus(NWB.msg("nwb-readonly-try-again"), true);
                                } else {
                                        NWB.apiFailed(null, result.error.info, null);
                                }
                          } else {
                                NWB.updateStatus(NWB.msg("nwb-description-saved"), false, NWB.statusTimeout);
                                NWB.gotostep(2);
                          }
                  },
                  NWB.apiFailed);
	}
	Mediawiki.waitingDone();
	</script>
</div>
<div class="nav">
	<a href="#step2" id="skip_step_1" onclick="WET.byStr('anwb/step1skip');"><?php echo wfMsgForContent("nwb-skip-this-step")?></a> <?php echo wfMsgForContent("nwb-or")?><button onclick="WET.byStr('anwb/step1save');saveTagline();"><span><?php echo wfMsgForContent("anwb-save-tagline")?></span></button>
	<input onclick="$('#step1_form').submit();" type="button" id="hidden_tagline_submit" style="display:none"><!-- For selenium tests -->
</div>
</li>

<!-- ############## Add a logo ############ -->
<li id="step2" class="step">
<h1 class="headline"><?php echo wfMsgForContent("nwb-step2-headline")?></h1>
<div class="wrapper clearfix">
	<?php echo wfMsgForContent("anwb-step2-text")?>	
	<!-- Hidden iframe to handle the file upload -->
	<iframe id="hidden_iframe" src="about:blank" style="display:none" name="hidden_iframe" onLoad="NWB.iframeFormUpload(this)"></iframe>

	<div>
	<form action="/api.php" method="post" enctype="multipart/form-data" target="hidden_iframe" onSubmit='return NWB.iframeFormInit(this)' id="logo_form">
		<input type="hidden" name="action" value="uploadlogo">	
		<input type="hidden" name="format" value="xml">	
		<input id="logo_article" type="hidden" name="title" value="Wiki.png">	
		<label><?php echo wfMsgForContent("anwb-choose-logo")?></label><input type="file" name="logo_file" id="logo_file" onclick="WET.byStr('anwb/step2browse');"/> <input type="submit" value="<?php echo wfMsgForContent("nwb-preview")?>" onclick="WET.byStr('anwb/step2preview');this.form.title.value='Wiki-Preview.png'"/>
	</form>
	<div id="logo_preview_wrapper">
		<label><?php echo wfMsgForContent("anwb-logo-preview")?>:</label>
		<div id="logo_preview"></div>
	</div>
	
	</div>
	<div class="accent note">
		<img src="/extensions/wikia/NewWikiBuilder/sample_logo.jpg" id="sample_logo" /><br />
		<?php echo wfMsgForContent("anwb-step2-example")?>
	</div>
</div>
<div class="nav">
	<span class="nav_reverse">
		<button class="secondary" onclick="WET.byStr('anwb/step2back');NWB.gotostep(1);"><span><?php echo wfMsgForContent("nwb-back-to-step-1")?></span></button>
	</span>
	<a href="#step3" id="skip_step_2" onclick="WET.byStr('anwb/step2skip');"><?php echo wfMsgForContent("nwb-skip-this-step")?></a> <?php echo wfMsgForContent("nwb-or")?><button onclick="WET.byStr('anwb/step2save');NWB.uploadLogo();"><span><?php echo wfMsgForContent("nwb-save-logo")?></span></button>
</div>
</li>

<!-- ############## Create first pages ############## -->

<li id="step3" class="step">
<h1 class="headline"><?php echo wfMsgForContent("anwb-fp-headline")?></h1>
<div class="wrapper clearfix">
  <div class="accent note">
	<?php echo wfMsgForContent("anwb-fp-text")?>
	<?php /* Yes, I tried to do this with CSS/divs/float. Gave up after 30 minutes. If you know how to get it to
		work and still display properly after more than 5 pages are added dynamically, go for it (and tell me how 
		you did it. :) 
		-Nick */
	?>
	<table> 
	  <tr valign="top">
	     <td>
		<div id="all_fp" class="bullets">
		<form id="first_pages_form">
		<input type="hidden" name="category" value="<?php echo htmlspecialchars(wfMsgForContent("nwb-new-pages"))?>">
			<ul>
				<li><div style="width:324px;float:left"><big><strong><?php echo wfMsg("nwb-question") ?></strong></big></div><div><big><strong><?php echo wfMsg("nwb-tag")  ?></strong></big></div></li>
			</ul>
			<ul class="fp_block" id="fp_block_1">
				<!-- Ids aren't necessary for the form, only used for Selenium -->
				<li><input id="fp_1" class="fp_page" type="text" onfocus="NWB.firstPagesInputs()" value="<?php echo htmlspecialchars(wfMsgForContent("nwb-sample-question-1"))?>"/> <input type="text" size="15" class="fp_cat" value="<?php echo htmlspecialchars(wfMsgForContent("nwb-sample-tag")) ?>" /></li>
				<li><input id="fp_2" class="fp_page" type="text" onfocus="NWB.firstPagesInputs()" value="<?php echo htmlspecialchars(wfMsgForContent("nwb-sample-question-2"))?>"/> <input type="text" size="15" class="fp_cat" value="<?php echo htmlspecialchars(wfMsgForContent("nwb-sample-tag")) ?>" /></li>
				<li><input id="fp_3" class="fp_page" type="text" onfocus="NWB.firstPagesInputs()" /> <input type="text" size="15" class="fp_cat"/></li>
				<li><input id="fp_4" class="fp_page" type="text" onfocus="NWB.firstPagesInputs()" /> <input type="text" size="15" class="fp_cat"/></li>
				<li><input id="fp_5" class="fp_page" type="text" onfocus="NWB.firstPagesInputs()" /> <input type="text" size="15" class="fp_cat"/></li>
			</ul>
			<!-- Other fp_blocks will be inserted into the dom here with javascript:NWB.firstPagesInputs() -->
		</form>
	    </td><!-- all_fp -->
	    <td style="padding-left: 10px"><?php echo wfMsgForContent("anwb-fp-example")?></td>
	  </tr>
	</table>
	
   </div>
</div>
<div class="nav">
	<span class="nav_reverse">
		<button class="secondary" onclick="WET.byStr('anwb/step3back');NWB.gotostep(2);"><span><?php echo wfMsgForContent("nwb-back-to-step-2")?></span></button>
	</span>
	<a href="#step4" id="skip_step_3" onclick="WET.byStr('anwb/step3skip');"><?php echo wfMsgForContent("nwb-skip-this-step")?></a> <?php echo wfMsgForContent("nwb-or")?><button onclick="WET.byStr('anwb/step3save');$('#first_pages_form').submit();"><span><?php echo wfMsgForContent("nwb-create-pages")?></span></button>
	<input onclick="$('#first_pages_form').submit();" type="button" id="hidden_step_3_submit" style="display:none"><!-- For selenium tests -->
</div>
</li>

<!-- ############## Dones ############## -->

<li id="step4" class="step">
<h1 class="headline"><?php echo wfMsgForContent("nwb-thatisall-headline")?></h1>
<div class="wrapper clearfix">
	<?php echo wfMsgForContent("anwb-thatisall-text")?>
	<div id="wiki_army_container">
		<img src="/extensions/wikia/NewWikiBuilder/wiki_army.gif" id="wiki_army" />
		<img src="/extensions/wikia/NewWikiBuilder/wiki_army_logo.png" id ="wiki_army_logo" />
	</div>
</div>
<div class="nav">
	<span class="nav_reverse">
		<button class="secondary" onclick="WET.byStr('anwb/step4back');NWB.gotostep(3);"><span><?php echo wfMsgForContent("nwb-back-to-step-4")?></span></button>
	</span>
	<button onclick="WET.byStr('anwb/step4go');NWB.finalize('<?php echo $wgServer ?>');"><span id="finito"><?php echo wfMsgForContent("nwb-go-to-your-wiki")?></span></button>
</div>
</li>
</ul>

<?php require dirname(__FILE__) . '/footer.php'; ?>
