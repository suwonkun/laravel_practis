<?php

namespace App\Policies;

use App\Models\Section;
use App\Models\User;
use App\Models\Company;
use Illuminate\Auth\Access\HandlesAuthorization;

class SectionPolicy
{
    use HandlesAuthorization;

    public function create(User $user, Company $company): bool
    {
        return $user->company_id === $company->id;
    }

    public function store(User $user, Company $company)
    {
        return $user->company_id === $company->id;
    }

    public function show(User $user, Company $company)
    {
        return $user->company_id === $company->id;
    }

    public function edit(User $user, Company $company)
    {
        return $user->company_id === $company->id;
    }

    public function update(User $user, Company $company)
    {
        return $user->company_id === $company->id;
    }

    public function delete(User $user, Company $company)
    {
        return $user->company_id === $company->id;
    }
}
