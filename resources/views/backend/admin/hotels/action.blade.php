<div class="btn-group">
    <!-- Edit Button -->
    <button class="btn btn-sm btn-info detail-btn" data-id="{{ $row->id }}" data-name="{{ $row->name }}">
        {{ __('message.h_view') }}
    </button>
    
   
</div>

<!-- Modal for viewing hotel details -->
<div class="modal fade" id="hotelDetailModal" tabindex="-1" aria-labelledby="hotelDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hotelDetailModalLabel">{{ __('message.h_details') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div id="hotelDetailsContent">
                    <div class="row">
                        <div class="col-6">
                          <p><strong>{{ __('message.h_name') }}:</strong> <span id="hotelName"></span></p>
                        </div>
                        <div class="col-6">
                            <p><strong>{{ __('message.h_address') }}:</strong> <span id="hotelAddress"></span></p>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-6">
                           <p><strong>{{ __('message.h_city') }}:</strong> <span id="hotelCity"></span></p>
                        </div>
                        <div class="col-6">
                          <p><strong>{{ __('message.h_pincode') }}:</strong> <span id="hotelPincode"></span></p>
                        </div>
                    </div>
            
                   
                    <br>
                    <div class="row">
                        <div class="col-6">
                            <p><strong>{{ __('message.h_email') }}:</strong> <span id="hotelEmail"></span></p>
                        </div>
                        <div class="col-6">
                             <p><strong>{{ __('message.h_phone') }}:</strong> <span id="hotelPhone"></span></p>
                        </div>
                    </div>
                    <br>
                  
                
                    <div class="row">
                        <div class="col-6">
                    <p><strong>{{ __('message.h_telephone') }}:</strong> <span id="hotelTelephone"></span></p>

                        </div>
                        <div class="col-6">
                    <p><strong>{{ __('message.h_star_category') }}:</strong> <span id="hotelStarCategory"></span></p>

                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-6">
                    <p><strong>{{ __('message.h_website') }}:</strong> <span id="hotelWebsite"  style="white-space: pre-wrap;"></span></p>

                        </div>
                        <div class="col-6">
                    <p><strong>{{ __('message.h_near_railwaystation') }}:</strong> <span id="hotelRailwayStation"></span></p>

                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-6">
                    <p><strong>{{ __('message.h_near_airport') }}:</strong> <span id="hotelAirport"></span></p>

                        </div>
                        <div class="col-6">
                    <p><strong>{{ __('message.h_status') }}:</strong> <span id="hotelStatus"></span></p>

                        </div>
                    </div>
                    <br>
                    <p><strong>{{ __('message.h_description') }}:</strong> <span id="hotelDescription" style="white-space: pre-wrap;"></span></p>

                    <div id="hotelImages" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ensure jQuery is included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Ensure Bootstrap JS is included -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-slimscroll@1.3.8/jquery.slimscroll.min.js"></script>
<script src="/admin/js/script.js"></script>
<script>
    
// Handle View Details Button

$('.detail-btn').on('click', function() {
    // Ensure this line is correctly assigning the hotel ID
    var hotelId = $(this).data('id');  // Get hotel ID from data-id attribute of the clicked button
    
    if (hotelId) {
        console.log('Hotel ID:', hotelId); // Debugging line to confirm the ID is retrieved

        $.ajax({
            url: '/admin/hotels/details/' + hotelId,  // Ensure the correct route is used
            method: 'GET',
            success: function(response) {
                console.log(response);
                // Populate the modal with hotel details
                $('#hotelName').text(response.name);
                $('#hotelAddress').text(response.address);
                $('#hotelEmail').text(response.email);
                $('#hotelPhone').text(response.	Phoneno);
                $('#hotelCity').text(response.city);
                $('#hotelPincode').text(response.pincode);
                $('#hotelTelephone').text(response.telephoneno);
                $('#hotelStarCategory').text(response.star_category);
                $('#hotelWebsite').text(response.website);
                $('#hotelRailwayStation').text(response.nearest_railwaystation);
                $('#hotelAirport').text(response.nearest_airport);
                $('#hotelStatus').text(response.status);
                $('#hotelDescription').text(response.description);
                 // Populate latitude and longitude
                 $('#hotelLatitude').text(response.latitude); // Add this line
                  $('#hotelLongitude').text(response.longitude); // Add this line


                let imagesHtml = '';
                response.images.forEach(image => {
                    imagesHtml += `<img src="${image}" class="img-thumbnail" width="100"> `;
                });
                $('#hotelImages').html(imagesHtml);

                // Open the modal
                $('#hotelDetailModal').modal('show');
            },
            error: function(xhr) {
                console.error("Error fetching hotel details:", xhr.responseText);
            }
        });
    } else {
        console.error('Hotel ID is not defined.');
    }
});

</script>
