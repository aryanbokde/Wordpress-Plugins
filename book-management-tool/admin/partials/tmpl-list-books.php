
  
<div class="panel panel-default mt-4">
  <div class="panel-heading"><h4>List Books</h4></div>
  <div class="panel-body">
    
      <table id="tbl-book-list" class="display" style="width:100%">
        <thead>            
            <tr>
                <th>#ID</th>
                <th>Name</th>
                <th>Shelf Name</th>
                <th>Amount</th>
                <th>Email</th> 
                <th>Publication</th>
                <th>Description</th>
                <th>Book Image</th>                      
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
                <td><?php echo $data->shelf_name; ?></td>
                <td><?php echo $data->amount; ?></td>
                <td><?php echo $data->email; ?></td>
                <td><?php 
                        if (!empty($data->publication)) {
                            echo $data->publication;
                        }else{
                            echo "<i>No Publication Available</i>";
                        }
                    ?>
                </td>
                <td><?php 
                        if (!empty($data->description)) {
                            echo $data->description;
                        }else{
                            echo "<i>No Description Available</i>";
                        }
                    ?>
                </td>
                <td>
                    <?php 
                        if (!empty($data->book_image)) {
                            echo "<img src='".$data->book_image."' height='30' width='30'>";
                        }else{
                            echo "<i>No Image</i>";
                        }                    
                    ?>         
                </td>
                          
                <td><?php 
                       if ($data->status) {
                        ?>
                            <button class="btn btn-success">Active</button>
                       <?php }else{ ?>
                            <button class="btn btn-danger">Inactive</button>
                        <?php }
                    ?>        
                </td>
                <td><button class="btn btn-danger btn-delete-book-list" data-id="<?php echo $data->id; ?>">Delete</button></td>
            </tr>
            <?php 
                    }

                }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th>#ID</th>
                <th>Name</th>
                <th>Shelf Name</th>
                <th>Amount</th>
                <th>Email</th> 
                <th>Publication</th>
                <th>Description</th>
                <th>Book Image</th>                      
                <th>Status</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>

  </div>
</div>
 

