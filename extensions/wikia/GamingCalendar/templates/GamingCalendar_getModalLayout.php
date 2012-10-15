<div id="GamingCalendar">
	<h1>
		<span class="title-wrapper">
			<span class="gradient-wrapper">
				<?= $calendarHeading ?>
			</span>
		</span>
	</h1>

	<div class="weeks">
		<ul>
			<li class="week"></li>
			<li class="week"></li>
			<li class="week"></li>
			<li class="week"></li>
			<li class="week"></li>
			<li class="week"></li>
		</ul>
	</div>

	<div class="controls">
		<a class="back-week wikia-button secondary">‹</a>
		<a class="forward-week wikia-button secondary">›</a>
		<a class="today wikia-button secondary"><?= wfMsg('gamingcalendar-today') ?></a>
	</div>

   <script type="text/template" id="GamingCalendarWeekTemplate">
			<h1>
				<span>##week-caption##</span>
				##startmonth## ##start## &ndash; ##endmonth## ##end##
			</h1>
			<div class="scroll-up"><img src="<?= $wgBlankImgUrl ?>" height="0" width="0"></div>
			<div class="list">
				<ul>##items##</ul>
			</div>
			<div class="scroll-down"><img src="<?= $wgBlankImgUrl ?>" height="0" width="0"></div>
   </script>
  
   <div id="INVISIBLE_MODAL" class="wikia-ad noprint">
<?= AdEngine::getInstance()->getAd('INVISIBLE_MODAL', array('ghostwriter'=>true)); ?>
   </div>
</div>
<div id="GamingCalendarSkinLeft" class="GamingCalendarSkin GamingCalendarSkinLeft"><a href="" target="_blank"></a></div>
<div id="GamingCalendarSkinRight" class="GamingCalendarSkin GamingCalendarSkinRight"><a href="" target="_blank"></a></div>