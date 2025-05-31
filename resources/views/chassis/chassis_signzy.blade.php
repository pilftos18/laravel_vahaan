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
</style>
<!-- Main container -->
<div id="main" class="main">
    <div class="row">
        <div class="pagetitle">
            <h1>Chassis Details</h1>
        </div>
    </div>

    <div id="validate" style="color:red;"></div>
    <div class="row g-3">
        <div class="col-lg-3">
            <input type="text" id="chassisno" placeholder="" class="form-control capitalized-text text-uppercase" required>
            <label class="form-element-label" for="chassisno">Chassis Number</label>
        </div>
        <div class="col-lg-auto">
            <button id="submitBtn" class="btn btn-primary">Submit</button>
        </div>
        <div class="col-lg-auto error-message">
            
        </div>
    </div>
	
    
    <div class="searched-details " style="display:none;">
        <div class="accordion" id="accordionExample">
            <div class="row">
            </div>

        </div>
    </div>
    
    
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
            var chassisno = $('#chassisno').val().toUpperCase().trim();
            var isValidChassisNumber = validateChassisNumber(chassisno);
            if(isValidChassisNumber === true && isValidChassisNumber != '')
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
                    url: "{{ route('chassis.chassispostdata') }}", // Path to controller through routes/web.php
                    type: 'POST',
                    data: { chassisno: chassisno },
                    dataType: 'json',
                    success: function(response) {
                       console.log(response);
                        loader.style.display = 'none';

                        if (response.result !== null && response.result !== undefined) {

                           
                            $(".re_details").css('display', 'block');
                            $(".no-data").hide();
                            $('.error-message').html('');
                            $(".searched-details").css('display', 'block');
                            $('#validate').html('');
                            displayDetails(response.result);

                        }
                        else if(response.error !== null && response.error !== undefined){

                                $('#noDataFound').html('<h4 style="color:red;">No Data Found</h4> <style="color:red;>No Data Found.</p>');
                                loader.style.display = 'none';
                                 $('#validate').html('');
                                $(".searched-details").css('display', 'none');
                                $('.error-message').html('');
                                $(".re_details").css('display', 'none');
                                $(".no-data").show();
                        }else{

                                $('#noDataFound').html('<h4 style="color:red;">Error  </h4> <style="color:red;>No Data Found.</p>');
                                loader.style.display = 'none';
                                $('#validate').html('');
                                $(".searched-details").css('display', 'none');
                                $('.error-message').html('');
                                $(".re_details").css('display', 'none');
                                $(".no-data").show();
                        }                      
                        
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX Error:', error);
                        loader.style.display = 'none';
                    }
                });
            }
            else{
                $(".re_details").css('display', 'block');
                $(".searched-details").css('display', 'none');
                 $('.error-message').html('<p> Please enter valid vehicle no </p>');
                 $(".no-data").show();
            }
        });

        function validateChassisNumber(chassisNumber) {
            // Regular expression for chassis number validation
            var chassisRegex = /^[A-HJ-NPR-Z0-9]{17}$/i;
            // Check if the chassis number matches the regex pattern
            return chassisRegex.test(chassisNumber);
        }


        function displayDetails(response) {

            var vehicleDetailsHtml = '<div class="row"><div class="col-md-8"><div class="table-heading"><h3>Vehicle Details</h3></div>';

            vehicleDetailsHtml += '<div class="table-responsive"><table class="table table-borderless table-striped dataTable no-footer nodata-table"><tbody>';

            vehicleDetailsHtml += '<tr> <th width="30%">Reg.No.</th><td>' + response.regNo + '</td> <th>Class</th>  <td>' + response.class + '</td></tr>';

            vehicleDetailsHtml += ' <tr> <th>Chassis</th><td>' + response.chassis + '</td> <th>Engine No.</th><td>' + response.engine + '</td>  </tr>';
                                    
            vehicleDetailsHtml += ' <tr> <th>Vehicle Manufacturer Name</th><td>' + response.vehicleManufacturerName + '</td><th>Vehicle Number</th> <td>' + response.regNo + '</td> </tr>';
                                        
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

            vehicleDetailsHtml += '   <tr>  <th width="30%">Owner</th>    <td>' + response.owner + '</td>    </tr>   <tr>   <th>Owner Father Name</th> <td>' + response.ownerFatherName + '</td>    </tr>   <tr> <th>Mobile Number</th> <td>' + response.mobileNumber + '</td> </tr> <tr>  <tr> <th>Owner Count</th> <td>' + response.ownerCount + '</td> </tr> <tr>  <th>Status</th>  <td>' + response.status + '</td> </tr> </tbody>  </table> </div>';

            vehicleDetailsHtml += ' <div class="table-heading">  <h3>Address Details</h3> </div>';
            vehicleDetailsHtml += '  <div class="table-responsive"> <table class="table table-borderless table-striped dataTable no-footer nodata-table">  <tbody>';
                
            vehicleDetailsHtml += ' <tr> <th width="30%">Address Line</th>  <td>' + response.splitPermanentAddress.addressLine + '</td>  </tr>  <tr>  <th>City</th> <td>' + response.splitPermanentAddress.city[0] + '</td>  </tr>  <tr>  <th>Pincode</th> <td>' + response.splitPermanentAddress.pincode + '</td> </tr>  <tr> <th>District</th>  <td>' + response.splitPermanentAddress.district[0] + '</td>  </tr> <tr> <th>State</th> <td>' + response.splitPermanentAddress.state[0][0] + '</td> </tr>  </tbody>  </table>  </div>  </div> </div> ';


            $('#accordionExample').html(vehicleDetailsHtml);

        }



});
</script>

@endsection