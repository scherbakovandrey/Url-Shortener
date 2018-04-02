<?php

namespace App\Repository;

use App\Entity\Url;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Utils\KeyGenerator;

/**
 * @method Url|null find($id, $lockMode = null, $lockVersion = null)
 * @method Url|null findOneBy(array $criteria, array $orderBy = null)
 * @method Url[]    findAll()
 * @method Url[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UrlRepository extends ServiceEntityRepository
{
    private $key;

    private $originalUrl;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Url::class);
    }

    public function getKey($originalUrl)
    {
        $this->originalUrl = $originalUrl;

        // if the url already exists in the database - we use the key for it
        // otherwise we generate the new key and add new record
        if ( ! $this->isUrlAlreadyExists() ) {
            $this->key = $this->generateKey();
            $this->addNewUrl();
        }
        return $this->key;
    }

    // checks if the URL is already exists in the database and if it does - set the $key
    private function isUrlAlreadyExists(): bool
    {
        $url = $this->findOneBy(
            ['originalUrl' => $this->originalUrl]
        );
        if ($url) {
            $this->key = $url->getKey();
            return true;
        }
        return false;
    }

    // we generate the key and if the key is already exists in the database we re-generate the new one
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
        $url = $this->findOneBy(
            ['key' => $key]
        );
        if ($url) {
            return true;
        }
        return false;
    }

    private function addNewUrl(): void
    {
        $entityManager = $this->getEntityManager();

        $url = new Url;
        $url->setOriginalUrl($this->originalUrl);
        $url->setKey($this->key);

        $entityManager->persist($url);
        $entityManager->flush();
    }
}
