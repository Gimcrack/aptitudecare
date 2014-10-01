<div id="pagination">
	{if $pagination->current_page != 1}
		<a href="{$url}&amp;page_count={$pagination->current_page - 1}">&laquo;&nbsp; Previous</a>
	{/if}
	{for $i=max($pagination->current_page-5, 1); $i<=max(1, min($pagination->num_pages,$pagination->current_page+5)); $i++}
		{if $i == $pagination->current_page}
			<strong><a href="{$url}&amp;page_count={$i}" class="page-numbers">{$i}</a></strong>
		{else}
			<a href="{$url}&amp;page_count={$i}" class="page-numbers">{$i}</a>
		{/if}
	{/for}
	{if $pagination->current_page != $pagination->num_pages}
		<a href="{$url}&amp;page_count={$pagination->current_page + 1}">Next &nbsp;&raquo;</a>
	{/if}
</div>
<div id="page-count">
	Page {$pagination->current_page} of {ceil($pagination->num_pages)}
</div>