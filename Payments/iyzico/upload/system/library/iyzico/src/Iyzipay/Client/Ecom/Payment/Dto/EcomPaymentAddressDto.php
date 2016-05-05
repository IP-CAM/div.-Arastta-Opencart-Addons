<?php

namespace Iyzipay\Client\Ecom\Payment\Dto;

use Iyzipay\Client\JsonBuilder;
use Iyzipay\Client\PKIRequestStringBuilder;
use Iyzipay\Client\RequestDto;

class EcomPaymentAddressDto extends RequestDto
{
    private $address;
    private $zipCode;
    private $contactName;
    private $city;
    private $country;

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getZipCode()
    {
        return $this->zipCode;
    }

    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    public function getContactName()
    {
        return $this->contactName;
    }

    public function setContactName($contactName)
    {
        $this->contactName = $contactName;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function getJsonObject()
    {
        return JsonBuilder::newInstance()
            ->add("address", $this->getAddress())
            ->add("zipCode", $this->getZipCode())
            ->add("contactName", $this->getContactName())
            ->add("city", $this->getCity())
            ->add("country", $this->getCountry())
            ->getObject();
    }

    public function toPKIRequestString()
    {
        return PKIRequestStringBuilder::newInstance()
            ->append("address", $this->getAddress())
            ->append("zipCode", $this->getZipCode())
            ->append("contactName", $this->getContactName())
            ->append("city", $this->getCity())
            ->append("country", $this->getCountry())
            ->getRequestString();
    }
}