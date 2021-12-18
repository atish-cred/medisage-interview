<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Student extends Model {
    protected $table = 'students';

    public function getAll($params = []){
        $count = "";
        if(isset($params['count']) && !empty($params['count'])){
            $count = ", count(*) as total_records ";
        }

        $qry = "SELECT *{$count} FROM {$this->table} WHERE 1 = 1 ";

        if(isset($params['where']) && !empty($params['where'])){
            foreach($params['where'] as $key => $item){
                $qry .= " AND {$item[0]} {$item[1]} {$item[2]} ";
            }
        }

        if (isset($params['where_or']) && !empty($params['where_or'])) {
            $tmpQuery = '';
            foreach ($params['where_or'] as $key => $item) {
                if (!empty($item[0]) && !empty($item[1]) && !empty($item[2])) {
                    $tmpQuery .= " {$item[0]} {$item[1]} {$item[2]} OR ";
                }
            }
            
            if(!empty($tmpQuery)){
                $tmpQuery = rtrim($tmpQuery, ' OR ');
                $qry .= "AND (".$tmpQuery.") ";
            }
        }

        if(isset($params['group_by']) && !empty($params['group_by'])) {
            $qry .= " group by {$params['group_by']} ";
        }
        
        if(isset($params['order_by']) && !empty($params['order_by'])) {
            $dir = '';
            if(isset($params['order_type']) && !empty($params['order_type'])) {
                $dir = $params['order_type'];
            }
            $qry .= "order by {$params['order_by']} {$dir}";
        }
        
        if(isset($params['count']) && !empty($params['count'])) {
            return collect(\DB::select($qry))->first();
        }
        
        if(isset($params['start']) && !empty($params['start']) || isset($params['limit']) && !empty($params['limit']) ){
            $qry .= " limit {$params['start']}, {$params['limit']} ";
        }
        
        // echo $qry;
        //  die;
        
        if(isset($params['single']) && !empty($params['single'])) {
            return collect(\DB::select($qry))->first();
        }

        return DB::select(DB::raw($qry));
    }

    public function getSingleData($id) {
        $id = (int) $id;
        $query = "SELECT * FROM {$this->table} WHERE id = {$id}";
        $result = DB::select(DB::raw($query));
        foreach ($result as $data) {
            return json_decode(json_encode($data), True);
        }
        return false;
    }

    public function saveData($post, $isNew = TRUE) {
        if (isset($post['_token'])) {
            unset($post['_token']);
        }

        $tableColumns = DB::getSchemaBuilder()->getColumnListing($this->table);
        $finalData = new Student();
        foreach ($post as $columns => $value) {
            if (!is_array($value) && in_array($columns, $tableColumns)) {
                $finalData[$columns] = $value;
            }
        }

        if (isset($finalData['id'])) {
            $id = (int) $finalData['id'];
        } else {
            $id = 0;
            unset($finalData['id']);
        }
        
        if ($id == 0) {
            $finalData['created_at'] = date("Y-m-d H:i:s");
            // $finalData['created_by'] = Auth::user()->id;
            $finalData->save();
            $id = $finalData->id;
            return array('id' => $id, 'status' => 'success', 'message' => "Data saved!");
        } else {
            if ($this->getSingleData($id)) {
                $finalData['updated_at'] = date("Y-m-d H:i:s");
                // $finalData['updated_by'] = Auth::user()->id;
                $finalData->exists = true;
                $finalData->id = $id;
                $finalData->save();
                return array('id' => $id, 'status' => 'success', 'message' => "Data updated!");
            }
        }
        return false;
    }
    
    public function updateById($updateArray, $id = '0'){
        if(empty($id)) return false;
        return Tpa::where('id', $id)->update($updateArray);
    }

    public function deleteById($id){
        if(is_array($id)){
            return Tpa::whereIn('id', $id)->delete();
        }
        return Tpa::where('id', $id)->delete();
    }
}
