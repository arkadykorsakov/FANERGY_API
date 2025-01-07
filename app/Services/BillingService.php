<?php

namespace App\Services;

use App\Http\Requests\Billing\StoreRequest;
use App\Models\Billing;
use App\Repositories\Interfaces\BillingRepositoryInterface;

class BillingService
{
    public function __construct(private BillingRepositoryInterface $billingRepository)
    {
    }

    public function createBilling(StoreRequest $request): \App\Models\Billing
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
       return $this->billingRepository->create($data);
    }

    public function setMain(Billing $billing): \App\Models\Billing
    {
        return $this->billingRepository->setMain($billing);
    }

    public function deleteBilling(Billing $billing): bool
    {
        return $this->billingRepository->delete($billing);
    }
}
