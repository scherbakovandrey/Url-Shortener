<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as CustomAssert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UrlRepository")
 * @ORM\Table(name="url")
 */
class Url
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="`originalUrl`", type="string", length=255, unique=true)
     * @Assert\NotBlank(message = "The url should not be blank")
     * @Assert\Url(message = "The url is not valid")
     * @CustomAssert\SelfServer
     */
    private $originalUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="`key`", type="string", length=6, unique=true)
     */
    private $key;

    public function getId() : int
    {
        return $this->id;
    }

    public function getOriginalUrl()
    {
        return $this->originalUrl;
    }

    public function setOriginalUrl(string $originalUrl) : void
    {
        $this->originalUrl = $originalUrl;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(string $key) : void
    {
        $this->key = $key;
    }
}