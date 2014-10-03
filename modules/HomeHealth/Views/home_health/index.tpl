<script src="{$js}/admissions.js" type="text/javascript"></script>
<script>
	$(document).ready(function() {
		$('#area').change(function() {
			window.location = "?module=HomeHealth&location=" + $("#location").val() + "&area=" + $(this).val();
		});

		$("#location").change(function() {
			window.location = "?module=HomeHealth&location=" + $(this).val();
		});

		$(function() {
			$(document).tooltip();
		});
	});
</script>
{include file="$VIEWS/elements/search_bar.tpl"}

<div id="date-header">
	<div class="date-header-img">
		<a href="{$siteUrl}/?module=HomeHealth&amp;area={$area->public_id}&amp;weekSeed={$retreatWeekSeed}"><img class="left" src="{$frameworkImg}/icons/prev-icon.png" /></a>
	</div>
	<div class="date-header-text-center">
		<h2>{$week[0]|date_format:"%a, %B %d, %Y"} &ndash; {$week[6]|date_format:"%a, %B %d, %Y"}</h2>
	</div>
	<div class="date-header-img">
	<a href="{$siteUrl}/?module=HomeHealth&amp;area={$area->public_id}&amp;weekSeed={$advanceWeekSeed}"><img class="left" src="{$frameworkImg}/icons/next-icon.png" /></a>	
	</div>	
</div>

<div class="clear"></div>

<div id="location-wrapper">
	{foreach $admitsByDate as $day => $admits}
	<div class="location-container">
		<h3 class="day-title">{$day|date_format:"%a, %b %e"}</h3>

		<div class="location-day-box location-day-box-admit {cycle name="admitDayColumn" values="location-day-box-color, "}" droppable="true">
			<input type="hidden" class="date" value="{$day}" />
			<div class="box-title">Admit</div>
			{foreach $admits as $admit}
			{if isset($admit->id)}
			<a href="#" class="tooltip" data-tip="This is a test">
				<div class="{if $admit->status == 'Pending'}location-admit-pending {if !$admit->confirmed}box-white{else}box-blue{/if}{else}location-admit{/if}" draggable="true">
					<strong>{$admit->last_name}, {$admit->first_name}</strong>{$patientTools->menu($admit)}<br>

					<input type="hidden" class="schedule-id" value="{$admit->hh_public_id}" />

					{$admit->healthcare_facility_name}
				</div>
			</a>
			{/if}
			{/foreach}

			
		</div>
	</div>
	{/foreach}

	<div class="clear"></div>
	<div class="horizontal-break"></div>

	{foreach $dischargesByDate as $day => $discharges}
	<div class="location-container">
		<h3 class="day-title">{$day|date_format:"%a, %b %e"}</h3>
		<div class="location-day-box location-day-box-discharge {cycle name="dischargeDayColumn" values="location-day-box-color, "}">
			<div class="box-title">Discharge</div>
			{foreach $discharges as $discharge}
			{if isset ($discharge->id)}
				<div class="location-discharge">
					<strong>{$discharge->last_name}, {$discharge->first_name}</strong><br>
				</div>
			{/if}
			{/foreach}
		</div>
	</div>
	{/foreach}

</div>
<div class="clear"></div>



	