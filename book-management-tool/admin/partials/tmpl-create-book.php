<?php
  wp_enqueue_media();
?>
  
<div class="panel panel-default mt-4">
  <div class="panel-heading"><h4>Create Book</h4></div>
  <div class="panel-body">
    <form class="form-horizontal" action="javascript:void(0)" method="post" id="frm-create-book">

      <div class="form-group mb-2">
        <label class="control-label col-sm-2" for="dd_book_shelf">Select Book Shelf</label>
        <div class="col-sm-4">
          <select class="control-label" required name="dd_book_shelf">
            <option class="text-left" value="">CHOOSE SHELF</option>
            <?php 
              if (count($book_shelf) > 0) {
                foreach($book_shelf as $key => $value){ ?>
                  <option class="text-left" value="<?php echo $value->id;?>"><?php echo strtoupper($value->shelf_name); ?></option>
                <?php }
              }
            ?>
            
          </select>
        </div>
      </div>
      <div class="form-group mb-2">
        <label class="control-label col-sm-2" for="txt_name">Name:</label>
        <div class="col-sm-4">
          <input type="text" required class="form-control" id="txt_name" name='txt_name' placeholder="Enter name">
        </div>
      </div>
      <div class="form-group mb-2">
        <label class="control-label col-sm-2" for="txt_cost">Book Cost:</label>
        <div class="col-sm-4">
          <input type="number" required class="form-control" id="txt_cost" name="txt_cost">
        </div>
      </div>
      <div class="form-group mb-2">
        <label class="control-label col-sm-2" for="txt_publication">Publication:</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="txt_publication" name='txt_publication' placeholder="Enter name">
        </div>
      </div>
      <div class="form-group mb-2">
        <label class="control-label col-sm-2" for="txt_description">Description:</label>
        <div class="col-sm-4">
          <textarea type="textarea" class="form-control" id="txt_description" name="txt_description" placeholder="Enter Book Description"></textarea>
        </div>
      </div>
      <div class="form-group mb-2">
        <label class="control-label col-sm-2" for="txt_image">Image:</label>
        <div class="col-sm-4">
          <input type="button" value="Upload Image" class="form-control" id="txt_image" name="txt_image">
          <img src="" width="80" height="80" id="book_image">
          <input type="hidden" name="book_cover_image" id="book_cover_image">
        </div>
      </div>
      
      <div class="form-group mb-2">
        <label class="control-label col-sm-2" for="txt_email">Email:</label>
        <div class="col-sm-4">
          <input type="email" required class="form-control" id="txt_email" name='txt_email' placeholder="Enter Email">
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
          <button type="submit" class="btn btn-success">Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>
 

