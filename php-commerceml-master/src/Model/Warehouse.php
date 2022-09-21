<?php


namespace Zenwalker\CommerceML\Model;


use Zenwalker\CommerceML\Model\Simple;

/**
 * Class Warehouse
 *
 * @package Zenwalker\CommerceML\Model
 * @property string warehouse
 *
 */
class Warehouse extends Simple
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
            'Склад' => 'warehouse',
            'ИдСклада' => 'id',
            'КоличествоНаСкладе' => 'quantity',

        ];
    }

    public function getType()
    {
        if (!$this->type && ($id = $this->id)) {
            if ($type = $this->owner->offerPackage->xpath('//c:ИдСклада[c:Ид = :id]/[c:КоличествоНаСкладе = :quantity]', ['id' => $id, 'quantity'=>$quantity])) {
                $this->type = new Simple($this->owner, $type[0]);
            }
        }
        return $this->type;
    }

    public function init()
    {
        if ($this->xml && $this->xml->Склад) {
            foreach ($this->xml->Склад as $warehouse) {
                $this->append(new self($this->owner, $warehouse));
            }
            $this->getType();
        }
        parent::init();
    }
}
