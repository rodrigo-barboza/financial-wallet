<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'balance',
        'account',
        'agency',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Str::title($value),
        );
    }

    protected function balance(): Attribute
    {
        return Attribute::make(
            get: fn (int $value) => $value / 100,
            set: fn (float $value) => $value * 100,
        );
    }

    protected function account(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => substr($value, 0, 7) . '-' . substr($value, -1, 1),
        );
    }

    public function deposit(float $amount): void
    {
        $this->balance += $amount;
        $this->save();
    }

    public function haveEnoughBalance(float $amount): bool
    {
        return $this->balance >= $amount;
    }

    public function canTransferTo(User $receiver): bool
    {
        return $this->id !== $receiver->id;
    }
}
