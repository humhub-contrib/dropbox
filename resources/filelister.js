var new_files;

var options = {

    // Required. Called when a user selects an item in the Chooser.
    success: function (files) {
        new_files = files;
        if (showWarning != 0) {

            var alertMessage = '<div class="modal" id="fileModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"' +
                'aria-hidden="true">' +
                '<div class="modal-dialog modal-dialog-small animated pulse">' +
                '<div class="modal-content">' +
                '<div class="modal-header">' +
                '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' +
                '<h4 class="modal-title" id="myModalLabel">' + warning_on_posting_modal_title + '</h4> ' +
                '</div>' +
                '<div class="modal-body">' + warning_on_posting_modal_message +
                '<br/><br/> <div class="checkbox"><label><input type="checkbox" onclick="changeWarningOnPosting(this)"/>' + unset_warning_on_posting_checkbox_label + '</label></div>' +
                '</div> ' +
                '<div class="modal-footer text-center">' +
                '<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="javascript:addNewFiles();">' + warning_on_posting_modal_confirm + '</button>' +
                '<button type="button" class="btn btn-default" data-dismiss="modal" style="margin-left:10px;">' + warning_on_posting_modal_cancel + '</button>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>';

            $('body').append(alertMessage);
            $('body').find(':checkbox, :radio').flatelements();
            $('#fileModal').modal('show');
        } else {
            addNewFiles();
        }
    },

    // Optional. Called when the user closes the dialog without selecting a file
    // and does not include any parameters.
    cancel: function () {
    },

    // Optional. "preview" (default) is a preview link to the document for
    // sharing,
    // "direct" is an expiring link to download the contents of the file. For
    // more
    // information about link types, see Link types below.
    linkType: "preview", // or "direct"

    // Optional. A value of false (default) limits selection to a single file,
    // while
    // true enables multiple file selection.
    multiselect: true,

    // Optional. This is a list of file extensions. If specified, the user will
    // only be able to select files with these extensions. You may also specify
    // file types, such as "video" or "images" in the list. For more
    // information,
    // see File types below. By default, all extensions are allowed.
    extensions: ['.pdf', '.doc', '.docx', '.jpg', '.png'],
};


function init() {
    if ($('#' + listId).val() != '') {
        $('#' + listId).css('visibility', 'hidden');
    }
    $('#' + openIcon).on("click", function () {
        Dropbox.appKey = appKey;
        Dropbox.choose(options);
    });

}

function addToFileList(id, name) {

    $('#' + listId).before('<li class="userInput dropboxInput">' + name + '<span id="' + id + '" class="dropbox_remove_file" > <i class="fa fa-times-circle dropbox_file_remove_link"></i></span></li>');

    $(".dropbox_remove_file").off("click");
    $(".dropbox_remove_file").on("click", function () {
        $(this).parent().remove();
        $('#' + listId).val($('#' + listId).val().replace("," + $(this).attr('id') + ",", ','));
        if ($('#' + listId).val().match("^" + $(this).attr('id') + ",")) {
            $('#' + listId).val($('#' + listId).val().replace($(this).attr('id') + ",", ''));
        }
        $.ajax({
            type: 'POST',
            data: {'id': $(this).attr('id')},
            url: file_delete_url,
        }).done(function () {
            data: {
                if ($('#' + listId).val().trim().length == 0) {
                    $('#' + listId).css('visibility', 'visible');
                }
            }
        });

    });
}


function addNewFiles() {

    for (var i = 0; i < new_files.length; i++) {

        $.ajax({
            type: 'POST',
            data: {'link': new_files[i].link, 'name': new_files[i].name, 'thumbnailLink': new_files[i].thumbnailLink},
            dataType: 'json',
            url: dropbox_add_image,
        }).done(function (data) {
            data: {
                if (data['success']) {
                    addToFileList(data['id'], data['name']);
                    $('#' + listId).val($('#' + listId).val() + data['id'] + ",");
                    $('#' + listId).css('visibility', 'hidden');
                }
            }
        });

    }
    return false;
}

function changeWarningOnPosting(obj) {

    var $this = $(obj);
    showWarning = !$this.is(':checked');
    $.ajax({
        type: 'POST',
        data: {'warningOnPosting': !$this.is(':checked')},
        dataType: 'json',
        url: dropbox_warning_setting_url,
    }).done(function (data) {
        data: {
            if (data['success']) {

            }
        }
    });
}