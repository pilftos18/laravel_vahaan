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

    table.dataTable.no-footer, .table-striped>tbody>tr:nth-of-type(odd)>*, .table>:not(caption)>*>*, table.dataTable thead th, table.dataTable thead td{border-bottom: none; padding: 2px 5px;}

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
</style>
<!-- Main container -->
<div id="main" class="main">
    <div class="row">
        <div class="pagetitle">
            <p></p>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-lg-3">
            <input type="text" id="vehicleNo" placeholder="" class="form-control capitalized-text text-uppercase" required>
            <label class="form-element-label" for="vehicleNo">Vehicle Number</label>
        </div>
        <div class="col-lg-auto">
            <button id="submitBtn" class="btn btn-primary">Submit</button>
        </div>
        <div class="col-lg-auto error-message" id="validate"></div>
    </div>


    <div class="row no-data g-3">
        <div class="col-lg-12">
            <div>
                <div class="no-data-content">
                    <h4 id="nodata" style="display:none;">No Data Found</h4>
                    <p id="noDataFound" >Searched vehicle detail will be displayed here. <br> To search enter vehicle number</p>
                </div>
                <img id="" src="assets/img/error-image.svg" alt="searching-data">
            </div>
        </div>
    </div>


    <div id="loader" class="loader-wrapper">
        <div class="loader-container">
            <div class="loader-box">
                <div class="ring"></div>
                <div class="ring"></div>
                <div class="ring"></div>
                <div class="ring"></div>
                <div class="loading-logo">
                    <img src="{{asset('assets/img/edas-logo-light.png')}}" alt="Amygb Logo">
                </div>
            </div>
        </div>
    </div>

    <div class="challan_details">
        <div class="">
            <div class="">
                <div class="d-flex align-items-center mb-2">
                    <h2 class="card-title me-auto" style="margin-top: 15px;">Challan Details</h2>

                    <a href="#" id="downloadPDF" data-content="" style="display:none;color:#a50101; border:1px solid; border-radius:20px; padding:5px 15px;"><i class="bi bi-file-pdf-fill"></i> Download </a>
                    {{-- <a href="#" id="downloadcsv" data-content="" style="display:none;color:#a50101; border:1px solid; border-radius:20px; padding:5px 15px;"><i class="bi bi-file-pdf-fill"></i> Download </a> --}}
                    {{-- bi bi-file-pdf-fill --}}
                    {{-- bi bi-filetype-csv --}}
                    {{-- generatePDF --}}
                    {{-- downloadCsv --}}
                </div>
            
                <div id="challanDetails"></div>
            </div>
        </div>
    </div>
    {{-- <div class="challan_details">
        <h2 class="card-title" style="
        margin-top: 15px;
    ">Challan Details</h2>
        <div id="challanDetails"></div>

    </div> --}}
    <div class="re_details_error">
        <div id="error"></div>
    </div>
</div>

{{-- <script src="{{asset('assets/socialmedia/emoji/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('assets/socialmedia/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/socialmedia/js/FileSaver.min.js')}}"></script>
<script src="{{asset('assets/socialmedia/js/html2canvas.min.js')}}"></script>
<script src="{{asset('assets/socialmedia/js/jspdf.min.js')}}"></script>
<script src="{{asset('assets/socialmedia/js/jspdf.umd.min.js')}}"></script>
<script src="{{asset('assets/socialmedia/emoji/js/jquery.emojiarea.js')}}"></script>
<script src="{{asset('assets/socialmedia/js/html2pdf.js')}}"></script> --}}

