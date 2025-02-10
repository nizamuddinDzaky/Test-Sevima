<?php

namespace App\Http\Controllers;

use App\Forms\SongForm;
use App\Models\MConfig;
use App\Models\Menu;
use App\Models\MUserConfig;
use App\Models\TPosting;
use App\Models\TPostingComment;
use App\Models\TPostingLike;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\Field;
use Spatie\Permission\Models\Permission;


class PostingController extends Controller
{

    public function comment(Request $request) {
        try {
            $posting = TPosting::with('comments')->find($request->posting_id);
            $view = view('posting.form-comment', compact('posting'));
            return $this->success_response("Success", $view->render());
        } catch (\Exception $e) {
            DB::rollback();
            return $this->failed_response($e->getMessage());
        }
    }

    public function previewImage(Request $request) {
        try {
            $posting = TPosting::with('comments')->find($request->posting_id);
            $view = view('posting.preview-image', compact('posting'));
            return $this->success_response("Success", $view->render());
        } catch (\Exception $e) {
            DB::rollback();
            return $this->failed_response($e->getMessage());
        }
    }

    public function commentSave(Request $request) {
        try {
            $request->validate(TPostingComment::validation()->rules, TPostingComment::validation()->messages);
            $userId = Auth::user()->id;
            TPostingComment::create([
                'user_id' => $userId,
                'comment' => $request->comment,
                'posting_id' => $request->posting_id
            ]);
            $response = [
                'url' => ''
            ];

            return $this->success_response("Berhasil Memposting", $response, $request->all());
        } catch (\Exception $e) {
            DB::rollback();
            return $this->failed_response($e->getMessage());
        }
    }
    public function add() {

        $view = view('posting.form-add');
        return $this->success_response("Success", $view->render());
    }

    public function store(Request $request) {
        try {
            $request->validate(TPosting::validation()->rules, TPosting::validation()->messages);
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('posting'), $imageName);
            $image = 'posting/'.$imageName;
            $userId = Auth::user()->id;
            TPosting::create([
                'user_id' => $userId,
                'image' => $image,
                'caption' => $request->caption,
            ]);
            $response = [
                'url' => ''
            ];

            return $this->success_response("Berhasil Memposting", $response, $request->all());
        }  catch (\Exception $e) {
            DB::rollback();
            return $this->failed_response($e->getMessage());
        }
    }

    public function like(Request $request)  {
        try {
            DB::beginTransaction();
            $userId = Auth::user()->id;
            TPostingLike::create([
                'user_id' =>$userId,
                'posting_id' => $request->posting_id
            ]);
            DB::commit();
            return $this->success_response("Berhasil", [], $request->all());
        }  catch (\Exception $e) {
            DB::rollback();
            return $this->failed_response($e->getMessage());
        }
    }

    public function dislike(Request $request) {
        try {
            DB::beginTransaction();
            $userId = Auth::user()->id;
            TPostingLike::where([
                'user_id' =>$userId,
                'posting_id' => $request->posting_id
            ])->delete();
            // TPostingLike::create([
            //     'user_id' =>$userId,
            //     'posting_id' => $request->posting_id
            // ]);
            DB::commit();
            return $this->success_response("Berhasil", [], $request->all());
        }  catch (\Exception $e) {
            DB::rollback();
            return $this->failed_response($e->getMessage());
        }
    }

    public function updateProfileSave(Request $request){
        try {
            DB::beginTransaction();
            $configs = MConfig::whereIn('type', array_keys($request->all()))->get();
            $conf = clone $configs;
            $userId = Auth::user()->id;
            MUserConfig::where('user_id', $userId)
            ->whereIn('config_id', array_column($conf->toArray(), 'id'))
            ->delete();
            $userConfigData = [];
            foreach ($configs as $key => $config) {
                if(isset($request->all()[$config->type])){
                    $value = $request->all()[$config->type];
                    if($config->type == 'image'){
                        $imageName = time().'.'.$request->image->extension();
                        $request->image->move(public_path('profile'), $imageName);
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

            return $this->success_response("Berhasil Membuat Account, Silahkan Periksa Email", $response, $request->all());
        } catch (\Exception $e) {
            DB::rollback();
            return $this->failed_response($e->getMessage());
        }
    }
}
