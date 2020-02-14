<?php

$myFile = "data.json";
appendNew();

function appendNew():void
{
    global $myFile;
    $arr_data = [];
    try {
        //Get form data
        $formdata = $_POST;
        validate($formdata);

        $formdata['date'] = time();
        //Get data from existing json file
        $jsondata = file_get_contents($myFile);
        // converts json data into array
        if (!$jsondata) {
            $arr_data = [];
        } else {
            $arr_data = json_decode($jsondata, true);
        }
        // Push user data to array
        array_unshift($arr_data, $formdata);
        //Convert updated array to JSON
        $jsondata = json_encode($arr_data, JSON_PRETTY_PRINT);

        //write json data into data.json file
        if (file_put_contents($myFile, $jsondata)) {
            response([1, 'success'.$jsondata]);
        } else {
            response([0, 'error']);
        }
    } catch (Exception $e) {
        response([0, $e->getMessage()]);
    }
}

// function readAll(): array
// {
//     global $myFile;
//     $jsondata = file_get_contents($myFile);
//     // converts json data into array
//     return json_decode($jsondata, true);
// }

function validate(array $data) :void
{
    if (!isset($data['name'])) response([0, 'Name is required']);
    if (!isset($data['quantity'])) response([0, 'Quantity is required']);
    if (!isset($data['price'])) response([0, 'Price is required']);

    if (mb_strlen($data['name']) > 100) response([0, 'Name can not be longer than 100 characters']);
    if (!is_integer((int) $data['quantity']) || $data['quantity'] < 1) response([0, 'Quantity must be number and can not less than 1']);
    if (!is_numeric($data['price']) || $data['price'] < 0) response([0, 'Price must be number and can not less than 0']);
}

function response(array $content)
{
    header('Content-Type:application/json; charset=utf-8');
    exit(json_encode(['status'=> $content[0], 'msg' => $content[1]]));
}
