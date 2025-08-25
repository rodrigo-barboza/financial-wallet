<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type->toArray(),
            'amount' => $this->amount,
            'receiver' => new UserResource($this->receiver),
            'sender' => new UserResource($this->sender),
            'date' => Carbon::parse($this->created_at)->diffForHumans(),
        ];
    }
}
