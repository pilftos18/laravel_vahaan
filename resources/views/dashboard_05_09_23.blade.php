
@extends('layout')

@section('content')
<div id="main" class="main">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pagetitle">
                <h1>Dashboard</h1>
            </div>
        </div>
    </div>

    @if(session('data.userRole') == 'user')
		
	<?php
	
	//echo "maxCount:".$maxCount.", successCount:".$successCount.", utliziedCount:".$utliziedCount;die;
	?>

    <div class="row servicesbox-set">
        <div class="col-lg-3 col-md-6">
            <div class="serviceBox">
                <div class="service-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="19" viewBox="0 0 24 19" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M1 3.43093V15.5856C1 16.9282 2.08837 18.0165 3.43093 18.0165H20.4475C21.7901 18.0165 22.8784 16.9282 22.8784 15.5856V3.43093C22.8784 2.08837 21.7901 1 20.4475 1H3.43093C2.08837 1 1 2.08837 1 3.43093Z" stroke="#1D4487" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M15.5856 7.07715H19.232" stroke="#1D4487" stroke-linecap="round"/>
                    <path d="M15.5856 10.7236H19.232" stroke="#1D4487" stroke-linecap="round"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.7238 7.07693C10.7238 8.41953 9.63548 9.50786 8.29287 9.50786C6.9503 9.50786 5.86194 8.41953 5.86194 7.07693C5.86194 5.73436 6.9503 4.646 8.29287 4.646C8.93756 4.646 9.55586 4.90211 10.0118 5.358C10.4677 5.81389 10.7238 6.43221 10.7238 7.07693Z" stroke="#1D4487" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M3.43091 14.3698C6.81355 10.5569 10.7869 11.7554 13.1546 14.3698" stroke="#1D4487" stroke-linecap="round"/>
                    </svg>
                </div>
                <div>
                    <h3 class="description">Available Credits</h3>
                    <div data-target='{{$maxCount}}' class="title count">{{$maxCount}}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="serviceBox">
                <div class="service-icon">
                    <i class="fa fa-sitemap"></i>
                </div>
                <div>
                    <div class="description">Utilized Credits</div>
                    <div data-target="{{$utliziedCount}}" class="title count">{{$utliziedCount}}</div>
                </div>
            </div>
        </div>
       
        <div class="col-lg-3 col-md-6">
            <div class="serviceBox">
                <div class="service-icon">
                    <i class="fa fa-hand-pointer-o"></i>
                </div>
                <div>
                    <div class="description">Success Hit</div>
                    <div data-target="{{$successCount}}" class="title count">{{$successCount}}</div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="serviceBox">
                <div class="service-icon">
                    <i class="fa fa-user"></i>
                </div>
                <div>
                    <div class="description">Failed Hit</div>
                    <div data-target="{{$failcount}}" class="title count">{{$failcount}}</div>
                </div>
                
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped" id="user_table">
            <thead>
                <tr>
                    <th>Sr.No</th>
                    <th>Module</th>
                    <th>Input</th>
                    <th>Status</th>
                    <th>Activity On</th>
                </tr>
            </thead>
        </table>
    </div>


    @endif 

    @if(session('data.userRole') == 'admin')

    <div class="row servicesbox-set">
        <div class="col-lg-3 col-md-6">
            <div class="serviceBox">
                <div class="service-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="19" viewBox="0 0 24 19" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M1 3.43093V15.5856C1 16.9282 2.08837 18.0165 3.43093 18.0165H20.4475C21.7901 18.0165 22.8784 16.9282 22.8784 15.5856V3.43093C22.8784 2.08837 21.7901 1 20.4475 1H3.43093C2.08837 1 1 2.08837 1 3.43093Z" stroke="#1D4487" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M15.5856 7.07715H19.232" stroke="#1D4487" stroke-linecap="round"/>
                    <path d="M15.5856 10.7236H19.232" stroke="#1D4487" stroke-linecap="round"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.7238 7.07693C10.7238 8.41953 9.63548 9.50786 8.29287 9.50786C6.9503 9.50786 5.86194 8.41953 5.86194 7.07693C5.86194 5.73436 6.9503 4.646 8.29287 4.646C8.93756 4.646 9.55586 4.90211 10.0118 5.358C10.4677 5.81389 10.7238 6.43221 10.7238 7.07693Z" stroke="#1D4487" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M3.43091 14.3698C6.81355 10.5569 10.7869 11.7554 13.1546 14.3698" stroke="#1D4487" stroke-linecap="round"/>
                    </svg>
                </div>
                <div>
                    <h3 class="description">Available Credits</h3>
                    <div data-target='{{$maxCount}}' class="title count"><?php echo $maxCount;?> </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="serviceBox">
                <div class="service-icon">
                    <i class="fa fa-sitemap"></i>
                </div>
                <div>
                    <div class="description">Utilized Credits</div>
                    <div data-target="{{$utliziedCount}}" class="title count">{{$utliziedCount}}</div>
                </div>
            </div>
        </div>
       
        <div class="col-lg-3 col-md-6">
            <div class="serviceBox">
                <div class="service-icon">
                    <i class="fa fa-hand-pointer-o"></i>
                </div>
                <div>
                    <div class="description">Success Hit</div>
                    <div data-target="{{$successCount}}" class="title count">{{$successCount}}</div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="serviceBox">
                <div class="service-icon">
                    <i class="fa fa-user"></i>
                </div>
                <div>
                    <div class="description">Failed Hit</div>
                    <div data-target="{{$failcount}}" class="title count">{{$failcount}}</div>
                </div>
                
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped" id="admin_table">
            <thead>
                <tr>
                    <th>Sr.No</th>
                    <th>Name</th>
                    <th>Total Hits</th>
                    <th>Success Hits</th>
                    <th>Failed Hits</th>
                    <th>Status</th>
                </tr>
            </thead>
        </table>
    </div>


    @endif

    @if(session('data.userRole') == 'super_admin')
    <!-- /.row -->
    <div class="row servicesbox-set">
        <div class="col-lg-3 col-md-6">
            <div class="serviceBox">
                <div class="service-icon">
                    <i class="fa fa-users"></i>
                </div>
                <div>
                    <div class="description">Organization</div>
                    <div data-target="{{$companyCount}}" class="title count">{{$companyCount}}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="serviceBox">
                <div class="service-icon">
                    <i class="fa fa-hand-pointer-o"></i>
                </div>
                <div>
                    <div class="description">Total Hit</div>
                    <div data-target="{{$sum}}" class="title count">{{$sum}}</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="serviceBox">
                <div class="service-icon">
                    <i class="fa fa-sitemap"></i>
                </div>
                <div>
                    <div class="description">Success Hits</div>
                    <h3 data-target="{{$successCounts[0]['count']}}" class="title count">{{$successCounts[0]['count']}}</h3>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="serviceBox">
                <div class="service-icon">
                    <i class="fa fa-user"></i>
                </div>
                <div>
                    <div class="description">Failed Hits</div>
                    <div data-target="{{$failCounts[0]['count']}}" class="title count">{{$failCounts[0]['count']}}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped" id="superadmin_table">
            <thead>
                <tr>
                    <th>Sr.No</th>
                    <th>Organization</th>
                    <th>Available Credits</th>
                    <th>Utilized Credit</th>
                    <th>Success Hit</th>
                    <th>Failed Hit</th>
                    <th>Status</th>
                </tr>
            </thead>
        </table>
    </div>

    @endif
    
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    $(document).ready(function(){

        // Get the CSRF token value from the meta tag
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Add the "buttons" option for downloading
        $('#superadmin_table').DataTable({
            processing: false,
            serverSide: true,
            ajax: {
                url: "{{ route('dashboard.list') }}",
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
                { data: 'max_count', name: 'max_count' },
                {
                    data: 'utilized_count',
                    name: 'utilized_count',
                    render: function (data, type, row) {
                        var clientName = row.client_name;
                        var count = 0;

                        for (var i = 0; i < data.length; i++) {
                            if (data[i].client_name === clientName) {
                                count = data[i].utilized_count;
                                break;
                            }
                        }

                        return count;
                    }
                },

                { 
                    data: 'successCounts', 
                    name: 'successCounts',
                    render: function (data, type, row) {
                        var clientName = row.client_name;
                        var count = 0;

                        // Iterate over the successCounts array to find the matching count value
                        for (var i = 0; i < data.length; i++) {
                            if (data[i].client_name === clientName) {
                                count = data[i].count;
                                break;
                            }
                        }

                        return count;
                    }
                },
                { 
                    data: 'failcounts', 
                    name: 'failcounts',
                    render: function (data, type, row) {
                        var clientName = row.client_name;
                        var count = 0;

                        // Iterate over the failCounts array to find the matching count value
                        for (var i = 0; i < data.length; i++) {
                            if (data[i].client_name === clientName) {
                                count = data[i].count;
                                break;
                            }
                        }

                        return count;
                    }
                },
                { 
                    data: 'status', 
                    name: 'status',
                    render: function (data, type, row) {
                        if (data == 0 || data == 1) {
                            return '<b class="text-success">Active</b>';
                        } else{
                            return '<b class="text-danger">Inactive</b>';
                        }
                    }
                },
                        //{ data: 'response_status_code', name: 'response_status_code' }
                ],
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print' // Add the buttons you want to enable
                ]
        });

        $('#admin_table').DataTable({
            processing: false,
            serverSide: true,
            ajax: {
                url: "{{ route('userdashboard.list') }}",
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
                { data: 'username', name: 'username' },
                { data: 'total_count', name: 'total_count' },
                { data: 'success_count', name: 'success_count' },
                { data: 'fail_count', name: 'fail_count' },
                { 
                    data: 'status', 
                    name: 'status',
                    render: function (data, type, row) {
                        if (data == 0 || data == 1) {
                            return '<b class="text-success">Active</b>';
                        } else{
                            return '<b class="text-danger">Inactive</b>';
                        }
                    }
                },
                ],
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print' // Add the buttons you want to enable
                ]
        });

        $('#user_table').DataTable({
            processing: false,
            serverSide: true,
            ajax: {
                url: "{{ route('userdashboard.list') }}",
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
                { data: 'api_name', name: 'api_name' },
                { data: 'input', name: 'input' },
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
                { data: 'created_at', name: 'created_at' }
                ],
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print' // Add the buttons you want to enable
                ]
        });

    });
</script>
<!-- counter  -->
<script>
		// const counters = document.querySelectorAll(".count");

		// counters.forEach(counter => {
			// counter.innerText = '0'
			// const target = +counter.getAttribute('data-target');
			// const interval = target / 130;

			// const updateCounter = () => {
				// const value = +counter.innerText;
				// if (value < target) {
					// counter.innerText = Math.ceil(value + interval);

					// setTimeout(() => {
						// updateCounter()
					// }, 20);
				// }
			// }

			// updateCounter();

		// });

	</script>
<!-- /#page-wrapper -->
    <!-- Your home page content goes here -->
    @endsection
