<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UrlShortenType;
use App\Entity\Url;
use App\Utils\KeyGenerator;
use App\Utils\UrlFormatter;

class UrlShortenerController extends AbstractController
{
    /**
     * @var string
     */
    private $originalUrl = '';

    /**
     * @var string
     */
    private $shortUrl = '';

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

                // if the url already exists in the database - we use the key for it
                // otherwise we generate the new key and add new record
                if ( ! $this->isUrlAlreadyExists() ) {
                    $this->key = $this->generateKey();
                    $this->addNewUrl();
                }

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

    // checks if the URL is already exists in the database and if it does - set the $key
    private function isUrlAlreadyExists(): bool
    {
        $repository = $this->getDoctrine()->getRepository(Url::class);
        $url = $repository->findOneBy(
            ['originalUrl' => $this->originalUrl]
        );
        if ($url) {
            $this->key = $url->getKey();
            return true;
        }
        return false;
    }

    private function generateKey() : string
    {
        $key = '';
        $isKeyAlreadyExists = true;
        while ($isKeyAlreadyExists) {
            $key = KeyGenerator::generate();
            $isKeyAlreadyExists = $this->isKeyAlreadyExists($key);
        }
        return $key;
    }

    private function isKeyAlreadyExists($key) : bool
    {
        $repository = $this->getDoctrine()->getRepository(Url::class);
        $url = $repository->findOneBy(
            ['key' => $key]
        );
        if ($url) {
            return true;
        }
        return false;
    }

    private function addNewUrl(): void
    {
        $entityManager = $this->getDoctrine()->getManager();

        $url = new Url;
        $url->setOriginalUrl($this->originalUrl);
        $url->setKey($this->key);

        $entityManager->persist($url);
        $entityManager->flush();
    }

    private function generateShortUrl(): string
    {
        return $this->generateUrl('home', [], UrlGeneratorInterface::ABSOLUTE_URL) . $this->key;
    }
}