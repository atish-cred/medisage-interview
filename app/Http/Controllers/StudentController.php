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
        $data['title'] = $this->pageTitle;
        return view('student.index', $data);
    }

    public function grid(Request $request) {
        $start = $request->has('start') ? (int) $request->start : (int) 0;
        $length = $request->has('length') ? (int) $request->length : (int) 10;
        $download = $request->has('download') ? $request->download : "";

        $params = [];
        $orderBy = $request->has('order') ? $request->order : array();        

        if(!empty($orderBy)){
            $columns = array('name','name','email','phone_number');
            $orderBy = $orderBy[0];
            $columnIndex = $orderBy['column'];
            
            if(array_key_exists($columnIndex, $columns)){
                $column = $columns[$columnIndex];
                $params['order_by'] = "{$column}";
                $params['order_type'] = "{$orderBy['dir']}";
            }
        }

        $params['start'] = $start;
        $params['limit'] = $length;
        $params['count'] = true;

        if($request->has('name') && !empty($request->name)){
            $params['where'][] = ['name', " LIKE ", "'%{$request->name}%'"];
        }

        if($request->has('email') && !empty($request->email)){
            $params['where'][] = ['email', " LIKE ", "'%{$request->email}%'"];
        }

        if($request->has('phone_number') && !empty($request->phone_number)){
            $params['where'][] = ['phone_number', " = ", "{$request->phone_number}"];
        }

        $obj = new Student();
        $totalRecordsdata = $obj->getAll($params);
        $totalRecords = 0;
        
        $data = [];
        if(!empty($totalRecordsdata) && $totalRecordsdata->total_records > 0){
            $totalRecords = $totalRecordsdata->total_records;
            $params['count'] = false;
            $data = $obj->getAll($params);
        }

        if(!empty($data)){
            $data = $this->getGridFields($data);
        }

        // echo "<pre>";
        // print_r($params);
        // print_r($data);
        // die;

        $response = array(
            'draw' => (int) $request->has('draw') ? (int) $request->draw : (int) 0,
            'recordsTotal' => (int) $totalRecords,
            'recordsFiltered' => (int) $totalRecords,
            'data' => $data,
        );
        return json_encode($response, true);
    }
    
    public function getGridFields($rows, $downloadOrCsv = false) {
        $data = array();
        if (count($rows)) {
            foreach ($rows as $row) {
                $row = (array) $row;
                $data[] = array(
                    $row['name'],
                    $row['email'],
                    $row['phone_number'],
                    $row['id'],
                );
            }
        }
        return $data;
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
       
        // ## File Upload Not added yet. Please Confirm AWS or Upload Folder 
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
            // echo 
            $msg = $e->getLine()." - ".$e->getMessage();
            $errorTransaction = true;
        }
       
        if($errorTransaction){
            DB::rollback();
            $returnData = array('status' => 'error', 'message' => 'Fail to delete data.', 'exception_error' => $msg);
        }else{
            DB::commit();
            $returnData = array('status' => 'success', 'message' => 'TPA deleted successfully.');
        }
        return json_encode($returnData);
    }


    public function apiFetch(Request $request){
        // print_r($request->all());

        $start = $request->has('start') ? (int) $request->start : (int) 0;
        $length = $request->has('length') ? (int) $request->length : (int) 10;
        $params = [];

        $params['start'] = $start;
        $params['limit'] = $length;
        $params['count'] = true;

        if($request->has('search') && !empty($request->search)){
            $params['where_or'][] = ['name', " LIKE ", "'%{$request->search}%'"];
            $params['where_or'][] = ['email', " LIKE ", "'%{$request->search}%'"];
            $params['where_or'][] = ['phone_number', " LIKE ", "'%{$request->search}%'"];
        }

        $obj = new Student();
        $totalRecordsdata = $obj->getAll($params);
        $totalRecords = 0;
        
        $data = [];
        if(!empty($totalRecordsdata) && $totalRecordsdata->total_records > 0){
            $totalRecords = $totalRecordsdata->total_records;
            $params['count'] = false;
            $data = $obj->getAll($params);
        }

        if(!empty($data)){
            $data = $this->getGridFields($data);
        }

        // echo "<pre>";
        // print_r($params);
        // print_r($data);
        // die;

        $response = array(
            'recordsTotal' => (int) $totalRecords,
            'data' => $data,
            'start' => $start,
            'limit' => $length,
        );

        return response()->json($response);
    }
}
