<?php
namespace App\Http\Controllers;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $action = 'show';
        $isAjax = $request->ajax();
        if ($isAjax) {
            $sortBy = $request->get('sortBy', 'id'); // Default column to sort
            $sortOrder = $request->get('sortOrder', 'asc'); // Default order
            $sections = Section::query();

            $name = $request->get('name', null); // name criteria
            $id = $request->get('id', null); // name criteria
            $icon = $request->get('icon', null); // name criteria
            $description = $request->get('description', null); // name criteria

            if ($name) {
                // Assuming 'name' is the field to filter, adjust as needed
                $sections = $sections->where('name', 'LIKE', "%$name%");
            }
            if ($id) {
                // Assuming 'name' is the field to filter, adjust as needed
                $sections = $sections->where('id', 'LIKE', "%$id%");
            }
            if ($icon) {
                // Assuming 'name' is the field to filter, adjust as needed
                $sections = $sections->where('icon', 'LIKE', "%$icon%");
            }
            if ($description) {
                // Assuming 'name' is the field to filter, adjust as needed
                $sections = $sections->where('description', 'LIKE', "%$description%");
            }

            $sections = $sections->orderBy($sortBy, $sortOrder)->paginate(2);
            
             // Check if the request is AJAX
            return view('sections', compact('sections', 'action','isAjax','sortBy','sortOrder'))->render();
        }
        return view('sections', compact('action'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $action = 'create';
        return view('sections',compact('action'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'icon' => 'required|max:255',
            'description' => 'required|max:255',
        ]);

        Section::create($request->all());
        return redirect()->route('sections.index')->with('success', 'Section created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        $action = 'edit';
        return view('sections', compact('section','action'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section)
    {
        $request->validate([
            'name' => 'required|max:255',
            'icon' => 'required|max:255',
            'description' => 'required|max:255',
        ]);

        $section->update($request->all());
        return redirect()->route('sections.index')->with('success', 'Section updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function export(Section $section){
        return Excel::download(new Section, 'sections.xlsx');
    }


}
