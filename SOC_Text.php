<?php
/**
 * Created by PhpStorm.
 * User: ko
 * Date: 2016/8/10
 * Time: 上午 11:56
 */

// array for JSON response
$response = array();
$ResultValue = array();

if (isset($_POST['battery_type']) && isset($_POST['voltage']) && isset($_POST['voltage_channel'])){

    // include db connect class
    require_once __DIR__ . '/calculate_soc.php';

    // get values
    $battery_type_value = $_POST['battery_type'];
    $voltage_value = $_POST['voltage'];
    $voltage_channel_value = $_POST['voltage_channel'];

    $calculate_soc = new CALCULATE_SOC();
    $ResultValue = $calculate_soc->Calculate_SOC($battery_type_value, $voltage_value, $voltage_channel_value);
    echo json_encode($ResultValue);
} else {

    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    // echoing JSON response
    echo json_encode($response);
}
?>