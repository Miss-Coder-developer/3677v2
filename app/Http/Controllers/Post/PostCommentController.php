<?php

namespace App\Http\Controllers\Api\Post;
//namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
//use App\Http\Requests\Post\StorePostComment;
//use App\Http\Requests\Post\UpdatePostComment;
use App\Models\PostComment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return PostComment[]|Collection
     */
    public function index()
    {
        return PostComment::orderBy('created_at','desc')
               ->paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     * @param StorePostComment $request
     * @return JsonResponse
     */
    public function store(StorePostComment $request)
    {
        try {
            // Create Post comment
            $request['user_id'] = auth()->user()->id;
            PostComment::create($request->toArray());

            // Success response
            $response = [
                'success' => true,
                'message' => 'Comment created successfully :)'
            ];
        } catch (\Exception $exception) {
            // Exception response
            $response['success'] = false;
            $response['message'] = $exception->getMessage();
        }

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePostComment $request
     * @param $id
     * @return JsonResponse
     */
    public function update(UpdatePostComment $request, $id)
    {

        try {
            // Find comment by id
            $postComment = PostComment::findorFail($id);
            $postComment->update($request->validated());

            // Success response
            $response = [
                'success' => true,
                'message' => 'Comment updated successfully :)'
            ];
        } catch (\Exception $exception) {
            // Exception response
            $response['success'] = false;
            $response['message'] = $exception->getMessage();
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {

    }
}
