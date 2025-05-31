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
            <h1>Aadhar Details</h1>
        </div>
    </div>

    <div id="validate" style="color:red;"></div>
    <div class="row g-3">
        <div class="col-lg-3">
            <input type="text" id="InputNumber" placeholder="" class="form-control capitalized-text text-uppercase" required>
            <label class="form-element-label" for="InputNumber">Aadhar Number</label>
        </div>
        <div class="col-lg-auto">
            <button id="submitBtn" class="btn btn-primary">Submit</button>
        </div>
        <div class="col-lg-auto error-message">
            
        </div>
    </div>

    <div class="searched-details " style="display:none;">
		{{-- <div class="d-flex  align-items-center mb-2">
            <h2 class="card-title me-auto" style="margin-top: 15px;"></h2>
			<a href="#" class="downloadPDF ms-auto pb-2" id="downloadPDF" data-content="" style="color:#a50101; border:1px solid; border-radius:20px; padding:5px 15px;"><i class="bi bi-file-pdf-fill"></i> Download </a>
		</div> --}}
        <div class="div-data" id="data">
            <div class="result">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title mt-3">Aadhar Details</h2>
                        <div id="personalDetails">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td width="30%">Age range</td>
                                        <td id="age_range"></td>
                                    </tr><tr>
                                        <td width="30%">Aadhaar Number</td>
                                        <td id="aadhaar_number"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">State</td>
                                        <td id="state"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">Gender</td>
                                        <td id="gender"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">Last Digits</td>
                                        <td id="last_digits"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row no-data g-3">
        <div class="col-lg-12">
            <div>
                <div class="no-data-content" id="noDataFound">
                    <h4 >No Data Found</h4>
                    <p>Searched aadhar detail will be displayed here. <br> To search enter aadhar number</p>
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
        $(document).ready(function(){
            function validateAadharNumber(panNumber)
            {
                var regex = /^\d{12}$/;
                return  regex.test(panNumber);
            }

            $('#submitBtn').click(function() {
                var input = $('#InputNumber').val().toUpperCase().trim();
                var isValidAadharNumber = validateAadharNumber(input);
                // console.log(isValidAadharNumber);
                if(isValidAadharNumber === true && isValidAadharNumber != ''){
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
                        url: "{{ route('pancard.aadharvPostData') }}", // Path to controller through routes/web.php
                        type: 'POST',
                        data: { input: input},
                        dataType: 'json',
                        success: function(response) {
                            loader.style.display = 'none';
                            if(response.code == 200)
                            {
                                
                                $(".re_details").css('display', 'block');
                                $(".no-data").hide();
                                $('.error-message').html('');
                                $(".searched-details").css('display', 'block');
                                $("#age_range").text(response.result.data.age_range);
                                $("#aadhaar_number").text(response.result.data.aadhaar_number);
                                $("#state").text(response.result.data.state);
                                $("#gender").text(response.result.data.gender);
                                $("#last_digits").text(response.result.data.last_digits);
                            }
                            else if(response.code != 200){
                                $('#noDataFound').html('<h4 style="color:red;">Error  </h4> <p>'+response.message+'.</p>');
                                $(".searched-details").css('display', 'none');
                                $('.error-message').html('');
                                $(".re_details").css('display', 'none');
                                $(".no-data").show();
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
                            loader.style.display = 'none';
                        }
                    })
                }else{ 

                    $(".re_details").css('display', 'block');
                    $(".searched-details").css('display', 'none');
                    $('.error-message').html('<p> Please enter valid Aadhar no </p>');
                    $(".no-data").show();
                }
            });
        });
</script>
@endsection