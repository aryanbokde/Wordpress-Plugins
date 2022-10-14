jQuery(function(){

	//let $ = jQuery;

	var ajaxurl = ast_book.ajaxurl;	
	// var name = ast_book.name;
	// var author = ast_book.author;
	// console.log(ajaxurl);
	// console.log(name);
	// console.log(author);

	if (jQuery('#tbl-book-list').length > 0) {

		jQuery('#tbl-book-list').DataTable();
	}

	jQuery('#frm-create-book').validate({
		submitHandler: function(){

			var postdata = jQuery("#frm-create-book").serialize();
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

	jQuery(document).on("click", ".book-list-delete", function(){

		var book_id = jQuery(this).attr("data-id");

		var confi = confirm("Are you sure want to delete ?");

		if (confi) {

			var postdata = "action=admin_ajax_request&param=delete_book_list&book_id=" + book_id;			
			jQuery.post(ajaxurl, postdata, function(response){
				//console.log(response);

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


	jQuery('.book-list-delete').validate({
		submitHandler: function(){

			var postdata = jQuery("#frm-create-book").serialize();
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





	

});


	


