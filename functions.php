<?php
/* 
 * get previous and next links to base on event date instead of publication date;
 */

/**
 * Display navigation to next/previous post when applicable.
*
* @since Twenty Thirteen 1.0
*/
function twentythirteen_post_nav() {
	global $post;
        
        if($post->post_type === "tf_events") {
            global $wpdb;
            $now = time() + ( get_option( 'gmt_offset' ) * 3600 );
            $today = intval( $now / 86400 ) * 86400;
            $previous = $wpdb->get_row("SELECT `wp_posts`.`ID`, `wp_posts`.`post_title` as title
                    FROM $wpdb->postmeta wp_postmeta
                    LEFT JOIN  $wpdb->posts wp_posts ON  `wp_postmeta`.`post_id` =  `wp_posts`.`ID` 
                    WHERE  `wp_postmeta`.`meta_key` =  'tf_events_startdate'
                    AND `wp_postmeta`.`meta_value` < " . get_post_meta($post->ID, 'tf_events_startdate', true) . "
                    AND wp_posts.post_status = 'publish'
                            ORDER BY wp_postmeta.meta_value DESC
                            LIMIT 1");
            $next = $wpdb->get_row("SELECT `wp_posts`.`ID`, `wp_posts`.`post_title` as title
                    FROM $wpdb->postmeta wp_postmeta
                    LEFT JOIN  $wpdb->posts wp_posts ON  `wp_postmeta`.`post_id` =  `wp_posts`.`ID` 
                    WHERE  `wp_postmeta`.`meta_key` =  'tf_events_startdate'
                    AND `wp_postmeta`.`meta_value` > " . get_post_meta($post->ID, 'tf_events_startdate', true) . "
                    AND wp_posts.post_status = 'publish'
                            ORDER BY wp_postmeta.meta_value ASC
                            LIMIT 1");
        } else {


            // Don't print empty markup if there's nowhere to navigate.
            $previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
            $next     = get_adjacent_post( false, '', false );
        }

	if ( ! $next && ! $previous )
		return;
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'twentythirteen' ); ?></h1>
		<div class="nav-links">
                <?php
                if($post->post_type === "tf_events" ) {
                    if($previous) { ?>
                    <a href="<?=home_url('?post_type=tf_events&p=' . $previous->ID)?>"  rel="prev"><span class="meta-nav">←</span> <?=$previous->title;?></a>
                    <?php }
                    if($next) { ?>
                            <a href="<?=home_url('?post_type=tf_events&p=' . $next->ID);?>" rel="next"> <?=$next->title;?> <span class="meta-nav">→</span></a>
                    <?php }
                } else {	
			previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'twentythirteen' ) ); 
			next_post_link( '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'twentythirteen' ) );
                } ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}

function twentythirteen_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	
        global $post;
        
        ?>


	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'twentythirteen' ); ?></h1>
		<div class="nav-links">

                <?php
                if($post->post_type === "tf_events" ) {
                    if($previous) echo '<a href="' . home_url('?post_type=tf_events&p=' . $previous->ID) . '"><span class="meta-nav">Previous Event</span>' . $previous->title;
                    if($next) echo '<a href="' . home_url('?post_type=tf_events&p=' . $next->ID) . '"><span class="meta-nav">Next Event</span>' . $next->title;
                } else {	
                    if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentythirteen' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?> 
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentythirteen' ) ); ?></div>
			<?php endif; 
                }?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
function bf_register_sidebars() {
    register_sidebar(array(
    'name' => 'plainpage',
    'id' => 3,
    'description' => 'Widgets for plainpage footer.',
    'before_widget' => '<div class="box">',
    'after_widget' => '</div>',
    'before_title' => '<h4>',
    'after_title' => '</h4>',
    ));
}
add_action( 'widgets_init', 'bf_register_sidebars' );
