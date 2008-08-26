<div id="rcform">
<form action="<?php echo $this_url; ?>" method="GET">
	Show
		last <input type="text" name="limit" value="<?php echo htmlspecialchars($params['limit']); ?>" id="rclimit" size="3" /> <label for="rclimit">changes</label>
		<!-- in last <input type="text" name="days" value="" id="rcdays" size="3" /> <label for="rcdays">days</label> -->
		from <input type="text" name="wiki" value="<?php echo htmlspecialchars(str_replace('|', ', ', $params['wiki'])); ?>" id="rcwiki" size="45" /> <label for="rcwiki">wiki</label>(s).
	<br/>
	Use space, coma or bar to separate entries. <i>Foo</i> or <i>foo.w</i> equals foo.wikia.com<!--, <i>xx</i> (language code) or <i>xx.wp</i> equals xx.wikipedia.org-->. Other urls, like <i>uncyclopedia.org</i>, please type in in full.
	<br/> 
	Show
		pages from 
			<select id="rcnamespace" name="namespace[]" multiple="multiple" size="3">
				<option value="-1" <?php if (empty($params['namespace'])):?>selected="selected"<?php endif; ?>>all</option>
				<?php foreach (array
				(
					0  => '(Main)',
					1  => 'Talk',
					2  => 'User',
					3  => 'User talk',
					4  => '(Project namespace)',
					5  => '(Project talk namespace)',
					6  => 'Image',
					7  => 'Image talk',
					8  => 'MediaWiki',
					9  => 'MediaWiki talk',
					10  => 'Template',
					11  => 'Template talk',
					12  => 'Help',
					13  => 'Help talk',
					14  => 'Category',
					15  => 'Category talk',
				) as $value => $text): ?>
					<option value="<?php echo $value; ?>" <?php if (preg_match("/\|{$value}\|/", "|{$params['namespace']}|", $preg)): ?>selected="selected"<?php endif; ?>><?php echo $text; ?></option>
				<?php endforeach; ?>
			</select>
			<label for="rcnamespace">namespace</label>(s).
	<br/>
	Hide <label for="rcminor">minor edits</label> <input type="checkbox" name="minor" id="rcminor" <?php if (preg_match("/\|!minor\|/", "|{$params['show']}|", $preg)): ?>checked="checked"<?php endif; ?> />,
		<label for="rcbot">bots</label> <input type="checkbox" name="bot" id="rcbot" <?php if (preg_match("/\|!bot\|/", "|{$params['show']}|", $preg)): ?>checked="checked"<?php endif; ?> />,
		<label for="rcanon">anonymous users</label> <input type="checkbox" name="anon" id="rcanon" <?php if (preg_match("/\|!anon\|/", "|{$params['show']}|", $preg)): ?>checked="checked"<?php endif; ?> />,
		and <label for="rcloggedin">logged-in users</label> <input type="checkbox" name="loggedin" id="rcloggedin" <?php if (preg_match("/\|anon\|/", "|{$params['show']}|", $preg)): ?>checked="checked"<?php endif; ?> /><!-- ,
		and <label for="rcmy edits">my edits</label> <input type="checkbox" name="myedits" id="rcmyedits" <?php if (preg_match("/\|myedits\|/", "|{$params['show']}|", $preg)): ?>checked="checked"<?php endif; ?> /> -->.
	<!-- <br/>
	Show
		<label for="rcfrom">new changes starting from</label> <input type="text" name="from" value="" id="rcfrom" size="15" /> -->
	<br/>
	<input type="submit" value="Go" />
</form>
</div>
