<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller {
    public $timestamps = false;
    protected $table = 'student';
    private $pageTitle = 'Student';

    public function index(Request $request) {
        $search = '';
        if($request->has('search') && !empty($request->search)){
            $search = $request->get('search');
        }
        
        $obj = new Student();
        $students = $obj->getDataWithPagination($request);

        $data['search'] = $search;
        $data['students'] = $students;
        $data['title'] = $this->pageTitle;
        return view('student.index', $data);
    }
    
    public function add(Request $request, $id = null) {
        $data['data'] = (object) [];
        $data['title'] = $this->pageTitle; 

        $id = isset($id) ? (int) $id : (int) 0;
        if ($id != 0) {
            $data['data'] = Student::findOrFail($id);
        }
        return view('student.add', $data);
    }

    public function save(Request $request) {
        $returnData = array();
        $validator = Validator::make($request->all(), ([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone_number' => 'required|numeric',
            'country' => 'required|string|max:50',
            'country_code' => 'required',
        ]));

        if ($validator->fails()) {
            $returnData = array('status' => 'error', 'message' => 'Validation Error', 'errors' => $validator->errors());
            return json_encode($returnData);
        }

        DB::beginTransaction();
        $errorTransaction = false;
        $msg = '';
        try{
            $profileImage = '';
            if($request->has('id') && !empty($request->id)){
                $obj = Student::where('id', $request->id)->first();
                
                if(empty($obj)){
                    $returnData = array('status' => 'error', 'message' => 'Record Not Found.');
                    return json_encode($returnData);
                }
                $profileImage = $obj->profile_image;
            }else{
                $obj = new Student();
            }

            $obj->name = $request->name;
            $obj->email = $request->email;
            $obj->phone_number = $request->phone_number;
            $obj->country = $request->country;
            $obj->country_code = $request->country_code;
            $obj->created_at = date("Y-m-d H:i:s");
            
            if(!empty($file = $request->file('profile_image'))){
                $name = $file->getClientOriginalName(); // '.".".$file->getClientOriginalExtension();

                if ($file->isValid()) {
                    $fileCheck = $file->move(base_path().'/public/images/', "{$name}");
                    if(!$fileCheck){
                        $errorTransaction = true;
                    }else{
                        $obj->profile_image = "{$name}";

                        if(file_exists(base_path().'/public/images/'.$profileImage) && !empty($profileImage)){
                            unlink('public/images/'.$profileImage);
                        }
                    }
                }
            }

            if(!$obj->save()){
                $errorTransaction = true;
            }
        }catch(\Exception $e){
            $msg = $e->getLine()." - ".$e->getMessage();
            $errorTransaction = true;
        }
        
        if($errorTransaction){
            DB::rollback();
            $returnData = array('status' => 'error', 'message' => 'Error in data insertion.', 'exception_error' => $msg);
        }else{
            DB::commit();
            $returnData = array('status' => 'success', 'message' => 'Student added successfully.');
        }
        return json_encode($returnData);
    }

    public function destroy($id) {
        $obj = Student::where('id', $id)->first();
        if(empty($obj)){
            $returnData = array('status' => 'error', 'message' => 'Record Not Found.');
            return json_encode($returnData);
        }

        $profileImage = $obj->profile_image;

        DB::beginTransaction();
        $msg = '';
        $errorTransaction = false;
        
        try{
            $response = Student::where('id', $id)->delete();
            if($response){
                if(file_exists(base_path().'/public/images/'.$profileImage) && !empty($profileImage)){
                    unlink('public/images/'.$profileImage);
                }
            }else{
                $errorTransaction = true;
            }
        }catch(\Exception $e){
            $msg = $e->getLine()." - ".$e->getMessage();
            $errorTransaction = true;
        }
       
        if($errorTransaction){
            DB::rollback();
            $returnData = array('status' => 'error', 'message' => 'Fail to delete data.', 'exception_error' => $msg);
        }else{
            DB::commit();
            $returnData = array('status' => 'success', 'message' => 'Student deleted successfully.');
        }
        return json_encode($returnData);
    }
    
    public function fetchStudentsApi(Request $request){
        $search = '';
        if($request->has('search') && !empty($request->search)){
            $search = $request->get('search');
        }

        $obj = new Student();
        $students = $obj->getDataWithPagination($request);

        $data['search'] = $search;

        $data['students'] = [];
        if($students->count() > 0){
            $data['students'] = $students->toArray();
        }
    }
}
