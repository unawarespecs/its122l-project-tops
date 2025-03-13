$(document).on('click', '.editAnnouncementBtn', function () {

    var id = $(this).val();

    $.ajax({
        type: "GET",
        url: "code_ann.php?announcement_id=" + id,
        success: function (response) {
            var res = jQuery.parseJSON(response);
            if (res.status == 404) {
                alert(res.message);
            } else if (res.status == 200) {
                $('#announcement_id').val(res.data.id);
                $('#title').val(res.data.title);
                $('#announcement_content').val(res.data.announcement_content);
                $('#author').val(res.data.author);
                $('#category').val(res.data.category);

                $('#editAnnounceModal').modal('show');
            }

        }
    });

});
$(document).on('submit', '#editAnnouncement', function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("update_announcement", true);

    $.ajax({
        type: "POST",
        url: "code_ann.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {

            var res = jQuery.parseJSON(response);
            if (res.status == 422) {
                $('#errorMessageUpdate').removeClass('d-none');
                $('#errorMessageUpdate').text(res.message);

            } else if (res.status == 200) {

                $('#errorMessageUpdate').addClass('d-none');

                alertify.set('notifier', 'position', 'top-right');
                alertify.success(res.message);

                $('#editAnnounceModal').modal('hide');
                $('#editAnnouncement')[0].reset();

                $('#announcements_table').load(location.href + " #announcements_table");

            } else if (res.status == 500) {
                alert(res.message);
            }
        }
    });

});
$(document).on('click', '.deleteAnnouncementBtn', function (e) {
    e.preventDefault();

    if (confirm('Are you sure you want to delete this announcement?')) {
        var announcement_id = $(this).val();
        $.ajax({
            type: "POST",
            url: "code_ann.php",
            data: {
                'delete_announcement': true,
                'announcement_id': announcement_id
            },
            success: function (response) {

                var res = jQuery.parseJSON(response);
                if (res.status == 500) {

                    alert(res.message);
                } else {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.success(res.message);

                    $('#announcements_table').load(location.href + " #announcements_table");
                }
            }
        });
    }
});