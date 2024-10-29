<?php

namespace App\Services;

use App\Http\Requests\Subscribe\BuyRequest;
use App\Http\Requests\Subscribe\ProlongRequest;
use App\Http\Requests\Subscribe\UpgradeRequest;
use App\Models\SubscriptionLevel;
use App\Models\User;
use App\Repositories\Interfaces\SubscriptionLevelRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class UserSubscriptionService
{
	public function __construct(private UserRepositoryInterface $userRepository, private SubscriptionLevelRepositoryInterface $subscriptionLevelRepository) {}

	public function subscribeToUser(User $author): void
	{
		if ($this->userRepository->isSubscribedByAuth($author)) {
			throw new ConflictHttpException('Подписка ужу оформлена');
		}
		$this->userRepository->subscribeToUser(auth()->user(), $author['id']);
	}

	public function buyLevelSubscriptionForUser(User $author, BuyRequest $request): void
	{
		$data = $request->validated();
		$subscription = $this->userRepository->findAuthUserSubscription($author['id']);
		if ($subscription->subscription_level_id) {
			throw new ConflictHttpException('Уровень доступа уже куплен');
		}
		// TODO: сделать оплату
		//  $subscriptionLevel = $this->subscriptionLevelRepository->findById($data['subscription_level_id']);
		//  $priceForSubscriptionLevel= $subscriptionLevel['price_per_month'] * $data['months'];
		$this->userRepository->updateSubscription($subscription, [
			'subscription_level_id' => $data['subscription_level_id'],
			'paid_subscription_start_date' => Carbon::today(),
			'paid_subscription_end_date' => Carbon::today()->addMonths($data['months'])
		]);
	}

	public function upgradeSubscriptionLevelForUser(User $author, UpgradeRequest $request): void
	{
		$data = $request->validated();
		$subscription = $this->userRepository->findAuthUserSubscription($author['id']);
		if ($subscription->subscription_level_id === $data['subscription_level_id']) {
			throw new ConflictHttpException('Уровень доступа уже куплен');
		}
		// TODO: сделать оплату
		//   $currentLevel = $this->subscriptionLevelRepository->findById($subscription->subscription_level_id);;
		//   $newLevel = $this->subscriptionLevelRepository->findById($data['subscription_level_id']);;
		//   $startDateCurrentLevel = Carbon::parse($subscription->paid_subscription_start_date);
		//   $endDateCurrentLevel = Carbon::parse($subscription->paid_subscription_end_date);
		//   $monthsPurchased = $startDateCurrentLevel->diffInMonths($endDateCurrentLevel);
		//	  30.44 — это усреднённое количество дней в месяце за год
		//   $monthsPassed = $startDateCurrentLevel->diffInDays(Carbon::today()) / 30.44;
		//   $previousPaymentBalance = $monthsPurchased * $currentLevel['price_per_month'] - $monthsPassed * $currentLevel['price_per_month'];
		//   $priceForSubscription = round($newLevel['price_per_month'] * $data['months'] - $previousPaymentBalance, 2);
		$this->userRepository->updateSubscription($subscription, [
			'subscription_level_id' => $data['subscription_level_id'],
			'paid_subscription_start_date' => Carbon::today(),
			'paid_subscription_end_date' => Carbon::today()->addMonths($data['months'])
		]);
	}

	public function prolongSubscriptionLevelForUser(User $author, ProlongRequest $request)
	{
		$data = $request->validated();
		$subscription = $this->userRepository->findAuthUserSubscription($author['id']);
		if (!$subscription->subscription_level_id) {
			throw new ConflictHttpException('Уровень доступа не куплен');
		}
		// TODO: сделать оплату
		//  $subscriptionLevel = $this->subscriptionLevelRepository->findById($subscription->subscription_level_id);
		//  $priceForSubscriptionLevel= $subscriptionLevel['price_per_month'] * $data['months'];
		$this->userRepository->updateSubscription($subscription, [
			'paid_subscription_end_date' => Carbon::parse($subscription['paid_subscription_end_date'])->addMonths((int)$data['months'])
		]);
	}

	public function unsubscribeFromUser(User $author): void
	{
		if (!$this->userRepository->isSubscribedByAuth($author)) {
			throw new ConflictHttpException('Отсутствует подписка');
		}
		$this->userRepository->unsubscribeFromUser(auth()->user(), $author['id']);
	}
}
