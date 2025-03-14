$(document).on('click', '.editUserBtn', function () {

    var user_id = $(this).val();

    $.ajax({
        type: "GET",
        url: "code.php?user_id=" + user_id,
        success: function (response) {
            var res = jQuery.parseJSON(response);
            if (res.status == 404) {
                alert(res.message);
            } else if (res.status == 200) {
                $('#user_id').val(res.data.id);
                $('#name').val(res.data.name);
                $('#email').val(res.data.email);
                $('#password').val(res.data.password);

                $('#editAdminModal').modal('show');
            }

        }
    });

});
$(document).on('submit', '#update_form', function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("update_user", true);

    $.ajax({
        type: "POST",
        url: "code.php",
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

                $('#editAdminModal').modal('hide');
                $('#update_form')[0].reset();

                $('#users_table').load(location.href + " #users_table");

            } else if (res.status == 500) {
                alert(res.message);
            }
        }
    });

});
$(document).on('click', '.deleteUserBtn', function (e) {
    e.preventDefault();

    if (confirm('Are you sure you want to delete this user?')) {
        var user_id = $(this).val();
        $.ajax({
            type: "POST",
            url: "code.php",
            data: {
                'delete_user': true,
                'user_id': user_id
            },
            success: function (response) {

                var res = jQuery.parseJSON(response);
                if (res.status == 500) {

                    alert(res.message);
                } else {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.success(res.message);

                    $('#users_table').load(location.href + " #users_table");
                }
            }
        });
    }
});