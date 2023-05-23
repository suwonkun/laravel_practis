<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use App\Models\Company;
use App\Models\Section;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $company = Company::find($id);
        return view('sections.create', compact('company'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreSectionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSectionRequest $request, Company $company): RedirectResponse
    {
        $section = new Section();

        $section->create([
            'company_id' => $company->id,
            'name' => $request->name
        ]);

        return new RedirectResponse(route('companies.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Section $section
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company, Section $section)
    {
        $unjoin_users = User::where('company_id', $company->id)
            ->whereDoesntHave('sections', function ($query) use ($section) {
                $query->where('section_id', $section->id);
            })
            ->get();

        $join_users = User::where('company_id', $company->id)
            ->whereHas('sections', function ($query) use ($section) {
                $query->where('section_id', $section->id);
            })
            ->get();

        return view('sections.show', compact('section', 'unjoin_users', 'company', 'join_users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Section $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company, Section $section)
    {
        return view('sections.edit', compact('section'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateSectionRequest $request
     * @param \App\Models\Section $section
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSectionRequest $request, Company $company, Section $section)
    {
        $section->name = $request->input('name');
        $section->save();


        return redirect()->route('companies.show', ['company' => $company]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Section $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company, Section $section)
    {
        $section->delete();

        return redirect()->route('companies.show', ['company' => $company]);
    }
}
