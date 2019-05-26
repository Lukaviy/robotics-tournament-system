<?php declare(strict_types=1);

namespace App\Models;

use Encore\Admin\Auth\Database\HasPermissions;
use Encore\Admin\Traits\AdminBuilder;
use Exception;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Encore\Admin\Auth\Database\Menu as EncoreMenu;
use Encore\Admin\Auth\Database\Permission as EncorePermission;
use Encore\Admin\Auth\Database\Role as EncoreRole;
use Storage;

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
    public $timestamps = false;

    protected $dateFormat = 'Y-m-d H:i:sO';

    public function save(array $options = [])
    {
        if (!parent::save($options))
            throw new Exception('Unable to save model');
    }
}

/**
 * App\Models\AdminMenu
 *
 * @property int $id
 * @property int $parent_id
 * @property int $order
 * @property string $title
 * @property string $icon
 * @property string|null $uri
 * @property string|null $permission
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdminMenu[] $children
 * @property-read \App\Models\AdminMenu $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Encore\Admin\Auth\Database\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMenu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMenu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMenu query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMenu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMenu whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMenu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMenu whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMenu whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMenu wherePermission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMenu whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMenu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminMenu whereUri($value)
 * @mixin \Eloquent
 */
class AdminMenu extends EncoreMenu
{

}

/**
 * App\Models\AdminPermission
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property array $http_method
 * @property mixed $http_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Encore\Admin\Auth\Database\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminPermission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminPermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminPermission whereHttpMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminPermission whereHttpPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminPermission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminPermission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminPermission whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminPermission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AdminPermission extends EncorePermission
{

}

/**
 * App\Models\AdminRole
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $administrators
 * @property-read \Illuminate\Database\Eloquent\Collection|\Encore\Admin\Auth\Database\Menu[] $menus
 * @property-read \Illuminate\Database\Eloquent\Collection|\Encore\Admin\Auth\Database\Permission[] $permissions
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminRole whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminRole whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminRole whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AdminRole extends EncoreRole
{
    public const ADMIN = 'Admin';
    public const MODERATOR = 'Moderator';
    public const USER = 'User';
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
 * @property string|null $avatar
 * @property-read mixed $username
 * @property-read \Illuminate\Database\Eloquent\Collection|\Encore\Admin\Auth\Database\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\Encore\Admin\Auth\Database\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAvatar($value)
 */
class User extends BaseModel implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, MustVerifyEmail, Notifiable, AdminBuilder, HasPermissions;

    public $timestamps = true;

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];

    public function getUsernameAttribute() : string
    {
        return $this->name;
    }

    public function __construct(array $attributes = [])
    {
        $this->setConnection(config('admin.database.connection') ?? config('database.default'));
        $this->setTable(config('admin.database.users_table'));
        parent::__construct($attributes);
    }

    public function getAvatarAttribute($avatar)
    {
        if (url()->isValidUrl($avatar))
            return $avatar;

        if ($avatar && array_key_exists(config('admin.upload.disk'), config('filesystems.disks')))
            return Storage::disk(config('admin.upload.disk'))->url($avatar);

        return admin_asset(config('admin.default_avatar') ?: '/vendor/laravel-admin/AdminLTE/dist/img/user2-160x160.jpg');
    }

    public function roles() : BelongsToMany
    {
        return $this->belongsToMany(config('admin.database.roles_model'), config('admin.database.role_users_table'), 'user_id', 'role_id');
    }

    public function permissions() : BelongsToMany
    {
        return $this->belongsToMany(config('admin.database.permissions_model'), config('admin.database.user_permissions_table'), 'user_id', 'permission_id');
    }
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
    public function name() : string {
        return $this->name;
    }
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
 * @property string $repository
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereRepository($value)
 */
class Problem extends BaseModel
{
    public function tournaments() : BelongsToMany
    {
        return $this->belongsToMany(Tournament::class);
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
    public $timestamps = true;

    public function problems() : BelongsToMany
    {
        return $this->BelongsToMany(Problem::class);
    }
}
