<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends ApplicationController
{
    protected array $fields = [
        'files'=>['thumbnail','project_file',],
        'inputs'=>['author*', 'title*', 'category',],
        'textfields'=>['body']
    ];

    private function project($project, $request)
    {
        $validator = Validator::make($request->all(), $this->generateRules($this->fields));
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $project->title = $request->title;
        $project->author = $request->author;
        $project->category = $request->category;
        $project->body = $request->body;

        if($request->has('publication_date'))
            $project->publication_date = $request->publication_date;

        if($request->has('is_published'))
            $project->is_published = $request->is_published;

        $this->attachThumbnail($request, $project, 'project');
        $this->attachThumbnail($request, $project, 'project', 'project_file');

        return $this->saveItem($project, 'project');

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();
        $fields = $this->fields;
        return view("projects.index", compact("projects", "fields"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $project = new Project();
        return $this->project($project, $request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return json_encode(['title' => $project->title]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $title = $project->title;

        if($project->delete())
        {
            return redirect('/projects')
                ->with(['project-message'=>'Successfully deleted '.$title,'type'=>'success']);
        }
        return redirect('/project')
            ->with(['project-message'=>'Failed to delete '.$title, 'type'=>'danger']);
    }
}
