<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CurrencyCacheRepository")
 */
class CurrencyCache
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $baseCurrency;

    /**
     * @ORM\Column(type="string", length=2000)
     */
    private $exchangeRatesJSON;

    /**
     * @ORM\Column(type="datetime")
     */
    private $expiresAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBaseCurrency(): ?string
    {
        return $this->baseCurrency;
    }

    public function setBaseCurrency(string $baseCurrency): self
    {
        $this->baseCurrency = $baseCurrency;

        return $this;
    }

    public function getExchangeRatesJSON(): ?string
    {
        return $this->exchangeRatesJSON;
    }

    public function setExchangeRatesJSON(string $exchangeRatesJSON): self
    {
        $this->exchangeRatesJSON = $exchangeRatesJSON;

        return $this;
    }

    public function getExpiresAt(): ?\DateTimeInterface
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }
}
