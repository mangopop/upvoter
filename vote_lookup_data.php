<?php

use \core\vote_lookup;
use \core\Tasks\Task;

require_once 'app/startup.php';
$helper = new \core\Helpers();

$final_array = array();

//get all votes for tasks
//$votes = vote_lookup::find('all');
$lookup_data = vote_lookup::find_by_sql('SELECT tasks.task, v.votes, v.user_id FROM vote_lookups as v LEFT JOIN tasks ON v.task_id = tasks.id');
$votes_left = vote_lookup::find('all', array('select' => 'votes'), array('conditions' => array('user_id = ?', 1)));
//$join = 'LEFT JOIN tasks ON (vote_lookups.task_id = tasks.id)';
//$lookup = vote_lookup::all(array('joins' => $join));

//echo $votes_left[0]->votes;
//$helper->pre($votes_left);

//$helper->pre($lookup_data);

$tasks = Task::find('all');//array-object
$key = 0;
foreach ($tasks as $task) {
    $final_array[$key] = array(
        'task' => $task->task,
        'votes' =>'',
        'user_votes' =>''
    );
    $key ++;
}

foreach ($final_array as $key => $val1) { //key = 0, val1 = task,empty

    foreach ($lookup_data as $val2) { //task, votes,user_id
        // add up votes where task name matches
        if($val1['task'] === $val2->task){
            $final_array[$key]['votes'] += $val2->votes;
            // add votes where user_id matches ... users id
            if($val2->user_id === 1){
                $final_array[$key]['user_votes'] = $val2->votes;
            }
        }
    }
}

//$helper->pre($final_array);
//echo $helper->arToJson($final_array);
echo json_encode($final_array);

//1.get task name - join from vote_lookup (will repeat - filter unique?)
//2.get total votes - select from vote_lookup (count votes where task_id)
//3.get user votes for task - select from vote_lookup (count votes where task_id and user_id)
//4.get votes left - select from vote_lookup (count votes where user_id)

//if the sql result array returns everything the can calculate from that an and return in one!

//echo $data[0]->task;

//$helper->pre($tasks);

// get names from tasks = task name / final-array   DONE
// go through each array                            DONE
// add up votes where name matches = total-votes    DONE
// add those to task final-array                    DONE
// add votes where user_id matches = user-votes     DONE
// take above and subtract from 5 = votes-left