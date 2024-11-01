(function($) {  
    $(document).ready(function() { 
        $('.agp-color-picker').wpColorPicker(); 
        $('.widgets-sortables .rpw-widget-color-picker').wpColorPicker();
        
        if( /Android|iPhone|iPad|iPod|webOS|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {   
            $("#rpw-constructor-box").colorbox({inline:true, width:"96%"});
        } else {
            $("#rpw-constructor-box").colorbox({inline:true, width:"50%"});
        }     

        $(document).bind('cbox_complete', function(){
            $.colorbox.resize();
        });
    });
})(jQuery);


