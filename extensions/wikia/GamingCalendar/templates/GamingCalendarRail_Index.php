<section class="GamingCalendarModule">
    <h1><span><?= $moduleTitle ?></span></h1>
    
    <a href="#" class="more">Open Calendar</a>
    
	<script type="text/template" id="GamingCalendarItemTemplate">
		<div class="GamingCalendarItem ##expanded##">
		    <div class="calendar">
		        <span class="month">##month##</span>
		        <span class="day">##day##</span>
		    </div>
			<img src="##imageSrc##" width="" height="" alt="" />
			<span class="game-title">##gameTitle##</span>
			##gameSubTitle##
                        <span class="game-systems">##systems##</span>
                        <span class="game-rating">##rating##</span>
			<div class="game-details">
				<p>##description##</p>
				<a href="##moreInfoUrl##" class="game-more-info" target="_blank">More info</a>
				##preorderLink##
			</div>
		</div>
    </script>
</section>
