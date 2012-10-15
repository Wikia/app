<div class="MiniEditorWrapper"<? if (isset($attributes)):
	foreach ($attributes as $name => $value) {
		echo ' ' . $name . '="' . $value . '"';
	}
endif; ?>>
