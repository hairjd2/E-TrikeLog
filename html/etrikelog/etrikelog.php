<?php
require 'common.php';

//Grab all the users from our database
$logs = $database->select("etrikelog", [
    'id',
    'user_id',
    'clock_in',
]);

$users = $database->select("users", [
    'id',
    'name',
])

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>E-trike Log</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>

    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">Grape Solutions E-trike Log</a>
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a href="etrikelog.php" class="nav-link">E-trike Log</a>
            </li>
            <li class="nav-item">
                <a href="users.php" class="nav-link active">View Users</a>
            </li>
        </ul>
    </nav>
    <div class="container">
        <div class="row">
            <h2>E-trike Log</h2>
        </div>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">Time In</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //Loop through and list all the information of each user including their RFID UID
                foreach($logs as $log) {
                    echo '<tr>';
                    echo '<td scope="row">' . $log['id'] . '</td>';
                    foreach($users as $user) {
			if($user['id'] == $log['user_id']) {
				echo '<td>' . $user['name'] . '</td>';
			}
		    }
                    echo '<td>' . $log['clock_in'] . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</html>
