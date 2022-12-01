<?php


require_once('vendor/autoload.php');
require_once('config.php');
require_once('functions.php');

use VK\Client\VKApiClient;
use VK\OAuth\VKOAuth;
use VK\OAuth\VKOAuthDisplay;
use VK\OAuth\Scopes\VKOAuthUserScope;
use VK\OAuth\VKOAuthResponseType;

header('Access-Control-Allow-Origin: *'); //https://vk.com
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Access-Control-Allow-Headers: *"); // X-Requested-With
header('Content-Type: application/json; charset=utf-8');

$key = $_GET['key'];
$data = json_decode(trim(file_get_contents('php://input')), true);
writeToLog(print_r($data, 1), "logWork", 'Into');

$vk = new VKApiClient();
$access_token = "XXXXXXXXXXXXXXXXXX";


$data['group'] = str_replace("/", "", $data['group']);

$linkInfo = getIdFromLink($vk, $access_token, $data['group']);

$walls = getWalls($vk, $access_token, $data['group'], $linkInfo['object_id']);
writeToLog(print_r($walls, 1), "logWork", 'Walls');

$resp = ['status' => "ok", 'items' => []];

foreach ($data['authors'] as $item) {
    $signer = null;
    //$index = array_search($item, $walls['signs']);

    foreach ($walls['walls'] as $wall) {
        if ($wall['signer_id'] == $item) {
            $signer = $wall; // $walls['walls'][$item]
            writeToLog('Item = ' . $item . ' ' . print_r($signer, 1), "loop", 'Items');
        } else continue;
    }

    if ($signer) {
        $resp['items'][] = array(
            'id' => $item,
            'result' => false,
            'signer_id' => $signer['signer_id'],
            'link' => $signer['link']
        );
    } else {
        $resp['items'][] = array(
            'id' => $item,
            'result' => true,
            'signer_id' => null,
            'link' => null
        );
    }
}

writeToLog(json_encode($resp), "logWork", 'resp');

echo json_encode($resp);


/**
 * Логирование
 * @param mixed $data
 * @param string $filename = "logRoistat"
 * @param string $title
 * @return bool
 */
function writeToLog($data, $filename = "logRoistat", $title = '')
{
    $log = "\n------------------------\n";
    $log .= date("Y.m.d G:i:s") . "\n";
    $log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
    $log .= print_r($data, 1);
    $log .= "\n------------------------\n";
    $path = __DIR__ . '/logs';

    if (!is_dir($path)) mkdir($path, 0777, true);
    file_put_contents("{$path}/roistat_{$filename}.log", $log, FILE_APPEND);

    return true;
}
