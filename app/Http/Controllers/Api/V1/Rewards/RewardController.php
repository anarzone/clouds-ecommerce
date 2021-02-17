<?php

namespace App\Http\Controllers\Api\V1\Rewards;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Reward;
use App\Http\Resources\Api\V1\RewardLog;
use App\Services\RewardService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RewardController extends Controller
{
    private $rewardService;
    public function __construct(RewardService $rewardService)
    {
        $this->middleware('auth:api');
        $this->rewardService = $rewardService;
    }

    public function getCustomerReward(){
        return response([
            "message" => "Retrieved reward",
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            "data" => $this->rewardService->getByCustomerId() ? new Reward($this->rewardService->getByCustomerId()) : []
        ]);
    }

    public function getLogs(){
        return response([
            "message" => "Retrieved rewards",
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            "data" => $this->rewardService->getLogs() ? RewardLog::collection($this->rewardService->getLogs()) : []
        ]);
    }
}
