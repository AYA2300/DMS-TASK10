<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Document;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments= Comment::all();
        return response()->json($comments);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeFdoc(Request $request)
    {
        $documents= Document::where('id',$request->document_id)->first();

        $documents->comments()->create([
            'comment'=>$request->comment
        ]);

        return response()->json($documents);
    }


    public function store(Request $request)
    {

        if(isset($request->doument_id)){
        $documents= Document::where('id',$request->category_id)->first();
        $documents->comments()->create([
            'comment'=>$request->comment
        ]);
        return response()->json([
            'Document_Comments'=>$documents]);
    }
        elseif(isset($request->category_id)){
        $categories= Category::where('id',$request->category_id)->first();

        $categories->comments()->create([
            'comment'=>$request->comment
        ]);

        return response()->json([
            'Category_Comments'=>$categories]);

    }
}


    /**
     * Display the specified resource.
     */
    public function show(Comment $id)
    {
        // $id->comments()->get();
        $f =$id->commentable()->get('name');
        return response()->json([

            'comment' => $id,
            'commentable' => $f
        ]);
    }

     /*
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $id)

    {

        if(isset($request->doument_id)){
            $documents= Document::where($id,$request->doument_id)->first();
            $documents->comments()->update([
                'comment'=>$request->comment
            ]);
        }


        elseif(isset($request->category_id)){
            $categories= Category::where($id,$request->category_id)->first();

            $categories->comments()->update([
                'comment'=>$request->comment
            ]);}

            return response()->json([
                'message'=>'Your comment updated Successfuly',
                'comment'=>$request->comment]);

        }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $id)
    {
        $id->delete();

        return response()->json([
            'message' => 'Comment deleted successfully'
        ]);
    }
}


