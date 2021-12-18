<?php 
    if(isset($row_id) && !empty($row_id)){
        $id = $rowId = $row_id;
    }else{
        $id = $rowId = 1;
    }
?>

<tr class="emp_structure_row removeEmpRow " id="removeEmpRow{{ $rowId }}">
    <input type="hidden" name="employee_id[]" value=""/>
    <td class="text-center" >
        <input type="text" id="employee_name{{ $id }}" name="employee_name[]" data-id="{{ $id }}" class="employee_name employee_name{{ $id }} form-control form-control-sm" 
        value="<?php echo (isset($data) && isset($data['name']))? $data['name']: ""; ?>">
        <span class="text-danger employee_name_error{{ $id }}"></span>
    </td>
    <td>
        <input type="text" id="employee_designation{{ $id }}" name="employee_designation[]" data-id="{{ $id }}" class="employee_designation employee_designation{{ $id }} form-control form-control-sm" 
        value="<?php echo (isset($data) && isset($data['designation']))? $data['designation']: ""; ?>">
        <span class="text-danger employee_designation_error{{ $id }}"></span>
    </td>
    <td>
        <input type="text" id="employee_mobile_1{{ $id }}" name="employee_mobile_1[]" data-id="{{ $id }}" class="employee_mobile_1 employee_mobile_1{{ $id }} form-control form-control-sm onlynumber"
        value="<?php echo (isset($data) && isset($data['contact1']))? $data['contact1']: ""; ?>">
        <span class="text-danger employee_mobile_1_error{{ $id }}"></span>
    </td>
    <td>
        <input type="text" id="employee_mobile_2{{ $id }}" name="employee_mobile_2[]" data-id="{{ $id }}" class="employee_mobile_2 employee_mobile_2{{ $id }} form-control form-control-sm onlynumber"
        value="<?php echo (isset($data) && isset($data['contact2']))? $data['contact2']: ""; ?>">
        <span class="text-danger employee_mobile_2_error{{ $id }}"></span>
    </td>
    <td>
        <input type="text" id="employee_email{{ $id }}" name="employee_email[]" class="employee_email employee_email{{ $id }} form-control form-control-sm" 
        value="<?php echo (isset($data) && isset($data['email1']))? $data['email1']: ""; ?>">
        <span class="text-danger employee_email{{ $id }}"></span>
    </td>
    <td>
        <?php if(isset($is_delete) && !empty($is_delete)){ ?>
            <button type="button" id="agentDeleterow{{ $id }}" class="btn btn-sm btn-xs btn-delete btn-danger" title="Delete" onclick="empDeleterow({{ $rowId }})"><i class="fa fa-trash"></i></button>
        <?php } ?>
    </td>
</tr>
