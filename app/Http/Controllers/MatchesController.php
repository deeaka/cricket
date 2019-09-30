<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Gate;
use App\Http\Requests;
use App\User;
use App\Player;
use App\Role;
use App\Team;
use App\Match;
use App\Uploaders\ImageUploader;
use App\Uploaders\AvatarUploader;

class MatchesController extends Controller
{
    /**
     * Display a listing of Players.
     *
     * @return \Illuminate\Http\Respons e
     */
    public function index()
    {
        if($this->previousUrlIsFlashMsg()) {
            $redirectAction = redirect()->route('home');
          } else {
            $redirectAction = redirect()->back();
          }
          
        $matchs = Match::all();
        return response()->view('teams.match', [
            'matchs' => $matchs
        ])->header('cache-control', 'no-store,no-cache,must-revalidate')
          ->header('pragma', 'no-cache')
          ->header('expires', '0');
    }
    

    /**
     * Show the form for creating a new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $teams = Team::all();  
        return view('teams.creatematch',['teams'=>$teams]);
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('create', User::class)) {
            return parent::unauthorizedResponse(redirect()->back(), $request);
        }

        return $this->createNewMatch($request);
    }

   

    private function createNewMatch(Request $request)
    {
        $this->validate($request, [
            'first_team_num' => 'required',
            'second_team_num' => 'required|different:first_team_num',
            'winnerTeam' => 'required'
        ]);

        $match = new Match();
        $match->first_team_id = $request->first_team_num;
        $match->second_team_id = $request->second_team_num;
        if($request->winnerTeam == 'f') {
        $match->winner_team_id = $request->first_team_num;
        } else {
        $match->winner_team_id = $request->second_team_num;    
        }
        $match->save();
        
        flash('Match created', 'success');

        return redirect()->route('match.index');
    }

   
    /**
     * Workaround to check if the previous url is the ajax url used for flashing status messages
     * If it is, maybe not redirect user back to it if user does not have the right permissions?
     * @return boolean
     */
    private function previousUrlIsFlashMsg()
    {
      $flashPath = 'flash';
      $previousUrl = url()->previous();

      // get the path based on last slash position
      $path = getSubstrAfterLastSlash($previousUrl);

      return substr($path, 0, strlen($flashPath)) == $flashPath;
    }
}
