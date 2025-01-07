<?php

namespace App\Repositories\Interfaces;


use App\Models\Billing;

interface BillingRepositoryInterface
{
    public function create(array $data): Billing;
    public function setMain(Billing $billing): Billing;
    public function delete(Billing $billing): bool;
}
