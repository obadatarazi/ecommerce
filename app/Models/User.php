<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Docs\Schemas\UserSchema;
use App\Http\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

#[UserSchema]
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, Filterable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['full_name', 'gender', 'email', 'password', 'phone_number', 'avatar_file_url', 'date_of_birth'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'date_of_birth' => 'datetime:Y-m-d',
    ];

    protected $filterable = [
        'full_name' => 'like',
        'email' => '=',
        'phone_number' => '=',
        'gender' => '=',
        'role' => '='
    ];

    protected $sorterable = ['id', 'full_name', 'email', 'phone_number', 'created_at', 'gender_value'];

    protected $appends = ['gender_value'];

    public function getGenderValueAttribute()
    {
        return match ($this->attributes['gender']) {
            'MALE' => __('enum.MALE'),
            'FEMALE' => __('enum.FEMALE'),
            default => $this->attributes['gender'],
        };
    }

    public function getMyRoles()
    {
        return $this->roles->load('permissions');
    }

    public function toArray(): array
    {
        $attributes = parent::toArray();
        $camelCaseAttributes = [];

        foreach ($attributes as $key => $value) {
            $camelCaseAttributes[Str::camel($key)] = $value;
        }
        return $camelCaseAttributes;
    }

    public function getCustomGenderAttribute(): array
    {
        return [
            'label' => $this->getGenderValueAttribute(),
            'value' => $this->attributes['gender'],
        ];
    }

    public function reviews():hasMany
    {
        return $this->hasMany(Review::class);
    }
    public function cart() :BelongsTo
{
    return $this->BelongsTo(Cart::class);
}

}
