

@extends('layout')

@section('content')
<div id="main" class="main">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pagetitle">
                <h1>Reports</h1>
            </div>
        </div>
    </div>

    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
    {{-- @if(session('data.userRole') == 'user')

    @endif
    @if(session('data.userRole') == 'super_admin') --}}
    <!-- /.row -->
    <div class="row">
        <div class="col-md-3">
            <input type="text" id="date_from" class="form-control" placeholder="From Date" required>
        </div>
        <div class="col-md-3">
            <input type="text" id="date_to" class="form-control" placeholder="To Date" required>
        </div>
        <div class="col-md-3">
            <select id="org" class="form-control select2-multiple" style="width: 100%;">
                <!-- Add options if needed -->
                <option value="All" selected>Select All</option>
            </select>
        </div>

        <div class="col-md-3">
            <button id="filter_button" class="btn btn-primary">Filter</button>
            <button id="csv_export_button" class="btn btn-primary float-right">Export CSV</button>
        </div>
    </div>
    <hr>
    <div class="table-responsive">
        <table class="table table-striped" id="user_table">
            <thead>
                <tr>
                    <th>Sr.</th>
                    <th>Org_name</th>
                    <th>User_Name</th>
                    <th>Role</th>
                    <th>Ip_Address</th>
                    <th>Login_status</th>
                    <th>Login_time</th>
                    <th>Logout_time</th>
                </tr>
            </thead>
        </table>
    </div>

    {{-- @endif --}}
</div>

<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.0/js/buttons.html5.min.js"></script>

<script>
$(document).ready(function(){

            $('.select2-multiple').select2({
            placeholder: "Select",
            allowClear: true
        });

        var today = new Date();

        $('#date_from').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            maxDate: today,
            changeMonth: true,
            changeYear: true,
        });

        $('#date_to').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            maxDate: today,
            changeMonth: true,
            changeYear: true,
        });  

            // Get the CSRF token value from the meta tag
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $('#org').on('change', function() {
        var selectedValue = $(this).val();
        
        if (selectedValue != 'All') {   
        $("#org option:selected").removeAttr("selected");
        }
        else if(selectedValue == 'All') {
        $('#org option:selected').removeAttr('selected');
        }
    });

    $('#org').select2({
        ajax: {
            url: "{{ route('organization.names') }}",
            type: "POST", 
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content') 
            },
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        },
    minimumInputLength: 0,
    multiple: true 
    });

    $.ajax({
    url: "{{ route('organization.names') }}",
    type: "POST", 
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content') 
    },
    success: function(data) {
        $('#org').select2({
            data: data
        });
        }
    });

    // Add the "buttons" option for downloading
    $('#user_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('report.list') }}",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken // Include the CSRF token in the headers
            }
        },
        columns: [
            { 
                data: 'id',
                render: function (data, type, row, meta) {
                    // Calculate the serial number using the row index
                    var srNo = meta.row + 1;

                    return srNo;
                },
                orderable: false,
                searchable: false
            },
            { data: 'client_name', name: 'client_name' },
            { data: 'user_name', name: 'user_name' },
            { data: 'role', name: 'role' },
            { data: 'ip_address', name: 'ip_address' },
            // { data: 'login_status', name: 'login_status' },
            { 
                    data: 'login_status',
                    name: 'login_status',
                    render: function(data, type, row) {
                        if (data == 1) {
                            return "Login";
                        } else if (data == 2) {
                            return "Logout";
                        } else {
                            return "";
                        }
                    }
            },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' }
        ],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print' // Add the buttons you want to enable
        ],
        createdRow: function(row, data, dataIndex) {
        var loginStatus = data.login_status;
        if (loginStatus == 1) {
            $(row).find('td:nth-child(7)').hide();
        }
    }
    });


    $("#filter_button").click(function () {
    var date_from = $("#date_from").val();
    var date_to = $("#date_to").val();
    var org = $("#org").val();

    if (date_from == '') {
        alert('Please select from date');
        return false;
    } else if (date_to == '') {
        alert('Please select to date');
        return false;
    } else if (org == '') {
        alert('Please select organization name');
        return false;
    } else {
        $.ajax({
            url: "{{ route('report.list') }}",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken
            },
            data: {
                date_from: date_from,
                date_to: date_to,
                org: org
            },
            success: function (response) {
                var dataTable = $('#user_table').DataTable();
                dataTable.clear().draw(); 
                var data = response.data;
                if (data == null || data[0] == null) {
                    // Handle case where data is empty
                } else { 
                    // console.log(response);
                    // console.log(data);
                    dataTable.clear().destroy(); 
                    $('#user_table').empty(); 
                    var columnNames = Object.keys(data[0]); 
                    
                    var tableHeaders = '<thead><tr>' +
                        '<th>Sr.</th>' +
                        '<th>Org_name</th>' +
                        '<th>User_Name</th>' +
                        '<th>Role</th>' +
                        '<th>Ip_Address</th>' +
                        '<th>Login_status</th>' +
                        '<th>Login_time</th>' +
                        '<th>Logout_time</th>' +
                        '</tr></thead>';

                    $('#user_table').append(tableHeaders); 
                    var tbody = '<tbody>';
                    data.forEach(function (rowData, index) {
                        var row = '<tr>';
                        row += '<td>' + (index + 1) + '</td>';

                        for (var i = 0; i < columnNames.length; i++) {
                            var columnName = columnNames[i];
                            if (columnName === 'Login_status') {
                                // Apply custom rendering for 'response_status_code' column
                                var cellData = rowData[columnName];
                                if (cellData == 2) {
                                    row += '<td>Logout</td>';
                                } else {
                                    row += '<td>Login</td>';
                                }
                            }
                            else {
                                row += '<td>' + rowData[columnName] + '</td>';
                            }
                        }
                        
                        row += '</tr>';
                        tbody += row;
                    });

                    tbody += '</tbody>';
                    $('#user_table').append(tbody);
                    dataTable = $('#user_table').DataTable(); // Initialize DataTable after modifying the table content
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr);
            }
        });
    }
});



    $("#csv_export_button").click(function () {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var date_from = $("#date_from").val();
        var date_to = $("#date_to").val();
        var org = $("#org").val();

         if (date_from == '') {
            alert('Please select from date');
            return false;
        } else if (date_to == '') {
            alert('Please select to date');
            return false;
        } else if (org == '') {
            alert('Please select organization name');
            return false;
        } else {
            $.ajax({
                url: "{{ route('loginActivity.csv') }}",
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken
                },
                data: {
                date_from: date_from,
                date_to: date_to,
                org: org
                },
                success: function (response) {
                    console.log(response);
                    if (response.download) {
                    var link = document.createElement('a');
                    link.href = response.file_url;
                    link.download = response.file_name;
                    link.style.display = 'none';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr);
                }
            });
        }
    });
});
    </script>
<!-- /#page-wrapper -->
    <!-- Your home page content goes here -->
    @endsection
