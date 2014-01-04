<?php
namespace App\Model\Payment;

interface IMethod
{
    public function getCode();

    public function isAvaliable();

    public function getLabel();
}