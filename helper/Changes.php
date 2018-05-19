<?php

namespace CodeYourFuture\Helper;

class Changes {

    public static function getChanges($total_payment, $cash) {
        $response = array();
        if ($total_payment > $cash) {
            $response["error"] = array(
                "code" => 400,
                "message" => "Bad request"
            );
            return json_encode($response); 
        }
        $list_money = array(500, 1000, 2000, 5000, 10000, 20000, 50000);
        rsort($list_money);
        $changes = $cash - $total_payment;
        for ($i = 0; $i < count($list_money); $i++) {
            if ($changes >= $list_money[$i]) {
                $response["data"][strval($list_money[$i])] = ($changes - ($changes % $list_money[$i])) / $list_money[$i];
                $changes = $changes - ($changes - ($changes % $list_money[$i]));
            }
        }
        if ($changes > 0) {
            $response["data"][strval($changes)] = 1;
        }
        return json_encode($response);
    }
}