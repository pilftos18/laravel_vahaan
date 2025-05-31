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
	
	
	.upload-btn {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    /* Style for image preview */
    .image-preview {
        display: inline-block;
        margin-top: 10px;
        width: 200px;
        height: auto;
    }
</style>
<!-- Main container -->
<div id="main" class="main">
    <div class="row">
        <div class="pagetitle">
            <h1>Adhar OCR</h1>
        </div>
    </div>

    <div id="validate" style="color:red;"></div>
 

    <form id="upload-form" enctype="multipart/form-data">
        <div class="row g-2">
            <div class="col">
                
            </div>
			<input type="file" id="front-image" accept="image/*" onchange="previewImage('front-image', 'front-preview')">
			<img id="front-preview" class="image-preview" src="#" alt="Front Image Preview">
			<input type="file" id="back-image" accept="image/*" onchange="previewImage('back-image', 'back-preview')">
			<img id="back-preview" class="image-preview" src="#" alt="Back Image Preview">
            <input type="hidden" id="doctype" name="doctype" value="1">
			<button type="button" class="btn btn-primary submit">Upload Images</button>
        </div>
    </form>
   
	
    
    <div class="searched-details " style="display:none;">
		<div class="d-flex  align-items-center mb-2">

		</div>
        <div class="accordion" id="accordionExample">

            <div class="row">

            </div>

        </div>
    </div>
    
    <div class="re_details searched-details"  style="display:none;">
		
        <div class="div-data" id="data">
            <div class="result">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title mt-3">Adhar Details</h2>
                        <div id="personalDetails">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td width="30%">name</td>
                                        <td id="name"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">age</td>
                                        <td id="age"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">dob</td>
                                        <td id="dob"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">doc_id</td>
                                        <td id="doc_id"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">doi</td>
                                        <td id="doi"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">gender</td>
                                        <td id="gender"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">address</td>
                                        <td id="address"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">district</td>
                                        <td id="district"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">pincode</td>
                                        <td id="pincode"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">state</td>
                                        <td id="state"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">street_address</td>
                                        <td id="street_address"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">yob</td>
                                        <td id="yob"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">relation_name</td>
                                        <td id="relation_name"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">relation_type</td>
                                        <td id="relation_type"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">minor</td>
                                        <td id="minor"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">scan_type</td>
                                        <td id="scan_type"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">is_scanned</td>
                                        <td id="is_scanned"></td>
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
function previewImage(inputId, previewId) {
    var input = document.getElementById(inputId);
    var preview = document.getElementById(previewId);

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
        };

        reader.readAsDataURL(input.files[0]);
    }
}


$(document).ready(function(){

    $('.submit').click(function (){
        var frontImage = document.getElementById('front-image').files[0];
    var backImage = document.getElementById('back-image').files[0];
    var doctype = document.getElementById('doctype').value;
    // .files[0]

    // console.log(frontImage);
    // console.log(backImage);

    if (!frontImage || !backImage) {
        swal.fire("Please select both front and back images.");
        return;
    }

    var formData = new FormData();
    formData.append('front_image', frontImage);
    formData.append('back_image', backImage);
    formData.append('doctype', doctype);

	// Show loader
	var loader = document.getElementById('loader');
	loader.style.display = 'block';
	$(".re_details").css('display','none');

	$('#validate').html();
	var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: "{{ route('ocr.ocrPostData') }}", // Path to controller through routes/web.php
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
			'X-CSRF-TOKEN': csrfToken
		},
        success: function(response) {
            loader.style.display = 'none';
			if(response.status == 1)
			{
				console.log(response);
				$(".re_details").css('display', 'block');
				$(".no-data").hide();
				$('.error-message').html('');
				$(".searched-details").css('display', 'block');

				$("#name").text(response.msg["name"]);
				$("#age").text(response.msg['age']);
				$("#dob").text(response.msg['dob']);
				$("#doc_id").text(response.msg['doc_id']);
				$("#doi").text(response.msg['doi']);
				$("#address").text(response.msg['address']);
				$("#gender").text(response.msg['gender']);
				$("#district").text(response.msg['district']);
				$("#pincode").text(response.msg['pincode']);
				$("#relation_name").text(response.msg['relation_name']);
				$("#relation_type").text(response.msg['relation_type']);
				$("#state").text(response.msg['state']);
				$("#street_address").text(response.msg['street_address']);
				$("#is_scanned").text((response.msg['is_scanned'].length > 0) ? response.msg['is_scanned'].length : 'NA');
				$("#minor").text((response.msg['minor'].length > 0) ? response.msg['minor'].length : 'NA');
				$("#scan_type").text((response.msg['scan_type'].length > 0) ? response.msg['scan_type'].length : 'NA');

			}
			else if(response.status != 1){
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
        error: function() {
            alert('Error uploading images. Please try again later.');
            // Handle error if needed
        }
    });
    });
});

</script>

@endsection