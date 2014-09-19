<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
	/*<![CDATA[*/
	.WikiaArticle #wiki-factory-panel .TablePager td.TablePager_col_cl_text { display: table-cell !important; }
	.TablePager .ChangeLogPager_cl_value {
		width: 100%;
		max-height: 100px;
		overflow-y: auto;
	}
	.TablePager .ChangeLogPager_cl_value .v1 {
		float:left;width:45%;
	}

	.TablePager .ChangeLogPager_cl_value .v2 {
		float:right;width:45%;
	}
	.TablePager .ChangeLogPager_cl_value pre {
		display: block;
	}
	.TablePager .ChangeLogPager_cl_value .clear {
		clear: both;
	}
	/*]]>*/
</style>
<h2>
    Changelog
</h2>
<div>
	<?php echo $changelog[ "limit" ] ?>
    <div>
        <?php echo $changelog[ "body" ] ?>
    </div>
    <?php echo $changelog[ "nav" ] ?>
</div>
<!-- e:<?= __FILE__ ?> -->
