<br />
<h2><?php $this->msg( 'dump-database' ) ?></h2>
<?php $this->msg( 'dump-database-info' ) ?>
<table class="mw-statistics-table">
	<tr>
		<td style="border-right: 0;">
			<?php $this->msg( 'dump-database-curr-pages' ) ?>
			<div class="small">
			<?php $this->msg( 'dump-database-curr-pages-info' ) ?>
			</div>
		</td>
		<td style="border-left: 0;padding 1em;">
			&nbsp;
			<a href="<?php echo $curr[ "url" ] ?>"><?php echo $curr[ "timestamp" ] ?></a>
		</td>
	</tr>
	<tr>
		<td  style="border-right: 0">
			<?php $this->msg( 'dump-database-full-pages' ) ?>
			<div class="small">
			<?php $this->msg( 'dump-database-full-pages-info' ) ?>
			</div>
		</td>
		<td style="border-left: 0">
			&nbsp;<a href="<?php echo $full[ "url" ] ?>"><?php echo $full[ "timestamp" ] ?></a>
		</td>
	</tr>
	<tr>
		<td  style="border-right: 0">
			<?php $this->msg( 'dump-database-request' ) ?>
			<div class="small">
				<?php $this->msg( 'dump-database-request-info' ) ?>
			</div>
		</td>
		<td style="border-left: 0">
			<form>
				<input type="submit" value="<?php $this->msg( 'dump-database-request-submit' ) ?>" />
			</form>
		</td>
	</tr>
</table>
<div class="right">
	<?php $this->msg( 'dump-database-info-more' ) ?>
</div>
