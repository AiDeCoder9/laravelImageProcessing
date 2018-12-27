<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class FileController extends Controller
{
    //

    public function index(){
        return view('file.image-upload');
    }

    public function store(Request $request){
        $fileValidation =$request->validate([
            'fileimg'=>'required|file|image|mimes:jpeg,png,gif,webp|max:2048'
        ]);
        if($request->hasFile('fileimg')){

            $file= $fileValidation['fileimg'];

            $fileName = $file->getClientOriginalName();

            $filelg = 'lg'.$fileName;
            $filemd = 'md'.$fileName;
            $filesm = 'sm'.$fileName;




            $pathlg = $file->storeAs('photos',$filelg);

            Image::load(storage_path('app/'.$pathlg))
                ->fit(Manipulations::FIT_CONTAIN,550,550)
                ->optimize()
                ->save(storage_path('app/manipulated/lg/'.$filelg));

            $pathmd = $file->storeAs('photos',$filemd);

            Image::load(storage_path('app/'.$pathmd))
                ->fit(Manipulations::FIT_CONTAIN,450,450)
                ->optimize()
                ->save(storage_path('app/manipulated/md/'.$filemd));

            $pathsm = $file->storeAs('photos',$filesm);

            Image::load(storage_path('app/'.$pathsm))
                ->fit(Manipulations::FIT_CONTAIN,350,350)
                ->optimize()
                ->save(storage_path('app/manipulated/sm/'.$filesm));



            $imgList []=$filelg;
            $imgList []=$filemd;
            $imgList []=$filesm;

             $imgStringList= implode(',',$imgList);




            File::create([
                    'user_id'=>'1',
                    'filename'=>$imgStringList
            ]);




              return redirect('/filesuccess');

        }
        //return $request->all();

    }

    public function show($id){

        $file = File::findOrFail($id);
        return view('file.image-success',compact('file'));

    }


}
