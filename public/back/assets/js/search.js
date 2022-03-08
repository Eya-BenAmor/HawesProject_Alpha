

    jQuery(document).ready(function() {
        var searchRequest = null;
        $("#search").keyup(function() {
            var minlength = 3;
            var that = this;
            var value = $(this).val();
            var entitySelector = $("#entitiesNav").html('');
            if (value.length >= minlength ) {
                if (searchRequest != null)
                    searchRequest.abort();
                searchRequest = $.ajax({
                    type: "GET",
                    url: "ajax_search",
                    data: {
                        'q' : value
                    },
                    dataType: "text",
                    success: function(msg){
                        //we need to check if the value is the same
                        if (value==$(that).val()) {
                            var result = JSON.parse(msg);
                            $.each(result, function(key, arr) {
                                $.each(arr, function(id, value) {
 
                                        if (id != 'error') {   
                                                 entitySelector.append('<li> <h1 style="color:grey !important;"class="headline">'+value[0]+'</h1> <p  style="color:black !important;" class="para para-light py-3">'+value[1]+' </p><img  class="img-fluid" src="../'+value[2]+'" alt = '+value[2]+'/> </li>');
                                        }  
                                        
                                        else {
                                            entitySelector.append('<li style="color:red;">'+value+'</li>');
                                        }s
                                    
                                });
                            });
                        }
                     }
                });
            }
        });
    });

