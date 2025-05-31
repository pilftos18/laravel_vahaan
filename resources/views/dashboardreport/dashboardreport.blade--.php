
@extends('layout')

@section('content')
<div id="main" class="main">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pagetitle">
                <h1>Module Activity Report</h1>
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
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.0/js/buttons.html5.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"/>
<link href='https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css' rel='stylesheet' type='text/css'>

    @if(session('data.userRole') == 'admin')
    <div class="row">
        <div class="col-md-3">
            <input type="text" id="date_from" class="form-control" placeholder="From Date" autocomplete="off" required>
        </div>
        <div class="col-md-3">
            <input type="text" id="date_to" class="form-control" placeholder="To Date" autocomplete="off" required>
        </div>
        <div class="col-md-3">
            <select id="org_admin" class="form-control select2-multiple" style="width: 100%;">
            </select>
        </div>
        <div class="col-md-3">
            <button id="filter_button" class="btn btn-primary">Filter</button>
            <button id="csv_export_button" class="btn btn-primary">Export CSV</button>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-md-3">
            <input type="text" id="date_from" class="form-control" placeholder="From Date" autocomplete="off" required>
        </div>
        <div class="col-md-3">
            <input type="text" id="date_to" class="form-control" placeholder="To Date" autocomplete="off" required>
        </div>
        <div class="col-md-3">
            <select id="org" class="form-control select2-multiple" style="width: 100%;">
                <!-- Add options if needed -->
                <option value="All" selected>Select All</option>
            </select>
        </div>

        <div class="col-md-3">
            <button id="filter_button" class="btn btn-primary">Filter</button>
            <button id="csv_export_button" class="btn btn-primary">Export CSV</button>
        </div>
    </div>
    @endif
    <hr>

    @if(session('data.userRole') == 'admin')
    <table class="table table-striped" id="user_table">
        <thead>
            <tr>
                <th>Sr.No</th>
                <th>Organization</th>
                <th>Username</th>
                <th>Module</th>
                <th>Request</th>
                <th>Status</th>
                <th>Timestamp</th>
            </tr>
        </thead>
    </table>
    @else
        <table class="table table-striped" id="user_table">
            <thead>
                <tr>
                    <th>Sr.No</th>
                    <th>Organization</th>
                    <th>Username</th>
                    <th>Vendor</th>
                    <th>Module</th>
                    <th>Request</th>
                    <th>Status</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
        </table>
    @endif
</div> 
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
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

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


    $.ajax({
        url: "{{ route('organizationadmin.names') }}",
        type: "POST", 
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content') 
        },
        success: function(data) {
            $('#org_admin').select2({
                data: [{ id: data, text: data }] // Assuming data is a single string value
            });
        },
        error: function(xhr, status, error) {
            console.error("Error fetching organization admin names:", error);
        }
    });

    $('#org_admin').select2({
    ajax: {
        url: "{{ route('organizationadmin.names') }}",
        type: "POST", 
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content') 
        },
        processResults: function(data) {
            return {
                results: [{ id: data, text: data }] // Assuming data is a single string value
            };
        },
        cache: true
    },
    minimumInputLength: 0,
    multiple: true 
});


    var table = $('#user_table').DataTable({
        processing: false,
        serverSide: false,
        ajax: {
            url: "{{ route('dashboardreport.list') }}",
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
            { data: 'organization', name: 'organization' },
            { data: 'username', name: 'username' },
            @if(session('data.userRole') != 'admin')
                    { data: 'vendor', name: 'vendor' },
            @endif
            { data: 'Module', name: 'Module' },
            { data: 'request', name: 'request' },
            { 
                data: 'response_status_code', 
                name: 'response_status_code',
                render: function (data, type, row) {
                    if (data == 200 || data == 201) {
                        return '<b class="text-success">Success</b>';
                    } else{
                        return '<b class="text-danger">Failed</b>';
                    }
                }
            },
            { data: 'timestamp', name: 'timestamp' },
        ]
    });

    $('#org').on('change', function() {
        var selectedValue = $(this).val();
        
        if (selectedValue != 'All') {   
        $("#org option:selected").removeAttr("selected");
        }
        else if(selectedValue == 'All') {
        $('#org option:selected').removeAttr('selected');
        }
    });

