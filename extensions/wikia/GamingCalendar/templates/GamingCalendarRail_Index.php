<section class="GamingCalendarModule">
    <h1><?= $moduleTitle ?></h1>
    
    <a href="#" class="more">Open Calendar</a>
    
	<script type="text/template" id="GamingCalendarItemTemplate">
		<div class="GamingCalendarItem">
		    <div class="calendar">
		        <span class="month">%month%</span>
		        <span class="day">%day%</span>
		    </div>
			<img src="%imageSrc%" width="" height="" alt="" />
			<span class="game-title">%gameTitle%</span>
			<span class="game-subtitle">%gameSubTitle%</span>
			<span class="game-systems">%systems%</span>
			<div class="game-details">
				<p>%description%</p>
				<a href="%moreInfoUrl%" class="game-more-info">More info</a>
				<a href="%preorderUrl%" class="game-pre-order">Pre-order now</a>
			</div>
		</div>
    </script>
</section>
