<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Billing\StoreRequest;
use App\Http\Resources\Billing\BillingResource;
use App\Models\Billing;
use App\Services\BillingService;
use Illuminate\Support\Facades\Gate;

class BillingController extends Controller
{
    public function __construct(private BillingService $billingService)
    {
    }

    public function store(StoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $billing = $this->billingService->createBilling($request);
        return response()->json(['billing' => BillingResource::make($billing)]);
    }

    public function setMain(Billing $billing): \Illuminate\Http\JsonResponse
    {
        Gate::authorize('update-billing', $billing);
        $billing = $this->billingService->setMain($billing);
        return response()->json(['billing' => BillingResource::make($billing)]);
    }

    public function destroy(Billing $billing): \Illuminate\Http\Response
    {
        Gate::authorize('delete-billing', $billing);
        $this->billingService->deleteBilling($billing);
        return response()->noContent();
    }
}
