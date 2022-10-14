jQuery(function(){

	//let $ = jQuery;

	var ajaxurl = owt_book.ajaxurl;
	
	if (jQuery('#tbl-book-list').length > 0) {

		jQuery('#tbl-book-list').DataTable();
	}	

	if (jQuery('#tbl-book-list-shelf').length > 0) {

		jQuery('#tbl-book-list-shelf').DataTable();
	}	

	jQuery(document).on("click", "#txt_image", function(){
		var image = wp.media({
			title: "Upload Book Image",
			multiple: false
		}).open().on("select", function(e){
			var uplaoded_image = image.state().get("selection").first();
			// console.log(uplaoded_image.toJSON());
			var image_data = uplaoded_image.toJSON();
			jQuery("#book_image").attr("src", image_data.url);
			jQuery("#book_cover_image").attr("value", image_data.url);
		});
	});

	//delete book List row from dataTable
	jQuery(document).on("click", ".btn-delete-book-list", function(){

		var book_id = jQuery(this).attr("data-id");

		var conf = confirm("Are you sure want to delete ?");

		if (conf) {

			var postdata = "action=admin_ajax_request&param=delete_book_list&book_list=" + book_id;
			// console.log(postdata);

			jQuery.post(ajaxurl, postdata, function(response){
				// console.log(response);

				var data = jQuery.parseJSON(response);
				if (data.status == 1) {

					alert(data.message);
					setTimeout(function(){
						location.reload();
					}, 1000);
				}else{
					alert(data.message);
				}

			});
		}	

	});

	//delete book shelf row from dataTable
	jQuery(document).on("click", ".btn-delete-book-shelf", function(){

		var shelf_id = jQuery(this).attr("data-id");

		var conf = confirm("Are you sure want to delete ?");

		if (conf) {

			var postdata = "action=admin_ajax_request&param=delete_book_shelf&shelf_id=" + shelf_id;

			jQuery.post(ajaxurl, postdata, function(response){
				// console.log(response);

				var data = jQuery.parseJSON(response);
				if (data.status == 1) {

					alert(data.message);
					setTimeout(function(){
						location.reload();
					}, 1000);
				}else{
					alert(data.message);
				}

			});
		}	

	});

	jQuery('#frm-create-book').validate({
		submitHandler: function(){

			var postdata = jQuery('#frm-create-book').serialize();
			postdata += "&action=admin_ajax_request&param=create_book";

			jQuery.post(ajaxurl, postdata, function(response){


				//console.log(response);

				var data = jQuery.parseJSON(response);

				if (data.status == 1) {

					alert(data.message);

					setTimeout(function(){
						location.reload();
					}, 1000);

				}

			});

		}
	});

	//Create Book shelf code 
	jQuery('#frm-add-book-shelf').validate({

		submitHandler: function(){

			var postdata = jQuery('#frm-add-book-shelf').serialize();

			postdata += "&action=admin_ajax_request&param=create_book_shelf";

			jQuery.post(ajaxurl, postdata, function(response){

				var data = jQuery.parseJSON(response);

				if (data.status == 1) {

					alert(data.message);

					setTimeout(function(){
						location.reload();
					}, 1000);

				}

			});

		}

	});

	//Processing event on button click
	jQuery(document).on('click', '#btn-first-ajax', function(){

		var postdata = "action=admin_ajax_request&param=first_simple_ajax";

		jQuery.post(ajaxurl, postdata, function(response){
			console.log(response);
		});
	});


});


	


