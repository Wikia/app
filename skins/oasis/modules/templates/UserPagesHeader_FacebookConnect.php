<?php
if ($fbAccess == true) {	
?>
<form action="<?= $fbSelectFormURL ?>" method="post">
<input type="hidden" id="FacebookProfileSyncUserNameWiki" value="<?= $fbUserNameWiki ?>" />


<table class="fbconnect-preview-synced-profile">
	<?php if (isset($fbUser->name)) { 
?>
	<tr>
		<th><span id="FacebookProfileSyncRemoveName" class="remove sprite error"></span><?=wfMsg('fb-sync-realname')?></th>
		<td><input name="fb-name" value="<?= $fbUser->name; ?>" /></td>
	</tr>
		<?php
	}
?>
	<?php if (isset($fbUser->birthday)) { 
?>
	<tr>
		<th><span id="FacebookProfileSyncRemoveBirthday" class="remove sprite error"></span><?=wfMsg('fb-sync-birthday')?></th>
		<td><input name="fb-birthday" value="<?= $fbUser->birthday; ?>" /></td>
	</tr>
		<?php
	}
?>
	<?php if (isset($fbUser->gender)) { 
?>
	<tr>
		<th><span id="FacebookProfileSyncRemoveGender" class="remove sprite error"></span><?=wfMsg('fb-sync-gender')?></th>
		<td><?= $fbUser->gender; ?><input type="hidden" value="<?= $fbUser->gender; ?>" name="fb-gender" /></td>
	</tr>
		<?php
	}
?>

	<?php if (isset($fbUser->relationship_status)) { 
?>
	<tr>
		<th><span id="FacebookProfileSyncRemoveRelationshipstatus" class="remove sprite error"></span><?=wfMsg('fb-sync-relationshipstatus')?></th>
		<td><input name="fb-relationshipstatus" value="<?= $fbUser->relationship_status ?>" /></td>
	</tr>
		<?php
	}
?>

<?php if (isset($fbUser->languages)) { ?>
	<tr>
		<th><span id="FacebookProfileSyncRemoveLanguages" class="remove sprite error"></span><?=wfMsg('fb-sync-languages')?></th>
		<td>
		<?php
		$languages = '';
		$space = ', ';
		foreach ($fbUser->languages as $language) {
			$languages .= $language->name .$space;
		}
		$languages = rtrim($languages, $space);
		
	?>
		<input name="fb-languages" value="<?= $languages ?>" /></td> 
		</td>
	</tr>
		<?php 
	}
?>


	<?php if (isset($fbUser->hometown->name)) { 
?>
	<tr>
		<th><span id="FacebookProfileSyncRemoveHometown" class="remove sprite error"></span><?=wfMsg('fb-sync-hometown')?></th>
		<td><input name="fb-hometown" value="<?= $fbUser->hometown->name; ?>" /></td>
	</tr>
		<?php
	}
?>
	<?php if (isset($fbUser->location)) { 
?>
	<tr>
		<th><span id="FacebookProfileSyncRemoveLocation" class="remove sprite error"></span><?=wfMsg('fb-sync-currentlocation')?></th>
		<td><input name="fb-location" value="<?= $fbUser->location->name; ?>" /></td>
	</tr>
		<?php
	}
?>
	<?php if (isset($fbUser->education)) { 
?>
	<tr>
		<th><span id="FacebookProfileSyncRemoveEducation" class="remove sprite error"></span><?=wfMsg('fb-sync-education')?></th>
		<td>
		<?php
		$educations = '';
		foreach ($fbUser->education as $education) { 
			$year = (isset($education->year->name)) ? ' - ' .$education->year->name : '';
			$educations .= "\n" .$education->school->name .$year;
			
			if (isset($education->concentration)) {
				foreach ($education->concentration as $concentration) {
					$educations .= ', ' .$concentration->name .', ';
				}	
			}
			if (isset($education->with)) {
				$educations .= wfMsg('fb-sync-educationwith');
				foreach ($education->with as $with) {
					$educations .= $with->name;
				}
			}
		}
	?>
			<textarea name="fb-education"><?= $educations; ?></textarea>		
		</td>
	</tr>
		<?php
	}
?>
	<?php if (isset($fbUser->work)) { 
?>
	<tr>
		<th><span id="FacebookProfileSyncRemoveWork" class="remove sprite error"></span><?=wfMsg('fb-sync-work')?></th>
		<td>
		<?php
		$works = '';
		foreach ($fbUser->work as $work) { 
			$works .= "\n";
			
			if (isset($work->position)) {
				$works .= $work->position->name;
			}
			
			if (isset($work->employer)) {
				$works .= wfMsg('fb-sync-work-at') .$work->employer->name;
			}
			if (isset($work->location)) {
				$works .= ' - ' .$work->location->name;
			}


		}
	?>
			<textarea name="fb-work"><?= $works; ?></textarea>		
		</td>
	</tr>
		<?php
	}
?>
	<?php if (isset($fbUser->religion)) { 
?>
	<tr>
		<th><span id="FacebookProfileSyncRemoveReligion" class="remove sprite error"></span><?=wfMsg('fb-sync-religiousviews')?></th>
		<td><input name="fb-religion" value="<?= $fbUser->religion; ?>" /></td>
	</tr>
		<?php
	}
?>
	<?php if (isset($fbUser->political)) { 
?>
	<tr>
		<th><span id="FacebookProfileSyncRemovePolitical" class="remove sprite error"></span><?=wfMsg('fb-sync-politicalviews')?></th>
		<td><input name="fb-political" value="<?= $fbUser->political; ?>" /></td>
	</tr>
		<?php
	}
?>
	<?php if (isset($fbUser->website)) { 
?>
	<tr>
		<th><span id="FacebookProfileSyncRemoveWebsite" class="remove sprite error"></span><?=wfMsg('fb-sync-website')?></th>
		<td><input name="fb-website" value="<?= $fbUser->website; ?>" /></td>
	</tr>
		<?php
	}
?>
<?php if (isset($fbUserInterests->data)) { ?>
	<tr>
		<th><span id="FacebookProfileSyncRemoveInterests" class="remove sprite error"></span><?=wfMsg('fb-sync-interestedin')?></th>
		<td>
		<?php
		$interests = '';
		$space = ', ';
		foreach ($fbUserInterests->data as $interest) {
			$interests .= $interest->name . $space;
		}
		$interests = rtrim($interests, $space);
		
	?>
			<textarea name="fb-interests"><?= $interests ?></textarea>
		</td>
	</tr>
		<?php 
	}
?>
	<tr class="submit-column">
		<th></th>
		<td>
			<input type="submit" id="FacebookProfileSyncSave" value="<?=wfMsg('fb-sync-save')?>" />
		</td>
	</tr>
</table>
</form>
<?php
}
else {
?>
<h2><?=wfMsg('fb-sync-permissionerror')?></h2>
<?php
}
?>