<?php

use \core\Users\User;

require_once 'app/startup.php';

//find user by id
$user = User::find(1);

echo $user->to_json();

//could use a query to get different tables?