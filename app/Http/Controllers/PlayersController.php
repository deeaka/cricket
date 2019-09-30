<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Gate;
use App\Http\Requests;
use App\User;
use App\Player;
use App\Role;
use App\Team;
use App\Uploaders\ImageUploader;
use App\Uploaders\AvatarUploader;

class PlayersController extends Controller implements ControllerImageUploaderInterface
{
    /**
     * Display a listing of Players.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if($this->previousUrlIsFlashMsg()) {
            $redirectAction = redirect()->route('home');
          } else {
            $redirectAction = redirect()->back();
          }
          
        $players = Player::all();
        
        return response()->view('players.index', [
            'players' => $players
        ])->header('cache-control', 'no-store,no-cache,must-revalidate')
          ->header('pragma', 'no-cache')
          ->header('expires', '0');
    }
    
    /**
     * Display a perticuler player
     *
     * @return \Illuminate\Http\Response
     */
    public function player()
    {
        if($this->previousUrlIsFlashMsg()) {
            $redirectAction = redirect()->route('home');
          } else {
            $redirectAction = redirect()->back();
          }
          //echo request()->team_id;exit;
          
        $players = Player::where('team_id', request()->team_id)->get();
        return response()->view('players.index', [
            'players' => $players,
            'teamId' =>request()->team_id
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
        return view('players.create',['teams'=>$teams]);
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

        if ($request->has('save')) {
            return $this->createNewPlayer($request);
        } elseif ($request->has('cancel')) {
            return $this->cancelCreateNewUser($request);
        }
    }

    /**
     * Display the specified User.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Player $player)
    {
        return view('players.show', [
            'player' => $player
        ]);
    }

    /**
     * Update the specified User in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'jsy_number'  => 'required'
        ]);
        $user = Player::find($request->id);
        $user->first_name = $request->name;
        $user->country = $request->country;
        $user->run = $request->run;
        $user->save();

        if ($request->ajax()) {
            return response()->json(['response' => 'User Updated']);
        }

        return back();
    }

    /**
     * Remove the specified User from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (Gate::denies('delete', $user)) {
            return parent::unauthorizedResponse(redirect()->back());
        }

        if ($user->avatar) {
          $user->deleteAvatar();
        }
        $user->delete();

        flash('User deleted', 'success');

        return redirect()->route('users.index');
    }

    private function createNewPlayer(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'jrcy_num' => 'required',
            'team_num' => 'required'
        ]);

        $user = new Player();
        $user->team_id = $request->team_num;
        $user->jsy_number = $request->jrcy_num;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->country = $request->c_name;
        $user->matches = $request->matches;
        $user->run = $request->run;
        $user->highest_scores = $request->highest_scores;
        $user->hundreds = $request->hundreds;
        
        

        //  If avatar is specified, check if the avatar is uploaded successfully. If so,
        //  move the avatar from the uploads/tmp dir to the uploads/users dir
        if ($request->has('avatar')) {
            $avatarTmpFile = $this->transferTmpAvatar($request->avatar);
            if ($avatarTmpFile) {
                $user->save(); //save user so that we can get an id

                $filename = 'user_' . $user->id;
                $avatarTmpFilePath = public_path(config('constants.upload_dir.tmp')) . $avatarTmpFile;
                $avatarUploader = new AvatarUploader($avatarTmpFilePath);

                $uploadedFile = $avatarUploader->upload(
                    $filename,
                    public_path(config('constants.upload_dir.users')),
                    AvatarUploader::IMAGE_SIZE,
                    AvatarUploader::IMAGE_SIZE,
                    false,
                    true
                );

                $user->setAvatar(url(config('constants.upload_dir.users'). $uploadedFile));
                \File::delete($avatarTmpFilePath);
            }
        } else {
            $user->save();
        }

        
        flash('User created', 'success');

        return redirect()->route('players.index');
    }

    private function cancelCreateNewUser(Request $request)
    {
        // delete any temporary uploaded user avatar image file
        if ($request->has('avatar')) {
            \File::delete(public_path(config('constants.upload_dir.tmp')) . basename($request->avatar));
        }

        return redirect()->route('players.index');
    }

    

    /**
     * Handles uploading of avatar image file.
     * If $user_id is 0, means that the user model is a temporary one
     * (most likely one made during the create() view before saving the model)
     * If user model is temporary ($user_id = 0), upload the file to a temporary directory first.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user_id
     * @return JSON   JSON response
     */
    public function upload(Request $request, $user_id)
    {
        $tmp_user_id = 0;

        if ($user_id == $tmp_user_id) { // temporary user model
            if (Gate::denies('update', User::class)) {
                return parent::unauthorizedResponse(redirect()->back(), $request);
            }

            $imageUploader = new ImageUploader($request->file('files')[0]);
            $response = $this->uploadToTmp($imageUploader);
        } else {
            if (Gate::denies('update', User::find($user_id))) {
                return parent::unauthorizedResponse(redirect()->back(), $request);
            }

            $avatarUploader = new AvatarUploader($request->file('files')[0]);
            $filename = 'user_' . $user_id;
            $uploadedFile = $avatarUploader->upload(
                $filename,
                public_path(config('constants.upload_dir.users')),
                150,
                150,
                true
            );

            if ($uploadedFile) {
                $user = User::find($user_id);
                $user->setAvatar(url(config('constants.upload_dir.users'). $uploadedFile));

                $response = AvatarUploader::formatResponse(url(config('constants.upload_dir.users'). $uploadedFile));
            } else {
                echo 'Image Upload Error!';
                $response = AvatarUploader::getErrorResponse();
            }
        }

        return json_encode($response);
    }

    /**
     * Upload avatar image file to the Users tmp directory
     * Used as an ajax endpoint for the jQuery file upload plugin
     * @param  \Illuminate\Http\UploadedFile $file
     * @param  \App\Uploaders\ImageUploader $imageUploader
     * @return array          Response Array containing the directory path of the uploaded file
     */
    public function uploadToTmp($imageUploader)
    {
        $filename = time().'-'.'user_' . generate_random_str(20);
        $uploadedFile = $imageUploader->upload(
            $filename,
            public_path(config('constants.upload_dir.tmp')),
            AvatarUploader::IMAGE_SIZE,
            AvatarUploader::IMAGE_SIZE,
            true
        );

        if ($uploadedFile) {
            $response = ImageUploader::formatResponse(url(config('constants.upload_dir.tmp') . $uploadedFile));
        } else {
            echo 'Image Upload Error!';
            $response = ImageUploader::getErrorResponse();
        }

        return $response;
    }

    /**
     * Read the avatar image url string during the user creation process and save it as a png file
     * in the uploads/tmp dir.
     * Converts an image from a url (e.g.: api.adorable.io/avatars) into a png file
     * @param  string $imageUrl  Url of the avatar image file
     * @return string/boolean    If image url is valid, returns filename of png file
     *                           If image url is invalid, returns false
     */
    private function transferTmpAvatar($imageUrl)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $imageUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);

        $imagedata = imagecreatefromstring($data);

        if ($imagedata !== false) {
            $imageUploader = new ImageUploader($imagedata);
            $filename = time().'-'.'user_avatar_' . generate_random_str(20);
            $uploadedFile = $imageUploader->upload(
                $filename,
                public_path(config('constants.upload_dir.tmp')),
                0,
                0,
                false,
                true
            );

            if (!$uploadedFile) {
                return false;
            }

            // delete tmp avatar file (if any)
            \File::delete(public_path(config('constants.upload_dir.tmp')) . basename($imageUrl));
            imagedestroy($imagedata);

            return $uploadedFile;
        }

        return false;
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
