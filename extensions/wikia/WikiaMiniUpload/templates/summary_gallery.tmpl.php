<div id="ImageUploadSuccess">
<?= $message ?>
</div>
<div style="text-align: center;">
        <input onclick="WMU_close(event);" type="button" value="<?= wfMsg( 'wmu-return' ) ?>" />
        <div id="ImageUploadCode" style="display: none;" ><?= $code ?></div>
        <input type="hidden" id="ImageUploadTag" value="<?= htmlspecialchars( $tag ) ?>" />
</div>
