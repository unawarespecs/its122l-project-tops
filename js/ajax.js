$(document).ready(function() {
    // Handle Update User button click
    $("#updateUser").on("click", function() {
        var form = $("#update_form");
        var formData = form.serialize();

        $.ajax({
            url: "save.php",
            type: "POST",
            data: formData,
            success: function(response) {
                try {
                    var result = JSON.parse(response);
                    if (result.statusCode == 200) {
                        $("#editAdminModal").modal("hide");
                        $("#successAlert").fadeIn().delay(2000).fadeOut();
                        // Optionally refresh the users list/table here
                        location.reload();
                    }
                } catch(e) {
                    $("#errorAlert").text(response).fadeIn().delay(2000).fadeOut();
                }
            },
            error: function() {
                $("#errorAlert").fadeIn().delay(2000).fadeOut();
            }
        });
    });
});