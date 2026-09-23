<?php

class VkWrapper
{
    private $appSecret;
    private $pageId;

    public function __construct($pageId,$appSecret)
    {
        $this->pageId = $pageId;
        $this->appSecret = $appSecret;
    }

    private function curl($url,$request_params)
    {
        $ch = curl_init();
        curl_setopt_array( $ch, array(
            CURLOPT_POST            => TRUE,
            CURLOPT_RETURNTRANSFER  => TRUE,
            CURLOPT_SSL_VERIFYPEER  => FALSE,
            CURLOPT_SSL_VERIFYHOST  => FALSE,
            CURLOPT_POSTFIELDS      => $request_params,
            CURLOPT_URL             => $url,
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result,true);
    }

    public function  get_data()
    {
        $params = array(
            'owner_id'=> '-'.$this->pageId, // ид страницы или пользователя, что парсить
            'owners_only'=> '1',
            'count'=>10, // Выбрать последние 10 постов максимум 100
            'access_token' => $this->appSecret,
            'v' => '5.58'
        );
        return $this->curl('https://api.vk.com/method/wall.get',$params)['response']['items']; // Выбрать массив данных
    }
}