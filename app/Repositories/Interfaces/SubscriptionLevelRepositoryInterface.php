<?php

namespace App\Repositories\Interfaces;


use App\Models\SubscriptionLevel;

interface SubscriptionLevelRepositoryInterface
{
    public function create(array $data): SubscriptionLevel;
    public function findById(int $subscriptionLevel): SubscriptionLevel;

	public function update(SubscriptionLevel $subscriptionLevel, array $data): SubscriptionLevel;

	public function delete(SubscriptionLevel $subscriptionLevel): bool;
}
