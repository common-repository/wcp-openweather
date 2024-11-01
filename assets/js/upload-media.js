jQuery(document).ready(function($){
    var rpw_media_frame;
    
    $(document).on("click", ".agp-upload-image-reset-button", function(e) {
        e.preventDefault();
        
        var url = agp_upload_media.noimage_url;
        
        $(this).closest('.agp-upload-image-container').find('.agp-upload-image').val('');
        $(this).closest('.agp-upload-image-container').find('.agp-upload-image-preview').attr('src', url);        
        $(this).closest('.agp-upload-image-container').find('.agp-upload-image-reset-button').hide();        
        
        setTimeout(function() {$.colorbox.resize();}, 200);
        
    });
    
    $(document).on("click", ".agp-upload-image-button", function(e) {
        e.preventDefault();

        if ( rpw_media_frame ) {
            rpw_media_frame.wcp_owner = this;
            rpw_media_frame.open();
            return;
        }
        
        rpw_media_frame = wp.media.frames.rpw_media_frame = wp.media({
            className: 'media-frame rpw-media-frame',
            frame: 'select',
            multiple: false,
            title: agp_upload_media.title,
            library: {
                type: 'image'
            },
            button: {
                text:  agp_upload_media.button
            }
        });

        rpw_media_frame.on('select', function(){
            var owner = rpw_media_frame.wcp_owner;
            var media_attachment = rpw_media_frame.state().get('selection').first().toJSON();
            var url;
            if (!media_attachment.sizes.wcp_weather_image_preview) {
                url = media_attachment.url;
            } else {
                url = media_attachment.sizes.wcp_weather_image_preview.url;
            }
            
            if (!url) {
                url = agp_upload_media.noimage_url;
                $(owner).closest('.agp-upload-image-container').find('.agp-upload-image-reset-button').hide();
            } else {
                $(owner).closest('.agp-upload-image-container').find('.agp-upload-image-reset-button').show();
            }
            
            $(owner).closest('.agp-upload-image-container').find('.agp-upload-image').val(media_attachment.id);
            $(owner).closest('.agp-upload-image-container').find('.agp-upload-image-preview').attr('src', url);
            setTimeout(function() {$.colorbox.resize();}, 200);
        });

        rpw_media_frame.wcp_owner = this;
        rpw_media_frame.open();
    });
});