<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected array $common_text_rules = [
        'title'=>'required',
        'body'=>'required',
    ];

    protected array $file_rules = [
        'thumbnail'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ];

    protected function rules($request,$specials = [])
    {
        $rules = $this->common_text_rules;
        if ($request->has('thumbnail'))
        {
            //$rules += $rules;
            $rules + $this->file_rules;
        }
        $rules += $specials;

        return $rules;
    }

    protected function saveItem($item, $messagePrefix)
    {
        if ($item->save())
        {
            return redirect()
                ->back()
                ->with(["$messagePrefix-message"=>ucfirst($messagePrefix).', successfully saved', 'type'=>'success']);
        }
        else
        {
            return redirect()
                ->back()
                ->with(["$messagePrefix-message"=>ucfirst($messagePrefix).', was not save', 'type'=>'warning']);
        }
    }

    protected function attachThumbnail($request, $model, $folder, $length=370, $width=214, $attachment='thumbnail')
    {
        if($request->has("$attachment"))
        {
            $this->detachThumbnail($model, $attachment);
            $image = $request->file("$attachment");
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $path = "/assets/images/$folder/$image_name";

            # $image->move(public_path($path), $image_name);
            $this->resizeThumbnail($image->getRealPath(),$path, $length, $width);
            $model->thumbnail = $path;
        }
    }

    protected function detachThumbnail($model , $attachment = 'thumbnail')
    {
        $old_path = $model->$attachment;
        if(File::exists($old_path)){
            unlink($old_path);
        }
    }

    private function resizeThumbnail($sourcePath, $targetPath, $length, $width)
    {
        $img = Image::make($sourcePath);

        if (!Storage::exists($targetPath)) {
            Storage::makeDirectory($targetPath, 0775, true, true);
        }
        $img->fit($length, $width, function ($constraint)  {
            $constraint->upsize();
        });
        $img->save(public_path($targetPath));
    }
}
