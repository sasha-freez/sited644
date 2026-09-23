<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>



<footer>
	<div class="container">
	<? if(!empty(get_field('логотип_в_подвале', 'option')['url'])) { ?>
		<div class="footer_logo"><a href="/"><img src="<? echo get_field('логотип_в_подвале', 'option')['url'];?>" alt="GIGS"></a></div>
	<? } ?>
	<div class="footer_mail"><a href="mailto:<? echo get_field('почта', 'option');?>"><? echo get_field('почта', 'option');?></a></div>
	<div class="footer_des"><? echo get_field('запись_в_подвале', 'option');?></div>
	</div>
</footer><!-- .site-footer -->

		
	
</div><!-- .wrapper -->




<div class="modal fade" id="myzakaz" tabindex="-1" role="dialog" aria-labelledby="myzakaz">
  <div class="modal-dialog modal-sm modal-zakaz" role="document">
    <div class="modal-content">
	
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	<div class="inside_page">

		<div class="inside_event_add">
			<?=do_shortcode(get_field('форма_добавить_событие_от_contact_form_7', 'option'))?>
		</div>

</div>

    </div>
    </div>
</div>	
	
	
	<?php wp_footer(); ?>




<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(62033743, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/62033743" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>
