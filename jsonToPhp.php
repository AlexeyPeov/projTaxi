<?php
$file = file_get_contents("jopa.json");

$arr = json_decode($file, true);


function recursive(array $arr){
    echo "[\n";
    foreach ($arr as $key => $value){
        if(is_array($value)){
            echo "  " . "'" . "$key" . "'" . " " . "=>" . "\n";
            recursive($value);
        }
        else {
            echo "  " . "'" . $key .  "'" . " " . "=>" . " " . "'" . $value . "'" . "," . "\n";
        }
    }
    echo "], \n";
}

recursive($arr);

$array = [
    'firstName' => 'Mike',
    'secondName' => 'Zorawski',
    'birthday' => '1992-12-02',
    'phoneNum' =>
        [
            'num1' => '+7 242 623 11 11',
            'num2' => '+8 245 662 15 73',
            'num3' => '+7 662 267 98 51',
        ],
    'pointA' => 'Новая Улица 2',
    'pointB' => 'Старая улица 4',
    'carClass' => '1',
    'test' =>
        [
            'test1' =>
                [
                    'jopa' => 'anus',
                    'jopa1' => 'anus1',
                ],
            'test2' =>
                [
                    'pisa' => 'popa',
                    'kaka' => 'meow',
                ],
        ],
 ];
echo $array["firstName"];