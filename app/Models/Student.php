<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Student extends Model {
    protected $table = 'students';

    public function getDataWithPagination($request){
        $search = '';
        $students = Student::paginate(5);
        if($request->has('search') && !empty($request->search)){
            $search = $request->get('search');
            $students = Student::where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('phone_number', 'like', '%'.$search.'%')
                    ->paginate(5);
        }
        return $students;
    }

    public function getSingleData($id) {
        $id = (int) $id;
        $result = Student::where('id', $id)->first();
        foreach ($result as $data) {
            return json_decode(json_encode($data), True);
        }
        return false;
    }
}
