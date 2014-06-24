<aside id="sidebar"> 
	<h1>
	<?php 
	if(is_tax()):
		$term =	$wp_query->queried_object;
		echo 'More ';
		echo $term->name;
		$snippets = new WP_query(array(
			'post_type' => 'snippet',
			//type = snippet taxonomy
			'type' => $term->slug,
			
		));
	elseif (is_single()) :
		echo 'Related Snippets';
		$snippets = get_posts_related_by_taxonomy($post->ID,'type'); 
	else:
		//get all the posts
		echo 'Latest Snippets';
		$snippets = new WP_query(array(
				'post_type' => 'snippet',	

		));	
	endif; ?>
	</h1>
	<ul>
		<?php while( $snippets->have_posts() ): $snippets->the_post(); ?>
			<li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
		<?php endwhile; ?>
	</ul>
</aside><!-- end #sidebar -->