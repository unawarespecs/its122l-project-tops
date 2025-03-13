<?php

require '../../config_admin.php';

global $conn;
$con = $conn;

if(isset($_GET['user_id']))
{
    $user_id = mysqli_real_escape_string($con, $_GET['user_id']);

    $query = "SELECT * FROM users WHERE id='$user_id'";
    $query_run = mysqli_query($con, $query);

    if(mysqli_num_rows($query_run) == 1)
    {
        $user = mysqli_fetch_array($query_run);

        $res = [
            'status' => 200,
            'message' => 'User ID fetched successfully',
            'data' => $user
        ];
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'User ID Not Found'
        ];
    }
    echo json_encode($res);
    return;
}

if (isset($_POST['update_user'])) {

    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);

    if ($name == NULL || $email == NULL) {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

    $query = "UPDATE users SET username='$name', email='$email'
                WHERE id='$user_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'User Updated Successfully'
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 500,
            'message' => 'User Not Updated'
        ];
        echo json_encode($res);
        return;
    }
}

if (isset($_POST['delete_user'])) {
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);

    $query = "DELETE FROM users WHERE id='$user_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'User Deleted Successfully'
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 500,
            'message' => 'User Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}

?>