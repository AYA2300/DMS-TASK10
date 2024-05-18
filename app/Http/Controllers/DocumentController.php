<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Visibility;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'category_id'=>'required',
            'path'=>'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg'
        ]);

                    $file = $request->file('path');
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();

                    if (preg_match('/\.[^.]+\./', $originalName)) {
                        throw new Exception(trans('general.notAllowedAction'), 403);
                    }
                    $storagePath = Storage::disk('public')->put('files', $file, [
                        'visibility' => Visibility::PUBLIC
                    ]);


        $document= Document::create([
            'name'=>$request->name,
            'path'=>$storagePath,
            'category_id'=>$request->category_id,
            'image'=>$request->file('image')->store('images'),
            'extension'=>$extension,
        ]);
        return response()->json([
            'message'=>'Document Created Successfully',
            'document'=>$document
        ]);


    }


    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        $category=$document->categories()->get();
        $comments=$document->comments()->get();
        return response()->json([

            'document'=>$document,
            'category'=>$category,
            'comments'=>$comments

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        $documentData=[];
        if(isset($request->name)){
            $documentData['name']=$request->name;
        }
        if(isset($request->category_id)){
            $documentData['category_id']=$request->category_id;
        }
        if(isset($request->path)){
            $documentData['path']=$request->path;
        }
        if(isset($request->image)){
            $documentData['image']=$request->file('image')->store('images');
        }
        if(isset($request->path)){
            $file = $request->file('path');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            if (preg_match('/\.[^.]+\./', $originalName)) {
                throw new Exception(trans('general.notAllowedAction'), 403);
            }
            $storagePath = Storage::disk('public')->put('files', $file, [
                'visibility' => Visibility::PUBLIC
            ]);
            $documentData['path']=$storagePath;
            $documentData['extension']=$extension;

        }
        $document->update($documentData);
        return response()->json([
            'message'=>'Document Updated Successfully',
            'document'=>$documentData
        ]);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        $document->delete();
        return response()->json([
            'message'=>'Document Deleted Successfully',
            'document'=>$document
        ]);

    }
}
