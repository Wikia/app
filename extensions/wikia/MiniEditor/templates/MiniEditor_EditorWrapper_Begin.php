    	<div class="MiniEditorWrapper"<?
    		if (isset($attributes)) {
    			foreach($attributes as $name => $value) {
    				echo ' ' . $name . '="' . $value . '"';
    			}
    		} ?>>
    		<div class="editor" data-space-type="editor">
    			<div class="editarea" data-space-type="editarea">
