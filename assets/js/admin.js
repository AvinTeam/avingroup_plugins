
jalaliDatepicker.startWatch({
    minDate: "attr",
    maxDate: "attr"
});


jQuery(document).ready(function ($) {

    $('.inputColor').wpColorPicker();


    $('.onlyNumbersInput').on('input paste', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });







    // انتخاب تصویر از گالری
    $(document).on('click', '.upload-menu-image', function (e) {
        e.preventDefault();

        var mediaUploader = wp.media({
            title: 'انتخاب تصویر برای کاور ویدئو',
            button: { text: 'استفاده از این تصویر' },
            multiple: false,
            library: {
                type: ['image']
            },
        });

        mediaUploader.on('select', function () {
            var attachment = mediaUploader.state().get('selection').first().toJSON();

            $('#zba-add-image-id').val(attachment.id);
            $('#zba-video-image').attr('src', attachment.url).show();
        });

        mediaUploader.open();
    });

    // حذف تصویر
    $(document).on('click', '.remove-menu-image', function (e) {
        e.preventDefault();
        $('#zba-add-image-id').val('');
        $('#zba-video-image').hide().attr('src', '');
    });

    $("form#edittag").attr("enctype", "multipart/form-data");


    $('#gallery-images-list').sortable({
        update: function () {
            updateGalleryInput();
        }
    });

    $('#upload-gallery-images').click(function (e) {
        e.preventDefault();
        var frame = wp.media({
            title: 'انتخاب عکس‌های گالری',
            multiple: true,
            library: { type: 'image' },
            button: { text: 'استفاده از عکس‌ها' }
        });

        frame.on('select', function () {
            var attachments = frame.state().get('selection').toJSON();
            attachments.forEach(function (attachment) {

                $('#gallery-images-list').append(`
                        <li class="image-item" data-id="${attachment.id}">
                            <img src="${attachment.url}" />
                            <a href="#" class="remove-image">حذف</a>
                        </li>
                    `);
            });
            updateGalleryInput();
        });

        frame.open();
    });

    // حذف عکس
    $(document).on('click', '.remove-image', function (e) {
        e.preventDefault();
        $(this).parent().remove();
        updateGalleryInput();
    });

    // ذخیره تغییرات با AJAX
    // $('#save-gallery').click(function (e) {
    //     e.preventDefault();
    //     console.log(zba_js.ajaxurl);
    //     $.post(zba_js.ajaxurl, {
    //         action: 'save_zba_galleries',
    //         image_ids: $('#zba_galleries').val(),
    //         gallery_type: $('#gallery_type').val(),
    //         security: zba_js.nonce
    //     }, function (response) {
    //         alert('تغییرات ذخیره شد!');
    //     });
    // });

    // به‌روزرسانی فیلد مخفی
    function updateGalleryInput() {
        var imageIds = [];
        $('#gallery-images-list .image-item').each(function () {
            imageIds.push($(this).data('id'));
        });

        console.log(imageIds);
        $('#gallery_items').val(imageIds.join(','));
    }




})

