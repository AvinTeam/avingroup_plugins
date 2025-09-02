
jalaliDatepicker.startWatch({
    minDate: "attr",
    maxDate: "attr"
});


jQuery(document).ready(function ($) {

    $('.inputColor').wpColorPicker();

    $('.onlyNumbersInput').on('input paste', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('#upload_service_icon').on('click', function (e) {
        e.preventDefault();

        var frame = wp.media({
            title: 'انتخاب آیکون',
            button: {
                text: 'استفاده از این تصویر'
            },
            multiple: false
        });

        frame.on('select', function () {
            var attachment = frame.state().get('selection').first().toJSON();
            $('#service_icon').val(attachment.id);
            $('#service_icon_preview').html('<img src="' + attachment.url + '" style="max-width: 50px; height: 50px; object-fit: contain;" />');
            $('#service_icon_preview').show();
            $('#remove_service_icon').show();
        });

        frame.open();
    });

    $('#remove_service_icon').on('click', function (e) {
        e.preventDefault();
        $('#service_icon').val('');
        $('#service_icon_preview').html('');
        $(this).hide();
    });

    $('#upload_service_poster').on('click', function (e) {
        e.preventDefault();

        var frame = wp.media({
            title: 'انتخاب پستر',
            button: {
                text: 'استفاده از این تصویر'
            },
            multiple: false
        });

        frame.on('select', function () {
            var attachment = frame.state().get('selection').first().toJSON();
            $('#service_poster').val(attachment.id);
            $('#service_poster_preview').html('<img src="' + attachment.url + '" style="max-width: 200px; height: auto;" />');
            $('#service_poster_preview').show();
            $('#remove_service_poster').show();
        });

        frame.open();
    });

    $('#remove_service_poster').on('click', function (e) {
        e.preventDefault();
        $('#service_poster').val('');
        $('#service_poster_preview').html('');
        $(this).hide();
    });


    let nextItem = 0;
    $('#add-link-item').click(function (e) {
        e.preventDefault();

        if (nextItem == 0) {
            nextItem = Number($(this).attr('data-next-item'));
        }
        nextItem += 1;

        const options = Object.entries(ag_js.linkList).map(([key, name]) => {
            return `<option value="${key}">${name}</option>`;
        });

        const optionsString = options.join('\n');

        $('#link-list').append(`
            <li>
                <select name="project[links][${nextItem}][type]">
                    ${optionsString}
                </select>
                <input name="project[links][${nextItem}][link]" type="url" class="w-100 regular-text">
                <button type="button" class="button button-error">حذف</button>
            </li>
        `);


    });


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

    $(document).on('click', '.remove-image', function (e) {
        e.preventDefault();
        $(this).parent().remove();
        updateGalleryInput();
    });

    function updateGalleryInput() {
        var imageIds = [];
        $('#gallery-images-list .image-item').each(function () {
            imageIds.push($(this).data('id'));
        });

        console.log(imageIds);
        $('#gallery_items').val(imageIds.join(','));
    }


    let allItemsChecked = [];


    const $checkboxes = $('#partners input[type="checkbox"]');

    $checkboxes.each(function () {
        changeTerm(this);
    });

    $checkboxes.change(function () {
        changeTerm(this)
    });

    function changeTerm(_this) {

        let id = $(_this).val();

        if (_this.checked) {

            allItemsChecked.push(id);

            $('#term-' + id).removeClass('d-none');
        } else {

            const index = allItemsChecked.indexOf(id);
            if (index !== -1) {
                allItemsChecked.splice(index, 1);
            }

            $('#term-' + id).addClass('d-none');

        }

        if (allItemsChecked.length == 0) {
            $('#services #isEmpty').removeClass('d-none');

        } else {
            $('#services #isEmpty').addClass('d-none');

        }



    }


    $('#select2ProjectClients').select2({
        placeholder: 'مشتری را انتخاب کنید',
        dir: 'rtl',
        language: {
            noResults: function () {
                return 'نتیجه‌ای یافت نشد.';
            },
            searching: function () {
                return 'در حال جستجو...';
            }
        },
    });

})

