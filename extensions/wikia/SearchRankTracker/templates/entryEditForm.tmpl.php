<!-- s:<?= __FILE__ ?> -->
<style type="text/css">/*<![CDATA[*/
#entry-form label { display: block; width: 12em !important; float: left; padding-right: 1em; text-align: right;font-weight: bold; }
#entry-form input.text { width: 24em;}
#entry-form div.row { padding-bottom: 0.8em; margin-bottom: 0.8em; display: block; clear: both; overflow: auto;}
#entry-form div.hint { width: 18em; font-style: italic; text-align: left; padding: 0.5em; background: #eeeeee;border: 1px solid #DCDCDC;}
#entry-form div.form-error { background: #fefefe; border: 1px solid #ff0000; color: red; padding: 3px; }
/*]]>*/</style>


<div id="entry-form">
<?php if(count($formErrors)): ?>
 <div class="form-error">
  <?php foreach($formErrors as $errorMsg): ?>
   <?=wfMsg($errorMsg);?><br />
  <?php endforeach; ?>
 </div>
<?php endif; ?>
	<form name="entryEditForm" method="POST" action="<?=$title->getLocalUrl('action=list');?>">
	 	<fieldset>
	 		<legend>Editing entry</legend>
	 		<div class="row">
	 			<label>Wikia page:</label>
	 			<input type="text" id="entry-page" name="entryPage" value="<?=$entry->getPageName();?>" tabindex="1" />
	 		</div>
	 		<div class="row">
	 			<label>Search Phrase:</label>
	 			<input type="text" id="entry-phrase" name="entryPhrase" value="<?=$entry->getPhrase();?>" tabindex="2" />
	 		</div>

				<div style="text-align: center;">
	    <input type="hidden" name="entryId" id="entry-id" value="<?=$entry->getId();?>" />
	    <input type="submit" name="entrySubmit" id="entry-submit" value="Save entry" tabindex="3" />
	    <input type="submit" name="cancel" id="cancel" value="Cancel" tabindex="4" />
				</div>

	 	</fieldset>
	</form>
</div>
<!-- e:<?= __FILE__ ?> -->