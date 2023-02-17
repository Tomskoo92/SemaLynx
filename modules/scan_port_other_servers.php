<?php
if(isset($_POST['Host']) && !empty($_POST['Host']) && isset($_POST['Target']) && !empty($_POST['Target'])) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $_POST['Host']."/api/scan_port_other_servers.py/--ip/".$_POST['Target'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        return false;
    } else {
        echo json_decode($response)->result_script_json;
    }
}else {
    return false;
}

