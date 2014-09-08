<?php
/*
* Template Name: 301 redirect
*
 * 
 */

if( isset ( $_GET['UNID'] ) && $_GET['UNID'] !== "" ) {
    $UNID = $_GET['UNID'];
    global $wpdb;
    $query = $wpdb->prepare ( "SELECT post_id FROM " . $wpdb->postmeta . " WHERE meta_key='bf_events_UNID' AND meta_value='%s'", $UNID );
    $post_meta = $wpdb->get_row ( $query, 'OBJECT' );
    if ( $post_meta ) {
        header("Location: " . get_permalink( $post_meta->post_id ) ,TRUE ,301 );
        exit;
    }
}

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
                    
                    <article>
                            <header class="entry-header">
                                    <h1 class="entry-title">Redirect failed</h1>
                            </header><!-- .entry-header -->

                            <div class="entry-content">
                                We tried to redirect you to the correct address on the new bikefun website, but we failed miserably.<br/>
                                Think of this as an opportunity to discover the new site by finding the event on our 
                                <a href="<?=get_site_url()?>">home page</a>!
                            </div><!-- .entry-content -->

                            <footer class="entry-meta">
                                    <?php edit_post_link( __( 'Edit', 'twentythirteen' ), '<span class="edit-link">', '</span>' ); ?>
                            </footer><!-- .entry-meta -->
                    </article>


		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer();
