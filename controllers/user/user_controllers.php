<?php
include "../../config/connection.php";
include "../../models/user/user_models.php";

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'getUsers':
        $users = getAllUsers();
        echo json_encode($users);
        break;
    case 'addUser':
        $users_id = isset($_POST['users_id']) ? $_POST['users_id'] : '';
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : '';
        if ($users_id && $username && $password && $status) {
            addUser($users_id, $username, $password, $status);
            echo "User added successfully";
        } else {
            echo "Invalid data provided";
        }
        break;
    case 'updateUser':
        $users_id = isset($_POST['users_id']) ? $_POST['users_id'] : '';
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : '';
        if ($users_id && $username && $password && $status) {
            updateUser($users_id, $username, $password, $status);
            echo "User updated successfully";
        } else {
            echo "Invalid data provided";
        }
        break;
    case 'deleteUser':
        $users_id = isset($_POST['users_id']) ? $_POST['users_id'] : '';
        if ($users_id) {
            deleteUser($users_id);
            echo "User deleted successfully";
        } else {
            echo "Invalid data provided";
        }
        break;
    default:
        echo "Invalid action";
}

?>