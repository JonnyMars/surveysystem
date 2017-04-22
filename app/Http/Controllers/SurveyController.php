<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Survey;
use App\User;
use Auth;
use Gate;
use DB;
use App\Question;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::all();

        $mysurveys = DB::table('survey')->where('creator_id', Auth::user()->id)->get();

        return view('/surveys/index', ['mysurveys' => $mysurveys], ['users' => $users]);




    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('surveys/create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        Survey::create($input);
        return view('surveys/index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $survey = Survey::where('id',$id)->first();

        // if article does not exist return to list
        if(!$survey)
        {
            return redirect('/surveys/index'); // you could add on here the flash messaging of article does not exist.
        }

            return view('/surveys/show')->withSurvey($survey);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $survey = Survey::where('id',$id)->first();

        if(!$survey){
            return redirect('/surveys/index');
        }
        if(Auth::id() !== $survey->creator_id){
            return view('/surveys/index');
        }
        if(Gate::allows('see_all_users')){
            return view('/surveys/edit')->with('survey', $survey);
        }
        return view('/surveys/edit')->with('survey', $survey);

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
        $survey = Survey::findOrFail($id);

        $survey->title = Input::get('title');
        $survey->description = Input::get('description');
        $survey->active = Input::get('active');
        $survey->anonymous = Input::get('anonymous');
        $survey->save();

        return redirect('/surveys');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $survey = Survey::find($id);
        $survey->delete();

        return redirect('/surveys');
    }
    public function add($id)
    {
        $survey = Survey::where('id',$id)->first();

        if(!$survey){
            return redirect('/surveys/index');
        }
        if(Auth::id() !== $survey->creator_id){
            return view('/surveys/index');
        }
        if(Gate::allows('see_all_users')){
            return view('/surveys/add')->with('survey', $survey);
        }
        return view('/surveys/add')->with('survey', $survey);
    }
}
