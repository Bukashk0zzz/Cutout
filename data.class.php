<?php

class dbData {
    public function getTemperature() {
        $temperature = '';
        $humidity = '';
        $time = time();
        $db = new SQLite3("temperature/temperature.db");
        if ($db) {
            $result = $db->query('SELECT * FROM temperature order by id desc limit 1');
            if ($result = $result->fetchArray(SQLITE3_ASSOC)) {
                $temperature = $result['temperature'];
                $humidity = $result['humidity'];
                $time = $result['time'];
            }
        }

        return [$temperature,$humidity,$time];
    }

    public function getPir() {
        $time = time();
        $db = new SQLite3("pir/pir.db");
        if ($db) {
            $result = $db->query('SELECT * FROM pir order by id desc limit 1');
            if ($result = $result->fetchArray(SQLITE3_ASSOC)) {
                $time = $result['time'];
            }
        }
        return $time;
    }

    public function getTemperatureTodayData()
    {
        $time_max = time();
        $time_min = $time_max - 86400;
        $labels = array();
        $data = array();
        $dataH = array();

        $db = new SQLite3("temperature/temperature.db");
        if ($db) {
            $result = $db->query("SELECT * FROM temperature where time < $time_max AND time > $time_min order by id asc");
            $i = 1;
            $z = 0;
            $temp = 0;
            $temp2 = 0;
            $time = 0;
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                if ($i == 60) {

                    $labels[] = date('H:i',$time);
                    $data[] = round($temp/$z,1);
                    $dataH[] = round($temp2/$z,1);

                    $temp = 0;
                    $temp2 = 0;
                    $i = 0;
                    $z = 0;
                }


                if($row['temperature'] > 0) {
                    $temp = $temp+$row['temperature'];
                    $temp2 = $temp2+$row['humidity'];
                    $time = $row['time'];
                    $z++;
                }

                $i++;
            }
        }

        function add_quotes($str) {
            return sprintf("'%s'", $str);
        }

        return [implode(',',array_map('add_quotes', $labels)),implode(",",array_map('add_quotes', $data)),implode(",",array_map('add_quotes', $dataH))];
    }
}