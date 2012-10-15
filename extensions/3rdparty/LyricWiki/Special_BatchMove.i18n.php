<?php
/**
 * Internationalisation file for Special:BatchMove extension.
 *
 * @addtogroup Extensions
 */

$messages = Array();
$messages["en"] = Array(
	"batchmove" => "Batch Move Pages",
	"batchmove-header"=>"Move from [[$1]]:* to [[$2]]:*",
	"batchmove-success"=>"Moved '''[[$1]]''' to '''[[$2]]'''",
	"batchmove-failed"=>"Failed to move [[$1]] to [[$2]], This page most likely needs to be merged manually",
	"batchmove-marked"=>"The page [[$1]] already exists, marked for manual merge.",
	"batchmove-skip"=>"Skipping page [[$1]].",

	"batchmove-confirm-msg"=>"Are you sure you want to move \"$1\":* to \"$2\":*?\n\nThis can possible be a large operation and will be difficult to reverse.",
	"batchmove-confirm"=>"Confirm",

	"batchmove-title"=>"Batch Move Pages",
	"batchmove-description"=>
		"This allows moving all pages with a specific prefix to a different prefix. ".
		"Doing this manually is a herculean task, so this facility has provided.",
	"batchmove-from"=>"From",
	"batchmove-to"=>"To",
	"batchmove-reason"=>"Reason",

	"batchmove-preview"=>"Preview",
	"batchmove-preview-header"=>"<i>This is only a preview, no action has been taken yet.</i>",

	"batchmove-complete"=>"Batch move complete''",
);
