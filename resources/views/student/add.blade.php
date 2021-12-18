<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap 5 Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <link href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js" type="text/javascript" ></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js" type="text/javascript" ></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.js" type="text/javascript" ></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js" type="text/javascript" ></script> -->


    <script src="https://jqueryvalidation.org/files/lib/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>


    <!-- <script src="js/common.js" defer></script> -->
    <script src="{{ asset('public/js/common.js') }}" defer></script>



    <!-- 

 -->

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
</head>

<body>

    <div class="container-fluid p-5 bg-primary text-white text-center">
        <h1>Student Add / Edit Page</h1>
        <p>Resize this responsive page to see the effect!</p>
    </div>

    <div class="container mt-5">
        <div class="row">

            <form class="kt-form kt-form--label-right " name="addForm" id="addForm" novalidate="novalidate" action="save" method="post">
                @csrf
                <input name="id" type="hidden" value="<?php echo (isset($data->id)) ? $data->id : ''; ?>" />

                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__body p-4 " style="display:block !important">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="name" class="col-form-label text-right">Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" placeholder="Enter Name" class="form-control form-control-sm" value="<?php echo (isset($data->name)) ? $data->name : ''; ?>" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="email" class="col-form-label text-right">Email<span class="text-danger">*</span></label>
                                    <input type="text" name="email" id="email" placeholder="Enter Email" class="form-control form-control-sm" value="<?php echo (isset($data->email)) ? $data->email : ''; ?>" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="phone_number" class="col-form-label text-right">Phone Number<span class="text-danger">*</span></label>
                                    <input type="text" name="phone_number" id="phone_number" placeholder="Enter Phone Number" class="form-control form-control-sm" value="<?php echo (isset($data->phone_number)) ? $data->phone_number : ''; ?>" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <?php $countrCodes = ['91', '92', '93']; ?>
                                    <label for="country_code" class="col-form-label text-right">Country Code<span class="text-danger">*</span></label>
                                    <select name="country_code" class="form-control form-control-sm" required>
                                        <option value="">-- Select -- </option>
                                        <?php foreach ($countrCodes as $code) {
                                            $selected =  (isset($data->country_code) && $data->country_code == $code) ? 'selected' : '';
                                        ?>
                                            <option value="<?php echo $code; ?>" {{$selected}}>+<?php echo $code; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="country" class="col-form-label text-right">Coutry<span class="text-danger">*</span></label>
                                    <input type="text" name="country" id="country" placeholder="Enter country Name" class="form-control form-control-sm" value="<?php echo (isset($data->country)) ? $data->country : ''; ?>" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="profile_image" class="col-form-label text-right">Upload Profile Photo</label>
                                    <input type="file" name="profile_image" id="profile_image" class="form-control form-control-sm">
                                    <?php if ((isset($data->profile_image))) { ?>
                                        <a class="btn btn-sm btn-primary" href="<?php echo asset('public/images/'.$data->profile_image); ?>">view profile image</a>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__foot">
                        <div class="row justify-content-center">
                            <div class="col-lg-2">
                                <input type="button" name="submit" id="submitbutton" class="btn btn-primary col-lg-12" value="Save" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <script type="text/javascript">
               
                $().ready(function() {
                    $("#addForm").validate({
                        onkeydown: false,
                        onkeyup: false,
                        onfocusin: false,
                        onfocusout: false,
                        errorElement: "div",
                        rules: {
                            name: {
                                required: true,
                                alphanumericRegex: true
                            },
                            email: {
                                required: true,
                                emailRegex: true
                            },

                            phone_number: {
                                required: true,
                                phoneRegex: true
                            },

                            country: {
                                required: true,
                                alphanumericRegex: true
                            },

                            country_code: "required",
                        },
                        messages: {
                            name: {
                                required: "Please enter name",
                                alphanumericRegex: "Please enter valid name"
                            },
                            email: {
                                required: "Please enter email",
                                emailRegex: "Please enter valid email"
                            },
                            phone_number: {
                                required: "Please enter phone number",
                                phoneRegex: "Please enter valid phone number"
                            },
                            country: {
                                required: "Please enter country",
                                alphanumericRegex: "Please enter valid country"
                            },
                            country_code: "Please select country code",

                        },
                        submitHandler: function(form) {
                            // alert(1);

                            $('#submitbutton').attr('disabled', false);

                            var form = $('form')[0]; 
                            var formData = new FormData(form);

                            $.ajax({
                                url: '/medisage/student/save',
                                // data: new FormData( $("#addForm")),
                                data: formData,
                                type: "POST",
                                dataType: "json",
                                contentType: false,
                                cache: false,
                                processData: false,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function (data) {
                                    commonStatusMessage(data, '/medisage/student');
                                    $('#submitbutton').attr('disabled', false);
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    // commonStatusMessage(data, '/medisage/student');
                                    $('#submitbutton').attr('disabled', false);
                                }
                            });
                            return false;
                        },
                        errorPlacement: function(error, element) {
                            showError(error, element);
                            // console.log(error, element);
                        }
                    });

                    $("#submitbutton").click(function() {
                        $("#addForm").submit();
                        return false;
                    });

                    //accpet atleast one alphabet 
                    $.validator.addMethod("alphaCapitalRegex", function(value, element) {
                        return this.optional(element) || /^\d*[a-zA-Z0-9 -]*$/.test(value);
                    });
                    $.validator.addMethod("alphanumericRegex", function(value, element) {
                        return this.optional(element) || /^\d*[a-zA-Z][a-zA-Z0-9 -]*$/.test(value);
                    });
                    $.validator.addMethod("phoneRegex", function(value, element) {
                        return this.optional(element) || /^(?:(?:\+|0{0,2})91(\s*[\  -]\s*)?|[0]?)?[789]\d{9}|(\d[ -]?){10}\d$/.test(value);
                    });
                    $.validator.addMethod("numericRegex", function(value, element) {
                        return this.optional(element) || /^[0-9]{1}[0-9]{0,19}$/.test(value);
                    });
                    $.validator.addMethod("emailRegex", function(value, element) {
                        return this.optional(element) || /^\w+[\w-\.]*\@\w+((-\w+)|(\w*))\.[a-z]{2,3}$/.test(value);
                    });
                });
            </script>
        </div>
    </div>
</body>

</html>