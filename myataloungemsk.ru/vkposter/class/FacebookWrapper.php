<?php
use Facebook\Facebook;
class FacebookWrapper
{
    private  $fb;
    private $accessToken;
    private $groupId;

    public function __construct(Facebook $facebook, $accessToken,$groupId)
    {
        $this->fb = $facebook;
        $this->accessToken = $accessToken;
        $this->groupId = $groupId;
    }

    public function sendPost($message, $image=false)
    {
        if($image)
            return $this->postWithImage($message, $image);
        return $this->postWithText($message);
    }

    private function postWithText($message)
    {
        $linkData = [
            'message' => $message
        ];

        $response = $this->fb->post("/{$this->groupId}/feed", $linkData, $this->accessToken);
        $graphNode = $response->getGraphNode();

        return $graphNode['id'];
    }

    private function postWithImage($message,$url)
    {
        $data = [
            'message' => $message,
            'source' => $this->fb->fileToUpload($url),
        ];

        $response = $this->fb->post('/me/photos', $data, $this->accessToken);
        $graphNode = $response->getGraphNode();

        return $graphNode['id'];
    }
}