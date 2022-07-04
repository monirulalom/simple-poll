<?php
add_action('wp_ajax_create_poll', 'create_poll');

function create_poll() {

  global $wpdb;
  $table_name = $wpdb->prefix . 'simple_poll';


  $wpdb->get_row( "SELECT * FROM `".$table_name."` WHERE `question` = '".$_POST['question']."' ORDER BY `id` DESC" );

  if($wpdb->num_rows < 1) {

    $wpdb->insert(
        $table_name,
        array(
            "question" => $_POST['question'],
        ),
    );

    $response = array('message'=>'Poll created successfully', 'rescode'=>200);
  }
  else {
    $response = array('message'=>'Poll already exists', 'rescode'=>404);
  }

  echo json_encode($response);
  
  exit();
  wp_die();
}


add_action('wp_ajax_edit_poll', 'edit_poll');

function edit_poll() {

  global $wpdb;
  $table_name = $wpdb->prefix . "simple_poll";

  $wpdb->update(
      $table_name,
      array(
          "question" => $_POST['question'],
      ),
      array(
          "id" => $_POST['id'],
      )
  );

  $response = array('message'=>'Poll updated successfully', 'rescode'=>200);

  echo json_encode($response);

  exit();
  wp_die();
}

add_action('wp_ajax_list_polls', 'list_polls');

function list_polls(){
  global $wpdb;
  $table_name = $wpdb->prefix . "simple_poll";

  $polls = $wpdb->get_results( "SELECT id, question FROM `".$table_name."` ORDER BY `id` DESC" , ARRAY_A);

  $list = array();
  foreach($polls as $poll){
    $list[] = array('value'=>$poll['id'], 'label'=>$poll['question']);
  }

  echo json_encode($list);
  exit();
  wp_die();
}


add_action('wp_ajax_submit_poll', 'submit_poll');
add_action('wp_ajax_nopriv_submit_poll', 'submit_poll');

function submit_poll(){
  global $wpdb;
  $table_name = $wpdb->prefix . "simple_poll";
  
  if($_POST['poll_response'] == 'yes'){
    $wpdb->query( "UPDATE `".$table_name."` SET `yes` = `yes` + 1 WHERE `id` = ".$_POST['poll_id'] );
  }
  elseif($_POST['poll_response'] == 'no'){
    $wpdb->query( "UPDATE `".$table_name."` SET `no` = `no` + 1 WHERE `id` = ".$_POST['poll_id'] );
  }
  

  $response = array('message'=>'Your response has been recorded. Thank you!', 'rescode'=>200);

  echo json_encode($response);

  exit();
  wp_die();
}

?>
