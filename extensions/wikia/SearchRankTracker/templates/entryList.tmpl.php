<!-- s:<?= __FILE__ ?> -->
<style type="text/css">/*<![CDATA[*/
#entry-list div.entry { margin-top: 20px; padding-top: 10px; padding-left: 5px; padding-right: 5px;  display: block; clear: both; overflow: auto; border: 1px solid #DCDCDC;}
#entry-list label { display: block; width: 12em !important; float: left; padding-right: 1em; text-align: right;font-weight: bold; }
#entry-list div.entry-graph { margin-top: 20px; margin-bottom: 0; text-align: center;}
#entry-desc { background: #f4f4f4; }
#entry-controls { float: right; }
/*]]>*/</style>

<?php $entriesCount = count($entries); ?>
<a href="<?=$title->getFullUrl('action=edit');?>"><b>[add new entry]</b></a>
<?php if($entriesCount): ?>
	<a href="<?=$title->getFullUrl();?>">[refresh]</a>
<?php endif; ?>
<div id="entry-list">
	<?php if($entriesCount): ?>
	 <?php foreach($entries as $entry): ?>
	  <div class="entry">
		  <div id="entry-desc">
					<div id="entry-controls">
						<a href="<?=$title->getFullUrl('action=edit&entryId=' . $entry->getId());?>">[edit entry]</a>
						<a href="<?=$title->getFullUrl('action=delete&entryId=' . $entry->getId());?>" onClick="javascript: return confirm('Are you sure?');">[remove entry]</a>
					</div>

			  <label>Search phrase:</label>
			  <div id="entry-search-phrase">"<?=$entry->getPhrase();?>",</div>
			  <label>Page URL:</label>
			  <div id="entry-page-url"><a href="<?=$entry->getPageUrl();?>" target="_blank"><?=$entry->getPageUrl();?></a></div>
				</div>
				<div class="entry-graph">
					<img src="<?=$title->getFullUrl('action=renderGraph&entryId=' . $entry->getId() . '&date=' . date('Y-m-d'));?>" />
				</div>
	  </div>
	 <?php endforeach; ?>
	<?php else: ?>
	 <br />
	 <br />
	 <i><?=wfMsg('searchranktracker-empty-list'); ?>
	<?php endif; // count($entries) ?>
</div>
<!-- e:<?= __FILE__ ?> -->