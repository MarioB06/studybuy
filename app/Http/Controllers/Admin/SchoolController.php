<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SchoolController extends Controller
{
    public function index(): View
    {
        $schools = School::withCount('products')->get();
        return view('admin.schools.index', compact('schools'));
    }

    public function create(): View
    {
        return view('admin.schools.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:2',
        ]);

        School::create($validated);

        return redirect()->route('admin.schools.index')
            ->with('success', 'Schule erfolgreich erstellt!');
    }

    public function edit(School $school): View
    {
        return view('admin.schools.edit', compact('school'));
    }

    public function update(Request $request, School $school): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:2',
        ]);

        $school->update($validated);

        return redirect()->route('admin.schools.index')
            ->with('success', 'Schule erfolgreich aktualisiert!');
    }

    public function destroy(School $school): RedirectResponse
    {
        if ($school->products()->count() > 0) {
            return redirect()->route('admin.schools.index')
                ->with('error', 'Schule kann nicht gelöscht werden, da sie noch Produkte enthält.');
        }

        $school->delete();

        return redirect()->route('admin.schools.index')
            ->with('success', 'Schule erfolgreich gelöscht!');
    }
}
