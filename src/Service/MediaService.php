<?php
namespace App\Service;

use App\Entity\Event;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MediaService{
    private $config;
    
    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->config = $parameterBag->get('media');
    }

    public function handleEvent(Event $event)
    {
        if($event->getPictureUrl()){
            $event->setPicture($event->getPictureUrl());
        }else if($event->getPictureFile()){
            $file = $event->getPictureFile();
            $name = sprintf('image_%s.%s', uniqid(), $file->guessExtension());
            $file->move($this->config['path'], $name);
            $event->setPicture($name);
        }
    }

}