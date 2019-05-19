<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\BaseModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel query()
 * @mixin \Eloquent
 */
class BaseModel extends Model
{

}

/**
 * App\Models\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 */
class User extends BaseModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail, Notifiable;

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];
}

/**
 * App\Models\RobotType
 *
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RobotType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RobotType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RobotType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RobotType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RobotType whereName($value)
 * @mixin \Eloquent
 */
class RobotType extends BaseModel
{

}

/**
 * App\Models\Solution
 *
 * @property int $id
 * @property int $user_id
 * @property int $problem_id
 * @property string $repository
 * @property string $commit
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\Problem $problem
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Solution newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Solution newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Solution query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Solution whereCommit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Solution whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Solution whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Solution whereProblemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Solution whereRepository($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Solution whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Solution whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\User $user
 */
class Solution extends BaseModel
{
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function problem() : BelongsTo
    {
        return $this->belongsTo(Problem::class);
    }
}

/**
 * App\Models\Problem
 *
 * @property int $id
 * @property string $name
 * @property int $tournament_id
 * @property int $robot_type_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereRobotTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereTournamentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\RobotType $robotType
 * @property-read \App\Models\Tournament $tournament
 */
class Problem extends BaseModel
{
    public function tournament() : BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    public function robotType() : BelongsTo
    {
        return $this->belongsTo(RobotType::class);
    }
}

/**
 * App\Models\Tournament
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tournament newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tournament newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tournament query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tournament whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tournament whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tournament whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tournament whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Problem[] $problems
 */
class Tournament extends BaseModel
{
    public function problems() : HasMany
    {
        return $this->hasMany(Problem::class);
    }
}
