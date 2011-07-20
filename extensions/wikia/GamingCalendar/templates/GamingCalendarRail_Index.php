<section class="GamingCalendarModule">
    <h1><?= $moduleTitle ?></h1>
    
    <a href="#" class="more">Open Calendar</a>
    
	<script type="text/template" id="GamingCalendarItemTemplate">
		<div class="GamingCalendarItem %expanded%">
		    <div class="calendar">
		        <span class="month">%month%</span>
		        <span class="day">%day%</span>
		    </div>
			<img src="%imageSrc%" width="" height="" alt="" />
			<span class="game-title">%gameTitle%</span>
			%gameSubTitle%
                        <span class="game-systems">%systems%</span>
			<div class="game-details">
				<p>%description%</p>
				<a href="%moreInfoUrl%" class="game-more-info">More info</a>
				<a href="%preorderUrl%" class="game-pre-order">Pre-order now</a>
			</div>
		</div>
    </script>

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
