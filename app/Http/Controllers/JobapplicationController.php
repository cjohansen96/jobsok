<?php

namespace App\Http\Controllers;

use App\Models\Jobbapplication;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Resources\Jobapplication as JobapplicationResource;
use App\Models\Jobapplication;


class JobapplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get jobapplications
        $jobapplications = Jobapplication::paginate(15);

        // Return collection of jobapplications as resource
        return JobapplicationResource::collection($jobapplications);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jobapplication  $jobapplication
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jobapplication = Jobapplication::findOrFail($id);

        return new JobapplicationResource($jobapplication);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jobapplication = $request->isMethod('put') ? Jobapplication::findOrFail
        ($request->id) : new Jobapplication;

        $jobapplication->id = $request->input('id');
        $jobapplication->company = $request->input('company');
        $jobapplication->jobtitle = $request->input('jobtitle');
        $jobapplication->status =   $request->input('status');
        $jobapplication->date_sent = $request->input('date_sent');
        $jobapplication->date_jobexpired = $request->input('date_jobexpired');
        $jobapplication->place = $request->input('place');
        $jobapplication->phone = $request->input('phone');
        $jobapplication->applicationlink = $request->input('applicationlink');

        if($jobapplication->save()){
            return new JobapplicationResource($jobapplication);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jobapplication  $jobapplication
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jobapplication = Jobapplication::findOrFail($id);

        if($jobapplication->delete()) {
            return new JobapplicationResource($jobapplication);
        }
    }
}