<?php

namespace App\Policies;

use App\Models\AitPinjam;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AitPinjamPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AitPinjam  $aitPinjam
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function aitPinjamView(User $user, AitPinjam $aitPinjam)
    {
        return $user->isAdmin || $aitPinjam->user_id == Auth::user()->id;
    }
    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AitPinjam  $aitPinjam
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, AitPinjam $aitPinjam)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AitPinjam  $aitPinjam
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, AitPinjam $aitPinjam)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AitPinjam  $aitPinjam
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, AitPinjam $aitPinjam)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AitPinjam  $aitPinjam
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, AitPinjam $aitPinjam)
    {
        //
    }
}
