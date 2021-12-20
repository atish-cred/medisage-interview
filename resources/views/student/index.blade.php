<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap 5 Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- <link href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet"> -->
    <!-- <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script> -->

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

    <!-- <script src="{{ asset('public/js/common.js') }}" defer></script> -->
</head>

<body>
    <div class="container-fluid p-5 bg-primary text-white text-center">
        <h1>Student Listing Page</h1>
        <p>Resize this responsive page to see the effect!</p>
    </div>

    <div class="container mt-5">
        <div class="row">
            <form action="{{url('/')}}" method="get" name="frmFilter1" id="frmFilter1">
                <div class="col-lg-12 form-group row">
                    <div class="col-lg-3 ">
                        <label class="">Name</label>
                        <input type="text" name="search" class="form-control form-control-sm" value="{{$search}}" id="name" />
                    </div>

                    <div class="col-lg-3">
                        <label class="">&nbsp;</label> <br>
                        <input type="submit" id="submitButton" class="btn btn-sm btn-success" value="Search">
                        <a href="student/add" id="addBtn" class="btn btn-sm btn-info pl-5 pr-5" >Add New Student</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive mt-5"> 
                <table class="table table-bordered " id="dataTable11">
                    <thead class="table-primary">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <?php if(!empty($students) && $students->count() > 0){ ?>
                        <tbody>
                            <?php foreach($students as $key => $item){ ?>
                                <tr>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->phone_number}}</td>
                                    <td>
                                        <a href="add/{{$item->id}}" class="btn btn-sm btn-success" title="Edit">Edit</a>
                                        <a type="button" class="btn btn-sm btn-danger text-white" onclick="confirmDelete('{{$item->id}}')">Delete</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    <?php } ?>
                </table>
                
                <?php if(!empty($students) && $students->count() > 0){ ?>
                    <div class="d-flex justify-content-center">
                        <div class="col-12">
                            {{ $students->links(); }}
                        </div>
                    </div>

                <?php } ?>
            </div>
        </div>
    </div>
</body>

<script type="text/javascript">
    jQuery(document).ready(function() {
       
    });

    function confirmDelete(id) {
        if (!confirm("Do you want to delete")){
            return false;
        }
        // $('#submitbutton').attr('disabled', false);
        var queryString = {id:id};

        $.get('student/delete/'+id, queryString, function (data) {
            window.location.href = "student";
        });
        return false;
    }
</script>

</html>
