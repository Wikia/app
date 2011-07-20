<section id="GamingCalendar">
	<h1>Game Calendar</h1>

	<div class="ad">
	
	</div>

	<div class="weeks">
		<ul>
			<?php $i = 0; while ( $i < 2 ) { 
				$i++; ?>
			<li class="week">
				<h1><span>This Week</span> July 14th - 21st</h1>
				<div class="scroll-up"></div>
				<ul>
					%week<?= $i; ?>%
				</ul>
				<div class="scroll-down"></div>
			</li>
			<?php } ?>
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
</section>
