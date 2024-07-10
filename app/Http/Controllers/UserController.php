<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Input;
use App\Form;  
use Illuminate\Support\Facades\Auth;
use Session;
use DB;  
use PDF; 

class UserController extends Controller
{
    public function __construct()  
    {  
        //$this->middleware(['auth','verified']);  
    }  
    
    public function index(){
//        $users = User::orderBy('id','asc')->paginate(5);
//        return view('user.index', compact('users'));
        $users = User::orderBy('id','desc')->paginate(5);
        return view('user.index',['users'=>$users]);
        
    }
    
//    public function pdfview(Request $request)  
//    {  
//        $items = DB::table("users")->get();  
//        view()->share('users',$items);  
//  
//        if($request->has('download')){  
//            $pdf = PDF::loadView('pdfview');  
//            return $pdf->download('pdfview.pdf');  
//        }  
//  
//        return view('user.index');  
//    }  
    
    public function create(){
        return view('user.create');
    }
    
    public function show(){
        //return $data = session()->get('user')['email'];
        if(Session::has('user')) {
            return redirect('');
        }else{
            return view('user.login');  
            
        }
    }
    
    public function signin(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            //return $credentials;
            $request->session()->put('user',$credentials);
            return redirect()->intended('user')
                        ->withSuccess('You have Successfully loggedin');
        }
  
        return redirect('user/login')->with('error','Oppes! You have entered invalid credentials');
    }
    
    public function store(Request $request){
        //dd($request->all());
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
            'address' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg,pdf,doc,docx|max:2048',
        ]);
     
        if($request->hasFile('image')){
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();  
            $img = $file->move('uploads/user',$fileName);
            //User::create($request->post());
            
            $post = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'username' => $request['username'],
                'password' => Hash::make($request['password']),
                'address' => $request['address'],
                'image' => $fileName,
            ]);
        }

        if(!$post){
            return 'record not iserted';
        }else{
            return redirect()->route('user.index')->with('success','User has been created successfully.');
        }
    }
    
    function edit(User $user){
        return view('user.edit', compact('user'));
    }
    
    function update(Request $request, User $user){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
            'address' => 'required',
        ]);
        
        if($request->hasFile('image')){
            if(file_exists(public_path().'/uploads/user/'.$user->image)){
                unlink(public_path().'/uploads/user/'.$user->image);
            }
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();  
            $img = $file->move('uploads/user',$fileName);
            //User::create($request->post());\
            
            $post = $user->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'username' => $request['username'],
                'password' => Hash::make($request['password']),
                'address' => $request['address'],
                'image' => $fileName,
            ]);
            return redirect()->route('user.index')->with('success','User has been updated successfully.');
        }else{
            $user->update($request->post());
            return redirect()->route('user.index')->with('success','User has been updated successfully.');
        }
        
        //$user->update($request->post());
        //return redirect()->route('user.index')->with('success','User has been updated successfully.');
    }
    
    function destroy(User $user){
        $user_id = $user->id;
        $data = \DB::table('users')->where('id', $user_id)->first();
        $file= $data->image;
         $filename = public_path().'/uploads/user/'.$file;
        \File::delete($filename);
        
        $user->delete();
        return redirect()->route('user.index')->with('success','User has been deleted successfully.');
    }
    
    function logout(){
        Session::flush();
        Auth::logout();
        return redirect('user/login');
    }
    
    //not working
//    public function deleteAll(Request $request)  
//    {  
//        $ids = $request->ids;  
//        DB::table("users")->whereIn('id',explode(",",$ids))->delete();  
//        return response()->json(['success'=>"Record Deleted successfully."]);  
//    }  
      
}
