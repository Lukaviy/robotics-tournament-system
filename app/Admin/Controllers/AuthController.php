<?php declare(strict_types=1);

namespace App\Admin\Controllers;

use App\Models\AdminRole;
use App\Models\User;
use Encore\Admin\Controllers\AuthController as BaseAuthController;
use Hash;
use Illuminate\Http\Request;
use Validator;

class AuthController extends BaseAuthController
{
    protected $loginView = 'admin/login';

    public function username() : string
    {
        return 'name';
    }

    protected function loginValidator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required',
            'password' => 'required',
        ]);
    }

    public function postLogin(Request $request)
    {
        $this->loginValidator($request->all())->validate();

        $credentials = [
            $this->username() => $request->get('username'),
            'password' => $request->get('password'),
        ];

        if ($this->guard()->attempt($credentials, $request->get('remember', false))) {
            return $this->sendLoginResponse($request);
        }

        return back()->withInput()->withErrors([
            $this->username() => $this->getFailedLoginMessage(),
        ]);
    }

    public function getRegister()
    {
        return view('admin/register');
    }

    public function postRegister(Request $request)
    {
        $user = new User();
        $user->name = $request->get('username');
        $user->password = Hash::make($request->get('password'));
        $user->save();
        $user->roles()->attach(AdminRole::where('name', AdminRole::ADMIN)->first()->id);

        $this->guard()->login($user);

        return redirect('admin');
    }
}
