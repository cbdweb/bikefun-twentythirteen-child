<?php 
/*template name: importCSV*/
?>

<div class="container-wrap">

	<div class="container main-content">
		
		<div class="row liftup">
                    
                    <?php
                    // http://stackoverflow.com/questions/5813168/how-to-import-csv-file-in-php
                    $row = 1;
                    global $wpdb;
                    if (($handle = fopen(get_stylesheet_directory() . "/subscriber.csv", "r")) !== FALSE) {
                        while (($data = fgetcsv($handle)) !== FALSE) {
                            $num = count($data);
                            $row++;
                            
                            if($row % 100 === 0 ) echo "row = " . $row . "<br/>\n";
                            
                            $query = $wpdb->prepare ( "SELECT * from " . $wpdb->posts . " p LEFT JOIN " . $wpdb->post_meta . " m on m.post_id=p.ID where meta_key='bf_subscription_email' AND meta_value='%s'",
                                    $data[0] );
                            $rows = $wpdb->get_row ( $query );
                            if( ! $rows ) {

                                $post_id = wp_insert_post(array(
                                        'post_status'=>'private',
                                        'post_type'=>'bf_subscription',
                                        'ping_status'=>false,
                                        'comment_status'=>'closed',
                                    ),
                                    true
                                );
                                
                                if(is_wp_error($post_id)) {
                                    echo $row . $post_id->get_error_message();
                                } else {
                                    update_post_meta($post_id, "bf_subscription_email", $data[0] );
                                }
                            }
                        }
                        fclose($handle);
                    }?>
                    
                </div><!--/row-->

        </div><!--/container-->
        

    </div>