$("#filter_button").click(function () {
    var date_from = $("#date_from").val();
    var date_to = $("#date_to").val();
    var org = "{{ session('data.userRole') == 'admin' ? 'org_admin' : 'org' }}";
    var selectedOrg = $("#" + org).val();

    if (date_from == '') {
        alert('Please select from date');
        return false;
    } else if (date_to == '') {
        alert('Please select to date');
        return false;
    } else if (selectedOrg == '') {
        alert('Please select organization name');
        return false;
    } else {
        $.ajax({
            url: "{{ route('dashboardreport.list') }}",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken
            },
            data: {
                date_from: date_from,
                date_to: date_to,
                org: selectedOrg
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
                        '<th>Sr.No</th>' +
                        '<th>organization</th>'+
                        '<th>username</th>';
                    // Conditionally add the "Vendor" column based on user role
                    @if(session('data.userRole') != 'admin')
                        tableHeaders += '<th>Vendor</th>';
                    @endif

                    tableHeaders += '<th>Module</th>' +
                        '<th>Request</th>' +
                        '<th>Status</th>' +
                        '<th>timestamp</th>' +
                        '</tr></thead>';

                    $('#user_table').append(tableHeaders); 
                    var tbody = '<tbody>';
                    data.forEach(function (rowData, index) {
                        var row = '<tr>';
                        row += '<td>' + (index + 1) + '</td>';

                        @if(session('data.userRole') === 'super_admin')

                        for (var i = 0; i < columnNames.length; i++) {
                            var columnName = columnNames[i];
                            if (columnName === 'response_status_code') {
                                // Apply custom rendering for 'response_status_code' column
                                var cellData = rowData[columnName];
                                if (cellData == 200 || cellData == 201) {
                                    row += '<td><b class="text-success">Success</b></td>';
                                } else {
                                    row += '<td><b class="text-danger">Failed</b></td>';
                                }
                            }
                            else {
                                row += '<td>' + rowData[columnName] + '</td>';
                            }
                        }

                        @else 
                        
                        for (var i = 0; i < columnNames.length; i++) {
                            var columnName = columnNames[i];
                            if (columnName === 'response_status_code') {
                                // Apply custom rendering for 'response_status_code' column
                                var cellData = rowData[columnName];
                                if (cellData == 200 || cellData == 201) {
                                    row += '<td><b class="text-success">Success</b></td>';
                                } else {
                                    row += '<td><b class="text-danger">Failed</b></td>';
                                }
                            } else if (columnName === 'vendor') {
                                // Skip adding the column if the user role is admin
                                @if(session('data.userRole') === 'admin')
                                continue;
                                @endif
                            } else {
                                row += '<td>' + rowData[columnName] + '</td>';
                            }
                        }
                        @endif

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

    /////////////////////////////////

    $("#csv_export_button").click(function () {

        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var date_from = $("#date_from").val();
        var date_to = $("#date_to").val();
        var org = "{{ session('data.userRole') == 'admin' ? 'org_admin' : 'org' }}";
        var selectedOrg = $("#" + org).val();

        if (date_from == '') {
            alert('Please select from date');
            return false;
        } else if (date_to == '') {
            alert('Please select to date');
            return false;
        } else if (selectedOrg == '') {
            alert('Please select organization name');
            return false;
        } else {

            $.ajax({
                    url: "{{ route('dashboardreport.csv') }}",
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken
                    },
                    data: {
                    date_from: date_from,
                    date_to: date_to,
                    org: selectedOrg
                    },
                    success: function (response) {
                        //console.log(response);
                        if (response.download) {
            // Create a temporary <a> element to trigger the file download
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
    @endsection
