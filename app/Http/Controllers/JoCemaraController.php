<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Auth;
use App\Jo;
use App\Client;
use App\JoParent;
use App\JoStatus;
use App\JoCategory;

use Pusher\Pusher;

class JoCemaraController extends Controller {

    public function __construct() {
        return $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $job_list  = Jo::where('parent_id', '=', 1)->paginate(20);
        return view('jo.cemara.index', array('job_list' => $job_list));
    }



    public function sendNotification($paramMessage) {
        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );
        $pusher = new Pusher(
            '72f209b771778f605aa1',
            '994ddc905a94827da0c0',
            '964596', $options
        );
        $message = $paramMessage;
        $pusher->trigger('notification', 'notification-event', $message);
    }


    /* Fungsi Buat JO secara otomatis */
    private function createJoCode() {
        //  ambil kode jo terbaru
        $lastJoCode     = Jo::orderBy('jo_code', 'DESC')->first()->jo_code;
        $codename       = "CK";

        if($lastJoCode != NULL) {
            $newCode        = (int)substr($lastJoCode, 2);
            /* tambah nomor jo dengan 1 */
            $codePlusOne       = $newCode + 1;
            $newJoCode         = NULL;
            /* uji nomor Jo nya */
            switch(strlen((string)$codePlusOne)) {
                case 1  : $newJoCode = $codename . "0000" . (string)$codePlusOne; break;
                case 2  : $newJoCode = $codename  . "000" . (string)$codePlusOne; break;
                case 3  : $newJoCode = $codename   . "00" . (string)$codePlusOne; break;
                case 4  : $newJoCode = $codename    . "0" . (string)$codePlusOne; break;
                default : $newJoCode = (string)$newCode;
            }
            return $newJoCode; // kembalikan nilai JO baru
        }
        else {
            return "CK00001";
        }
        
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $pageTitle      = "Buat JO";
        $parents        = JoParent::orderBy('name', 'ASC')->pluck('name', 'id');
        $clients        = Client::orderBy('name', 'ASC')->pluck('name', 'id');
        $status         = JoStatus::orderBy('name', 'ASC')->pluck('name', 'id');

        $newJoCode      = $this->createJoCode();
        return view('jo.create', compact('parents', 'clients', 'status', 'pageTitle', 'newJoCode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        
        /* validation */
        $this->validate($request, array(
            'image_url'         => 'image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'title'             => 'required',
            'client_id'         => 'required',
        ));

        $input = $request->all();
        $input['user_id']       = Auth::user()->id;
        $input['parent_id']     = (int)$request->parent_id;
        $input['jo_code']       = $this->createJoCode();

        
        $input['start_date']    = $request->start_date;
        $input['deadline']      = $request->deadline;
        
        $input['category_id']   = 1;
        $input['client_id']     = (int)$request->client_id;
        $input['jo_status_id']  = (int)$request->jo_status_id;
        $input['qty']           = (int)$request->qty;

        

        // if ($files = $request->file('image_url')) {
        //     $destinationPath = 'public/uploads/jo/'; // upload path
        //     $joImage =  $input['jo_code'] . Carbon::now() . "." . $files->getClientOriginalExtension();
        //     $files->move($destinationPath, $joImage);
        // }

        if($file = $request->file('image_url')) {
            $name               =  $input['jo_code'] . '_' . Str::slug($input['title'], '-') . '.' . $file->getClientOriginalExtension();
            $destinationPath    =  public_path('/uploads/jo/');
            $file->move($destinationPath, $name);
            $input['image_url'] = $name;
        }

        // Create to the Database
        Jo::create($input);

        /** panggil method send notification */
        $this->sendNotification('Ada JO baru nih!');
        /* pengujian siapa yang akan menerima notifikasi dilakukan di view */

        return redirect()->route('job')
                ->withSuccess('Jo Berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $jo = Jo::findOrFail($id);
        return view('jo.show', array('jo' => $jo));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $pageTitle      = 'Edit Job Order';
        $jo             = Jo::where('id', $id)->first();
        $parents        = JoParent::orderBy('name', 'ASC')->pluck('name', 'id');
        $clients        = Client::orderBy('name', 'ASC')->pluck('name', 'id');
        $status         = JoStatus::orderBy('name', 'ASC')->pluck('name', 'id');
        return view('jo.edit', compact('jo', 'parents', 'clients', 'status', 'pageTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        /* validation */
        $this->validate($request, array(
            'image_url'         => 'image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'title'             => 'required',
            'client_id'         => 'required',
        ));

        $jo = Jo::where('id', $id)->first();

        $jo->title         = $request->title;
        $jo->start_date    = $request->start_date;
        $jo->deadline      = $request->deadline;
        $jo->client_id     = (int)$request->client_id;
        $jo->qty           = (int)$request->qty;

        if($file = $request->file('image_url')) {
            $name               =  $input->jo_code . '_' . Str::slug($input->title, '-') . '.' . $file->getClientOriginalExtension();
            $destinationPath    =  public_path('/uploads/jo/');
            $file->move($destinationPath, $name);
            $input->image_url = $name;
        }
        // dd($jo);
        // Update Database
        $jo->save();
        return redirect()->route('jo.cemara.show', $jo->id)->with('updateSuccess','Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }
}
