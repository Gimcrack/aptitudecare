<script>
	$(document).ready(function() {
		$(".delete").click(function(e) {
			e.preventDefault();
			var dataRow = $(this).parent().parent();
			var item = $(this);
			$("#dialog").dialog({
				buttons: {
					"Confirm": function() {
						var row = item.children().next($(".public-id"));
						var id = row.val();
							
						$.ajax({
							type: 'post',
							url: SITE_URL,
							data: {
								page: "users",
								action: 'delete_user',
								id: id,
							},
							success: function() {
								dataRow.fadeOut("slow");
							}
						});
						$(this).dialog("close");

					},
					"Cancel": function() {
						$(this).dialog("close");
					}
				}
			});
		});

		$(".order").click(function(e) {
			e.preventDefault();
			var order = $(this).next("input").val();
			console.log
			window.location = SITE_URL + "/?page=data&action=manage&type=" + $("#page").val() + "&orderBy=" + order;
		});


		$("#locations").change(function() {
			window.location = SITE_URL + "/?page=users&action=manage&location=" + $("#locations option:selected").val();
		});

	});
</script>


<div id="page-header">
	<div id="action-left">
		<a class="button" href="{$SITE_URL}/?page=users&amp;action=user&amp;type=add&amp;location={$location_id}">Add New</a>
	</div>
	<div id="center-title">
		<div id="locations">
			<select name="location" id="location">
			{foreach $locations as $location}
				<option value="{$location->public_id}" {if $location->public_id == $location_id} selected{/if}><h1>{$location->name}</h1></option>
			{/foreach}
			{foreach $areas as $area}
				<option value="{$area->public_id}" {if $area->public_id == $location_id} selected{/if}><h1>{$area->name}</h1></option>
			{/foreach}
			</select>
		</div>
	</div>
</div>


<h2>Manage Users</h2>

<table class="view">
	<tr>
		<th>Last Name</th>
		<th>First Name</th>
		<th>Email</th>
		<th>Phone</th>
		<th>Default Location</th>
		<th>Default Module</th>
		<th>Group Name</th>
		<th style="width:20px;font-weight:normal"><span class="text-darker-grey">Edit</span></th>
		<th style="width:20px;font-weight:normal"><span class="text-darker-grey">Delete</span></th>
	</tr>

	{foreach $users as $user}
	<tr>
		<td>{$user->last_name}</td>
		<td>{$user->first_name}</td>
		<td>{$user->email}</td>
		<td>{$user->phone}</td>
		<td>{$user->default_location}</td>
		<td>{$user->default_module}</td>
		<td>{$user->group_name}</td>
		<td>
			<a href="{$SITE_URL}/?page=users&amp;action=user&amp;type=edit&amp;location={$location_id}&amp;id={$user->public_id}">
				<img src="{$FRAMEWORK_IMAGES}/pencil.png" alt="">
			</a>
		</td>
		<td>
			<a href="" value="{$user->public_id}" class="delete">
				<img src="{$FRAMEWORK_IMAGES}/delete.png" alt="">
				<input type="hidden" name="public_id" class="public-id" value="{$user->public_id}" />
			</a>
		</td>
	</tr>
	{/foreach}
</table>


{if isset ($pagination)}
	<div id="pagination">
		{if $pagination->current_page != 1}
			<a href="{$SITE_URL}?page=users&amp;action=manage&amp;location={$location_id}&amp;page_count={$pagination->current_page - 1}">&laquo;&nbsp; Previous</a>
		{/if}
		{for $i=max($pagination->current_page-5, 1); $i<=max(1, min($pagination->num_pages,$pagination->current_page+5)); $i++}
			{if $i == $pagination->current_page}
				<strong><a href="{$SITE_URL}?page=users&amp;action=manage&amp;location={$location_id}&amp;page_count={$i}" class="page-numbers">{$i}</a></strong>
			{else}
				<a href="{$SITE_URL}?page=users&amp;action=manage&amp;location={$location_id}&amp;page_count={$i}" class="page-numbers">{$i}</a>
			{/if}
		{/for}
		{if $pagination->current_page != $pagination->num_pages}
			<a href="{$SITE_URL}?page=users&amp;action=manage&amp;location={$location_id}&amp;page_count={$pagination->current_page + 1}">Next &nbsp;&raquo;</a>
		{/if}
	</div>
	{if $pagination->num_pages > 20}
	<div id="beginning-end">
		<a href="{$SITE_URL}?page=users&amp;action=manage&amp;location={$location_id}&amp;page_count=1" class="page-numbers">First Page</a>
		<a href="{$SITE_URL}?page=users&amp;action=manage&amp;location={$location_id}&amp;page_count={floor($pagination->num_pages)}" class="page-numbers">Last Page</a>
	</div>
	{/if}
{/if}



<div id="dialog" title="Confirmation Required">
	<p>Are you sure you want to delete this item? This cannot be undone.</p>
</div>
