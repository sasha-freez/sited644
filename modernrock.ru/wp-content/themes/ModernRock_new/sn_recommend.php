<div class="b-recommend">
	<div class="h3">МЫ РЕКОМЕНДУЕМ</div>
	<div class="tabs_s">
		<ul>
			<li class="t1 active"><a href="#recommend-tab-1" data-tab=".tab-n1">Посты</a></li>
			<li class="t2"><a href="#recommend-tab-2" data-tab=".tab-n2">Конкурсы</a></li>
			<li class="t3"><a href="#recommend-tab-3" data-tab=".tab-n3">Рецензии</a></li>
			<li class="t4"><a href="#recommend-tab-4" data-tab=".tab-n4">TV</a></li>
		</ul>
	</div>
	<div class="js-toggle">
		<div class="tab-content tab-n1 tc-act">
			<?php
				wp_reset_query();
				$arh=array(
					'showposts'=>'6',
					'cat'=>'6',
					'post__not_in'=>array(get_the_ID())
				);
				query_posts($arh + ['no_found_rows' => true]);
				$i=0;
			?>
			<?php if (have_posts()) : ?>
			<div class="n-item bnews">
				<?php while (have_posts()) : the_post(); ?>
				<?php 
					$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
					if (empty($large[0])) $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
				?>
				
				<div class="row">
					<a href="<?php the_permalink(); ?>">
						<span class="img"><img src="<?php echo kama_thumb_src('w=47&h=47',$large[0]);?>" width="47" height="47" alt="<?php the_title_attribute(); ?>" /></span>
						<span class="desc">
							<span class="name"><?php the_title();?></span>
						</span>
					</a>
				</div>
				
				<?php $i++;endwhile; ?>
			</div>
			<?php endif; ?>
		</div>
		<div class="tab-content tab-n2">
			<?php
				wp_reset_query();
				$arh=array(
					'showposts'=>4,
					'cat'=>'8',
					'meta_key'=>'active_contest',
					'meta_value'=>'true'
				);
				query_posts($arh + ['no_found_rows' => true]);
			?>
			<?php if (have_posts()) : ?>
			<div class="n-item concurs_last">
				<?php while (have_posts()) : the_post(); ?>
				<div class="item"><a href="<?php the_permalink(); ?>" class="type<?php echo get_post_meta(get_the_ID(), 'type_contest', true);?>"><?php the_title();?></a></div>
				<?php $i++; endwhile; ?>
			</div>
			<?php else: ?><p class="recommend-empty">Сейчас нет активных конкурсов.</p><?php endif; ?>
		</div>
		<div class="tab-content tab-n3">
			<div class="n-item reviews_mini">
				<?php rewind_posts(); ?>
				<?php query_posts('showposts=6&cat=9&no_found_rows=1'); ?>
				<?php if (have_posts()) : ?>
					<?php while (have_posts()) : the_post(); ?>
						<?php 
							$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
							if (empty($large[0])) $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
						?>
						<div class="item">
							<div class="img"><a href="<?php the_permalink(); ?>"><img src="<?php echo kama_thumb_src('w=47&h=47',$large[0]);?>" width="47" height="47" alt="<?php the_title();?>"/></a></div>
							<div class="desc">
								<p class="name"><a href="<?php the_permalink(); ?>"><?php echo get_post_meta(get_the_ID(), 'notices_group', true);?></a></p>
								<p class="intro"><?php echo get_post_meta(get_the_ID(), 'album', true);?></p>
							</div> 
						</div>
					<?php endwhile; ?>
				<?php endif; ?>	
			</div>
		</div>
		<div class="tab-content tab-n4">
			<?php
				wp_reset_query();
				$arh=array(
					'showposts'=>'6',
					'cat'=>'16',
					'post__not_in'=>array(get_the_ID())
				);
				query_posts($arh + ['no_found_rows' => true]);
				$i=0;
			?>
			<?php if (have_posts()) : ?>
			<div class="n-item bnews">
				<?php while (have_posts()) : the_post(); ?>
				<?php 
					$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
					if (empty($large[0])) $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
				?>
				<div class="row">
					<a href="<?php the_permalink(); ?>">
						<span class="img"><img src="<?php echo kama_thumb_src('w=47&h=47',$large[0]);?>" width="47" height="47" alt="<?php the_title_attribute(); ?>" /></span>
						<span class="desc">
							<span class="name"><?php the_title();?></span>
						</span>
					</a>
				</div>
				<?php $i++;endwhile; ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>