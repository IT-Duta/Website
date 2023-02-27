<?php

namespace App\Providers;

use App\Models\SoftReq;
use App\Models\User;
use App\Models\UserDet;
use App\Policies\SoftReqPolicy;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        // 'App\Models\HardReq' => 'App\Policies\HardReqPolicy',
        // 'App\Models\User' => 'App\Policies\TaskPolicy',
        // User::class => TaskPolicy::class,
        // SoftReq::class => SoftReqPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Schema::defaultStringLength(191);
        //
        Gate::define('isAdmin', function (User $user) {
            return $user->isAdmin;
        });
        Gate::define('isProduksi', function (User $user) {
            return $user->isRole;
        });
        Gate::define('isPROCUREMENT', function (User $user) {
                $isRole = DB::table('users as u')
                ->join('user_detail as ud', 'u.email','=','ud.email' )
                ->select('ud.user_divisi')
                ->where('u.id','=',$user->id)
                ->whereIn('ud.user_divisi', ['PROCUREMENT', 'IT'])
                ->first();
            return $isRole ? true : false;
        });

        Gate::define('isIT', function (User $user) {
                $isRole = DB::table('users as u')
                ->join('user_detail as ud', 'u.email','=','ud.email' )
                ->select('ud.user_divisi')
                ->where('u.id','=',$user->id)
                ->where('ud.user_divisi','IT')
                ->first();
            return $isRole ? true : false;
        });
        Gate::define('isGA', function (User $user) {
                $isRole = DB::table('users as u')
                ->join('user_detail as ud', 'u.email','=','ud.email' )
                ->select('ud.user_divisi')
                ->where('u.id','=',$user->id)
                ->whereIn('ud.user_divisi', ['GENERAL AFFAIR', 'IT'])
                ->first();
            return $isRole ? true : false;
        });

        // $isRole = DB::table('users as u')
        // ->join('user_detail as ud', 'u.email','=','ud.email' )
        // ->select('u.*','ud.user_nik','ud.user_divisi','ud.user_gender','ud.user_birthday')
        // ->where('u.id','=',$user->id)
        // ->first();
        // Gate::define('isProduksi', function (User $user, UserDet $usDet) {
        //     return $user->isRole && $usDet->user_divisi=='EDP';
        // });
        // Gate::define('isProduksi', function ( UserDet $usDet) {
        //     return $usDet->user_divisi == 'EDP';
        // });

        // Share Data to all view
        $hard_req_progress=DB::table('hard_req')->where('hard_req_status','Progress')->count();
        $hard_fix_progress=DB::table('hard_fix_general')->where('hard_fix_status','Progress')->count();
        $soft_req_progress=DB::table('soft_req')->where('soft_req_status','Progress')->count();
        $ink_report=DB::table('inventaris_ink_report')->count();

        View::share('hard_req_progress',$hard_req_progress);
        View::share('hard_fix_progress',$hard_fix_progress);
        View::share('soft_req_progress',$soft_req_progress);
        View::share('ink_report',$ink_report);


    }
}
