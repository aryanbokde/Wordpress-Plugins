

jQuery(document).ready( function($){    
    var ajaxurl = my_ajax_front.ajax_url;     
    $('#ast-event-register').on('submit', function(e){
        e.preventDefault();
        var postdata = jQuery("#ast-event-register").serialize();
            postdata += "&action=ast-register-event";
        
        $.post(ajaxurl, postdata, function(data){

            if (data.status == true) {
                $('.event-form-error-handling').html(data.message); 
                //console.log(data.message);
                setTimeout(function(){
                   window.location.reload();
                }, 3000);
            }else{
                $('.event-form-error-handling').html(data.message); 
                //console.log(data.message);
                setTimeout(function(){
                   window.location.reload();
                }, 3000);
            }            
        });
        
                   
    });     
});


