jQuery(document).ready(function ($) {

    $('.multiple_image_preview').click(function () {

        var multiple_image_uploader = wp.media({
            title: 'Select Images',
            button: {
                text: 'Select'
            },
            multiple: true
        }).open().on('select', function () {
            var attachment_ids = '';
            var attachments = multiple_image_uploader.state().get('selection').toJSON();

            $.each(attachments, function (index, attachment) {
                attachment_ids += attachment.id + ',';
                $('.images_preview').append('<img src="' + attachment.sizes.thumbnail.url + '" />');
            });

            $('.image_ids').val(attachment_ids);
        });

    });
});