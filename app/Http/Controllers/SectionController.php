<?php
namespace App\Http\Controllers;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public $type = ['L'=>'LEFT','T'=>'TOP'];
    public function index(Request $request)
    {
        $action = 'show';
        $isAjax = $request->ajax();
        if ($isAjax) {
            $sortBy = $request->get('sortBy', 'id'); // Default column to sort
            $sortOrder = $request->get('sortOrder', 'desc'); // Default order
            $sections = Section::query();

            $name = $request->get('name', null); // name criteria
            $id = $request->get('id', null); // name criteria
            $icon = $request->get('icon', null); // name criteria
            $description = $request->get('description', null); // name criteria
            $types = $request->get('type', null); // name criteria

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
            if ($types) {
                // Assuming 'name' is the field to filter, adjust as needed
                $sections = $sections->where('type', 'LIKE', "%$types%");
            }
            if ($description) {
                // Assuming 'name' is the field to filter, adjust as needed
                $sections = $sections->where('description', 'LIKE', "%$description%");
            }

            $sections = $sections->orderBy($sortBy, $sortOrder)->paginate(5);
            $type = $this->type;
            return view('sections', compact('sections', 'action','isAjax','sortBy','sortOrder','type'))->render();
        }
        return view('sections', compact('action'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $action = 'create';
        $type = $this->type;
        return view('sections',compact('action','type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:15|unique:sections,name',
            'icon' => 'required|max:50',
            'type' => 'required|max:1',
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
        if (!$section) {
            return redirect()->route('section.index')->with('error', 'Invalid ID. Record not found.');
        }
        $action = 'edit';
        $type = $this->type;
        return view('sections', compact('section','action','type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section)
    {
        $request->validate([
            'name' => 'required|max:15|unique:sections,name,' . $section->id,  // Ignore current section during uniqueness check
            'icon' => 'required|max:50',
            'type' => 'required|max:1',
            'description' => 'required|max:255',
        ]);

        if (!$section) {
            return redirect()->route('section.index')->with('error', 'Invalid ID. Record not found.');
        }

        $section->update($request->all());
        return redirect()->route('sections.index')->with('success', 'Section updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Section $section){

        if (!$section) {
            return redirect()->route('section.index')->with('error', 'Invalid ID. Record not found.');
        }

        // Optionally, check if there are related models (if needed)
        $relatedModelsCount = \App\Models\Models::where('section_id', $section->id)->count();
        if ($relatedModelsCount > 0) {
            return redirect()->route('sections.index')->with('error', 'Cannot delete section, there are related models.');
        }

        // Delete the section
        $section->delete();

        // Redirect back to the sections index page with a success message
        return redirect()->route('sections.index')->with('success', 'Section deleted successfully.');
    }

    public function export(){
        // Fetch data from the database
        $sections = Section::select('id', 'name','icon','description', 'created_at')->get();

        // Define the CSV file name
        $fileName = 'sections_' . date('Y-m-d_H-i-s') . '.csv';

        // Add CSV headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        // Generate the CSV content
        $callback = function () use ($sections) {
            $file = fopen('php://output', 'w');

            // Add column headings
            fputcsv($file, ['ID', 'Name','Icon','Description', 'Created At']);

            // Add data rows
            foreach ($sections as $section) {
                fputcsv($file, [$section->id, $section->name,$section->icon,$section->description, $section->created_at]);
            }

            fclose($file);
        };

        // Return the response as a downloadable CSV
        return response()->stream($callback, 200, $headers);
    }


}
