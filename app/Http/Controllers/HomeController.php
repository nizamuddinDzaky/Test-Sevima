<?php

namespace App\Http\Controllers;

use App\Forms\SongForm;
use App\Models\MConfig;
use App\Models\Menu;
use App\Models\MUserConfig;
use App\Models\TPosting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\Field;
use Spatie\Permission\Models\Permission;

/**
 *   0 => ""id_kain""
    1 => ""kd_jns""
    2 => ""kd_wrn""
    3 => ""kd_stn""
    4 => ""ktg""
    5 => ""kd_kat""
 */

class HomeController extends Controller
{

    public function index() {
        $user = Auth::user();
        // $user = User::find();
        $postings = TPosting::where('user_id', $user->id)
        ->with('user', 'like')
        ->get();
        // dd($postings[0]->user->enable_comment);
        $page_title = 'Profile '.$user->username;
        return view('profile.profile', compact('user', 'page_title', 'postings'));
    }

    public function updateProfile(Request $request) {
        try {
            $user = Auth::user();
            $config = MConfig::all();
            $view = view('profile.form-update-profile',
            [
                'config' => $config,
                'user' => $user
            ]);
            return $this->success_response("Success", $view->render());
        } catch (\Exception $e) {
            DB::rollback();
            return $this->failed_response($e->getMessage());
        }
    }

    public function updateProfileSave(Request $request){
        try {
            DB::beginTransaction();
            $configs = MConfig::whereIn('key', array_keys($request->all()))->get();
            $conf = clone $configs;
            $userId = Auth::user()->id;
            MUserConfig::where('user_id', $userId)
            ->whereIn('config_id', array_column($conf->toArray(), 'id'))
            ->delete();
            $userConfigData = [];
            foreach ($configs as $key => $config) {
                if(isset($request->all()[$config->key])){
                    $value = $request->all()[$config->key];
                    if($config->key == 'photo_profile'){
                        $imageName = time().'.'.$request->photo_profile->extension();
                        $request->photo_profile->move(public_path('profile'), $imageName);
                        $value = 'profile/'.$imageName;
                    }
                    $userConfigData[] = [
                        'user_id' => $userId,
                        'config_id' => $config->id,
                        'value' => $value
                    ];
                }
            }

            MUserConfig::insert($userConfigData);
            DB::commit();
            $response = [
                'url' => route('home')
            ];

            return $this->success_response("Berhasil Mengubah Account, Silahkan Periksa Email", $response, $request->all());
        } catch (\Exception $e) {
            DB::rollback();
            return $this->failed_response($e->getMessage());
        }
    }

    public function explore() {
        try {
            $postings = TPosting::with('user', 'like')
            ->get();
            $page_title = 'Explore ';
            return view('explore', compact('page_title', 'postings'));
        } catch (\Exception $e) {
            DB::rollback();
            return $this->failed_response($e->getMessage());
        }
    }
}
