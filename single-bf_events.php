<?php
/*
Template Name: Show event
*
 * 
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
                                            <h1 class="entry-title"><?php the_title(); ?></h1>
						
					</header><!-- .entry-header -->

					<div class="entry-content">
                                                <?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
						<div class="entry-thumbnail">
							<?php the_post_thumbnail("medium"); ?>
						</div>
						<?php endif; ?>
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
					</div><!-- .entry-content -->

					<footer class="entry-meta">
						<?php edit_post_link( __( 'Edit', 'twentythirteen' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-meta -->
				</article><!-- #post -->
                                
                                <?php twentythirteen_paging_nav(); ?>
                                <!-- paging_nav -->
				<?php comments_template(); ?>

                                <?php if ( ! current_user_can('edit_post', the_ID()) ) { ?>
                                
                                <script type="text/javascript">
                                    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                                    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

                                    ga('create', 'UA-20203215-1', 'auto');
                                    ga('send', 'pageview');

                                </script>
                                <?php }
			endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer();