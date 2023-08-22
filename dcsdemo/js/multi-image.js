$ = jQuery.noConflict();

const getDiv = (item, i) => {
    return `<li class='image-list'>
        <img src='${item.src}'  name='${i}' />
        <input class='image-text' name='${i}' value='${item.title || ''}' placeholder='Enter Title'/>
        <textarea class='image-description' name='${i}' placeholder='Enter Description'>${item.description || ''}</textarea>
        <a href='#' class='image-delete btn' name='${i}'>x</a>
        </li>`;
};
const removeListiner = (id) => {
    $(id + " .image-delete").off();
    $(id + " .image-text").off();
    $(id + " .image-description").off();
    $(id + " img").off();
};
const addListiner = (id, bannerList) => {
    removeListiner(id);
    $(id + " img").click(function () {
        var custom_uploader = wp.media.frames.file_frame = wp.media({
            multiple: true
        });
        const _this = this;
        const name = $(this).attr("name");
        custom_uploader.on('select', function () {
            var selection = custom_uploader.state().get('selection');
            selection.map(function (attachment) {
                attachment = attachment.toJSON();
                bannerList[name]['id'] = attachment.id;
                bannerList[name]['src'] = attachment.url;
                $(_this).attr('src', attachment.url);
                $(id + ' .wp-editor-area').val(JSON.stringify(bannerList)).trigger('change');
            });
        });
        custom_uploader.open();
    });
    $(id + " .image-delete").click(function () {
        bannerList = bannerList.filter((_, i) => i !== Number($(this).attr('name')))
        $(id + ' .wp-editor-area').val(JSON.stringify(bannerList)).trigger('change');
        render(id, bannerList);
    });
    $(id + " .image-text").change(function () {
        bannerList[$(this).attr("name")]['title'] = $(this).val()
        $(id + ' .wp-editor-area').val(JSON.stringify(bannerList)).trigger('change');
    });
    $(id + " .image-description").change(function () {
        bannerList[$(this).attr("name")]['description'] = $(this).val()
        $(id + ' .wp-editor-area').val(JSON.stringify(bannerList)).trigger('change');
    });
};

const render = (id, bannerList) => {
    $(id + " .images").empty();
    bannerList.map((item, i) => {
        $(id + " .images").append(getDiv(item, i));
    });
    addListiner(id, bannerList);
};
const getFun = (id) => {
    var begin_attachment_string = $(id + " .wp-editor-area").val();
    var bannerList = JSON.parse(begin_attachment_string || '[]') || [];
    render(id, bannerList);
    $(id + " .button-secondary.upload").click(function () {
        var custom_uploader = wp.media.frames.file_frame = wp.media({
            multiple: true
        });
        custom_uploader.on('select', function () {
            var selection = custom_uploader.state().get('selection');
            selection.map(function (attachment) {
                attachment = attachment.toJSON();
                const item = {
                    id: attachment.id,
                    src: attachment.url,
                    title: ''
                };
                bannerList.push(item)
                $(id + " .images").append(getDiv(item, bannerList.length - 1));
            });
            $(id + ' .wp-editor-area').val(JSON.stringify(bannerList)).trigger('change');
            addListiner(id, bannerList);
        });
        custom_uploader.open();
    });
    $(id + " .button-secondary.reset").click(function () {
        $(id + ' .wp-editor-area').val([]).trigger('change');
        bannerList = [];
        render(id, bannerList);
    });
};
