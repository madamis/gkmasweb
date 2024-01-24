<?php echo "<?php" ?>
//php artisan make:controller CustomController --resource --model=YourModelName --stub=custom-controller

namespace App\Http\Controllers;

use App\Models\{{ $modelName }};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class {{$controllerName}} extends Controller
{
    private function {{Str::lower($modelName)}}(Request $request, {{$modelName}} ${{Str::lower($modelName)}})
    {
        ${{Str::lower($modelName)}}->icon = $request->icon;
        ${{Str::lower($modelName)}}->title = $request->title;
        ${{Str::lower($modelName)}}->body = $request->body;

        $this->attachThumbnail($request, ${{Str::lower($modelName)}}, {{Str::lower($modelName)}}, 600,400);

        if (${{Str::lower($modelName)}}->save())
        {
            return redirect()
                ->back()
                ->with([{{Str::lower($modelName)}}.'-message'=>{{$modelName}}.', successfully saved', 'type'=>'success']);
        }
        else
        {
            return redirect()
                ->back()
                ->with([${{Str::lower($modelName)}}.'-message'=>$modelName.', was not save', 'type'=>'warning']);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validator = Validator::make($request->all(), $this->rules($request));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $about = new {{$modelName}}();

        return $this->${{Str::lower($modelName)}}($request, $about);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, {{$modelName}} ${{Str::lower($modelName))}}
    {
        if($request->has('format'))
        {
            return json_encode(['title' => $about->title]);
        }
        else
        {
            return view('abouts.show', compact('about'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(About $about)
    {
        return view('abouts.edit', compact('about'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, About $about)
    {
        $validator = Validator::make($request->all(), $this->rules($request));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        return $this->about($request, $about);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(About $about)
    {
        $title = $about->title;

        if($about->delete())
        {
            return redirect('/abouts')
                ->with(['about-message'=>'Successfully deleted '.$title,'type'=>'success']);
        }
        return redirect('/abouts')
            ->with(['about-message'=>'Failed to delete '.$title, 'type'=>'danger']);
    }
}
