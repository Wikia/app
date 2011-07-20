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
				%month% %start% - %end%
			</h1>
			<div class="scroll-up"></div>
			<div class="list">
				<ul>%items%</ul>
			</div>
			<div class="scroll-down"></div>
		</li>
   </script>	
</section>
