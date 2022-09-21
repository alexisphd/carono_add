<?php


namespace Zenwalker\CommerceML\Model;


use Zenwalker\CommerceML\Collections\SpecificationCollection;
use Zenwalker\CommerceML\CommerceML;
use Zenwalker\CommerceML\ORM\Model;
use Zenwalker\CommerceML\Model\Warehouse;
use Zenwalker\CommerceML\Model\Quantity;


/**
 * Class Offer
 *
 * @package Zenwalker\CommerceML\Model
 * @property Price prices
 * @property SpecificationCollection specifications
 * @property \SimpleXMLElement ХарактеристикиТовара
 * @property Quantity quantity
 * @property Warehouse warehouse
 */
class Offer extends Simple
{
    /**
     * @var Price
     */
    protected $prices = [];
    protected $specifications = [];

    /**
     * @var CommerceML
     */
    public $owner;
    /**
     * @var \SimpleXMLElement
     */
    public $xml;

    /**
     * @var Warehouse
     */
    protected $quantity;
    protected $warehouse=[];

    /**
     * @return array|SpecificationCollection
     */
    public function getSpecifications()
    {
        if (empty($this->specifications)) {
            $this->specifications = new SpecificationCollection($this->owner, $this->ХарактеристикиТовара);
        }
        return $this->specifications;
    }

    /**
     * @return Price
     */
    public function getPrices()
    {
        if ($this->xml && empty($this->prices)) {
            $this->prices = new Price($this->owner, $this->xml->Цены);
        }
        return $this->prices;
    }


    public function getQuantity()
    {
        if ($this->xml && empty($this->quantity)) {
            $this->quantity = new Quantity($this->owner, $this->xml->Количество);
        }
        return $this->quantity;

    }

    public function getWarehouse()
    {
        if ($this->xml && empty($this->warehouse)) {
            $this->warehouse = new Warehouse($this->owner, $this->xml->Склад);
        }

        return $this->warehouse;
    }



}
