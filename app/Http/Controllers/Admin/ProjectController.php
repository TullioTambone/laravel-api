<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Project;
use App\Models\Admin\Type;
use App\Models\Admin\Technology;
use Illuminate\Support\Facades\Storage;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project = Project::all();

        return view('admin.projects.index', compact('project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $technologies = Technology::all();

        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate(
            [
                "title" => "required",
                'description' => "required",
                'img' => 'nullable|image',
                'type_id' => "nullable|exists:types,id",
                'technologies' => "exists:technologies,id",
            ],
            [
                "title.required" => 'il nome é obbligatorio',
                "description.required" => 'la descrizione é obbligatoria',
            ]
        );
        
        
        $form_data = $request->all();
        
        if ($request->hasFile('img')) {
            $path = Storage::disk('public')->put('project_images', $request->img);
    
            $form_data['img'] = $path;
        }

        $slug = Project::generateSlug($request->title);
        $form_data['slug'] = $slug;
        
        $new_project = new Project();
        $new_project->fill( $form_data );
        $new_project->save();

        if ($request->has('technologies')){
            $new_project->technologies()->attach($request->technologies);
        }
        
        return redirect()->route('admin.projects.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //$projectID = Project::findOrFail($id);
        
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();

        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {

        $request->validate(
            [
                "title" => "required",
                'description' => "required",
                'img' => 'nullable|image',
                'type_id' => "nullable|exists:types,id",
                'technologies' => "exists:technologies,id"
            ],
            [
                "title.required" => 'il nome é obbligatorio',
                "description.required" => 'la descrizione é obbligatoria',
            ]
        );

        $form_data = $request->all();
        
        if ($request->hasFile('img')) {
            if( $project->img ){
                Storage::delete($project->img);
            }

            $path = Storage::disk('public')->put('project_images', $request->img);
            
            $form_data['img'] = $path;
        }

        $slug = Project::generateSlug($request->name);
        $form_data['slug'] = $slug;
        
        $project->update($form_data);
        
        if ($request->has('technologies')){
            $project->technologies()->sync($request->technologies);

        } else{
            $project->technologies()->sync([]);                
        }
        
        return redirect()->route('admin.projects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        $project->technologies()->sync([]);
        return redirect()->route('admin.projects.index');
    }
}