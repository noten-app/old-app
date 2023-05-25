<?php
// Check login state
require("../../res/php/session.php");
start_session();
require("../../res/php/checkLogin.php");
if (!checkLogin()) header("Location: /account");

// Get config
require("../../config.php");

// DB Connection
$con = mysqli_connect(
	config_db_host,
	config_db_user,
	config_db_password,
	config_db_name
);
if (mysqli_connect_errno()) die("Error with the Database");

// Get input
$class_id = $_POST["id"];
if ($class_id === "") die("no id given");

// Delete class if belonging to user, then check if one was deleted
if ($stmt = $con->prepare('DELETE FROM classes WHERE id = ? AND user_id = ?')) {
	$stmt->bind_param('is', $class_id, $_SESSION["user_id"]);
	$stmt->execute();
	if ($stmt->affected_rows === 0) die("no class deleted");
	else if ($stmt->affected_rows === 1) {
		if ($stmt->prepare('DELETE FROM homework WHERE class = ? AND user_id = ?')) {
			$stmt->bind_param('ss', $class_id, $_SESSION["user_id"]);
			$stmt->execute();
			if ($stmt->prepare('DELETE FROM grades WHERE class = ? AND user_id = ?')) {
				$stmt->bind_param('ss', $class_id, $_SESSION["user_id"]);
				$stmt->execute();
				exit("success");
			} else die("Error with the Database");
		}
	} else die("too many classes deleted");
} else {
	die("Error with the Database");
}
