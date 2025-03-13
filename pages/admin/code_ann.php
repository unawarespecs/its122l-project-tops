<?php

require '../../config_announcements.php';

global $conn_announcements;
$con = $conn_announcements;

if (isset($_GET['announcement_id'])) {
    $announcement_id = mysqli_real_escape_string($con, $_GET['announcement_id']);

    $query = "SELECT * FROM announcements WHERE id='$announcement_id'";
    $query_run = mysqli_query($con, $query);

    if (mysqli_num_rows($query_run) == 1) {
        $user = mysqli_fetch_array($query_run);

        $res = [
            'status' => 200,
            'message' => 'Fetched successfully',
            'data' => $user
        ];
    } else {
        $res = [
            'status' => 404,
            'message' => 'Not Found'
        ];
    }
    echo json_encode($res);
    return;
}

if (isset($_POST['update_announcement'])) {

    $announcement_id = mysqli_real_escape_string($con, $_POST['announcement_id']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $content = mysqli_real_escape_string($con, $_POST['announcement_content']);
    $author = mysqli_real_escape_string($con, $_POST['author']);
    $category = mysqli_real_escape_string($con, $_POST['category']);

    if ($title == NULL || $content == NULL || $author == NULL || $category == NULL) {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

    $query = "UPDATE announcements SET title='$title', content='$content', author='$author', category='$category'
                WHERE id='$announcement_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'Updated Successfully'
        ];
    } else {
        $res = [
            'status' => 500,
            'message' => 'Not Updated'
        ];
    }
    echo json_encode($res);
    return;
}

if (isset($_POST['delete_announcement'])) {
    $announcement_id = mysqli_real_escape_string($con, $_POST['announcement_id']);

    $query = "DELETE FROM announcements WHERE id='$announcement_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'Deleted Successfully'
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}

?>