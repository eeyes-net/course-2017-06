<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Library\Eeyes\Api\Permission;
use App\Library\Eeyes\Api\XjtuUserInfo;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Auth\Database\Role;
use Illuminate\Support\Facades\Auth;
use phpCAS;

class AuthController extends Controller
{
    public function __construct()
    {
        phpCAS::client(CAS_VERSION_2_0, config('cas.host'), config('cas.port'), config('cas.context'));
        if (config('app.debug')) {
            phpCAS::setNoCasServerValidation();
        }
    }

    public function login()
    {
        phpCAS::forceAuthentication();
        $username = phpCAS::getUser();
        $permission = Permission::username($username, 'website.course.admin');
        if ($permission['can']) {
            /** @var Administrator $user */
            $user = Administrator::firstOrNew(['username' => $username]);
            if (!$user->exists) {
                $user->password = '*';
                $userinfo = XjtuUserInfo::getByNetId($username);
                $user->name = $userinfo ? $userinfo['username'] : ucfirst($username);
                $user->save();
            }

            $administrator_permission = Permission::username($username, 'website.course.administrator');
            $administrator_role = Role::where('slug', 'administrator')->get();
            if ($administrator_permission['can']) {
                $user->roles()->syncWithoutDetaching($administrator_role);
            } else {
                $user->roles()->detach($administrator_role);
            }

            Auth::guard('admin')->login($user);
            admin_toastr(trans('admin::lang.login_successful'));
            return redirect()->intended(config('admin.prefix'));
        }
        return response($permission['msg'], 403);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        session_unset();
        session_destroy();
        return redirect(phpCAS::getServerLogoutURL() . '?' . http_build_query([
                'service' => url(config('admin.prefix')),
            ]));
    }
}
