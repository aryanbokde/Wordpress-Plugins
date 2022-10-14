
  
<div class="panel panel-default mt-4">
  <div class="panel-heading"><h4>Create Book Shelf

    <button class="btn btn-info pull-right" style="margin-top:-7px;" id="btn-first-ajax">First Ajax Request</button></h4></div>
  <div class="panel-body">
    <form class="form-horizontal" action="javascript:void(0)" id="frm-add-book-shelf">
      <div class="form-group mb-2">
        <label class="control-label col-sm-2" for="txt_name">Name:</label>
        <div class="col-sm-4">
          <input type="text" required class="form-control" id="txt_name" name='txt_name' placeholder="Enter Shelf Name">
        </div>
      </div>
      <div class="form-group mb-2">
        <label class="control-label col-sm-2" for="txt_capacity">Capacity:</label>
        <div class="col-sm-4">
          <input type="number" required min="1" class="form-control" id="txt_capacity" name='txt_capacity' placeholder="Enter Capacity">
        </div>
      </div>
      <div class="form-group mb-2">
        <label class="control-label col-sm-2" for="txt_location">Shelf Location:</label>
        <div class="col-sm-4">
          <input type="text" required class="form-control" id="txt_location" name='txt_location' placeholder="Enter Location">
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
 

