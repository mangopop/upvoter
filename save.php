<?php

use \core\vote_lookup;

require_once 'app/startup.php';
$helper = new \core\Helpers();

$task_data = file_get_contents("php://input");
//$task_data = $_POST;
//print_r($task_data);//json
$task_data = json_decode($task_data);
//$helper->pre($task_data);
//print_r($task_data);

$test_data = array(
    array('task' => 'composer', 'votes' => '3', 'user_votes' => 9, 'user_id' => 1, 'id' => 1),
    array('task' => 'composer', 'votes' => '3', 'user_votes' => 9, 'user_id' => 1, 'id' => 2)
);

//want to save to vote_lookup WHERE id
foreach ($task_data as $row) {
    echo "user_votes:".$row->user_votes." ";
    echo "user_id:".$row->user_id." ";
    echo "id:".$row->id." <br>";

    //update record that matches user id AND id
    //when we save to this record we need to add
    //the other code will add all the user votes and display
    $lookup = vote_lookup::find(array('conditions' => "id =". $row->id." AND user_id =".$row->user_id)); // TODO TEST USER_ID
    // this will overwrite the user votes on this line.
    $lookup->votes = $row->user_votes;// TODO THIS MUST ADD TO THE VALUE
    $lookup->save();

//    echo "votes".$row['user_votes'];
//    echo "id".$row['id'];
//
//    $lookup = vote_lookup::find($row['id']);
//    $lookup->votes = $row['user_votes'];
//    //$lookup->user_id = $row->user_id;
//    $lookup->save();
}
