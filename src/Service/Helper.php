<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UrlShortenType;
use App\Entity\Url;
use App\Utils\KeyGenerator;
use App\Utils\UrlFormatter;

class Helper
{
    public function getHappyMessage()
    {
        $repository = $this->getDoctrine()->getRepository(Url::class);

        $messages = [
            'You did it! You updated the system! Amazing!',
            'That was one of the coolest updates I\'ve seen all day!',
            'Great work! Keep going!',
        ];

        $index = array_rand($messages);

        return $messages[$index];
    }
}