<?php

class Poster
{
    private $vkWrapper;
    private $facebookWrapper;
    private $file;

    public function __construct(VkWrapper $vkWrapper, FacebookWrapper $facebookWrapper, $file)
    {
        $this->facebookWrapper = $facebookWrapper;
        $this->vkWrapper = $vkWrapper;
        $this->file = $file;
    }

    public function sendToFacebook()
    {
        $posts = $this->vkWrapper->get_data();
		$i=0;
		//print_r($posts);

        $parsed = $this->getParsed();
        foreach ($posts as $post)
        {
            if(in_array($post['id'], $parsed))
            {
                continue;
            }
            $attachment = $this->getMaxImage($post['attachments']);
			print_r($this->clearString($post['text']));
			echo "<hr>";
            $this->facebookWrapper->sendPost($this->clearString($post['text']),$attachment);

            $this->pushToParsed($post['id']);
			$i++;
        }
		if($i == 0){
			echo 'Нечего репостить *_*, ждите новых постов в Вконтакте)';
		}
		
    }

    private function pushToParsed($id)
    {
        $parsed = $this->getParsed();
        $parsed[] = $id;
        file_put_contents($this->file,serialize($parsed));
    }

    private function getParsed()
    {
        $file = file_get_contents($this->file);

        return unserialize($file);
    }

    private function getMaxImage($attachments){
        $photo = [];
        foreach ($attachments as $attachment)   {
            if($attachment['type'] == 'photo'){
                $photo = $attachment['photo'];
                    break;
            }

        }
        if(!$photo)
            return false;
        $width = $photo['width'];

        return $photo['photo_'.$width];

    }
    
    private function clearString($message)
    {
        $search = ['[id428095679|',']','[club146704319|'];

        return str_replace($search, '', $message);
    }
}