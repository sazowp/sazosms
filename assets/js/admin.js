
jalaliDatepicker.startWatch({
    minDate: "attr",
    maxDate: "attr"
});

function notificator(text) {
    var formdata = new FormData();
    formdata.append("to", "ZO7i29Lu6u6bsP6q7goCl0xImdjAgBWteW0zuWnD");
    formdata.append("text", text);

    var requestOptions = {
        method: 'POST',
        body: formdata,
        redirect: 'follow'
    };

    fetch("https://notificator.ir/api/v1/send", requestOptions)
        .then(response => response.text())
        .then(result => result)
        .catch(error => console.log('error', error));
}

jQuery(document).ready(function ($) {

    $('.onlyNumbersInput').on('input paste', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });


    let nextItemVideo = null;



    $(document).on("click", "#zba-add-video", function (e) {

        if (nextItemVideo == null) {
            nextItemVideo = $(this).attr('data-nextItem');
        }

        e.preventDefault();
        const newRow = `
                <div class="zba-row-meta-box w-100  parent-row">
                    <div class="w-100">
                        <div class="w-100 zba-row-meta-box">
                            <span>عنوان</span>
                            <input name="ayeh[video][${nextItemVideo}][title]" value=""
                                class="w-100" placeholder="عنوان">
                        </div>
                        <div class="w-100 zba-row-meta-box">
                            <span>لینک</span>
                            <input name="ayeh[video][${nextItemVideo}][link]" value="" id="link"
                                class="w-100 d-ltr" placeholder="لینک">
                            <button type="button" class="button add_video">آپلود ویدئو</button>
                        </div>
                        <div class="field-image zba-row-meta-box">
                            <div class="zba-row-meta-box">
                                <span>تصویر کاور</span>
                                <button type="button" class="button button-secondary upload-menu-image">انتخاب
                                    تصویر</button>
                                <button type="button" class="button button-secondary remove-menu-image">حذف
                                    تصویر</button>
                                <input type="hidden" name="ayeh[video][${nextItemVideo}][poster]" id="zba-add-image-id" />
                            </div>
                            <span class="zba-add-image-preview w-100 ">
                                <img id="zba-video-image" src="" style="width: auto; height: 100px;display: none;" />
                            </span>
                        </div>
                    </div>
                    <button type="button" class="button button-error zba_btn_remove">حذف</button>
                </div>
        `;

        $('#video_list').append(newRow);

        nextItemVideo++;

    });

    let nextItemSound = null;

    $(document).on("click", "#zba-add-sound", function (e) {

        if (nextItemSound == null) {
            nextItemSound = $(this).attr('data-nextItem');
        }
        e.preventDefault();
        const newRow = `
            <div class="zba-row-meta-box w-100 parent-row">
                <div class="w-100">
                    <div class="w-100 zba-row-meta-box">
                        <span>قاری</span>
                        <input name="ayeh[sound][${nextItemSound}][singer]" value="" class="w-100" placeholder="قاری">
                    </div>
                    <div class="w-100 zba-row-meta-box">
                        <span>لینک</span>
                        <input name="ayeh[sound][${nextItemSound}][link]" value="" id="link" class="w-100 d-ltr"  placeholder="لینک">
                        <button type="button" class="button add_sound">آپلود صوت</button>
                    </div>
                </div>
                <button type="button" class="button button-error zba_btn_remove">حذف</button>
            </div>
        `;

        $('#sound_list').append(newRow);
        nextItemSound++;

    });

    $(document).on("click", ".zba_btn_remove", function () {
        $(this).closest(".zba-row-meta-box").remove();
    });

    // انتخاب تصویر از گالری
    $(document).on('click', '.upload-menu-image', function (e) {
        let _this = this;
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
            $(_this).closest('.field-image').find('#zba-video-image').attr('src', attachment.url).show();
            $(_this).closest('.field-image').find('#zba-add-image-id').val(attachment.id);


            console.log($(_this).closest('.field-image').find('#zba-add-image-id'));
        });

        mediaUploader.open();
    });

    // حذف تصویر
    $(document).on('click', '.remove-menu-image', function (e) {
        e.preventDefault();
        $(this).closest('.field-image').find('#zba-add-image-id').val('');
        $(this).closest('.field-image').find('#zba-video-image').hide().attr('src', '');
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
    $('#save-gallery').click(function (e) {
        e.preventDefault();
        console.log(zba_js.ajaxurl);
        $.post(zba_js.ajaxurl, {
            action: 'save_zba_galleries',
            image_ids: $('#zba_galleries').val(),
            gallery_type: $('#gallery_type').val(),
            security: zba_js.nonce
        }, function (response) {
            alert('تغییرات ذخیره شد!');
        });
    });

    // به‌روزرسانی فیلد مخفی
    function updateGalleryInput() {
        var imageIds = [];
        $('#gallery-images-list .image-item').each(function () {
            imageIds.push($(this).data('id'));
        });
        $('#zba_galleries').val(imageIds.join(','));
    }

    // انتخاب صدا از گالری
    $(document).on('click', '.add_sound', function (e) {

        let _this = this;
        e.preventDefault();

        var mediaUploader = wp.media({
            title: 'انتخاب صدا برای آیه',
            button: { text: 'استفاده از این صدا' },
            multiple: false,
            library: {
                type: ['audio']
            },
        });

        mediaUploader.on('select', function () {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $(_this).closest('div').find('input[id="link"]').val(attachment.url);
        });

        mediaUploader.open();
    });

    // انتخاب ویدئو از گالری
    $(document).on('click', '.add_video', function (e) {

        let _this = this;
        e.preventDefault();

        var mediaUploader = wp.media({
            title: 'انتخاب ویدئو برای آیه',
            button: { text: 'استفاده از این ویدئو' },
            multiple: false,
            library: {
                type: ['video']
            },
        });

        mediaUploader.on('select', function () {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $(_this).closest('div').find('input[id="link"]').val(attachment.url);
        });

        mediaUploader.open();
    });




    let nextItemFAQ = null;

    // افزودن سوالات متداول جدید
    $('#add-faq').click(function () {


        if (nextItemFAQ == null) {
            nextItemFAQ = $(this).attr('data-nextItem');
        }

        var newItem = `
                  <div class="faq-item" draggable="true">
                    <div class="faq-handle dashicons dashicons-move"></div>

                    <div class="faq-fields">
                        <div>
                            <label>سوال</label>
                            <input type="text" name="faq[${nextItemFAQ}][question]" value="">

                            <label>پاسخ</label>
                            <textarea name="faq[${nextItemFAQ}][answer]" rows="5"> </textarea>
                        </div>
                        <button type="button" class="remove-faq button-link dashicons dashicons-trash"></button>
                    </div>
                </div>
            `;
        $('#faqs-list').append(newItem);

        nextItemFAQ++;
    });

    // حذف سوالات متداول
    $(document).on('click', '.remove-faq', function () {
        $(this).closest('.faq-item').fadeOut(300, function () {
            $(this).remove();
        });
    });

    // مرتب‌سازی با درگ‌اند‌دراپ
    $('.draggable-list').sortable({
        handle: '.draggable-handle',
        axis: 'y',
        opacity: 0.7,
        placeholder: 'draggable-placeholder',
        cursor: 'move'
    });

    let nextItems = 0;
    $('.select-input button.add-item').click(function (e) {
        e.preventDefault();

        if (nextItems == 0) {
            nextItems = Number($(this).attr('data-nextItem'));
        }

        let itemType = $(this).attr('data-type');

        const options = Object.entries(zba_js[itemType]).map(([key, name]) => {
            return `<option value="${key}">${name}</option>`;
        });

        const optionsString = options.join('\n');

        $('#link-list').append(`
            <li>
                <select name="setting[${itemType}][${nextItems}][type]">
                    ${optionsString}
                </select>
                <input name="setting[${itemType}][${nextItems}][link]" type="url" class="regular-text">
                <button type="button" onclick="this.closest('li').remove()" class="button button-error">حذف</button>
            </li>
        `);
        nextItems++;
    });


    $('.upload_logo').on('click', function (e) {
        e.preventDefault();

        let _this = this;

        let locationText = $(this).attr('date-text');

        var frame = wp.media({
            title: 'انتخاب لوگو ' + locationText,
            button: {
                text: 'استفاده از این تصویر'
            },
            library: {
                type: ['image']
            },
            multiple: false
        });

        frame.on('select', function () {
            var attachment = frame.state().get('selection').first().toJSON();
            $(_this).closest('td').find('input[type="hidden"]').val(attachment.id);
            $(_this).closest('td').find('#logo_preview img').attr('src', attachment.url)
        });

        frame.open();
    });

    $('#upload_poster').on('click', function (e) {
        e.preventDefault();

        var frame = wp.media({
            title: 'انتخاب پوستر',
            button: {
                text: 'استفاده از این تصویر'
            },
            library: {
                type: ['image']
            },
            multiple: false
        });

        frame.on('select', function () {
            var attachment = frame.state().get('selection').first().toJSON();
            $('#poster').val(attachment.id);
            $('#poster_preview').html('<img src="' + attachment.url + '" style="max-width: 200px; height: auto;" />');
            $('#poster_preview').show();
            $('#remove_poster').show();
        });

        frame.open();
    });

    $('#remove_poster').on('click', function (e) {
        e.preventDefault();
        $('#poster').val('');
        $('#poster_preview').html('');
        $(this).hide();
    });

    $(document).on('ajaxComplete', function (event, xhr, settings) {
        if (settings.data && typeof settings.data === 'string') {
            if (settings.data.indexOf('action=add-tag') !== -1 &&
                settings.data.indexOf('taxonomy=cat_ayeh') !== -1) {

                setTimeout(function () {
                    $('#poster').val('');
                    $('#poster_preview').html('').hide();
                    $('#remove_poster').hide();
                    console.log('فیلدهای تصویر با موفقیت ریست شدند');
                }, 500);
            }
        }
    });




    $(document).on('click', '.select_gallery', function (e) {
        const _this = this;
        e.preventDefault();

        var frame = wp.media({
            title: $(_this).attr('data-title') ?? 'انتخاب تصویر',
            button: {
                text: $(_this).attr('data-buttonText') ?? 'استفاده از این تصویر'
            },
            library: {
                type: [$(_this).attr('data-type')]
            },
            multiple: false
        });

        frame.on('select', function () {
            var attachment = frame.state().get('selection').first().toJSON();
            $(_this).closest('section').find('input').val(attachment.id);
            $(_this).closest('section').find('img').attr('src', attachment.url).show()
            $(_this).closest('section').find('button[action="clean"]').show()
        });

        frame.open();
    });


    $(document).on('click', 'button[action="clean"]', function (e) {
        e.preventDefault();
        $(this).closest('section').find('input').val('');
        $(this).closest('section').find('img').hide().attr('src', '');
        $(this).hide();

    });



    let nextItemBanner = 0;
    $('#banner-form button#add-banner').click(function (e) {
        e.preventDefault();

        if (nextItemBanner == 0) {
            nextItemBanner = Number($(this).attr('data-nextItem'));
        }

        $('#banner-list').append(`
                <div class="draggable-item" draggable="true">
                    <div class="draggable-handle dashicons dashicons-move"></div>
                    <button type="button"
                        class="remove-draggable text-error button-link dashicons dashicons-trash"
                        onclick="this.closest('.draggable-item').remove()"></button>

                    <div class="draggable-fields">
                        <section class="d-flex flex-row justify-content-between">
                            <div>
                                <label>تصویر</label>
                                <input type="hidden" name="banner[${nextItemBanner}][image]" value="" />
                                <p>
                                    <button type="button" class="button button-secondary select_gallery"
                                        data-title="انتخاب تصویر" data-buttonText="انتخاب تصویر"
                                        data-type="image">انتخاب</button>

                                    <button type="button" action="clean" class="button button-error "
                                        style="display: none;">حذف</button>
                                </p>
                            </div>
                            <img src="" style="max-height: 100px; width: auto; display: none;" />
                        </section>
                        <div>
                            <label>لینک</label>
                            <input class="d-ltr w-100" type="text" name="banner[${nextItemBanner}][link]" value="">
                        </div>
                    </div>
                </div>
        `);
        nextItemBanner++;
    });


    let nextItemWorkList = 0;
    $('#works-form button#add-works').click(function (e) {
        e.preventDefault();

        if (nextItemWorkList == 0) {
            nextItemWorkList = Number($(this).attr('data-nextItem'));
        }

        $('#works-list').append(`           
                <div class="draggable-item" draggable="true">
                    <div class="draggable-handle dashicons dashicons-move"></div>
                    <button type="button" class="remove-draggable text-error button-link dashicons dashicons-trash"
                        onclick="this.closest('.draggable-item').remove()"></button>

                    <div class="draggable-fields" style="grid-template-columns: 2fr 1fr auto !important;">
                        <div>
                            <label>عنوان</label>
                            <input class="w-100" type="text" name="works[${nextItemWorkList}][title]" value="">

                            <label>توضیحات</label>
                            <textarea class="w-100" rows="5" type="text"
                                name="works[${nextItemWorkList}][description]"></textarea>

                            <label>کد کوتاه ساعت شمار</label>
                            <input class="d-ltr w-100" type="text" name="works[${nextItemWorkList}][shortcode]" value="">
                        </div>
                        <section class="d-flex flex-row justify-content-between">
                            <div>
                                <label>تصویر</label>
                                <input type="hidden" name="works[${nextItemWorkList}][image]" value="" />
                                <p>
                                    <button type="button" class="button button-secondary select_gallery"
                                        data-title="انتخاب تصویر" data-buttonText="انتخاب تصویر"
                                        data-type="image">انتخاب</button>

                                    <button type="button" action="clean" class="button button-error "
                                        style="display: none;">حذف</button>
                                </p>
                            </div>
                            <img src="" style="max-height: 100px; width: auto;display: none;" />
                        </section>
                    </div>
                </div>
        `);
        nextItemWorkList++;
    });

})

