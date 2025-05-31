@extends('layout')

@section('content')
<style>
    /* input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        } */
        
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
    table {
        border-collapse: collapse;
        width: 100%;
    }
    
    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    
    th {
        background-color: #f2f2f2;
    }
    .re_details{
        
    }

    .loader {
      border: 16px solid #f3f3f3; /* Light grey */
      border-top: 16px solid #3498db; /* Blue */
      border-radius: 50%;
      width: 120px;
      height: 120px;
      animation: spin 2s linear infinite;
      margin: 50px auto;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
	/* input[type=text]{
		text-transform:uppercase;
	} */
	.downloadPDF{color: #b30b00; font-size: 16px;}
	.downloadPDF:hover{color: #ffce00;}
</style>
<!-- Main container -->
<div id="main" class="main">
    <div class="row">
        <div class="pagetitle">
            <h1>RC Details</h1>
        </div>
    </div>

    <div id="validate" style="color:red;"></div>
    <div class="row g-3">
        <div class="col-lg-3">
            <input type="text" id="vehicleNoInput" placeholder="" class="form-control capitalized-text text-uppercase" required>
            <label class="form-element-label" for="vehicleNoInput">Vehicle Number</label>
        </div>
        <div class="col-lg-auto">
            <button id="submitBtn" class="btn btn-primary">Submit</button>
        </div>
        <div class="col-lg-auto error-message">
            
        </div>
    </div>
	
    <div class="searched-details " style="display:none;">
		<div class="d-flex  align-items-center mb-2">
            <h2 class="card-title me-auto" style="margin-top: 15px;"></h2>
			<a href="#" class="downloadPDF ms-auto pb-2" id="downloadPDF" data-content="" style="color:#a50101; border:1px solid; border-radius:20px; padding:5px 15px;"><i class="bi bi-file-pdf-fill"></i> Download </a>
            {{-- <a href="#" id="downloadPDF" data-content="" style="display:none;color:#a50101; border:1px solid; border-radius:20px; padding:5px 15px;"><i class="bi bi-file-pdf-fill"></i> Download </a> --}}
		</div>
        <div class="accordion" id="accordionExample">
    {{-- <div class="searched-details " style="display:none;">
		<div class="d-flex">

            <a href="#" class="downloadPDF ms-auto pb-2" id="downloadPDF" data-content="" style="color:#a50101; border:1px solid; border-radius:20px; padding:5px 15px;"><i class="bi bi-file-pdf-fill"></i> Download </a>
		</div>
        <div class="accordion" id="accordionExample"> --}}

{{-- 

            <div class="row">
                <div class="col-md-8">
                    <div class="table-heading">
                        <h3>Vehicle Details</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless table-striped dataTable no-footer nodata-table">
                            <tbody>
                                <tr>
                                    <th width="30%">Reg No</th>
                                    <td>MH47U0571</td>
                                    <th>Class</th>
                                    <td>M-Cycle/Scooter</td>
                                </tr>
                                <tr>
                                    <th>Chassis</th>
                                    <td>ME4JF509BHU186130</td>
                                    <th>Engine</th>
                                    <td>JF50EU6186185</td>
                                </tr>
                             
                                <tr>
                                    <th>Vehicle Manufacturer Name</th>
                                    <td>HONDA CARS INDIA LTD</td>
                                    <th>Vehicle Number</th>
                                    <td>MH47U0571</td>
                                </tr>
                                
                                <tr>
                                    <th>Status As On</th>
                                    <td>04/08/2023</td>
                                    <th>Type</th>
                                    <td>PETROL</td>
                                </tr>
                             
                                <tr>
                                    <th>Unladen Weight</th>
                                    <td>112</td>
                                    <th>Vehicle Category</th>
                                    <td>2WN</td>
                                </tr>
                               
                                <tr>
                                    <th>Vehicle Colour</th>
                                    <td>T BLUE-M</td>
                                    <th>Vehicle Cubic Capacity</th>
                                    <td>109</td>
                                </tr>
                            
                                <tr>
                                    <th>Vehicle Cylinders No</th>
                                    <td>1</td>
                                    <th>Vehicle Insurance Company Name</th>
                                    <td>ACKO GENERAL INSURANCE LIMITED</td>
                                </tr>
                           
                                <tr>
                                    <th>Vehicle Insurance Policy Number</th>
                                    <td>DBTR00404995486/00</td>
                                    <th>Vehicle Insurance Upto</th>
                                    <td>01/07/2024</td>
                                </tr>
                              
                                <tr>
                                    <th>Vehicle Manufacturing Month/Year</th>
                                    <td>02/2017</td>
                                    <th>Vehicle Seat Capacity</th>
                                    <td>2</td>
                                </tr>
                             
                                <tr>
                                    <th>Vehicle Sleeper Capacity</th>
                                    <td></td>
                                    <th>Vehicle Standing Capacity</th>
                                    <td></td>
                                </tr>
                            
                                <tr>
                                    <th>Vehicle Tax Upto</th>
                                    <td>LTT</td>
                                    <th>Wheelbase</th>
                                    <td></td>
                                </tr>
                            
                                <tr>
                                    <th>RC Expiry Date</th>
                                    <td>17/03/2032</td>
                                    <th>RC Financer</th>
                                    <td></td>
                                </tr>
                             
                                <tr>
                                    <th>RC Standard Cap</th>
                                    <td></td>
                                    <th>Reg Authority</th>
                                    <td>DY.R.T.O.BORIVALI</td>
                                </tr>
                         
                                <tr>
                                    <th>Reg Date</th>
                                    <td>18/03/2017</td>
                                    <th>Reg Date</th>
                                    <td>18/03/2017</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div> 

                <div class="col-md-4">
                    <div class="table-heading">
                        <h3>Personal Details</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless table-striped dataTable no-footer nodata-table">
                            <tbody>
                                <tr>
                                    <th width="30%">Owner</th>
                                    <td>KRUNAL D WANKHEDE</td>
                                </tr>
                                <tr>
                                    <th>Owner Father Name</th>
                                    <td>.</td>
                                </tr>
                                <tr>
                                    <th>Mobile Number</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>NA</td>
                                </tr>
                                <tr>
                                    <th>Status As On</th>
                                    <td>04/08/2023</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-heading">
                        <h3>Address Details</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless table-striped dataTable no-footer nodata-table">
                            <tbody>
                                <tr>
                                    <th width="30%">Address Line</th>
                                    <td>RM NO 5 SAI PRASAD CHAWL,DAMU NAGAR AKURLI ROAD,KANDIVALI EAST</td>
                                </tr>
                                <tr>
                                    <th>City</th>
                                    <td>MUMBAI</td>
                                </tr>
                                <tr>
                                    <th>Pincode</th>
                                    <td>400101</td>
                                </tr>
                                <tr>
                                    <th>District</th>
                                    <td>MUMBAI</td>
                                </tr>
                                <tr>
                                    <th>State</th>
                                    <td>MAHARASHTRA</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>  --}}
            <div class="row">
                <!-- <div class="col-md-6">
                        <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Vehicle Details
                        </button>
                        </h2>

                        <div id="collapseOne" >
                            <div class="accordion-body">
                                <div class="table-heading">
                                    <h3>Vehicle Details</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-borderless table-striped dataTable no-footer nodata-table">
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-bg-colored">
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div> -->



                <!-- <div class="col-md-6">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Personal Details
                        </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="accordion-item">
                        <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Address Details
                        </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="table-responsive">
                                    <table class="table table-bg-colored">
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->




            </div>

        </div>
    </div>
    
    {{-- <div class="re_details searched-details"></div> --}}
    
    <div class="row no-data g-3">
        <div class="col-lg-12">
            <div>
                <div class="no-data-content" id="noDataFound">
                    <h4 >No Data Found</h4>
                    <p>Searched vehicle detail will be displayed here. <br> To search enter vehicle number</p>
                </div>
                <img src="assets/img/error-image.svg" alt="searching-data">
            </div>
        </div>
    </div>
   
    <!-- //Filters -->
    <!-- <div class="loader" style="display: none;"></div> -->
    <div id="loader" class="loader-wrapper">
        <div class="loader-container">
            <div class="loader-box">
                <div class="ring"></div>
                <div class="ring"></div>
                <div class="ring"></div>
                <div class="ring"></div>
                <div class="loading-logo">
                    <img src="{{asset('assets/img/edas-logo-light.png')}}" alt="Edas Logo">
                </div>
            </div>
        </div>
    </div>
    
    
</div>

<!-- //Main container -->
<script src="{{asset('assets/js/moment.min.js')}}"></script>
<script>
    $(document).ready(function() {
		
		
        $('#submitBtn').click(function() {
            var vehicleNo = $('#vehicleNoInput').val().toUpperCase().trim();
            var isValidVehicleNumber = validateVehicleNumber(vehicleNo);
            if(isValidVehicleNumber === true && isValidVehicleNumber != '')
            {
                // Show loader
                var loader = document.getElementById('loader');
                loader.style.display = 'block';
                $(".re_details").css('display','none');

                $('#validate').html();

                 // Get the CSRF token value from the meta tag
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    // Add the CSRF token to the AJAX request headers
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
                });
                // Make the Ajax request
                $.ajax({
                    url: "{{ route('rc.rcPostData') }}", // Path to controller through routes/web.php
                    type: 'POST',
                    data: { vehicleNo: vehicleNo },
                    dataType: 'json',
                    success: function(response) {
                        // console.log(response);
                        loader.style.display = 'none';
                        if(response != null && response != '')
                        {
                            var api_log_id = response.api_log_id;
							var statusCode = response.statusCode;
                            var response_message = response.response_message;
                            var vendor = response.vendor;
                            var responseJson = response.response;
                            // console.log(responseJson);
           

                            if(statusCode == 200 || statusCode == 1)
                            {   
                                $(".re_details").css('display', 'block');
                                $(".no-data").hide();
                                $(".searched-details").css('display', 'block');
                                // console.log(responseJson.msg["Owners Details"]["Father Name/Husband Name"]); 
                                if(vendor == 'authbridge'){
                                    displayDetailsauth(responseJson.msg);
                                }
                                else if(vendor == 'signzy'){
                                    displayDetails(responseJson.result);
                                }else if(vendor == 'SC'){
                                    displayDetails(responseJson.result);
                                }
                                else if(vendor == 'invincible'){
                                    displayDetailsInvincible(responseJson.result.data);
                                }
                                else if(vendor == 'surepass'){
                                    displayDetailsSurePass(responseJson.data);
                                }
								$("#downloadPDF").attr('data-content', api_log_id);
                            }
                            else
                            {
                                $('#noDataFound').html('<h4 style="color:red;">Error  </h4> <p>'+response_message+'.</p>');
                                $(".searched-details").css('display', 'none');
                                $('.error-message').html('');
                                $(".re_details").css('display', 'none');
                                $(".no-data").show();
                            }
                        }
                        else{
                            $('#noDataFound').html('<h4 style="color:red;">Error  </h4> <p> No Data Found!.</p>');
                            $(".searched-details").css('display', 'none');
                            $('.error-message').html('');
                            $(".re_details").css('display', 'none');
                            $(".no-data").show();
                        }                        
                        
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX Error:', error);
                    }
                });
            }
            else{
                $(".re_details").css('display', 'block');
                $(".searched-details").css('display', 'none');
                 $('.error-message').html('<p> Please enter valid vehicle no </p>');
            }
        });
		
		
		
        function displayDetailsInvincible(response) {
            // console.log(response);

            var vehicleDetailsHtml = '<div class="row"><div class="col-md-8"><div class="table-heading"><h3>Vehicle Details</h3></div>';

            vehicleDetailsHtml += '<div class="table-responsive"><table class="table table-borderless table-striped dataTable no-footer nodata-table"><tbody>';

            vehicleDetailsHtml += '<tr> <th width="30%">Reg.No.</th><td>' + response.regNo + '</td> <th>Class</th>  <td>' + response.class + '</td></tr>';

            vehicleDetailsHtml += ' <tr> <th>Chassis</th><td>' + response.chassis + '</td> <th>Engine No.</th><td>' + response.engine + '</td>  </tr>';
                                    
            vehicleDetailsHtml += ' <tr> <th>Vehicle Manufacturer Name</th><td>' + response.vehicleManufacturerName + '</td><th>Vehicle Number</th> <td>' + response.vehicleNumber + '</td> </tr>';
                                        
            vehicleDetailsHtml += ' <tr> <th>Status As On</th>  <td>' + response.statusAsOn + '</td> <th>Type</th>   <td>' + response.type + '</td>  </tr>';
                                    
            vehicleDetailsHtml += '<tr> <th>Unladen Weight</th> <td>' + response.unladenWeight + '</td> <th>Vehicle Category</th>  <td>' + response.vehicleCategory + '</td> </tr>';
                                    
            vehicleDetailsHtml += '<tr> <th>Vehicle Colour</th>  <td>' + response.vehicleColour + '</td>  <th>Vehicle Cubic Capacity</th>  <td>' + response.vehicleCubicCapacity + '</td>   </tr>';
                                    
            vehicleDetailsHtml += ' <tr>  <th>Vehicle Cylinders No.</th>   <td>' + response.vehicleCylindersNo + '</td>  <th>Vehicle Insurance Company Name</th> <td>' + response.vehicleInsuranceCompanyName + '</td>   </tr>';
                                
            vehicleDetailsHtml += ' <tr> <th>Vehicle Insurance Policy Number</th><td>' + response.vehicleInsurancePolicyNumber + '</td>  <th>Vehicle Insurance Upto</th> <td>' + response.vehicleInsuranceUpto + '</td></tr>';
                                    
            vehicleDetailsHtml += ' <tr>  <th>Vehicle Manufacturing Month/Year</th>   <td>' + response.vehicleManufacturingMonthYear + '</td>  <th>Vehicle Seat Capacity</th>   <td>' + response.vehicleSeatCapacity + '</td> </tr>';
                                    
            vehicleDetailsHtml += ' <tr> <th>Vehicle Sleeper Capacity</th> <td>' + response.vehicleSleeperCapacity + '</td>    <th>Vehicle Standing Capacity</th>    <td>' + response.vehicleStandingCapacity + '</td>     </tr>';
                                
            vehicleDetailsHtml += '  <tr> <th>Vehicle Tax Upto</th> <td>' + response.vehicleTaxUpto + '</td>   <th>Wheelbase</th>   <td>' + response.wheelbase + '</td>  </tr>';
                                
            vehicleDetailsHtml += ' <tr>  <th>RC Expiry Date</th>  <td>' + response.rcExpiryDate + '</td>   <th>RC Financer</th>   <td>' + response.rcFinancer + '</td>   </tr>';
                                    
            vehicleDetailsHtml += ' <tr> <th>RC Standard Cap</th> <td>' + response.rcStandardCap + '</td> <th>Reg Authority</th> <td>' + response.regAuthority + '</td>  </tr>';

            vehicleDetailsHtml += ' <tr> <th>Reg. Date</th> <td>' + response.regDate + '</td> <th>Gross Vehicle Weight</th> <td>' + response.grossVehicleWeight + '</td>  </tr>';

            vehicleDetailsHtml += ' <tr> <th>Pucc Number</th> <td>' + response.puccNumber + '</td> <th>Pucc Upto</th> <td>' + response.puccUpto + '</td>  </tr>';

            vehicleDetailsHtml += ' <tr> <th>Blacklist Status</th> <td>' + response.blacklistStatus + '</td> <th>Permit Issue Date</th> <td>' + response.permitIssueDate + '</td>  </tr>';

            vehicleDetailsHtml += ' <tr> <th>Permit Number</th> <td>' + response.permitNumber + '</td> <th>Permit Type</th> <td>' + response.permitType + '</td>  </tr>';
            
            vehicleDetailsHtml += ' <tr> <th>Permit Valid From</th> <td>' + response.permitValidFrom + '</td> <th>Permit Valid Upto</th> <td>' + response.permitValidUpto + '</td>  </tr>';

            
            vehicleDetailsHtml += ' <tr> <th>Non Use Status</th> <td>' + response.nonUseStatus + '</td> <th>Non Use From</th> <td>' + response.nonUseFrom + '</td>  </tr>';

            
            vehicleDetailsHtml += ' <tr> <th>Non Use To</th> <td>' + response.nonUseTo + '</td> <th>National Permit Number</th> <td>' + response.nationalPermitNumber + '</td>  </tr>';

            
            vehicleDetailsHtml += ' <tr> <th>National Permit Upto</th> <td>' + response.nationalPermitUpto + '</td> <th>National Permit Issued By</th> <td>' + response.nationalPermitIssuedBy + '</td>  </tr>';

            vehicleDetailsHtml += ' <tr> <th>Commercial Status</th> <td>' + response.isCommercial + '</td> <th>Noc Details</th> <td>' + response.nocDetails + '</td>  </tr>';
			vehicleDetailsHtml += ' <tr> <th>Model / Makers Class</th> <td>' + response.model + '</td> <th></th> <td></td>  </tr>';


            vehicleDetailsHtml += '  </tbody> </table>  </div>  </div> ';

            vehicleDetailsHtml += '  <div class="col-md-4"><div class="table-heading">     <h3>Personal Details</h3>   </div>';
            vehicleDetailsHtml += '   <div class="table-responsive"> <table class="table table-borderless table-striped dataTable no-footer nodata-table">  <tbody>';

            vehicleDetailsHtml += '   <tr>  <th width="30%">Owner</th>    <td>' + response.owner + '</td>    </tr>   <tr>   <th>Owner Father Name</th> <td>' + response.ownerFatherName + '</td>    </tr> <tr>   <th>Owner sr no.</th> <td>' + response.ownerCount + '</td>    </tr>  <tr> <th>Mobile Number</th> <td>' + response.mobileNumber + '</td> </tr> <tr>    <th>Status</th>  <td>' + response.status + '</td> </tr> </tbody>  </table> </div>';

            vehicleDetailsHtml += ' <div class="table-heading">  <h3>Address Details</h3> </div>';
            vehicleDetailsHtml += '  <div class="table-responsive"> <table class="table table-borderless table-striped dataTable no-footer nodata-table">  <tbody>';
                
            vehicleDetailsHtml += ' <tr> <th width="30%">Address Line</th>  <td>' + response.permanentAddress + '</td>  </tr>  </tbody>  </table>  </div>  </div> </div> ';


            $('#accordionExample').html(vehicleDetailsHtml);

            $('.searched-details').css('display', 'block');
            $('.error-message').html('');
        }

        function displayDetailsSurePass(response) {
            // console.log(response);
            var vehicleDetailsHtml = '<div class="row"><div class="col-md-8"><div class="table-heading"><h3>Vehicle Details</h3></div>';

            vehicleDetailsHtml += '<div class="table-responsive"><table class="table table-borderless table-striped dataTable no-footer nodata-table"><tbody>';

            vehicleDetailsHtml += '<tr> <th width="30%">Reg No.</th><td>' + response.rc_number + '</td> <th>Class</th> <td>'+ response.vehicle_category_description+'</td></tr>';

            vehicleDetailsHtml += '<tr> <th>Chassis </th> <td>' + response.vehicle_chasi_number + '</td>  <th>Engine No.</th><td>' + response.vehicle_engine_number + '</td></tr>';

            vehicleDetailsHtml += '<tr> <th>Status As On</th> <td>' + response.latest_by + '</td>  <th>Type </th><td>' + response.fuel_type + '</td></tr>';
            
            vehicleDetailsHtml += '<tr> <th>Unladen Weight</th> <td>' + response.unladen_weight + '</td> <th>Vehicle Category</th><td>' + response.vehicle_category + '</td></tr>';

            vehicleDetailsHtml += '<tr> <th>Vehicle Colour</th>  <td>' + response.color + '</td>  <th>Vehicle Cubic Capacity</th>  <td>' + response.cubic_capacity + '</td>   </tr>';

            vehicleDetailsHtml += '<tr> <th>Vehicle Cylinders No.</th>   <td>' + response.no_cylinders + '</td>  <th>Vehicle Insurance Company Name</th> <td>' + response.insurance_company + '</td> </tr>';

            vehicleDetailsHtml += ' <tr> <th>Vehicle Insurance Policy Number</th><td>' + response.insurance_policy_number + '</td>  <th>Vehicle Insurance Upto</th> <td>' + response.insurance_upto + '</td></tr>';

            vehicleDetailsHtml += ' <tr>  <th>Vehicle Manufacturing Month/Year </th>   <td>' + response.manufacturing_date_formatted + '</td>  <th>Vehicle Seat Capacity</th>   <td>' + response.seat_capacity + '</td> </tr>';

            vehicleDetailsHtml += ' <tr> <th>Vehicle Sleeper Capacity</th> <td>' + response.sleeper_capacity + '</td>    <th>Vehicle Standing Capacity</th>    <td>' + response.standing_capacity + '</td>     </tr>';
            
            vehicleDetailsHtml += ' <tr> <th>Vehicle Tax Upto</th> <td>' + (response.tax_upto == null ? '' : response.tax_upto) + '</td> <th>Wheelbase</th>  <td>' + response.wheelbase + '</td>     </tr>';

            vehicleDetailsHtml += ' <tr> <th>RC Expiry Date</th>  <td>' + response.fit_up_to + '</td> <th>RC Financer</th>   <td>' + response.financer + '</td>  </tr>';

            vehicleDetailsHtml += ' <tr> <th>Reg Date.</th><td>' + response.registration_date + '</td> <th>Gross Vehicle Weight</th> <td>' + response.vehicle_gross_weight + '</td>  </tr>';

            vehicleDetailsHtml += ' <tr> <th>PUCC Number</th> <td>' + response.pucc_number + '</td> <th>PUCC Upto</th> <td>'+ response.pucc_upto+'</td>  </tr>'; 

            vehicleDetailsHtml += ' <tr> <th>Blacklist Status</th> <td>' + (response.blacklist_status == null ? '' : response.blacklist_status) + '</td> <th>Permit Issue Date</th> <td>' + (response.permit_issue_date == null ? '' : response.permit_issue_date) + '</td>  </tr>';

            vehicleDetailsHtml += ' <tr> <th>Permit Number</th> <td>' + response.permit_number + '</td> <th>Permit Type</th> <td>' + response.permit_type + '</td>  </tr>';

            vehicleDetailsHtml += ' <tr> <th>Permit Valid From</th> <td>' + (response.permit_valid_from == null ? '' : response.permit_valid_from) + '</td>  <th>Permit Valid To</th> <td>' + (response.permit_valid_to == null ? '' : response.permit_valid_to) + '</td> </tr>';

            vehicleDetailsHtml += ' <tr> <th>Non Use Status</th> <td>' + (response.non_use_status == null ? '' : response.non_use_status) + '</td> <th>Non Use From</th> <td>' + (response.non_use_from == null ? '' : response.non_use_from) + '</td>  </tr>';

            vehicleDetailsHtml += ' <tr> <th>Non Use To</th> <td>' + (response.non_use_to == null ? '' : response.non_use_to) + '</td> <th>National Permit Number</th> <td>' + (response.national_permit_number == null ? '' : response.national_permit_number)  + '</td>  </tr>';

            vehicleDetailsHtml += ' <tr> <th>National Permit Upto</th> <td>' + (response.national_permit_upto == null ? '' : response.national_permit_upto) + '</td> <th>National Permit Issued By</th> <td>' + (response.national_permit_issued_by == null ? '' : response.national_permit_issued_by) + '</td>  </tr>';

            vehicleDetailsHtml += ' <tr>  <th>Noc Details</th> <td>' + (response.noc_details == null ? '' : response.noc_details) + '</td> <th>Model/Makers Class</th>   <td>' + response.maker_model + '</td> </tr>';

            vehicleDetailsHtml += '  </tbody> </table>  </div>  </div> ';


            vehicleDetailsHtml += '  <div class="col-md-4"><div class="table-heading">     <h3>Personal Details</h3>   </div>';
            vehicleDetailsHtml += '   <div class="table-responsive"> <table class="table table-borderless table-striped dataTable no-footer nodata-table">  <tbody>';

            vehicleDetailsHtml += '   <tr>  <th width="30%">Owner</th>    <td>' + response.owner_name + '</td>    </tr>   <tr>   <th>Owner Father Name</th> <td>' + response.father_name + '</td>    </tr> <tr>   <th>Owner sr no.</th> <td>' + response.owner_number + '</td>    </tr>  <tr> <th>Mobile Number</th> <td>' + response.mobile_number + '</td> </tr> <tr>    <th>Status</th>  <td>' + response.rc_status + '</td> </tr> </tbody>  </table> </div>';

            vehicleDetailsHtml += ' <div class="table-heading">  <h3>Address Details</h3> </div>';
            vehicleDetailsHtml += '  <div class="table-responsive"> <table class="table table-borderless table-striped dataTable no-footer nodata-table">  <tbody>';
                
            vehicleDetailsHtml += ' <tr> <th width="30%">Present Address</th>  <td>' + response.present_address + '</td>  </tr> <tr> <th width="30%">Permanent Address</th>  <td>' + response.permanent_address + '</td>  </tr>  </tbody>  </table>  </div>  </div> </div> ';


            $('#accordionExample').html(vehicleDetailsHtml);

            $('.searched-details').css('display', 'block');
            $('.error-message').html('');
        }


        function displayDetails(response) {

            var vehicleDetailsHtml = '<div class="row"><div class="col-md-8"><div class="table-heading"><h3>Vehicle Details</h3></div>';

            vehicleDetailsHtml += '<div class="table-responsive"><table class="table table-borderless table-striped dataTable no-footer nodata-table"><tbody>';

            vehicleDetailsHtml += '<tr> <th width="30%">Reg.No.</th><td>' + response.regNo + '</td> <th>Class</th>  <td>' + response.class + '</td></tr>';

            vehicleDetailsHtml += ' <tr> <th>Chassis</th><td>' + response.chassis + '</td> <th>Engine No.</th><td>' + response.engine + '</td>  </tr>';
                                    
            vehicleDetailsHtml += ' <tr> <th>Vehicle Manufacturer Name</th><td>' + response.vehicleManufacturerName + '</td><th>Vehicle Number</th> <td>' + response.vehicleNumber + '</td> </tr>';
                                        
            vehicleDetailsHtml += ' <tr> <th>Status As On</th>  <td>' + response.statusAsOn + '</td> <th>Type</th>   <td>' + response.type + '</td>  </tr>';
                                    
            vehicleDetailsHtml += '<tr> <th>Unladen Weight</th> <td>' + response.unladenWeight + '</td> <th>Vehicle Category</th>  <td>' + response.vehicleCategory + '</td> </tr>';
                                    
            vehicleDetailsHtml += '<tr> <th>Vehicle Colour</th>  <td>' + response.vehicleColour + '</td>  <th>Vehicle Cubic Capacity</th>  <td>' + response.vehicleCubicCapacity + '</td>   </tr>';
                                    
            vehicleDetailsHtml += ' <tr>  <th>Vehicle Cylinders No.</th>   <td>' + response.vehicleCylindersNo + '</td>  <th>Vehicle Insurance Company Name</th> <td>' + response.vehicleInsuranceCompanyName + '</td>   </tr>';
                                
            vehicleDetailsHtml += ' <tr> <th>Vehicle Insurance Policy Number</th><td>' + response.vehicleInsurancePolicyNumber + '</td>  <th>Vehicle Insurance Upto</th> <td>' + response.vehicleInsuranceUpto + '</td></tr>';
                                    
            vehicleDetailsHtml += ' <tr>  <th>Vehicle Manufacturing Month/Year</th>   <td>' + response.vehicleManufacturingMonthYear + '</td>  <th>Vehicle Seat Capacity</th>   <td>' + response.vehicleSeatCapacity + '</td> </tr>';
                                    
            vehicleDetailsHtml += ' <tr> <th>Vehicle Sleeper Capacity</th> <td>' + response.vehicleSleeperCapacity + '</td>    <th>Vehicle Standing Capacity</th>    <td>' + response.vehicleStandingCapacity + '</td>     </tr>';
                                
            vehicleDetailsHtml += '  <tr> <th>Vehicle Tax Upto</th> <td>' + response.vehicleTaxUpto + '</td>   <th>Wheelbase</th>   <td>' + response.wheelbase + '</td>  </tr>';
                                
            vehicleDetailsHtml += ' <tr>  <th>RC Expiry Date</th>  <td>' + response.rcExpiryDate + '</td>   <th>RC Financer</th>   <td>' + response.rcFinancer + '</td>   </tr>';
                                    
            vehicleDetailsHtml += ' <tr> <th>RC Standard Cap</th> <td>' + response.rcStandardCap + '</td> <th>Reg Authority</th> <td>' + response.regAuthority + '</td>  </tr>';

            vehicleDetailsHtml += ' <tr> <th>Reg. Date</th> <td>' + response.regDate + '</td> <th>Gross Vehicle Weight</th> <td>' + response.grossVehicleWeight + '</td>  </tr>';

            vehicleDetailsHtml += ' <tr> <th>Pucc Number</th> <td>' + response.puccNumber + '</td> <th>Pucc Upto</th> <td>' + response.puccUpto + '</td>  </tr>';

            vehicleDetailsHtml += ' <tr> <th>Blacklist Status</th> <td>' + response.blacklistStatus + '</td> <th>Permit Issue Date</th> <td>' + response.permitIssueDate + '</td>  </tr>';

            vehicleDetailsHtml += ' <tr> <th>Permit Number</th> <td>' + response.permitNumber + '</td> <th>Permit Type</th> <td>' + response.permitType + '</td>  </tr>';
            
            vehicleDetailsHtml += ' <tr> <th>Permit Valid From</th> <td>' + response.permitValidFrom + '</td> <th>Permit Valid Upto</th> <td>' + response.permitValidUpto + '</td>  </tr>';

            
            vehicleDetailsHtml += ' <tr> <th>Non Use Status</th> <td>' + response.nonUseStatus + '</td> <th>Non Use From</th> <td>' + response.nonUseFrom + '</td>  </tr>';

            
            vehicleDetailsHtml += ' <tr> <th>Non Use To</th> <td>' + response.nonUseTo + '</td> <th>National Permit Number</th> <td>' + response.nationalPermitNumber + '</td>  </tr>';

            
            vehicleDetailsHtml += ' <tr> <th>National Permit Upto</th> <td>' + response.nationalPermitUpto + '</td> <th>National Permit Issued By</th> <td>' + response.nationalPermitIssuedBy + '</td>  </tr>';

            vehicleDetailsHtml += ' <tr> <th>Commercial Status</th> <td>' + response.isCommercial + '</td> <th>Noc Details</th> <td>' + response.nocDetails + '</td>  </tr>';
			vehicleDetailsHtml += ' <tr> <th>Model / Makers Class</th> <td>' + response.model + '</td> <th></th> <td></td>  </tr>';

            vehicleDetailsHtml += '  </tbody> </table>  </div>  </div> ';

            vehicleDetailsHtml += '  <div class="col-md-4"><div class="table-heading">     <h3>Personal Details</h3>   </div>';
            vehicleDetailsHtml += '   <div class="table-responsive"> <table class="table table-borderless table-striped dataTable no-footer nodata-table">  <tbody>';

            vehicleDetailsHtml += '   <tr>  <th width="30%">Owner</th>    <td>' + response.owner + '</td>    </tr>   <tr>   <th>Owner Father Name</th> <td>' + response.ownerFatherName + '</td>    </tr> <tr>   <th>Owner sr no.</th> <td>' + response.ownerCount + '</td>    </tr>  <tr> <th>Mobile Number</th> <td>' + response.mobileNumber + '</td> </tr> <tr>    <th>Status</th>  <td>' + response.status + '</td> </tr> </tbody>  </table> </div>';

            vehicleDetailsHtml += ' <div class="table-heading">  <h3>Address Details</h3> </div>';
            vehicleDetailsHtml += '  <div class="table-responsive"> <table class="table table-borderless table-striped dataTable no-footer nodata-table">  <tbody>';
                
            vehicleDetailsHtml += ' <tr> <th width="30%">Address Line</th>  <td>' + response.splitPermanentAddress.addressLine + '</td>  </tr>  <tr>  <th>City</th> <td>' + response.splitPermanentAddress.city[0] + '</td>  </tr>  <tr>  <th>Pincode</th> <td>' + response.splitPermanentAddress.pincode + '</td> </tr>  <tr> <th>District</th>  <td>' + response.splitPermanentAddress.district[0] + '</td>  </tr> <tr> <th>State</th> <td>' + response.splitPermanentAddress.state[0][0] + '</td> </tr>  </tbody>  </table>  </div>  </div> </div> ';


            $('#accordionExample').html(vehicleDetailsHtml);

            $('.searched-details').css('display', 'block');
            $('.error-message').html('');
        }

        function displayDetailsauth(response){

            var vehicleDetailsHtml = '<div class="row"><div class="col-md-8"><div class="table-heading"><h3>Vehicle Details</h3></div>';
            vehicleDetailsHtml += '<div class="table-responsive"><table class="table table-borderless table-striped dataTable no-footer nodata-table"><tbody>';
            vehicleDetailsHtml += ' <tr><th width="30%">Reg. No.</th><td>' + response["Registration Details"]["Registration Number"] + '</td><th>Class</th><td>' + response["Vehicle Details"]["Vehicle Class"] + '</td></tr>';
            vehicleDetailsHtml += '<tr> <th>Chassis No.</th><td>' + response["Vehicle Details"]["Chassis Number"] + '</td><th>Engine Capacity</th><td>' + response["Vehicle Details"]["Engine Capacity"] + '</td> </tr>';
            vehicleDetailsHtml += ' <tr> <th>Vehicle Manufacturer Name</th><td>' + response["Vehicle Details"]["Maker/Manufacturer"] + '</td><th>Vehicle No.</th> <td>'+ response["Vehicle Details"]["Vehicle Number"] +'</td></tr>'; 
            vehicleDetailsHtml += '  <tr><th>Status As On</th> <td>' + response["Vehicle Details"]["Status As On"] + '</td><th>Type</th><td>' + response["Vehicle Details"]["Body Type"] + '</td></tr>';                           
            vehicleDetailsHtml += '<tr> <th>Unladen Weight</th><td>' + response["Vehicle Details"]["Unloading Weight"] + '</td><th>Vehicle Category</th><td>' + response["Vehicle Details"]["Vehicle Category"] + '</td> </tr>';

            vehicleDetailsHtml += ' <tr><th>Vehicle Colour</th><td>' + response["Vehicle Details"]["Color"] + '</td><th>Vehicle Cylinders No.</th><td>' + response["Vehicle Details"]["No of cylinder"] + '</td></tr>';

            vehicleDetailsHtml += '  <tr> <th>Vehicle Insurance Company Name</th>  <td>' + response["Insurance Details"]["Insurance Company"] + '</td> <th>Vehicle Insurance Policy Number</th><td>' + response["Insurance Details"]["Policy Number"] + '</td> </tr>';

            vehicleDetailsHtml += '   <tr> <th>Vehicle Insurance Upto</th> <td>' + response["Insurance Details"]["Insurance To Date/Insurance Upto"] + '</td> <th>Vehicle Manufacturing Month/Year</th>    <td>' + response["Vehicle Details"]["Manufacture Date"] + '</td>  </tr>'; 
            vehicleDetailsHtml += ' <tr> <th>Vehicle Seat Capacity</th> <td>' + response["Vehicle Details"]["Seating Capacity"] + '</td>    <th>Vehicle Sleeper Capacity</th>  <td>' + response["Vehicle Details"]["sleeper Capacity"] + '</td> </tr>';

            vehicleDetailsHtml += ' <tr> <th>Vehicle Standing Capacity</th> <td>' + response["Vehicle Details"]["Vehicle Standing Capacity"] + '</td> <th>Vehicle Tax Upto</th>  <td>' + response["Vehicle Details"]["Tax Upto"] + '</td> </tr>';

            vehicleDetailsHtml += '  <tr><th>Wheelbase</th>  <td>' + response["Registration Details"]["RTO"] + '</td><th>RC Expiry Date</th>  <td>' + response["Registration Details"]["Fitness Date/RC Expiry Date"] + '</td>  </tr>';

            vehicleDetailsHtml += ' <tr>  <th>RC Financer</th>  <td>' + response["Hypothecation Details"]["Financed"] + '</td>  <th>PUCC No.</th> <td>' + response["RC Status"]["PUCC NO"] + '</td> </tr>';

            vehicleDetailsHtml += '  <tr>  <th>PUCC Upto</th>  <td>' + response["RC Status"]["PUCC Upto"] + '</td>    <th>Norms Type</th><td>' + response["Vehicle Details"]["Norms Type"] + '</td>   </tr>';

            vehicleDetailsHtml += '   <tr> <th>Reg. Date</th><td>' + response["Registration Details"]["Registration Date"] + '</td> <th>Blacklist Status</th>  <td>' + response["Vehicle Details"]["Blacklist Status"] + '</td> </tr>';

            vehicleDetailsHtml += '   <tr> <th>Permit Valid Upto</th><td>' + response["RC Status"]["Permit Valid Upto"] + '</td> <th>Fuel Type</th>  <td>' + response["Vehicle Details"]["Fuel Type"] + '</td> </tr>';

            vehicleDetailsHtml += '   <tr> <th>Gross Weight</th><td>' + response["Vehicle Details"]["Gross Weight"] + '</td> <th>Commercial Status</th>  <td>' + response["Vehicle Details"]["Is Commercial"] + '</td> </tr>';

            vehicleDetailsHtml += '   <tr> <th>Noc Details</th><td>' + response["Vehicle Details"]["Noc Details"] + '</td> <th>Owner Serial Number</th>  <td>' + response["Vehicle Details"]["Owner Serial Number"] + '</td> </tr>';

            vehicleDetailsHtml += '   <tr> <th>National Permit Issued By</th><td>' + response["RC Status"]["National Permit Issued By"] + '</td> <th>National Permit Number</th>  <td>' + response["RC Status"]["National Permit Number"] + '</td> </tr>';

            vehicleDetailsHtml += '   <tr> <th>National Permit Upto</th><td>' + response["RC Status"]["National Permit Upto"] + '</td> <th>Non Use From</th>  <td>' + response["RC Status"]["Non Use From"] + '</td> </tr>';

            vehicleDetailsHtml += '   <tr> <th>Non Use Status</th><td>' + response["RC Status"]["Non Use Status"] + '</td> <th>Non Use To</th>  <td>' + response["RC Status"]["Non Use To"] + '</td> </tr>';

            vehicleDetailsHtml += '   <tr> <th>Permit Issue Date</th><td>' + response["RC Status"]["Permit Issue Date"] + '</td> <th>Permit Number</th>  <td>' + response["RC Status"]["Permit Number"] + '</td> </tr>';

            vehicleDetailsHtml += '   <tr> <th>Permit Type</th><td>' + response["RC Status"]["Permit Type"] + '</td> <th>Permit Valid From</th>  <td>' + response["RC Status"]["Permit Vald From"] + '</td> </tr>';
			vehicleDetailsHtml += '   <tr> <th>Model / Makers Class</th><td>' + response["Vehicle Details"]["Model / Makers Class"] + '</td> <th></th>  <td></td> </tr>';

            // vehicleDetailsHtml += '   <tr> <th>Financer Name</th><td>' + response["Hypothecation Details"]["Financer Name"] + '</td></tr></tbody> </table> </div></div> ';
            vehicleDetailsHtml += '   <tr> <th>Financer Name</th><td>' + response["Hypothecation Details"]["Financer Name"] + '</td> <th>Engine Number</th>  <td>' + response["Vehicle Details"]["Engine Number"] + '</td> </tr></tbody> </table> </div></div>';

            // vehicleDetailsHtml += '</tbody> </table> </div></div> ';

            vehicleDetailsHtml += ' <div class="col-md-4"> ';
            vehicleDetailsHtml += '  <div class="table-heading"> <h3>Personal Details</h3> </div>';
            vehicleDetailsHtml += ' <div class="table-responsive"><table class="table table-borderless table-striped dataTable no-footer nodata-table"> <tbody>';
            vehicleDetailsHtml += '  <tr><th width="30%">Owner</th>  <td>' + response["Owners Details"]["Owners Name"] + '</td></tr> <tr>   <th>Owner Father Name</th> <td>' + response["Owners Details"]["Father Name/Husband Name"] + '</td></tr>  <tr> <th>Owners Number</th> <td>' + response["Owners Details"]["Owners Number"] + '</td> </tr>  <tr>  <th>Owner Serial Number</th> <td>' + response["Vehicle Details"]["Owner Serial Number"] + '</td> </tr>';
            vehicleDetailsHtml += '</tbody></table></div>';
            vehicleDetailsHtml += ' <div class="table-heading"> <h3>Address Details</h3> </div>';
            vehicleDetailsHtml += '<div class="table-responsive"><table class="table table-borderless table-striped dataTable no-footer nodata-table"><tbody>';  
            vehicleDetailsHtml += ' <tr> <th width="30%">Address Line</th> <td>' + response["Owners Details"]["Permanent Address"] + '</td></tr> <tr> <th>Present address</th> <td>' + response["Owners Details"]["Present Address"] + '</td> </tr> <tr>  <th>City</th> <td>' + response["Owners Details"]["Permanant Address City"] + '</td>  </tr><tr> <th>Pincode</th> <td>' + response["Owners Details"]["Permanant Address Pincode"] + '</td>  </tr> <tr> <th>District</th><td>' + response["Owners Details"]["Permanant Address District"] + '</td> </tr>   <tr> <th>District</th> <td>' + response["Owners Details"]["Permanant Address District"] + '</td></tr><tr>  <th>State</th><td>' + response["Owners Details"]["Permanant Address State"]+ '</td> </tr>';
            vehicleDetailsHtml += '  </tbody></table></div></div></div> ';


            $('#accordionExample').html(vehicleDetailsHtml);

            $('.searched-details').css('display', 'block');
            $('.error-message').html('');
        }

	$('#downloadPDF').click(function(){
			var id = $(this).attr('data-content');
			$.ajax({
				url: "{{ route('rc.downloadPDF') }}", // Path to controller through routes/web.php
				type: 'POST',
				data: { id: id },
				dataType: 'json',
				success: function(response) {
				   // console.log(response);
					loader.style.display = 'none';
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
				error: function(xhr, status, error) {
					console.log('AJAX Error:', error);
				}
			});
		});
		

});
</script>

@endsection