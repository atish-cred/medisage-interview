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

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

    <script src="{{ asset('public/js/common.js') }}" defer></script>
</head>

<body>
    <div class="container-fluid p-5 bg-primary text-white text-center">
        <h1>Student Listing Page</h1>
        <p>Resize this responsive page to see the effect!</p>
    </div>

    <div class="container mt-5">
        <div class="row">
            <form class="kt-form kt-form--label-right" action="" method="get" name="frmFilter" id="frmFilter">
                <div class="col-lg-12 form-group row">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <label class="">Name</label>
                        <input type="text" name="name" class="form-control form-control-sm" id="name" />
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <label class="">Email</label>
                        <input type="text" name="email" class="form-control form-control-sm" id="email" />
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <label class="">Phone Number</label>
                        <input type="text" name="phone_number" class="form-control form-control-sm" id="phone_number" />
                    </div>

                    <div class="col-auto kt-align-center">
                        <label class="">&nbsp;</label> <br>
                        <input type="button" name="btn_filter_apply" id="btn_filter_apply" class="btn btn-sm btn-info" value="Search">
                        <a href="student/add" id="addBtn" class="btn btn-sm btn-success pl-5 pr-5" >Add New Student</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive-sm table-responsive-md table-responsive mt-5"> 
                <table class="table table-striped table-bordered table-hover table-checkable" id="dataTable">
                    <thead>
                        <tr>
                            @php $columns = array('Name', 'Email', 'Phone Number'); @endphp
                            @foreach($columns as $column)
                            <th>{{$column}}</th>
                            @endforeach
                            <th class="action-width">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</body>

<script type="text/javascript">
    jQuery(document).ready(function() {
        var table = $('#dataTable').DataTable({
            bFilter: false,
            processing: true,
            serverSide: true,
            ajax: 'student/grid?status=Active',
            columnDefs: [{
                    "render": function(data, type, row) {
                        return '<a href="student/add/' + row[3] + '" class="btn btn-sm btn-success" title="Edit">\
                                <i class="fa fa-edit p-0"></i> Edit\
                            </a>\
                           <a type="button" class="btn btn-sm btn-danger text-white" title="Copy" onclick="confirmDelete(' + row[3] + ')">\
                                 <i class="fa fa-trash p-0"></i> Delete\
                             </a>';
                    },
                    "targets": 3
                },
                {
                    "orderable": false,
                    "targets": [3]
                },
                {
                    "searchable": false,
                    "targets": [1, 2, 3]
                },
            ]
        });

        $("#btn_filter_apply").click(function() {
            var table = $('#dataTable').dataTable();
            var passData = "?" + $("#frmFilter").serialize();
            table.fnReloadAjax("student/grid" + passData);
            return false;
        });
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
