<?php

// create shortcode for poll [simple-poll id="1"]
add_shortcode('simple-poll', 'simple_poll_shortcode');

function simple_poll_shortcode($atts) {
  global $wpdb;
  $id = $atts['id'];
  
  $result = $wpdb->get_results("SELECT question FROM ".$wpdb->prefix."simple_poll WHERE id = ".$id, ARRAY_A);
  
  if(empty($result)) {
    $output = "<div>Invalid poll id in shortcode. No poll found. </div>";
  }
  else {
    $output = '<div><h4>'. $result[0]['question'].'</h4><form class="poll"><input type="hidden" name="poll_id" value="'.$id.'"><input type="radio" id="poll-'.$id.'-yes" name="poll_response" value="yes"><label for="poll-'.$id.'-yes"> Yes</label><br><input type="radio" id="poll-'.$id.'-no" name="poll_response" value="no"><label for="poll-'.$id.'-no"> No</label><br><input class="poll-submit-button" type="submit" value="Submit"></form><div class="poll-message"></div></div>';

  }
    return $output;
}


?>