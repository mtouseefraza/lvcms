<?php
namespace App\Http\Controllers;
use App\Models\Models;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


class ModelsController extends BaseController
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
            $sortOrder = $request->get('sortOrder', 'desc'); // Default order
            
            $models = Models::query();

            $name = $request->get('name', null); // name criteria
            $id = $request->get('id', null); // name criteria
            $description = $request->get('description', null); // name criteria
            $sectionId = $request->get('section_id', null); // section_id criteria

            if ($name) {
                // Assuming 'name' is the field to filter, adjust as needed
                $models = $models->where('models.name', 'LIKE', "%$name%");
            }
            if ($id) {
                // Assuming 'name' is the field to filter, adjust as needed
                $models = $models->where('models.id', 'LIKE', "%$id%");
            }
            if ($description) {
                // Assuming 'name' is the field to filter, adjust as needed
                $models = $models->where('models.description', 'LIKE', "%$description%");
            }
            if ($sectionId) {
                $models = $models->where('models.section_id', $sectionId);
            }

            $models = $models->join('sections', 'models.section_id', '=', 'sections.id')->select('models.*', 'sections.name as section_name')->orderBy($sortBy, $sortOrder)->paginate(5);
        
            return view('models', compact('models', 'action','isAjax','sortBy','sortOrder'))->render();
        }
        return view('models', compact('action'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $action = 'create';
        $sections = \App\Models\Section::all(['id', 'name']);
        return view('models',compact('action','sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:15|unique:models,name',
            'url' => [
                'required',
                'max:50',
                function ($attribute, $value, $fail) {
                    if (!Route::has($value)) {
                        $fail('The :attribute must correspond to a valid route.');
                    }
                },
            ],
            'section_id' => 'required',
            'permission' => 'required',
            'description' => 'required|max:255',
        ]);

        Models::create($request->all());
        return redirect()->route('models.index')->with('success', 'Model created successfully.');
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
    public function edit($id)
    {
        $action = 'edit';
        $models = Models::find($id);
        if (!$models) {
            // Redirect back with an error message
            return redirect()->route('models.index')->with('error', 'Invalid ID. Record not found.');
        }
        $sections = \App\Models\Section::all(['id', 'name']);
        return view('models', compact('models','action','sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        
        $request->validate([
            'name' => 'required|max:15|unique:models,name,' . $id, 
            'url' => [
                'required',
                'max:50',
                function ($attribute, $value, $fail) {
                    if (!Route::has($value)) {
                        $fail('The :attribute must correspond to a valid route.');
                    }
                },
            ],
            'section_id' => 'required',
            'permission' => 'required',
            'description' => 'required|max:255',
        ]);

        $model = Models::find($id);

        // Check if the record exists
        if (!$model) {
            return redirect()->route('models.index')->with('error', 'Invalid ID. Record not found.');
        }

        $model->update($request->all());
        return redirect()->route('models.index')->with('success', 'Model updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       $models = Models::findOrFail($id);
       $models->delete();
        // Redirect back to the sections index page with a success message
        return redirect()->route('models.index')->with('success', 'Model deleted successfully.');
    }

    public function export(){
        // Fetch data from the database
        $models = Models::query()->join('sections', 'models.section_id', '=', 'sections.id')->select('models.*', 'sections.name as section_name')->get();

        // Define the CSV file name
        $fileName = 'models_' . date('Y-m-d_H-i-s') . '.csv';

        // Add CSV headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        // Generate the CSV content
        $callback = function () use ($models) {
            $file = fopen('php://output', 'w');

            // Add column headings
            fputcsv($file, ['ID', 'Name','Section Name','Url','Description','Permission', 'Created At']);

            // Add data rows
            foreach ($models as $model) {
                fputcsv($file, [$model->id, $model->name,$model->section_name,$model->url,$model->description,implode(' | ', $model->permission), $model->created_at]);
            }

            fclose($file);
        };

        // Return the response as a downloadable CSV
        return response()->stream($callback, 200, $headers);
    }
}
