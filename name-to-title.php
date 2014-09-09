<?php 
/*template name: name-to-title*/
?>

<div class="container-wrap">

	<div class="container main-content">
		
		<div class="row liftup">
                    
                    <?php
                    global $wpdb;
                    $query = "SELECT * from " . $wpdb->postmeta . " m WHERE meta_key='bf_subscription_email'";
                    $rows = $wpdb->get_results ( $query, OBJECT );
                    foreach ( $rows as $postmeta ) {
                        $post = array ( 
                            'ID'=>$postmeta->post_id,
                            'post_title'=>$postmeta->meta_value,
                        );
                        wp_update_post( $post );
                    }
                   ?>
                    
                </div><!--/row-->

        </div><!--/container-->
        

    </div>
