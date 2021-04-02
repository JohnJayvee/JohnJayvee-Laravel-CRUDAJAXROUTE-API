<!DOCTYPE html>
<html>

<head>
    <title>Laravel 8 Crud operation using ajax(Real Programmer)</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <h1>Laravel 8 Crud with Ajax</h1>
        <a class="btn btn-success" href="javascript:void(0)" id="createNewUser"> Create New User</a>
        <span id="success_message"></span>

        <table class="table table-bordered data-table" style="width: 100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>FirstName</th>
                    <th>LastName</th>
                    <th width="300px">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

    </div>
    {{-- edit modal --}}
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="userForm" name="userForm" class="form-horizontal">
                        <input type="hidden" name="user_id" id="user_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Firstname</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="firstName" name="firstName"
                                    placeholder="Enter Title" value="" maxlength="50" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Lastname</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="lastName" name="lastName"
                                    placeholder="Enter Title" value="" maxlength="50" required="">
                                {{-- <textarea id="lastName" name="lastName" required="" placeholder="Enter Author"
                                    class="form-control"></textarea> --}}
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>









    {{-- show modal --}}

    <div class="modal fade ajaxShowModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <table class="table table-user-information">
                        <tr>
                            <td>Firstname</td>
                            <td class="firstName"></td>
                        </tr>

                        <tr>
                            <td>Lastname: </td>
                            <td class="lastName"></td>
                        </tr>
                    </table>

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Close
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ url('users') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'firstName',
                        name: 'firstName'
                    },
                    {
                        data: 'lastName',
                        name: 'lastName'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
            // setInterval(function() {
            //     table.draw();
            // }, 500);



            $('#createNewUser').click(function() {
                $('#saveBtn').val("create-user");
                $('#user_id').val('');
                $('#userForm').trigger("reset");
                $('#modelHeading').html("Create New User");
                $('#ajaxModel').modal('show');
            });
            // Edit function
            $('body').on('click', '.editUser', function() {
                var user_id = $(this).data('id');
                $.get("{{ url('users') }}" + '/' + user_id + '/edit', function(data) {
                    $('#modelHeading').html("Edit User");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#user_id').val(data.id);
                    $('#firstName').val(data.firstName);
                    $('#lastName').val(data.lastName);
                })
            });
            // show
            $('body').on('click', '.showUser', function() {
                var user_id = $(this).data('id');
                $.get("{{ url('users') }}" + '/' + user_id, function(data) {
                    $('.modelHeading').html("Show User");
                    $('.ajaxShowModel').modal('show');
                    $(".btn").click(function() {
                        $(".ajaxShowModel").modal('hide');
                    });
                    $('.firstName').text(data.firstName);
                    $('.lastName').text(data.lastName);
                    console.log(data.lastName);
                })
            });
            $('#saveBtn').click(function(e) {
                e.preventDefault();
                $(this).html('Save');

                $.ajax({
                    data: $('#userForm').serialize(),
                    url: "{{ url('/users/store/') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {

                        $('#userForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        console.log('Success:', data);
                        table.draw();

                    },
                    error: function(data) {
                        console.log('Error:', data);
                        $('#saveBtn').html('Save Changes');
                    }
                });
            });

            // Delete function
            $('body').on('click', '.deleteUser', function() {
                var user_id = $(this).data("id");
                var token = $("meta[name='csrf-token']").attr("content");


                if (confirm("Are You sure want to delete !")) {
                    $.ajax({
                        url: "{{ url('users') }}" + "/" + user_id,
                        type: "DELETE",
                        error: function() {
                            console.log('Error:', data);
                            table.draw();
                        },
                        success: function(data) {
                            console.log('Success:', data);
                            table.draw();
                        }

                    });
                }
            });
        });

    </script>
</body>

</html>
