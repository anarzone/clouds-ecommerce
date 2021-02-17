<?php


namespace App\Services;
use App\Repositories\CustomerRepository;
use App\Repositories\RewardRepository;
use App\Repositories\SettingRepository;

class RewardService
{
    private $rewardRepository, $customerRepository, $settingRepository;

    public function __construct(RewardRepository $rewardRepository,
                                CustomerRepository $customerRepository,
                                SettingRepository $settingRepository
    )
    {
        $this->rewardRepository = $rewardRepository;
        $this->customerRepository = $customerRepository;
        $this->settingRepository = $settingRepository;
    }

    public function getByCustomerId(){
        return $this->customerRepository->getReward(auth('api')->user()->customer->id);
    }

    public function getLogs(){
        return $this->customerRepository->getRewardLogs(auth('api')->user()->customer->id);
    }

    public function save($data){
        $customer = auth('api')->user()->customer;
        $rewardTotal = $customer->reward ? intval($customer->reward->total) : 0;
        $rewardAmount = ((int)$data['total'] * $this->settingRepository->rewardRate())/100;
        $total = $rewardTotal + $rewardAmount - intval($data['reward']);

        $reward = $this->rewardRepository->save($customer->reward ? $customer->reward->id : null, [
            'total' => $total,
            'customer_id' => $customer->id
        ]);

        $this->rewardRepository->saveLogs($reward->id, [
            'name' => 'Order #'.$data['orderId'],
            'amount' => $rewardAmount,
            'reward_id' => $reward->id
        ]);
    }
}
