<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 18/10/2014
 * Time: 16:02
 */

namespace core;


class Helpers {

    public function arToJson($data, $options = null)
    {
        $out = "[";
        foreach ($data as $row) {
            if ($options != null) {
                $out .= $row->to_json($options);
            } else {
                $out .= $row->to_json();
            }
            $out .= ",";
        }
        $out = rtrim($out, ',');
        $out .= "]";
        return $out;
    }

    public function pre($code){
        echo "<pre>";
        print_r($code);
        echo "</pre>";
    }

} 