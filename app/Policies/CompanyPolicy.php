<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function show(User $user, Company $company): bool
    {
        return $user->company->id === $company->id;
    }

    public function edit(User $user, Company $company): bool
    {
        return $user->company->id === $company->id;
    }

    public function update(User $user, Company $company)
    {
        return $user->company->id === $company->id;
    }

    public function delete(User $user, Company $company)
    {
        return $user->company->id === $company->id;
    }
}
