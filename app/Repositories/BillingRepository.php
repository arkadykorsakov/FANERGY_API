<?php

namespace App\Repositories;

use App\Models\Billing;
use App\Repositories\Interfaces\BillingRepositoryInterface;

class BillingRepository implements BillingRepositoryInterface
{
    public function create(array $data): Billing
    {
        return Billing::create($data)->fresh();
    }

    public function setMain(Billing $billing): Billing
    {
        auth()->user()->billings()->update(['is_main' => false]);
        $billing->update(['is_main' => true]);
        $billing->refresh();
        return $billing;
    }

    public function delete(Billing $billing): bool
    {
        return $billing->delete();
    }
}
