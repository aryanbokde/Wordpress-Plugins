<?php 
    
    require_once( BOOK_MANAGEMENT_PLUGIN_DIR_PATH . 'includes/class-user-list-table.php' );

    // $owt_table = new User_List_Tables();
    // $owt_table->prepare_items();
    // $owt_table->display();
?>
  
<div class="panel panel-default mt-4">
  <div class="panel-heading"><h4>Books List</h4></div>
  <div class="panel-body">
    
      <table id="tbl-book-list" class="display" style="width:100%">
        <thead>            
            <tr>
                <th>#ID</th>
                <th>Name</th>
                <th>Amount</th>
                <th>Publication</th>
                <th>Description</th> 
                <th>Image</th>
                <th>Email</th>                      
                <th>Status</th>
                <th>Action</th>
            </tr>            
        </thead>
        <tbody>
            <?php 

                if (count($book_list) > 0) {
                    foreach($book_list as $index => $data){ ?>

                        <tr>
                            <td><?php echo $data->id; ?></td>
                            <td><?php echo $data->name; ?></td>
                            <td><?php echo $data->amount; ?></td>
                            <td><?php echo $data->publication; ?></td>
                            <td><?php echo $data->description; ?></td> 
                            <td><?php echo $data->book_image; ?></td>
                            <td><?php echo $data->email; ?></td>
                            <td><?php 
                                    if ($data->status) { ?>
                                        <button class="btn btn-success">Active</button>
                                    <?php }else{ ?>
                                        <button class="btn btn-danger">Inactive</button>
                                    <?php }
                                ?>                                    
                            </td>                      
                            <td>
                                <a href="#" class="book-list-edit" data-id="<?php echo $data->id; ?>">Edit</a> / <a href="#" class="book-list-delete" data-id="<?php echo $data->id; ?>">Delete</a>
                            </td>
                        </tr>

            <?php  }
                }

            ?>
        </tbody>
        <tfoot>
            <tr>
                <th>#ID</th>
                <th>Name</th>
                <th>Amount</th>
                <th>Publication</th>
                <th>Description</th> 
                <th>Image</th>
                <th>Email</th>                      
                <th>Status</th>
                <th>Action</th>
            </tr>   
        </tfoot>
    </table>

  </div>
</div>
 

