<?php get_header(); ?>


<main id="content">

		<?php //THE LOOP!  display the content of any 'page'
		if( have_posts() ):
			while( have_posts() ):
				the_post();
			?>
	<article id="post-<?php the_ID();?>" <?php post_class(); ?>>
		<h2 class="entry-title"> 
			<a href="<?php the_permalink(); ?>"> 
				<?php the_title(); ?> 
			</a>
			<?php edit_post_link( 'Edit', '<br />'); ?>
		</h2>

		<div class="entry-content">
			<?php the_content(); ?>
		</div>
		<?php if(is_single()): ?>
		<div class="snippet-info">
			<?php $docs = get_post_meta( $post->ID, 'Documentation' );
			if($docs)
				echo '<h3>Documentation: </h3>';
			foreach($docs as $doc){
				echo '<a href="'.$doc.'">WordPress Codex Page</a>';
			} ?>
			<?php $wheres = get_post_meta( $post->ID, 'Where to Use', false);
			if($wheres)
				echo '<h3>Where to use: </h3>';
			foreach($wheres as $where){
				echo $where;
			} ?>

			<div class="postmeta"> 
				<span class="type"> 
					<h3>Snippet Type:</h3>
					<?php the_terms( $post->ID, 'type');?>
				</span>
				<span class="keywords">
					<h3>Tags:</h3>
					<?php the_terms( $post->ID, 'keyword', '', '', '');?>
				</span> 
			</div><!-- end postmeta -->	
		</div>		
	<?php endif; ?>
	</article><!-- end post -->
			<?php 
			endwhile; 
			endif; //end of the loop ?>

		</main><!-- end #content -->
		<?php get_sidebar(); ?>
		<?php get_footer(); ?>