<!-- s:<?= __FILE__ ?> -->
<?php if( !is_null( $title ) ): ?>
<style type="text/css">
/*<![CDATA[*/
#wf-category {
	margin-left: auto;
	margin-right: auto;
}
#wf-category fieldset { border: 1px dotted lightgray; background: #f9f9f9; padding: 0.4em; }
/*]]>*/
</style>
<div>
    <form id="wf-category" action="<?php echo $title->getFullUrl() ?>" method="post">
        <fieldset>
            <input type="hidden" name="wpWikiID" value="<?php echo $city_id ?>" />
            <div>
<?php endif ?>
				<select name="wpWikiCategory">
				<?php foreach( $categories as $id => $data ): ?>
					<option value="<?php echo $id ?>" <?php if( $id == $cat_id ) echo "selected=\"selected\"" ?>><?php echo $data["name"] ?></option>
				<?php endforeach ?>
				</select>
<?php if( !is_null( $title ) ): ?>
                <input type="submit" name="wpSubmit" value="Set category" />
            </div>
        </fieldset>
    </form>
</div>
<?php endif ?>
<!-- e:<?= __FILE__ ?> -->
