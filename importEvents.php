<?php 
/*template name: import Events*/
?>

<div class="container-wrap">

	<div class="container main-content">
		
		<div class="row liftup">
                    
                    <?php
                    // http://stackoverflow.com/questions/5813168/how-to-import-csv-file-in-php
                    $row = 1;
                    global $wpdb;
                    if (($handle = fopen(get_stylesheet_directory() . "/events.csv", "r")) !== FALSE) {
                        while (($data = fgetcsv($handle)) !== FALSE ) {
                            $num = count($data);
                            $row++;
                            
                            if($row % 100 === 0 ) echo "row = " . $row . "<br/>\n";
                            
                            $post_id = wp_insert_post(array(
                                    'post_status'=>($data[9] === "y" ? 'publish': 'draft' ),
                                    'post_type'=>'bf_events',
                                    'ping_status'=>false,
                                    'comment_status'=>'open',
                                    'post_title'=>$data[1],
                                    'post_content'=>$data[5],
                                ),
                                true
                            );
                            
                            $date = explode('/', $data[2]);
                            $time = explode(":", $data[3] );
                            $pm = ( false !== strpos ( strtolower ( $data[3] ), 'pm' ) && $time[0]!=='12' );
                            $minute = intval ( $time[1] ); // get rid of am/pm
                            $bf_events_startdate = mktime ( $time[0], $minute, 0, $date[1], $date[0], $date[2] ) - get_option( 'gmt_offset' ) * 3600;
                            if($pm) $bf_events_startdate += 12 * 60 * 60;
                            if($data[8]) {
                                $time = explode(":", $data[8] );
                                $pm = ( false !== strpos ( strtolower ( $data[8] ), 'pm' ) && $time[0]!=='12' );
                                $minute = intval ( $time[1] ); // get rid of am/pm
                                $bf_events_enddate = mktime ( $time[0], $minute, 0, $date[1], $date[0], $date[2] ) - get_option( 'gmt_offset' ) * 3600;
                                if($pm) $bf_events_enddate += 12 * 60 * 60;
                            } else {
                                $bf_events_enddate = null;
                            }
                         
                            if(is_wp_error($post_id)) {
                                echo $row . $post_id->get_error_message();
                            } else {
                                $url = $data[6];
                                if ( false === strpos( strtolower( $url ), 'http') ) $url = "http://" . $url;
                                update_post_meta($post_id, "bf_events_email", $data[0] );
                                update_post_meta($post_id, "bf_events_place", $data[4] );
                                update_post_meta($post_id, "bf_events_url", $url );
                                update_post_meta($post_id, "bf_events_image", $data[7] );
                                update_post_meta($post_id, "bf_events_startdate", $bf_events_startdate );
                                if($bf_events_enddate) update_post_meta($post_id, "bf_events_enddate", $bf_events_enddate );
                                update_post_meta($post_id, "bf_events_UNID", $data[10] );
                            }
                        }
                        fclose($handle);
                    }?>
                    
                </div><!--/row-->

        </div><!--/container-->
        

    </div>
