<?php
/**
* Template Name: Добавление события (форма связи)
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/
?>
<?php get_header(); ?>

<div class="inside_header">
	<div class="container">
		<a href="/"><img src="<? echo get_field('основной_логотип', 'option')['url'];?>" alt="GIGS"></a>
	</div>
</div>
<div class="inside_page">
	<div class="container">
		<div class="inside_event_add">
			<?=do_shortcode(get_field('вставьте_код_от_contact_form_7'))?>
		</div>
	</div>
</div>

<?php get_footer();	?> 

