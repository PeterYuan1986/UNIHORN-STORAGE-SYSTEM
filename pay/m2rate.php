<?php

header("Content-Type:text/html;charset=UTF-8");

function nowapi_call($a_parm) {
    if (!is_array($a_parm)) {
        return false;
    }
    //combinations
    $a_parm['format'] = empty($a_parm['format']) ? 'json' : $a_parm['format'];
    $apiurl = empty($a_parm['apiurl']) ? 'http://api.k780.com/?' : $a_parm['apiurl'] . '/?';
    unset($a_parm['apiurl']);
    foreach ($a_parm as $k => $v) {
        $apiurl .= $k . '=' . $v . '&';
    }
    $apiurl = substr($apiurl, 0, -1);
    if (!$callapi = file_get_contents($apiurl)) {
        return false;
    }
    //format
    if ($a_parm['format'] == 'base64') {
        $a_cdata = unserialize(base64_decode($callapi));
    } elseif ($a_parm['format'] == 'json') {
        if (!$a_cdata = json_decode($callapi, true)) {
            return false;
        }
    } else {
        return false;
    }
    //array
    if ($a_cdata['success'] != '1') {
        echo $a_cdata['msgid'] . ' ' . $a_cdata['msg'];
        return false;
    }
    return $a_cdata['result'];
}

$nowapi_parm['app'] = 'finance.rate_unionpayintl';
$nowapi_parm['cur_base'] = 'CNY';
$nowapi_parm['cur_transaction'] = 'USD';
$nowapi_parm['cur_date'] = date('Ymd');
$nowapi_parm['appkey'] = '52564';
$nowapi_parm['sign'] = 'c18d1347a50f10e2c551476deade2fec';
$nowapi_parm['format'] = 'json';
$result = nowapi_call($nowapi_parm);
$m2rate=$result['exchange_rate'];
?>