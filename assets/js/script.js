jQuery(document).ready(function ($) {


    $('.product-quantity-change').click(function () {
        var inputGroup = $(this).closest('.product-input-qty-options').find('.product-input-qty-row');
        var inputGroupModal = $(this).closest('.product-input-qty-options').find('.product-input-qty-row-modal');
        var inputGroupSingle = $(this).closest('.product-input-qty-options').find('.product-plus-btn-show');
        var inputField = inputGroup.find('.input-number-qty');
        var currentValue = parseInt(inputField.val());
        var updatedValue;
        if ($(this).data('type') === 'plus') {
            updatedValue = currentValue + 1;
            inputGroup.show();


            if (updatedValue > 0) {

                inputGroupSingle.removeClass('show-important');
                inputGroupSingle.addClass('hidden-important');
                inputGroup.closest('.product-card-item').addClass('bg-primary text-white card-product-added');
                $('#section-next-btn').prop('disabled', false);
                $('#mobile-service-right-btn').prop('disabled', false);

            }
        } else {
            updatedValue = currentValue > 0 ? currentValue - 1 : 0;
            // inputGroup.hide();
            // inputGroup.siblings('.input-group').show();


            if (updatedValue == 0) {
                inputGroup.closest('.product-card-item').removeClass('bg-primary text-white card-product-added');
                inputGroup.hide();
                inputGroupModal.show();

                inputGroupSingle.addClass('show-important');

                // $(this).find('.input-group.product-input-qty-row-modal').addClass('show-important');
                $('#mobile-service-right-btn').prop('disabled', true);
                // $('#section-next-btn').prop('disabled', true);

            }
        }

        inputField.val(updatedValue);


        var totalProductsAdded = $('.card-product-added').length;


        if (totalProductsAdded > 0) {
            $('.service-next-btn').prop('disabled', false);
        } else {
            $('.service-next-btn').prop('disabled', true);
            $('#product-checkout-second-section').prop('disabled', true);

        }
        // AJAX request
        updateCartItem(inputField);
    });

    function updateCartItem(inputField) {
        var carpetSingleProductId = inputField.siblings('.carpet_single_product_info').attr('product-id');
        var updatedValue = parseInt(inputField.val());

        $.ajax({
            type: 'POST',
            url: carpet_checkout.ajaxurl,
            data: {
                action: 'add_single_carpet_product_to_cart',
                carpetSingleProductId: carpetSingleProductId,
                productItemQty: updatedValue,
            },
            success: function (response) {
                // Parse the JSON response
                var responseData = JSON.parse(response);


                if (responseData.success) {



                    $('.cart-products-data').html(responseData.cart_info);

                    // Get the cart count element
                    var $cartCount = $('.cart-count');

                    // Get the current cart total
                    var currentTotal = parseFloat($cartCount.text());

                    // Get the updated cart total from the response
                    var updatedTotal = parseFloat(responseData.subtotal);


                    // Animate the counting effect with decimal support
                    $cartCount.prop('number', currentTotal).animateNumber({
                        number: updatedTotal,
                        numberStep: function (now, tween) {
                            var target = $(tween.elem);

                            // Display the number with two decimal places
                            target.text(now.toFixed(2));
                        }
                    }, 500); // Adjust the duration as needed


                    $('.cart-products-data').html(response.cart_info);

                } else {
                    // Handle error if needed
                    console.error('Error:', responseData.error);
                }



            },
        });
    }


    $('.service-next-btn').click(function (e) {

        $('#service-section').hide();
        $('#schedule-section').show();

        $('#product-checkout-second-section').prop('disabled', false);
        $(this).hide();

        $('#schedule-section').show();
        $('.schedule-next-btn').show();


    })

    $('#product-checkout-first-section').click(function (e) {

        $('#service-section').show();
        $('#schedule-section').hide();
        $('#confirm-section').hide();


        $('.service-next-btn').show();
        $('.schedule-next-btn').hide();
        $('.booking-confirm-btn').hide();


    })


    $('#product-checkout-second-section').click(function (e) {
        $('#service-section').hide();
        $('#schedule-section').show();
        $('#confirm-section').hide();


        $('.service-next-btn').hide();
        $('.schedule-next-btn').show();
        $('.booking-confirm-btn').hide();
    })


    $('#product-checkout-third-section').click(function (e) {
        $('#service-section').hide();
        $('#schedule-section').hide();
        $('#confirm-section').show();


        $('.service-next-btn').hide();
        $('.schedule-next-btn').hide();
        $('.booking-confirm-btn').show();
    })





    $('#big-screen-date-picker').markyourcalendar({
        availability: [
            ['9a - 1p', '2p - 6p'],
            ['9a - 1p', '2p - 6p'],
            ['9a - 1p', '2p - 6p'],
            ['9a - 1p', '2p - 6p'],
            ['9a - 1p', '2p - 6p'],
            ['9a - 1p', '2p - 6p'],
            ['9a - 1p', '2p - 6p']

        ],
        weekdays: ['sun', 'mon', 'tue', 'wed', 'thurs', 'fri', 'sat'],

        startDate: new Date(),
        onClick: function (ev, data) {

            var dataArray = data[0].split(' ');
            // Extracting date and time variables
            var date = dataArray[0];
            var time = dataArray.slice(1).join(' ');

            // Split the string based on the '-' delimiter
            var timeParts = time.split('-');

            // Trim whitespaces from the resulting strings
            var startTime = timeParts[0].trim();
            var endTime = timeParts[1].trim();
            // var selectedTimeFrom = 

            // Get the current date and format it
            var currentDate = new Date();
            var formattedCurrentDate = formatDate(currentDate);

            // Compare the extracted date with the current date
            if (date < formattedCurrentDate) {
                $(this).removeClass('selected');
                $('.schedule-next-btn').prop('disabled', true);
                alert('The extracted date is in the past.');
            } else {


                $('#selected-date').html(date);
                $('#selected-time').html(time);
                $('#selected-time-from').html(startTime);
                $('#selected-time-to').html(endTime);



            }

        },
        onClickNavigator: function (ev, instance) {
            var arr = [

                ['9a - 1p', '2p - 6p'],
                ['9a - 1p', '2p - 6p'],
                ['9a - 1p', '2p - 6p'],
                ['9a - 1p', '2p - 6p'],
                ['9a - 1p', '2p - 6p'],
                ['9a - 1p', '2p - 6p'],
                ['9a - 1p', '2p - 6p'],

            ]

            instance.setAvailability(arr);
        }
    });



    $('.schedule-next-btn').click(function (e) {
        $(this).hide();

        $('.booking-confirm-btn').show();

        $('#schedule-section').hide();
        $('#confirm-section').show();

        $('#product-checkout-third-section').prop('disabled', false);


    })


    $("#datepicker-3").datepicker({
        dateFormat: "DD, d MM, yy",
        minDate: 0,
        defaultDate: new Date(),
        onSelect: function (dateText, inst) {

            $('#mobile-schedule-next').prop('disabled', true);

            var selectedDate = new Date(dateText);
            // Format the date to 'yyyy-mm-dd' using toLocaleDateString
            var formattedDate = selectedDate.toLocaleDateString('en-CA');

            // Output the selected date
            // alert(formattedDate);
            var dayName = $.datepicker.formatDate('DD', selectedDate);
            showContentBasedOnDay(dayName, formattedDate);
        }
    });

    var today = new Date();
    // Format the current date to 'yyyy-mm-dd'
    var defaultFormattedDate = today.toLocaleDateString('en-CA');

    var availability = [
        ['9a - 1p', '2p - 6p'],
        ['9a - 1p', '2p - 6p'],
        ['9a - 1p', '2p - 6p'],
        ['9a - 1p', '2p - 6p'],
        ['9a - 1p', '2p - 6p'],
        ['9a - 1p', '2p - 6p'],
        ['9a - 1p', '2p - 6p'],
    ];

    // Call the function for the current day by default
    showContentBasedOnDay(getCurrentDayName(), defaultFormattedDate);


    function showContentBasedOnDay(dayName, formattedDate) {

        var dayIndex = getDayIndex(dayName);

        if (dayIndex !== -1) {


            var schedule = availability[dayIndex];
            var contentHtml = "<h5 class='mt-3'>Availability for " + dayName + ":</h5>";
            contentHtml += "<div class='myc-available-times'>";
            schedule.forEach(function (item) {
                contentHtml += "<a href='javascript:;' class='myc-available-time-small' data-time='" + item + "' data-date='" + formattedDate + "'>" + item + "</a>";
            });
            contentHtml += "</div>";

            $("#schedule-content").html(contentHtml);
        } else {
            $("#schedule-content").html("<p>No content available for " + dayName + "</p>");
        }
    }


    // Set the default value to the current date
    $("#datepicker-3").datepicker("setDate", new Date());

    function getCurrentDayName() {
        var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        var today = new Date();
        var currentDay = today.getDay();
        return days[currentDay];
    }
    // Set the default value to the current date
    function getCurrentDayName() {
        var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        var today = new Date();
        var currentDay = today.getDay();
        return days[currentDay];
    }

    function getDayIndex(dayName) {
        var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        return days.indexOf(dayName);
    }


    // mobile
    $(document).on('click', '.myc-available-time-small', function () {
        var date = $(this).data('date');
        var time = $(this).data('time');
        var tmp = date + ' ' + time;



        console.log(date);

        // Split the time range into start and end times
        var times = time.split(' - ');

        // Extract the start and end times
        var startTime = times[0];
        var endTime = times[1];

        // Toggle the 'selected' class
        $(this).toggleClass('selected');

        // Remove 'selected' class from other elements
        $('.myc-available-time-small').not(this).removeClass('selected');
        $('#selected-date').html(date);
        $('#selected-time').html(time);

        $('#selected-time-from').html(startTime);
        $('#selected-time-to').html(endTime);


        // Mobile

        if ($(this).hasClass('selected')) {
            // alert('ok');
            $('#mobile-schedule-next').prop('disabled', false);
        } else {
            $('#mobile-schedule-next').prop('disabled', true);
        }



    });





    // Event listener for input changes
    $('.booking-input-class').on('input', function () {
        var allInputsFilled = true;
        $('.booking-input-class').each(function () {
            if ($(this).val().trim() === '') {
                allInputsFilled = false;
                return false; // Exit the loop if any input is empty
            }
        });

        if (allInputsFilled) {
            $('.booking-confirm-btn').prop('disabled', false);
            $('#mobile-confirm-next').prop('disabled', false);
            // If all inputs are not empty, show the button
        } else {
            // If any input is empty, hide the button

            $('.booking-confirm-btn').prop('disabled', true);
            $('#mobile-confirm-next').prop('disabled', true);
        }
    });



    $(document).on('click', '.booking-confirm-btn', function (e) {
        e.preventDefault(); // Prevent the default form submission behavior, if any

        // Get selected date and time
        var selected_date = $('#selected-date').text();
        var selected_time = $('#selected-time').text();


        // Initialize an array to store values and placeholders
        var inputValuesAndPlaceholders = [];

        // Iterate over each element with the class .booking-input-class
        $('.booking-input-class').each(function () {
            // Get the value and placeholder of each input
            var inputValue = $(this).val().trim();
            var inputName = $(this).attr('placeholder');

            // Create an object with 'value' and 'name' properties
            var inputObject = {
                name: inputName,
                value: inputValue,
            };

            // Push the object to the array
            inputValuesAndPlaceholders.push(inputObject);
        });

        // Make an AJAX request to WordPress
        $.ajax({
            url: carpet_checkout.ajaxurl, // The WordPress AJAX endpoint
            type: 'POST',
            data: {
                action: 'carpet_process_booking', // The action hook for your WordPress function
                inputs: inputValuesAndPlaceholders,
                selected_date: selected_date,
                selected_time: selected_time
            },

            beforeSend: function () {
                // Show the spinner while processing
                var spinner = '<div class="d-flex justify-content-center my-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
                $('.service-booking-row').hide().after(spinner);
            },

            success: function (response) {
                // Show the spinner while processing

                // Simulate a delay (you can remove this in your actual code)
                setTimeout(function () {
                    // Hide the spinner and show the success message
                    $('.spinner-border').remove();
                    $('.service-booking-row').hide();
                    $('.service-success-row').show();
                }, 2000); // Adjust the delay time as needed

                // Reload the page with the added parameter
                // window.location.href = window.location.href;
            },
            error: function (error) {
                // Handle the error response
                console.log('Error:', error);
            }
        });
    });



    // Mobile Arrow Buttons
    $('#mobile-service-right-btn').click(function (e) {

        $('.left-progress').text('33% Complete');

        $('#service-section').hide();
        $('#schedule-section').show();

        $('#service-btn-part-mobile').hide();
        $('#schedule-btn-part-mobile').show();
    })

    $("#mobile-schedule-prev").click(function (e) {
        $('.left-progress').text('0% Complete');
        $('#service-section').show();
        $('#schedule-section').hide();


        $('#service-btn-part-mobile').show();
        $('#schedule-btn-part-mobile').hide();
    })


    $("#mobile-schedule-prev").click(function (e) {

        $('.left-progress').text('33% Complete');
        $('#service-section').show();
        $('#schedule-section').hide();
        $('#confirm-section').hide();


        $('#service-btn-part-mobile').show();
        $('#schedule-btn-part-mobile').hide();
        $('#confirm-btn-part-mobile').hide();
    })



    $("#mobile-schedule-next").click(function (e) {

        $('.left-progress').text('67% Complete');
        $('#service-section').hide();
        $('#schedule-section').hide();
        $('#confirm-section').show();


        $('#service-btn-part-mobile').hide();
        $('#schedule-btn-part-mobile').hide();
        $('#confirm-btn-part-mobile').show();
    })


    $("#mobile-confirm-prev").click(function (e) {
        $('.left-progress').text('67% Complete');
        $('#service-section').hide();
        $('#schedule-section').show();
        $('#confirm-section').hide();


        $('#service-btn-part-mobile').hide();
        $('#schedule-btn-part-mobile').show();
        $('#confirm-btn-part-mobile').hide();
    })


    //  // Update the quantity in the modal when the quantity changes
    //  $('.product-quantity-change').on('click', function () {
    //     var product_id = $(this).closest('.card').find('.carpet_single_product_info').attr('product-id');
    //     var quantity = $(this).closest('.card').find('.input-number-qty').val();
    //     $('#selectedQuantity' + product_id).text(quantity);
    // });

    // // Reset the quantity to 0 when the modal is closed
    // $('[id^="productDetailsModal"]').on('hidden.bs.modal', function () {
    //     var product_id = $(this).attr('id').replace('productDetailsModal', '');
    //     $('#selectedQuantity' + product_id).text('0');
    // });







    // Decode the JSON string
    var filtered_selected_date_time = JSON.parse(carpet_checkout.filtered_selected_date_time);


    // Desktop Part
    // Create a new MutationObserver object
    var observer = new MutationObserver(handleContainerChanges);

    // Configuration options for the observer (observe changes to the attributes and child nodes of the document)
    var config = { attributes: true, childList: true, subtree: true };



    // Start observing the document for changes in the .myc-container element
    observer.observe(document.getElementById('big-screen-date-picker'), config);

    // Function to handle changes in the .myc-container element
    function handleContainerChanges(mutationsList, observer) {
        // Run your code when changes occur in the .myc-container element
        // Select all elements with class 'myc-available-time' within the .myc-container element
        $('#myc-container .myc-available-time').each(function () {
            // Get the value of 'data-date' and 'data-time' attributes
            var date = $(this).data('date');
            var time = $(this).data('time');


            // Loop through the filtered selected date and time array
            for (var i = 0; i < filtered_selected_date_time.length; i++) {
                var selectedDate = filtered_selected_date_time[i].selected_date;
                var selectedTime = filtered_selected_date_time[i].selected_time;

                // Check if the date and time match
                if (date === selectedDate && time === selectedTime) {
                    // Add the class 'time-disabled'
                    $(this).addClass('time-disabled');
                    // Exit the loop if a match is found
                    break;
                }
            }
        });
    }


    // Select all elements with class 'myc-available-time'
    $('.myc-available-time').each(function () {
        // Get the value of 'data-date' and 'data-time' attributes
        var date = $(this).data('date');
        var time = $(this).data('time');

        // Loop through the filtered selected date and time array
        for (var i = 0; i < filtered_selected_date_time.length; i++) {
            var selectedDate = filtered_selected_date_time[i].selected_date;
            var selectedTime = filtered_selected_date_time[i].selected_time;

            // Check if the date and time match
            if (date === selectedDate && time === selectedTime) {
                // Add the class 'disabled'
                $(this).addClass('time-disabled');
                // Exit the loop if a match is found
                break;
            }
        }
    });



    // mobile
    // Create a new MutationObserver object
    var mobileObserver = new MutationObserver(handleContainerChangesMobile);

    // Start observing the document for changes in the .myc-container element
    mobileObserver.observe(document.getElementById('mobile-date-available-time'), config);

    // Function to handle changes in the .myc-container element
    function handleContainerChangesMobile(mutationsList, observer) {
        // Run your code when changes occur in the .myc-container element
        // Select all elements with class 'myc-available-time' within the .myc-container element
        $('.myc-available-time-small').each(function () {
            // Get the value of 'data-date' and 'data-time' attributes
            var date = $(this).data('date');
            var time = $(this).data('time');


            // Loop through the filtered selected date and time array
            for (var i = 0; i < filtered_selected_date_time.length; i++) {
                var selectedDate = filtered_selected_date_time[i].selected_date;
                var selectedTime = filtered_selected_date_time[i].selected_time;
                // Check if the date and time match
                if (date === selectedDate && time === selectedTime) {
                    // Add the class 'time-disabled'
                    $(this).addClass('time-disabled');
                    // Exit the loop if a match is found
                    break;
                }
            }
        });
    }





    // Select all elements with class 'myc-available-time'
    $('.myc-available-time-small').each(function () {
        // Get the value of 'data-date' and 'data-time' attributes
        var date = $(this).data('date');
        var time = $(this).data('time');

        // Loop through the filtered selected date and time array
        for (var i = 0; i < filtered_selected_date_time.length; i++) {
            var selectedDate = filtered_selected_date_time[i].selected_date;
            var selectedTime = filtered_selected_date_time[i].selected_time;

            // Check if the date and time match
            if (date === selectedDate && time === selectedTime) {
                // Add the class 'disabled'
                $(this).addClass('time-disabled');
                // Exit the loop if a match is found
                break;
            }
        }
    });




});



// Function to format a date as 'yyyy-mm-dd'
function formatDate(date) {
    var year = date.getFullYear();
    var month = (date.getMonth() + 1).toString().padStart(2, '0');
    var day = date.getDate().toString().padStart(2, '0');
    return year + '-' + month + '-' + day;
}

