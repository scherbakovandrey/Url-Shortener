<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Entity\Url;

class RedirectController extends AbstractController
{
    /**
     * @Route("/{key}", name="redirect", requirements={"key"="[A-Za-z0-9]{6}"})
     *
     */
    public function index(Url $url = null): Response
    {
        if ($url == null) {
            throw new NotFoundHttpException('Sorry, we coudn\'t find the short URL for this key!');
        }
        return $this->redirect($url->getOriginalUrl());
    }
}