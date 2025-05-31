@extends('layout')

@section('content')
<style>       
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
    .challan_details{
        display:none;
    }
    .re_details_error{
        display:none;
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
</style>
<!-- Main container -->
<div id="main" class="main">
    <div class="row">
        <div class="pagetitle">
            <h1>Challan Details</h1>
        </div>
    </div>

    <div id="validate" style="color:red;"></div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Vehicle Number</h5>
            <div class="row g-3">
                <div class="col-auto">
                    <input type="text" id="challanNo" placeholder="Enter Vehicle Number" class="form-control">
                </div>
                <div class="col-auto">
                    <button id="submitBtn" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- //Filters -->
    <div id="loader" class="loader" style="display: none;"></div>
    <div class="challan_details">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Challan Number</h2>
                <div id="challanDetails"></div>
            </div>
        </div>
    </div>
    <div class="re_details_error">
        <div id="error"></div>
    </div>
</div>

<!-- //Main container -->
<script>
    $(document).ready(function() {

        function validateVehicleNumber(vehicleNumber) {
            // Check if the vehicle number is empty
            if (vehicleNumber.trim() === '') {
                return false;
            }

            // Regular expression pattern for vehicle number validation
            var regex = /^[A-Z]{2}[0-9]{1,2}[A-Z]{1,2}[0-9]{1,4}$/;

            // Test the vehicle number against the regex pattern
            var isValid = regex.test(vehicleNumber);

            return isValid;
        }
        
        $('#submitBtn').click(function() {
            var vehicle_No = $('#challanNo').val();
            var isValidChallanNumber = validateVehicleNumber(vehicle_No);
            //console.log(isValidChallanNumber);
            if(isValidChallanNumber !== false)
            {
                // Show loader
                var loader = document.getElementById('loader');
                $(".challan_details").css('display','none');
                //$("#validate").css('display','none');
                //$(".re_details_error").css('display','none');
                loader.style.display = 'block';
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
                    url: "{{ route('challan.data') }}",// Path to controller through routes/web.php
                    type: 'POST',
                    data: { vehicle_No: vehicle_No },
                    dataType: 'json',
                    success: function(response) {
                        // Hide loader
                        loader.style.display = 'none';
                        //console.log(response);
                    //console.log();
                        if(response.error)
                        {
                            $("#validate").css('display','block');
                            $('#validate').html('Connection failed. Please try again later.');
                        }
                        else if (response.status) {
                                $('#error').html('<p>'+response.status+' </p>');
                                $('.re_details_error').css('display', 'block');
                            }
                        else{
                            // Handle the response data
                            $(".challan_details").css('display', 'block');
                           
                                displayVehicleDetails(response);
                        }
                    },
                    error: function(xhr, status, error) {
                        loader.style.display = 'none';
                        $('#error').html('An error occurred: ' + error);
                        $('.re_details_error').css('display', 'block');
                    }
                });
            }
            else{
                $('#validate').html('<p> Please enter valid challan no </p>');
            }
        });




        function displayVehicleDetails(vehicleDetails) 
        {

            var vehicleDetailsHtml = '<div>';
            $.each(vehicleDetails, function(i, data) {
                vehicleDetailsHtml += '<div><table>';
                vehicleDetailsHtml += '<tr><th colspan="2"></th></tr>';
                $.each(data, function(index, detail) {
                    var fieldName = index;
                    var fieldValue = detail;
                    vehicleDetailsHtml += '<tr><td width="30%">' + fieldName + '</td><td>' + fieldValue + '</td></tr>';
                });
                vehicleDetailsHtml += '</table></div>';
            });
            vehicleDetailsHtml += '</div>';
            //console.log(vehicleDetailsHtml);
            $('#challanDetails').html(vehicleDetailsHtml);
        }

    });
</script>

@endsection