

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

jQuery(document).ready(function() { 

   	jQuery("#ast_country").change(function () {   		
   	var cid = jQuery('#ast_country').val();
    //console.log(cid);
		jQuery.ajax({
		    type: "POST",
	        url: my_ajax_object.ajax_url,
	        data: {
	            action: 'get_country_state_id',
	            // add your parameters here
	            c_id: cid
	        },
	        success: function (response) {   

	        	if (response.message == true) {
	           		var array = response.data;
	           		jQuery("#ast_state").empty();
	           		for (var key in array) {
					    var value = array[key];
					    if (key == 0) {
					    	jQuery('#ast_state').append('<option value="">Select State</option>');
					    }
					    jQuery('#ast_state').append('<option value="' + value.ID + '">' + value.post_title + '</option>');
					    
					}
				  
	           	}else{
	           		// console.log(response.data);
	           		jQuery("#ast_state").empty();
	           		jQuery("#ast_city").empty();
	           		jQuery('#state_error').fadeIn('fast');
	           		jQuery('#state_error').text(response.data); 
	           		setTimeout(function() {
	                    jQuery('#state_error').fadeOut('fast');
	                }, 4000);
	           	}

	        }
		});
    });

    jQuery("#ast_state").change(function () {   		
   	var sid = jQuery('#ast_state').val();
    //console.log(sid);
		jQuery.ajax({
		    type: "POST",
	        url: my_ajax_object.ajax_url,
	        data: {
	            action: 'get_country_city_id',
	            // add your parameters here
	            s_id: sid
	        },
	        success: function (response) {   

	        	if (response.message == true) {

	           		jQuery("#ast_city").empty();
	           		var array = response.data;
	           		for (var key in array) {
					    var value = array[key];
					    jQuery('#ast_city').append('<option value="' + value.ID + '">' + value.post_title + '</option>');
					    
					}
				  
	           	}else{
	           		// console.log(response.data);
	           		jQuery("#ast_city").empty();
	           		jQuery('#city_error').fadeIn('medium');
	           		jQuery('#city_error').text(response.data); 
	           		setTimeout(function() {
	                    jQuery('#city_error').fadeOut('medium');
	                }, 4000);
	           	}

	        }
		});
    });


















	// Event management Option page jquery function run on change country.



    jQuery("#ast-default-country").change(function () {   		
	   	var cid = jQuery('#ast-default-country').val();
	   	//console.log(cid);
	   	
			jQuery.ajax({
			    type: "POST",
		        url: my_ajax_object.ajax_url,
		        data: {
		            action: 'get-ast-country-id',
		            // add your parameters here
		            c_id: cid
		        },
		        success: function (response) {   

		        	if (response.message == true) {	           		

						var array = response.data;
		           		jQuery("#ast-default-state").empty();
		           		jQuery("#ast-default-city").empty();
		           		for (var key in array) {
						    var value = array[key];
						    if (key == 0) {
						    	jQuery('#ast-default-state').append('<option value="">Select State</option>');
						    }
						    jQuery('#ast-default-state').append('<option value="' + value.ID + '">' + value.post_title + '</option>');
						    
						}
					  
		           	}else{
		           		// console.log(response.data);
		           		jQuery("#ast-default-state").empty();
		           		jQuery("#ast-default-city").empty();
		           		jQuery('#default_state_error').fadeIn('medium');
		           		jQuery('#default_state_error').text(response.data); 
		           		setTimeout(function() {
		                    jQuery('#default_state_error').fadeOut('medium');
		                }, 4000);
		           	}

		        }
			});
	  
    

    });





    // Event management Option page jquery function run on change state.
    jQuery("#ast-default-state").change(function () {   		
	   	var sid = jQuery('#ast-default-state').val();
	   	if( !jQuery("#ast-default-state").val() ) {
	   		jQuery('#default_city_error').text("Please select default State"); 
	   	}else{
		    //console.log(sid);
			jQuery.ajax({
			    type: "POST",
		        url: my_ajax_object.ajax_url,
		        data: {
		            action: 'get-ast-state-id',
		            // add your parameters here
		            s_id: sid
		        },
		        success: function (response) {   

		        	if (response.message == true) {	           		

						var array = response.data;
		           		jQuery("#ast-default-city").empty();
		           		for (var key in array) {
						    var value = array[key];
						    if (key == 0) {
						    	jQuery('#ast-default-city').append('<option value="">Select City</option>');
						    }
						    jQuery('#ast-default-city').append('<option value="' + value.ID + '">' + value.post_title + '</option>');
						    
						}
					  
		           	}else{
		           		// console.log(response.data);
		           		jQuery("#ast-default-city").empty();
		           		jQuery('#default_city_error').fadeIn('medium');
		           		jQuery('#default_city_error').text(response.data); 
		           		setTimeout(function() {
		                    jQuery('#default_city_error').fadeOut('medium');
		                }, 4000);
		           	}

		        }
			});
	   	}

    });


});