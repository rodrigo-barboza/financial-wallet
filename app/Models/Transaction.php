<?php

namespace App\Models;

use App\Enums\OperationTypes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'type',
        'amount',
        'user_agent',
        'ip',
    ];

    protected function casts(): array
    {
        return [
            'type' => OperationTypes::class,
        ];
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    protected function amount(): Attribute
    {
        return Attribute::make(
            get: fn (int $value) => $value / 100,
            set: fn (float $value) => $value * 100,
        );
    }

    public function revert(): void
    {
        $receiver = User::find($this->receiver_id);
        $receiver->deposit(-$this->amount);

        $sender = User::find($this->sender_id);
        $sender->deposit($this->amount);

        $this->save();
    }
}
