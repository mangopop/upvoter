<?php

use \core\vote_lookup;
use \core\Tasks\Task;

require_once 'app/startup.php';
$helper = new \core\Helpers();

//$task_data = file_get_contents("php://input");
//$task_data = $_POST;

$final_array = array();

//TODO get user_id
$user_id = 1;
//get all votes for tasks
//$votes = vote_lookup::find('all');

$votes_left = vote_lookup::find('all', array('select' => 'votes'), array('conditions' => array('user_id = ?', 1)));
//$join = 'LEFT JOIN tasks ON (vote_lookups.task_id = tasks.id)';
//$lookup = vote_lookup::all(array('joins' => $join));

//Just performing update here //cannot be called at start
//if(!empty($task_data)){
//    $task_data = json_decode($task_data);
//
//    //want to save to vote_lookup WHERE id
//    foreach ($task_data as $row) {
//        $lookup = vote_lookup::find($row['id']); //get a record from teh lookup table matching one from POSTED object
//        $lookup->votes = $row['votes'];
//        $lookup->user_id = $row['user_id'];
//        $lookup->save();
//    }

//}else{
    //get task data for task titles
    $tasks = Task::find('all');//array-object
    $key = 0;
    foreach ($tasks as $task) {
        $final_array[$key] = array(
            'task' => $task->task,
            'votes' =>'',
            'user_votes' =>'',
            'user_id' =>'',
            'id' => ''
        );
        $key ++;
    }

    $lookup_data = vote_lookup::find_by_sql('SELECT tasks.task, v.votes, v.user_id, v.id FROM vote_lookups as v LEFT JOIN tasks ON v.task_id = tasks.id');

    foreach ($final_array as $key => $val1) { //key = 0, val1 = task,empty

        foreach ($lookup_data as $val2) { // use - task, votes,user_id, id
            // add up votes where task name matches
            if($val1['task'] === $val2->task){
                if ($val2->user_id === $user_id) {
                    $final_array[$key]['user_id'] = $val2->user_id; //TODO don't override
                }
                $final_array[$key]['id'] = $val2->id;
                $final_array[$key]['votes'] += $val2->votes; //add votes where user_id matches ... users id
                if($val2->user_id === 1){
                    $final_array[$key]['user_votes'] = $val2->votes; //get user votes by id
                }
            }
        }
    }

    //$helper->pre($final_array);
    //echo $helper->arToJson($final_array);
    echo json_encode($final_array);
//}

//1.get task name - join from vote_lookup (will repeat - filter unique?)
//2.get total votes - select from vote_lookup (count votes where task_id)
//3.get user votes for task - select from vote_lookup (count votes where task_id and user_id)
//4.get votes left - select from vote_lookup (count votes where user_id)

//if the sql result array returns everything the can calculate from that an and return in one!

//echo $task_data[0]->task;

//$helper->pre($tasks);

// get names from tasks = task name / final-array   DONE
// go through each array                            DONE
// add up votes where name matches = total-votes    DONE
// add those to task final-array                    DONE
// add votes where user_id matches = user-votes     DONE
// take above and subtract from 5 = votes-left