<section id="GamingCalendar">
	<h1>Game Calendar</h1>

	<div class="ad">
	
	</div>

	<div class="weeks">
		<ul>
		</ul>
	</div>

	<div class="controls">
		<div class="back">
			<div class="back-month"></div>
			<div class="back-week"></div>
		</div>
		<div class="today"></div>
		<div class="forward">
			<div class="forward-month"></div>		
			<div class="forward-week"></div>
		</div>
	</div>

   <script type="text/template" id="GamingCalendarWeekTemplate">
		<li class="week">
			<h1>
				<span>%week-caption%</span>
				%startmonth% %start% - %endmonth% %end%
			</h1>
			<div class="scroll-up"><img src="<?= $wgBlankImgUrl ?>" height="0" width="0"></div>
			<div class="list">
				<ul>%items%</ul>
			</div>
			<div class="scroll-down"><img src="<?= $wgBlankImgUrl ?>" height="0" width="0"></div>
		</li>
   </script>	
</section>
