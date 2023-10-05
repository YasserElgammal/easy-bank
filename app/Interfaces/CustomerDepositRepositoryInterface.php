<?php

namespace App\Interfaces;


interface CustomerDepositRepositoryInterface extends BaseRepositoryInterface
{
    public function payWithPaypal($id);
}
