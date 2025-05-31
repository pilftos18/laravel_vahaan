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
    .result{
        display: none;
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
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


<!-- Main container -->
<div id="main" class="main">
    <div class="row">
        <div class="pagetitle">
            <h1>Driving License Details</h1>
        </div>
    </div>

    
    <div class="row g-3">
        <div class="col-lg-3">
            <input type="text" id="dl" placeholder="" class="form-control text-uppercase" required >
            <label class="form-element-label" for="dl">Driving Number</label>
        </div>

        {{-- <div class="col-lg-3">
            <input type="text" id="licensedate" placeholder="" class="form-control" required>
            <label class="form-element-label" for="licensedate">License date</label>
        </div> --}}

        <div class="col-lg-3">
            <input type="text" id="dob" name="dob" placeholder=""  required class="form-control" autocomplete="off" required>
            <label class="form-element-label" for="dob">DOB</label>
        </div>
        <div class="col-lg-auto">
            <button id="submitBtn" class="btn btn-primary">Submit</button>
        </div>
        <div class="col-lg-auto error-message" id="validate"></div>
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
    <div class="result searched-details">
        <h2 class="card-title">Personal Details</h2>
        <div id="personalDetails" class="row">
            <div class="col-lg-auto">
                <img id="photo" src="assets/img/profile-img.jpg" alt="Profile photo" class="img-profile">
            </div>
            <div  class="col-lg-10">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <th width="30%" >Driving License Number</th>
                            <td id="dlNumber">NA</td>
                        </tr>
                        <tr>
                            <th width="30%">Owner's Name</th>
                            <td id="name">NA</td>
                        </tr>
                        <tr>
                            <th width="30%">Father's Name</th>
                            <td id="fatherOrHusbandName">NA</td>
                        </tr>
                        <tr>
                            <th width="30%">Date of Birth</th>
                            <td id="dob_r">NA</td>
                        </tr>
                        <tr>
                            <th width="30%">Address</th>
                            <td id="completeAddress">NA</td>
                        </tr>
                        <tr>
                            <th width="30%">Blood group</th>
                            <td id="bloodgroup">NA</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            </div>
        </div>
        <h2 class="card-title">License Details (validity) </h2>
        <div id="personalDetails">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>License Type</th>
                            <th>Issue Date (From)</th>
                            <th>Issue Date (To)</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr>
                            <td width="30%" id="dlValidity">NA</td>
                            <td id="from">NA</td>
                            <td id="to">NA</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
        <h2 class="card-title">COV Details </h2>
        <div id="personalDetails">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Vehicle Class </th>
                            <th>Vehicle Type</th>
                            <th>COV Issue Date</th>
                        </tr>
                    </thead>
                    <tbody id="cov">
                        <tr>
                            <td width="30%" id="sss">NA</td>
                            <td id="classOfVehicle">LMV</td>
                            <td id="aaa">NA</td>
                        </tr>
                    </tbody>
                </table>
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
</div>
<!-- //Main container -->

<!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
<script src="{{asset('assets/js/jquery-ui.js')}}"></script>


<script>
    $(document).ready(function() {
        var today = new Date(); // Get today's date
        $('#dob').datepicker(
            {  
                dateFormat: 'dd-mm-yy',
                maxDate: today,
                changeMonth: true,
                changeYear: true,
                yearRange: '1950:2050' // Set the year range
            }
        ); // Initialize date pickers
        //$("#dlNumber").text('Hey Hi');

        $('#submitBtn').click(function() {
            event.preventDefault(); // Prevent form submission
            var dl = $('#dl').val().trim();
            var dob = $('#dob').val();
            var isValidDL = validateNumber(dl);
            var isValidDOB = validateDOB(dob);
            if(isValidDL === false)
            {
                $('#validate').html('<p> Please enter valid driving lincese</p>');
                return false;
            }
            else if(isValidDOB === false)
            {
                $('#validate').html('<p> Please enter valid DOB</p>');
                return false;
            }
            else
            {
                var loader = document.getElementById('loader');
                $(".result").css('display','none');
                $("#validate").css('display','none');
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

                    url: "{{ route('licensesignzy.data') }}", // Path to controller through routes/web.php
                    type: 'POST',
                    data: { dl:dl,  dob:dob },
                    dataType: 'json',
                    success: function(response) {
                        // Hide loader
                        //debugger;
                        loader.style.display = 'none';
                        $(".no-data").hide();
                        //console.log(response);
                       if(response.status)
                        {
                           // alert(response.status);
                           $("#validate").css('display','block');
                            $('#validate').html('<p> '+response.status+' </p>');
                            $('.result').css('display', 'none');
                        }
                        else if(response.error)
                        {   
                            $("#validate").css('display','block');
                            $('#validate').html('<p> '+response.error.message+' or check your DOB </p>');
                            $('.result').css('display', 'none');
                        }
                        else{   
                            /////////////////////
                            $('#dl').val('');
                            $('#dob').val('');
                            $(".challan_details").css('display', 'block');
                            $(".result").css('display','block');

                                $("#dlNumber").text(response.response.result.dlNumber);
                                $("#name").text(response.response.result.detailsOfDrivingLicence.name);
                                $("#fatherOrHusbandName").text(response.response.result.detailsOfDrivingLicence.fatherOrHusbandName);
                                $("#dob_r").text(response.response.dob);
                                $("#bloodgroup").text('NA');

                                // License Details (validity)
                                var dlValidity = '';
                                var from = '';
                                var to = '';
                                if (response.response.result.dlValidity.nonTransport.from) {
                                dlValidity = 'Non Transport';
                                from = response.response.result.dlValidity.nonTransport.from;
                                to = response.response.result.dlValidity.nonTransport.to;
                                } else {
                                dlValidity = 'Transport';
                                from = response.response.result.dlValidity.transport.from;
                                to = response.response.result.dlValidity.transport.to;
                                }
                                $("#dlValidity").text(dlValidity);
                                $("#from").text(from);
                                $("#to").text(to);
                                $("#completeAddress").text(response.response.result.detailsOfDrivingLicence.address);
                                $("#photo").attr('src', response.response.result.detailsOfDrivingLicence.photo);

                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle the error
                        console.log('AJAX Error:', error);
                    }
                });
            }
        });

        function validateNumber(LicenseNo) {
            // Check if the vehicle number is empty
            if (LicenseNo.trim() === '') {
                return false;
            }
            var regex = /^[A-Za-z]{2}\d{2}\s\d{11}$/;
            var isValid = regex.test(LicenseNo);
            return isValid;
        }

        function validateDOB(date){
            //var date = "1986-06-03";
            if (date.trim() === '') {
                return false;
            }
            var dateRegex = /^\d{2}-\d{2}-\d{4}$/;
            return isValid = dateRegex.test(date);
        }
    });
</script>

@endsection