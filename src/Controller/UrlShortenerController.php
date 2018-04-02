<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UrlShortenType;
use App\Entity\Url;
use App\Utils\UrlFormatter;

class UrlShortenerController extends AbstractController
{
    /**
     * @var string
     */
    private $shortUrl = '';

    /**
     * @var string
     */
    private $originalUrl = '';


    /**
     * @var string
     */
    private $key = '';

    /**
     * @Route("/", name="home")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(UrlShortenType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $url = $form->getData();
                $this->originalUrl = $url->getOriginalUrl();

                $this->key = $this->getDoctrine()->getRepository(Url::class)->getKey($this->originalUrl);
                $this->shortUrl = $this->generateShortUrl();
            } else {
                $this->addFlash("error", "Unable to shorten the entered URL");
            }
        }

        return $this->render('index.html.twig', [
            'url_form' => $form->createView(),
            'original_url' => $this->originalUrl,
            'original_url_formatted' => UrlFormatter::format($this->originalUrl),
            'short_url' => $this->shortUrl
        ]);
    }

    private function generateShortUrl(): string
    {
        return $this->generateUrl('home', [], UrlGeneratorInterface::ABSOLUTE_URL) . $this->key;
    }
}