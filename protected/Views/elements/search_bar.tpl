<script>
	$(document).ready(function() {
		$("#module").change(function() {
			var module = $("#module option:selected").val();
			if (module == "Admission") {
				window.location.href = SiteUrl + "/?module=Admission&user=" + User;
			} else {
				window.location.href = SiteUrl + "/?module=" + module;
			}

		});
	});
</script>

<div id="search-header">
	
	{if count($modules) > 1}
	<div id="modules">
		Module: <select name="module" id="module">
			
			{foreach $modules as $m}
				<option value="{$m->name}" {if $module == $m->name} selected{/if}>{$m->name}</option>
			{/foreach}
		</select>
	</div>
	{/if}
	
	<div id="locations">
		<select name="location" id="location">
			<div id="optgroup">
			{foreach $locations as $location}	
				<option value="{$location->public_id}" {if $location->public_id == $loc->public_id} selected{/if}><h1>{$location->name}</h1></option>
			{/foreach}
			</optgroup>
		</select>
	</div>
		
	<div id="areas">
		Area: <select name="areas" id="area">
			{foreach $areas as $area}
			<option value="{$area->public_id}" {if $area->public_id == $selectedArea->public_id} selected{/if}>{$area->name}</option>
			{/foreach}
		</select>
	</div>
</div>
