<?php
session_start();
require 'dbcon.php';

function validate($inputData)
{
    global $conn;
    $validationData = mysqli_real_escape_string($conn, $inputData);
    return trim($validationData);
}

function redirect($url, $status)
{
    $_SESSION['status'] = $status;
    header('Location:' . $url);
    exit(0);
}

function alertMessage()
{
    if (isset($_SESSION['status'])) {
        echo ' <div class="alert alert-warning alert-dismissible fade show" role="alert"> <h6>' . $_SESSION['status'] . '  </h6>
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Clost"> </Button>
            </div> ';
        unset($_SESSION['status']);
    }
}

function insert($tableName, $data)
{
    global $conn;
    $table = validate($tableName);
    $columns = array_keys($data);
    $escaped_values = array_map(function ($value) use ($conn) {
        return "'" . mysqli_real_escape_string($conn, $value) . "'";
    }, array_values($data));
    $finalColumn = implode(',', $columns);
    $finalValues = implode(',', $escaped_values);
    $query = "INSERT INTO $table ($finalColumn) VALUES ($finalValues)";
    $result = mysqli_query($conn, $query);
    return $result;
}

function update($tableName, $id, $data)
{
    global $conn;
    $table = validate($tableName);
    $id = validate($id);
    $updateParts = [];
    foreach ($data as $column => $value) {
        $safeColumn = mysqli_real_escape_string($conn, $column);
        $safeValue = mysqli_real_escape_string($conn, $value);
        $updateParts[] = "$safeColumn='$safeValue'";
    }

    $updateString = implode(",", $updateParts);

    $query = "UPDATE $table SET $updateString WHERE id='$id'";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Update Error:" . mysqli_error($conn));
    }

    return $result;
}

function getAll($tableName, $status = NULL)
{
    global $conn;
    $table = validate($tableName);
    $status = validate($status);
    if ($status == 'status') {
        $query = 'SELECT * FROM $table WHERE status = "0"';
    } else {
        $query = 'SELECT * FROM $table';
    }

    $result = mysqli_query($conn, $query);
    return $result;
}

function getById($tableName, $id)
{
    global $conn;
    $table = validate($tableName);
    $id = validate($id);
    $query = "SELECT * FROM $table WHERE id = '$id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $response = ['status' => 200, 'data' => $row, 'message' => 'Record Found!'];
            return $response;
        } else {
            $response = ['status' => 404, 'message' => 'No Data Found!'];
            return $response;
        }
    } else {
        $response = ['status' => 500, 'message' => 'Something went wrong!'];
        return $response;
    }
}

function delete($tableName, $id)
{
    global $conn;
    $table = validate($tableName);
    $id = validate($id);

    $query = "DELETE FROM $table WHERE id = '$id' LIMIT 1";

    $result = mysqli_query($conn,$query);

    return $result;
}
