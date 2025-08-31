
jalaliDatepicker.startWatch({
    minDate: "attr",
    maxDate: "attr"
});


jQuery(document).ready(function ($) {

    $('.onlyNumbersInput').on('input paste', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });


    $(document).on('click', '.upload-logo', function (e) {
        e.preventDefault();
        var button = $(this);
        var logoIdInput = button.siblings('.partner-logo-id');
        var preview = button.siblings('.logo-preview');

        var frame = wp.media({
            title: 'انتخاب لوگو',
            multiple: false,
            library: { type: 'image' },
            button: { text: 'استفاده به عنوان لوگو' }
        });

        // اگر لوگوی قبلی وجود دارد، آن را انتخاب شده نشان دهید
        if (logoIdInput.val()) {
            frame.on('open', function () {
                var selection = frame.state().get('selection');
                var attachment = wp.media.attachment(logoIdInput.val());
                attachment.fetch();
                selection.add(attachment);
            });
        }

        frame.on('select', function () {
            var attachment = frame.state().get('selection').first().toJSON();
            logoIdInput.val(attachment.id);
            preview.html('<img src="' + attachment.url + '" />');
            button.text('تغییر لوگو');
        }).open();
    });

    // افزودن همکار جدید
    $('#add-partner').click(function () {
        var newItem = `
            <div class="partner-item" draggable="true">
                <div class="partner-handle dashicons dashicons-move"></div>
                <div class="partner-fields">
                    <div>
                        <label>عنوان همکار</label>
                        <input type="text" name="partner_name[]" required>
                    </div>
                    <div>
                        <label>لینک (اختیاری)</label>
                        <input type="url" name="partner_url[]">
                    </div>
                    <div class="logo-uploader">
                        <label>لوگو</label>
                        <input type="hidden" class="partner-logo-id" name="partner_logo_id[]" required>
                        <button type="button" class="upload-logo button">انتخاب لوگو</button>
                        <div class="logo-preview"></div>
                    </div>
                    <button type="button" class="remove-partner button-link dashicons dashicons-trash"></button>
                </div>
            </div>
            `;
        $('#partners-list').append(newItem);
    });

    // حذف همکار
    $(document).on('click', '.remove-partner', function () {
        $(this).closest('.partner-item').fadeOut(300, function () {
            $(this).remove();
        });
    });

    // مرتب‌سازی با درگ‌اند‌دراپ
    $('#partners-list').sortable({
        handle: '.partner-handle',
        axis: 'y',
        opacity: 0.7,
        placeholder: 'partner-placeholder',
        cursor: 'move'
    });

    // اعتبارسنجی فرم قبل از ارسال
    $('#partners-form').on('submit', function (e) {
        var isValid = true;

        $('.partner-item').each(function () {
            var name = $(this).find('input[name="partner_name[]"]').val();
            var logoId = $(this).find('.partner-logo-id').val();

            if (!name || !logoId) {
                isValid = false;
                $(this).css('border-color', '#ff0000');
            } else {
                $(this).css('border-color', '#ddd');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('لطفاً برای تمام همکاران عنوان و لوگو را مشخص کنید.');
        }
    });


})

