<!-- Список категорий -->
<?php $this_category = get_category($cat);?>
<?php if (get_category_children($this_category->cat_ID) != ""):?>
<div class="cat_parent">
	<ul>
		<?php wp_list_categories('orderby=id&show_count=0&depth=1&hide_empty=0&title_li=&use_desc_for_title=1&child_of='.$this_category->cat_ID); ?>
	</ul>
</div>
<?php else:?>
<div class="cat_parent">
	<ul>
		<?php wp_list_categories('orderby=id&show_count=0&depth=1&hide_empty=0&title_li=&use_desc_for_title=1&child_of=6'); ?>
	</ul>					
</div>
<?php endif;?>