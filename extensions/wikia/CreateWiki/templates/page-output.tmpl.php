<!-- s:<?= __FILE__ ?> -->
Congratulations, you did it again ;-) New wiki will be created in background task shortly.<br />
<br />
<ol>
<li>
You can check <a href="<?= $title->getFullUrl() ?>">request page</a> for this Wiki.
</li>
<li>
    The following pages will be added/modified automagically by CreateWiki background task:
    <ul>
    	<li>
    		<a href="http://www.wikia.com/index.php?title=<?= $link ?>">
    		http://www.wikia.com/index.php?title=<?= urlencode($link); ?>
    		</a>.
    	</li>
    	<li>
						<a href="http://www.wikia.com/index.php?title=Template:List_of_Wikia_New">
						http://www.wikia.com/index.php?title=Template:List_of_Wikia_New
						</a>
					</li>
					<li>
    		<a href="http://www.wikia.com/index.php?title=New_wikis_this_week/Draft">
    		http://www.wikia.com/index.php?title=New_wikis_this_week/Draft
    		</a>
					</li>
					<li>
    		<a href="http://www.wikia.com/index.php?title=<?= $params["redirect"] ?>">
    		http://www.wikia.com/index.php?title=<?= urlencode($params["redirect"]); ?>
    		</a> (redirect page)
					</li>
				<ul>
</li>
</ol>
<br />
Go back and <a href="<?=($pageUrl . "?title=Special:RequestWiki&action=list");?>">create another wiki</a>.
<!-- e:<?= __FILE__ ?> -->
