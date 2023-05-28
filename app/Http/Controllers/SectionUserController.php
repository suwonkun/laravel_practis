<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Company;
use App\Models\User;
use App\Models\UserSection;

class SectionUserController extends Controller
{
    public function store(Request $request, Company $company, Section $section)
    {
        $section->users()->attach($request->user_id);

        return redirect()->back()->with('success', 'ユーザーが部署に登録されました。');
    }
}
