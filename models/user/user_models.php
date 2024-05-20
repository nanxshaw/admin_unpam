<?php
include "../../config/connection.php";

function getUsers()
{
    global $conn;
    $result = $conn->query("SELECT * FROM tb_user");
    if (!$result) {
        error_log("Error fetching users: " . $conn->error);
        return [];
    }

    return $result->fetch_all(MYSQLI_ASSOC);
}

function addUser($users_id, $username, $password, $status)
{
    global $conn;
    $create_date = date('Y-m-d H:i:s');
    $sql = "INSERT INTO tb_user (users_id,username, password, status, create_date) VALUES ('$users_id','$username', '$password', '$status','$create_date')";
    if (!$conn->query($sql)) {
        error_log("Error adding user: " . $conn->error);
    }
}

function updateUser($users_id, $username, $password, $status)
{
    global $conn;
    $create_date = date('Y-m-d H:i:s');
    $query = "UPDATE tb_user SET  username = '$username', password = '$password', status = '$status' WHERE user_id = $users_id";
    if (!$conn->query($query)) {
        error_log("Error updating user: " . $conn->error);
    }
}

function deleteUser($users_id)
{
    global $conn;
    $query = "DELETE FROM tb_user WHERE user_id = $users_id";

    if (!$conn->query($query)) {
        error_log("Error deleting user: " . $conn->error);
    }
}

function getAllUsers()
{
    return getUsers();
}
