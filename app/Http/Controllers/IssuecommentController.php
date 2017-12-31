<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Validator;

use DB;

use Auth;

use App\Issue;

use App\Issuecomment;

class IssuecommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Issue $issue)
    {
            $this->validate($request, [
                    'comment_title' => 'required',
                    'comment_body' => 'required'
                ]);

            $comment = new Issuecomment;
            $comment->user_id = auth()->id();
            $comment->issue_id = $issue->id;
            $comment->comment_title = $request->Input('comment_title');
            $comment->comment_body = $request->Input('comment_body');

            $comment->save();

            return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
