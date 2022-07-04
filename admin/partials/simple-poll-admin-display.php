<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://monirulalom.com
 * @since      1.0.0
 *
 * @package    Simple_Poll
 * @subpackage Simple_Poll/admin/partials
 */

class Simple_Poll_Admin_Page{
    public function add_new_poll_page(){
       echo "<h1>".__("Add New Poll","simple-poll")."</h1>";

         echo "<form method='post' id='add_poll_form'>";
         // table
            echo "<table class='form-table'>";
            echo "<tbody>";
            echo "<tr class='form-field'>";
            echo "<th scope='row'>";
            echo "<label for='question'> <h3>Question </h3></label>";
            echo "</th>";
            echo "<td>";
            echo "<input type='text' id='question' name='question' placeholder='Type your poll question here' required />";
            echo "</td>";
            echo "</tr>";
            echo "</tbody>";
            echo "</table>";
            echo "<input class='button button-primary' type='submit' value='Add Poll'/>";
            echo "<p>";
            echo " <div class='message'></div>";
            echo "</p>";
    }

    public function view_existing_polls_page(){
        echo "<h1>".__("Existing Polls","simple-poll")."</h1>";
        global $wpdb;
        $table = new PollListTable();
        $table->prepare_items();
        $message = '';
        if ('delete' === $table->current_action()) {
          $message = '<div class="div_message" id="message"><p>' . sprintf('Items deleted: %d', count($_REQUEST['id'])) . '</p></div>';
        }
        ob_start();
      ?>
        <div>
          <?php echo $message; ?>
          <form id="entry-table" method="GET">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
            <?php
                $table->search_box( 'search', 'search_id' );
                $table->display();
            ?>
          </form>
        </div>
      <?php
        $wq_message = ob_get_clean();
        echo $wq_message;
    }

    public function delete_poll_page(){

      if(!(isset($_REQUEST['id'])))
          wp_die();
      
      global $wpdb;
      $table_name = $wpdb->prefix . "simple_poll";
      $id =  $_REQUEST['id'] ;
      $wpdb->delete($table_name, array('id' => $id));

      
      echo "<p>Poll deleted successfully</p>";
      echo "<a href='".admin_url('admin.php?page=view-exixting-polls')."'>View Polls</a>";
  }

  public function edit_poll_page(){
      if(!(isset($_REQUEST['id']))){
          wp_die();
      }

      global $wpdb;
      $table_name = $wpdb->prefix . "simple_poll";
      $id =  $_REQUEST['id'] ;
      $poll = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $id");

      echo "<h1>".__("Edit Poll","simple-poll")."</h1>";
      echo "<form method='post' id='edit_poll_form'>";
      echo "<table class='form-table'>";
      echo "<tbody>";
      echo "<tr class='form-field'>";
      echo "<th scope='row'>";
      echo "<label for='question'> <h3>Question </h3></label>";
      echo "</th>";
      echo "<td>";
      echo "<input type='text' id='question' name='question' value='".$poll->question."' required />";
      echo "<input type='hidden' id='id' name='id' value='".$poll->id."' />";
      echo "</td>";
      echo "</tr>";
      echo "</tbody>";
      echo "</table>";
      echo "<input class='button button-primary' type='submit' value='Update Poll'/>";
      echo "</form>";
      echo "<p>";
      echo " <div class='message'></div>";
      echo "</p>";
  }
}

if (!class_exists('PollListTable')) {
  require_once( plugin_dir_path(__DIR__) . 'partials/simple-poll-list-table.php');
}