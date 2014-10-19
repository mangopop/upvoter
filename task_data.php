<?php

use \core\Tasks\Task;

require_once 'app/startup.php';

$helper = new \core\Helpers();

//should be all tasks
if(isset($_POST['data'])){
    $data = $_POST['data'];
}

/* multiple records always return array */
//$tasks = Task::all(); //returns array
//$tasks = Task::find('all'); //returns array
//$tasks = Task::find('last'); //returns object
//$tasks = Task::first(); //returns object

//perform SQL join query to get info from 3 tables

/* save data to database
 *-----------------------------------------------------*/

if(isset($data)){
    $data = json_decode($data);

    foreach ($data as $row) {
        $task = Task::find($row['id']);
        //$task->id = $row['id'];
        $task->task = $row['task'];
        $task->user_id = $row['user_id'];
        //$task->total_votes = $row['total_votes'];
        $task->save();
    }
}


# UPDATE `tasks` SET task='Composer' WHERE id=1

/* return data
 *-----------------------------------------------------*/

//return JSON
echo $helper->arToJson($tasks);

//echo json_encode($tasks[0]->task);
//$json = $tasks->to_json();
//$json = $tasks->to_json(array(
//     'only' => array('id', 'task')
//));


//echo $arToJson($users, array('except' => 'password')); //options example

//foreach ($tasks as $task) {
//    $task->task;
//    $task->total_votes;
//}
