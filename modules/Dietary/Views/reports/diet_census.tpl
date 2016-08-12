<script>
	$(document).ready(function() {
		$(".order").click(function(e) {
			e.preventDefault();
			var id = $(this).attr("id");
			var url = SITE_URL + "/?module=Dietary&page=reports&action=diet_census&location=" + $("#location").val() + "&orderby=" + id;
			window.location = url;
		}); 
	});
</script>


<div id="page-header">
	<div id="action-left">&nbsp;</div>
	<div id="center-title">
		<h1>Diet Census</h1>
		{if $isPDF}
      		<h2>{$smarty.now|date_format}</h2>
    	{/if}
	</div>
  <div id="action-right">
  	{if $auth->isLoggedIn()}
  	<a href="{$pageUrl}&amp;pdf=true" target="_blank">
  		<img src="{$FRAMEWORK_IMAGES}/print.png" alt="">
  	</a>
  	{/if}
  </div>
</div>

<input type="hidden" id="location" name="location" value="{$location->public_id}">
<input type="hidden" id="current-url" name="current_url" value="{$current_url}">
<table class="form">
	<tr>
		<th><a href="" id="room" class="order">Room</a></th>
		<th><a href="" id="patient_name" class="order">Patient Name</a></th>
		<th>&nbsp;</th>
		<th><a href="" id="diet_order" class="order">Diet Order</a></th>
		<th><a href="" id="texture" class="order">Texture</a></th>
		<th><a href="" id="liquid_consistency" class="order">Liquid Consistency</a></th>
	</tr>
	{foreach from=$dietCensus item=diet}
	<tr>
		<td>{$diet->room}</td>
		<td>{$diet->patient_name}</td>
		<td class="{$k}">{$dietaryMenu->menu($diet, $selectedLocation)}</td>
		<td class="{$k}">
			{if !$modEnabled}
			<a href="#" class="delete-patient">
				<img src="{$FRAMEWORK_IMAGES}/delete.png" class="{$k}" style="position: relative; top: 7px;" alt="">
				<input type="hidden" name="public_id" class="public-id" value="{$diet->public_id}">
				<input type="hidden" name="room_number" class="room-number" value="{$diet->number}">
			</a>
				<input type="hidden" class="patient-id" value="{$diet->public_id}">
			{/if}
		</td>
		<td>{$diet->diet_order}</td>
		<td>{$diet->texture}</td>
		<td>{$diet->liquid_consistency}</td>
	</tr>
	{/foreach}
</table>