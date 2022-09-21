<?php


namespace Zenwalker\CommerceML\Model;


use Zenwalker\CommerceML\Model\Simple;
use Zenwalker\CommerceML\ORM\Model;

/**
 * Class Quantity
 *
 * @package Zenwalker\CommerceML\Model
 * @property string quantity
 *
 */
class Quantity extends Simple
{
    protected $type;

    public function __get($name)
    {
        if ($result = parent::__get($name)) {
            if ($this->type && ($value = $this->type->{$name})) {
                return $value;
            }
        }
        return $result;
    }

    public function propertyAliases()
    {
        return [
            'Количество' => 'quantity',
            'Ид' => 'id',
       /*     'ЦенаЗаЕдиницу' => 'cost',
            'Валюта' => 'currency',
            'Единица' => 'unit',
            'Коэффициент' => 'rate',*/
        ];
    }

  /*  public function getType()
    {
        if (!$this->type && ($id = $this->id)) {
            if ($type = $this->owner->offerPackage->xpath('//c:Количество = :id]', ['id' => $id])) {
                $this->type = new Simple($this->owner, $type[0]);
            }
        }
        return $this->type;
    }*/

    public function init()
    {
        if ($this->xml && $this->xml->Количество) {
            foreach ($this->xml->Количество as $quantity) {
                $this->append(new self($this->owner, $quantity));
            }
            $this->getType();
        }
        parent::init();
    }

    public function getValueModel()
    {
        if ($this->productId && !$this->_value && ($product = $this->owner->catalog->getById($this->productId))) {
            $xpath = "c:ЗначенияСвойства[c:Ид = '{$this->id}']";
            $valueXml = $product->xpath($xpath)[0];
            $value = $this->_value = (string)$valueXml->Значение;
            if ($property = $this->owner->classifier->getReferenceBookValueById($value)) {
                $this->_value = new Simple($this->owner, $property);
            } else {
                $this->_value = new Simple($this->owner, $valueXml);
            }
        }
        return $this->_value;
    }

    public function getValue()
    {
        return $this->getValueModel() ? (string)$this->getValueModel()->value : null;
    }
}