<script>
    $(document).ready(function() {

        let pdfresponse = null;

        $('#submitBtn').click(function() {
            var vehicle_No = $('#vehicleNo').val().toUpperCase().trim();
            // console.log(vehicle_No);
            var isValidChallanNumber = validateVehicleNumber(vehicle_No);
            //console.log(isValidChallanNumber);
            if(isValidChallanNumber !== false || isValidChallanNumber != '')
            {
                var loader = document.getElementById('loader');
                $(".challan_details").css('display','none');
                loader.style.display = 'block';
                 // Get the CSRF token value from the meta tag
                 var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': csrfToken
                    }
                    });
                $.ajax({
                    url: "{{ route('data.schallandata') }}",// Path to controller through routes/web.php
                    type: 'POST',
                    data: { vehicle_No: vehicle_No },
                    dataType: 'json',
                    success: function(responses) {
                        
                        var api_log_id = responses.api_log_id;
                        var response = responses.return;
                        // Hide loader
                        //console.log(response.message.result.challanDetails);
                        console.log("api_log_id : "+api_log_id);
                        loader.style.display = 'none';
                        if (response.code == 200) {
                            var challanDetails = response.message.result.challanDetails;

                            if (!challanDetails || (Array.isArray(challanDetails) && challanDetails.length === 0)) {

                                $('#validate').html('');
                                $('.no-data').css('display', 'flex');
                                $('#noDataFound').html(response.message.result.message).css("color", "red");
                                $('.re_details_error').css('display', 'block');
                                loader.style.display = 'none';

                            } else {
                                loader.style.display = 'none';
                                $(".challan_details").css('display', 'block');
                                $('.no-data').css('display', 'none');
                                $('#validate').html('');
                                displayVehicleDetails(response.message.result.challanDetails);
                                pdfresponse = response.message.result.challanDetails;
                                $('#downloadPDF').attr('data-content', api_log_id);
                                //console.log(pdfresponse);
                                $('#downloadPDF').css('display', 'block');
                                $('#collapse0').addClass('show');
                            }
                        }
                        else{
                            loader.style.display = 'none';
                            $('#validate').html('');
                            $('.no-data').css('display', 'flex');
                            $('#noDataFound').html(response.Error).css("color", "red");
                            $('#noDataFound').html(response.message).css("color", "red");
                            $('.re_details_error').css('display', 'block');
                        }
                    },
                    error: function(xhr, status, error) {
                        loader.style.display = 'none';
                        $('.no-data').css('display', 'flex');
                        $('#noDataFound').html('An error occurred: ' + error).css("color", "red");
                        $('.re_details_error').css('display', 'block');
                    }
                });
            }
            else{
                //$('#noDataFound').html('<p style="color:red;"> Please enter valid challan no </p>');
                loader.style.display = 'none';
                $('#validate').html('<p> Please enter valid challan no </p>');
                $('.no-data').css('display', 'flex');
                $('#noDataFound').css('display', 'block');
                $(".challan_details").css('display', 'none');
            }
        });

        $('#downloadPDF').click(function(){
			var id = $(this).attr('data-content');
			//console.log(id);
			//alert(id);
			$.ajax({
				url: "{{ route('rc.downloadChallanPDF') }}", // Path to controller through routes/web.php
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
                    loader.style.display = 'none';
				}
			});
	    });


    });


    function displayVehicleDetails(vehicleDetails) {
        var vehicleDetailsHtml = '<div class="accordion" id="accordionExample">';

        $.each(vehicleDetails, function(i, challanDetails) {
            var accordionId = 'accordion' + i;
            var collapseId = 'collapse' + i;

            vehicleDetailsHtml += '<div class="accordion-item">';
            vehicleDetailsHtml += '<h2 class="accordion-header" id="heading' + i + '">';
            vehicleDetailsHtml += '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#' + collapseId + '" aria-expanded="true" aria-controls="' + collapseId + '">';
            vehicleDetailsHtml += 'Challan N0. ' + (i + 1);
            vehicleDetailsHtml += '</button>';
            vehicleDetailsHtml += '</h2>';
            vehicleDetailsHtml += '<div id="' + collapseId + '" class="accordion-collapse collapse" aria-labelledby="heading' + i + '" data-bs-parent="#accordionExample">';
            vehicleDetailsHtml += '<div class="accordion-body">';
            vehicleDetailsHtml += generateTableHtml(challanDetails);
            vehicleDetailsHtml += '</div>';
            vehicleDetailsHtml += '</div>';
            vehicleDetailsHtml += '</div>';
        });

    vehicleDetailsHtml += '</div>';
    $('#challanDetails').html(vehicleDetailsHtml);
    }

    function generateTableHtml(data) {
        var tableHtml = '<table  class="table table-striped">';
        $.each(data, function(index, detail) {
            var fieldName = index;
            var fieldValue = detail;
            tableHtml += '<tr><td width="30%">' + fieldName + '</td><td>' + fieldValue + '</td></tr>';
        });
        tableHtml += '</table>';
        return tableHtml;
    }





</script>

@endsection