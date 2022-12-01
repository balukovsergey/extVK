<?php

function getIdFromLink($vk, string $access_token, string $link)
{
    $response = $vk->utils()->resolveScreenName($access_token, ['screen_name' => $link]); // https://vk.com/dev/utils.checkLink

    return $response;
}

function getWalls($vk, string $access_token, string $link, string $id)
{
    $info['signs'] = [];
    $info['walls'] = [];
    //$link = "https://vk.com/goodadsnn?w=wall-99417575_";
    $link = "https://vk.com/" . $link . "?w=wall-".$id."_";

    $date = new DateTime('now');
    $date->sub(new DateInterval('P7D'));


    for ($i = 0; $i <= 20; $i++) {
        $json = $vk->wall()->get($access_token, ['owner_id' => "-" . $id, 'count' => 100, 'offset' => $i . 00]);

        foreach ($json['items'] as $item) {
            if ($item['is_pinned']) continue;
            if ($item['date'] >= $date->getTimestamp()) {
                $info['signs'][$item['id']] = $item['signer_id'];
                $info['walls'][$item['id']] = ['signer_id' => $item['signer_id'], 'date' => $item['date'], 'link' => $link . $item['id']];
            } else return $info;
        }
    }

    return $info;
}