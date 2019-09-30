<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Course;
use App\Team;
use App\Uploaders\ImageUploader;
use App\Uploaders\CourseImageUploader;
use Gate;

class TeamController extends Controller 
{
    /**
     * Show all courses
     */
    public function index()
    {
        $teams = Team::all();        
        $teams = $teams->each(function ($team) {
            if ($team->logo_uri) {
                $team->logo_uri = generateThumbnailImagePath($team->logo_uri);
            }
        });
        return view('teams.index', [
            'teams' => $teams
        ]);
    }

    /**
     * Show view for creating new course
     */
    public function create()
    {        
        return view('teams.create');
    }

    /**
     * Show course details and lessons
     * @param  Course $course
     */
    public function show(Course $course)
    {
        if (Gate::denies('show', $course)) {
            return parent::unauthorizedResponse(redirect()->action('CoursesController@index'));
        }

        $course->load('lessons');

        return view('courses.show', [
            'course' => $course,
            'users' => \App\User::all()
        ]);
    }

    /**
     * Create a new course
     * @param  Request $request
     */
    public function store(Request $request)
    {
        if ($request->has('save')) {
            return $this->createNewTeam($request);
        } 
        elseif ($request->has('cancel')) {
            return $this->cancelCreateNewTeam($request);
        }
    }
    

    private function createNewTeam(Request $request)
    {
        $this->validate($request, [
            'team' => 'required',
            'state' => 'required'
        ]);

        $course = new Team;
        $course->name = $request->team;
        $course->state = $request->state;
        
        $course->save(); // save course here so that we can get an id

        if ($request->has('image')) {
            $filename = 'course_' . $course->team_id;
            $tmpImgFilePath = public_path(config('constants.upload_dir.tmp')) . getSubstrAfterLastSlash($request->image);

            if (\File::exists($tmpImgFilePath)) {
                $courseImgUploader = new CourseImageUploader($tmpImgFilePath);

                $uploadedFile = $courseImgUploader->upload(
                    $filename,
                    public_path(config('constants.upload_dir.courses'))
                );

                $course->setImage(url(config('constants.upload_dir.courses'). $uploadedFile));
                \File::delete($tmpImgFilePath);
            }
        }

        flash('Team added', 'success');

        return redirect()->route('teams.index');
    }

    private function cancelCreateNewTeam(Request $request)
    {
        // delete any temporary uploaded course image file
        if ($request->has('image')) {
            \File::delete(public_path(config('constants.upload_dir.tmp')) . basename($request->image));
        }

        return redirect()->route('teams.index');
    }

}
