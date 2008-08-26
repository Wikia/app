<!-- s:<?= __FILE__ ?> -->
<style type="text/css">/*<![CDATA[*/
#rw-form label { display: block; width: 12em !important; float: left; padding-right: 1em; text-align: right;font-weight: bold; }
#rw-form input.text { width: 24em;}
#rw-form div.row { padding-bottom: 0.8em; margin-bottom: 0.8em; display: block; clear: both; border-bottom: 1px solid #DCDCDC; }
/*]]>*/</style>

<div id="rw-form">
    <form action="<?= $title->getLocalUrl("action=delete&doit=1") ?>" method="post">
    <fieldset>
        <legend>Please confirm deleting of Wiki:</legend>
        <div class="row">
            <label>Name:</label>
            <span><?= $request->request_name ?></span>
        </div>
        <div class="row">
            <label>Title:</label>
            <span><?= $request->request_title ?></span>
        </div>
        <div class="row">
            <label>Description:</label>
            <span><?= $request->request_description_english ?></span>
            <span><?= $request->request_description_international ?></span>
        </div>
        <div style="text-align: center;">
            <input type="hidden" name="request" id="request" value="<?= $request->request_id ?>" />
            <input type="submit" name="rw-submit" id="rw-submit" value="Delete request" />
        </div>
    </fieldset>
    </form>
</div>
<!-- e:<?= __FILE__ ?> -->
