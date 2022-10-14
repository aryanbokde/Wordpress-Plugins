<?php
  //wp_enqueue_media();

  global $wpdb;
  $tblname = $wpdb->prefix .'books';
  $book_list = $wpdb->get_results($wpdb->prepare("SELECT * FROM $tblname WHERE id =".$book_id));

  if(count($book_list) > 0){
    foreach($book_list as $index => $book_data){

    }
  }


  if (!empty(isset($_POST['submit']))) {

    $book_id    =   $_POST['book_id'];
    $book_name  =   $_POST['txt_name'];
    $book_amt   =   $_POST['txt_amt'];
    $book_pub   =   $_POST['txt_publication'];
    $book_dec   =   $_POST['txt_description'];
    $book_email =   $_POST['txt_email'];
    $book_status =   $_POST['dd_status'];

    //echo $book_status;


    $result = $wpdb->update( $tblname, array( 'name' => $book_name, 'amount' => $book_amt, 'publication' => $book_pub, 'description' => $book_dec, 'email' => $book_email, 'status' => $book_status), array( 'id' => $book_id ) );

    if($result > 0){
      $msg = "<span class='text-success'>Book has been updated</span>";
    }else{
      $msg = "<span class='text-danger'>Book has been NOT updated</span>";
    }

  }


  



?>
  
<div class="panel panel-default mt-4">
  <div class="panel-heading"><h4>Edit Book</h4></div>
  <div class="panel-body">
    <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'].'?page=book_dashboard&action=book-edit&book_id='.$book_id; ?>" method="post" id="frm-edit-book">
      <div class="col-12">
          <input type="hidden" class="form-control" id="book_id" name='book_id' value="<?php echo $book_data->id;?>">
          <?php if(isset($_POST['submit'])){
                echo $msg;
          } ?>
      </div>
      <div class="form-group mb-2">
        <label class="control-label col-sm-2" for="txt_name">Book Name:</label>
        <div class="col-sm-4">
          <input type="text" required class="form-control" id="txt_name" name='txt_name' placeholder="Enter name" value="<?php echo $book_data->name;?>">
        </div>
      </div>
      <div class="form-group mb-2">
        <label class="control-label col-sm-2" for="txt_amt">Book Amount:</label>
        <div class="col-sm-4">
          <input type="number" required class="form-control" id="txt_amt" name="txt_amt" value="<?php echo $book_data->amount;?>"> 
        </div>
      </div>
      <div class="form-group mb-2">
        <label class="control-label col-sm-2" for="txt_publication">Publication:</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="txt_publication" name='txt_publication' placeholder="Enter name" value="<?php echo $book_data->publication;?>">
        </div>
      </div>
      <div class="form-group mb-2">
        <label class="control-label col-sm-2" for="txt_description">Description:</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="txt_description" name="txt_description" placeholder="Enter Book Description" value="<?php echo $book_data->description;?>">
        </div>
      </div>
      
      <div class="form-group mb-2">
        <label class="control-label col-sm-2" for="txt_email">Email:</label>
        <div class="col-sm-4">
          <input type="email" required class="form-control" id="txt_email" name='txt_email' placeholder="Enter Email" value="<?php echo $book_data->email;?>">
        </div>
      </div>
      <div class="form-group mb-2">
        <label class="control-label col-sm-2" for="dd_status">Status</label>
        <div class="col-sm-4">
          <select class="control-label" name="dd_status">
            <option class="text-left" value="1">Active</option>
            <option class="text-left" value="0">Inactive</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-4">
          <button type="submit" name="submit" class="btn btn-success">Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>