<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class PermissionAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 是否登录
        if (!Auth::guard('admin')->check()) {
            return redirect(route('admin.login'));
        }

        // 当前路由名称
        $currentRouteName = Route::currentRouteName();

        $administrator = Auth::guard('admin')->user();
        $permissions = [];

        foreach ($administrator->roles as $role) {
            foreach ($role->permissions as $permission) {
                $permissions[] = $permission;
            }
        }

        $actions = $this->buildTree($permissions);

        if ($currentRouteName !== 'admin.index') {

            $flag = $this->checkPermission($currentRouteName, $actions);
            if (!$flag && $request->ajax()) {
                return response()->json(['code' => 403, 'msg' => '对不起，您暂时没有权限访问']);
            } elseif (!$flag) {
                abort('403', '对不起，您暂时没有权限访问');
            }
        }

        view()->composer('admin.layout.left', function ($view) use ($actions) {
            $view->with('actions', $actions);
        });
        return $next($request);
    }

    /**
     * 权限重组成树形结构
     * @param array $actions 权限信息
     * @param int $pid 上级权限id
     * @return \Illuminate\Support\Collection
     */
    private function buildTree($actions, $pid = 0)
    {
        $data = [];
        foreach ($actions as $v) {
            if ($v->pid == $pid) {
                $children = self::buildTree($actions, $v->id);
                if ($children) {
                    $v->children = $children;
                }
                $data[] = $v;
            }
        }

        return collect($data);
    }

    /**
     * 权限验证
     * @param string $currentRouteName 当前路由
     * @param object $actions 路由信息
     * @return bool
     */
    private function checkPermission($currentRouteName, $actions)
    {
        $flag = false;
        foreach ($actions as $action) {
            $flag = $currentRouteName === $action->route;
            if (!$flag && $action->children && !$action->children->isEmpty()) {
                $flag = $this->checkPermission($currentRouteName, $action->children);
            }
            if ($flag) {
                break;
            }
        }

        return $flag;

    }
}
