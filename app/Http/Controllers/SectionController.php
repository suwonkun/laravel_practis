<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use App\Models\Company;
use App\Models\Section;
use App\Rules\UniqueSectionName;
use App\Rules\UpdateUniqueSectionName;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Company $company)
    {
        $this->authorize('create', [Section::class, $company]);
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
        $this->authorize('store', [Section::class, $company]);

        $request->validate([
            'name' => ['max:255','required','string',new UniqueSectionName("$company->id")]
        ]);

        $section = new Section();

        $company->sections()->create([
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
        $this->authorize('show', [Section::class, $company]);

        $company->load([
            'users' => function($query) use ($section) {
                $query->whereDoesntHave('sections', function ($query) use ($section) {
                    $query->where('section_id', $section->id);
                });
            }
        ]);

        return view('sections.show', compact('section',  'company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Section $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company, Section $section)
    {
        $this->authorize('edit', [Section::class, $company]);
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
        $this->authorize('update', [Section::class, $company]);

        $request->validate([
            'name' => ['max:255','required','string',new UpdateUniqueSectionName("$company->id", $section)]
        ]);
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
        $this->authorize('delete', [Section::class, $company]);

        $section->delete();

        return redirect()->route('companies.show', ['company' => $company]);
    }
}
