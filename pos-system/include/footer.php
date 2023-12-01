    <script src="./assets/js/qty-selector.js"></script>

    <!-- Preloader -->
    <!-- <div id="preloader">
        <div id="filler"></div>
    </div> -->
    <style>
        .footer-credit {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            z-index: 999 !important;
            background-color: #fff;
            display: flex;
            justify-content: space-between;
            /* This will push the date-time to the left and credit to the right. */
            padding: 10px;
        }

        #date-time {
            margin: 0;
            font-weight: 700;
            padding: 0;
        }

        .credit-text {
            font-weight: 700;
        }

        #logged-user span {
            font-weight: 700;
            margin-left: 5px;
        }
    </style>

    <div class="footer-credit">
        <div id="logged-user"><i class="fa-solid fa-user"></i> <span><?= $LoggedName ?></span></div>
        <div id="logged-user"><i class="fa-solid fa-location-dot"></i> <span><?= $Locations[$LocationID]['location_name'] ?></span></div>
        <div id="date-time"></div>
        <div class="credit-text">Powered By Payshia.com</div>
    </div>


    <script>
        // Function to update the date and time element
        function updateDateTime() {
            const dateTimeElement = document.getElementById('date-time');
            const currentDate = new Date();
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
            };
            const formattedDate = currentDate.toLocaleDateString('en-US', options);

            dateTimeElement.textContent = formattedDate;
        }

        // Call the function to update the date and time immediately
        updateDateTime();

        // Set an interval to update the date and time every second (1000 milliseconds)
        setInterval(updateDateTime, 1000);
    </script>


    <!-- Preloader -->
    <div id="inner-preloader-content" class="preloader-content">
        <div class=" text-center">
            <div class="card-body p-5 my-5">
                <img src="../assets/images/loader.svg" alt="">
                <p class="mb-0">Please Wait...</p>
            </div>
        </div>
    </div>

    <div id="component-preloader-content" class="preloader-content">
        <div class=" text-center">
            <div class="card-body p-5 my-5">
                <img src="../assets/images/loader.svg" alt="">
            </div>
        </div>
    </div>


    <div class="loading-popup" id="loading-popup">
        <div class="loading-popup-content" id="loading-popup-content">
            <div class="row mb-4">
                <div class="col-4 offset-4 text-center">
                    <img src="./assets/images/pos-logo.png" style="height: 40px">
                </div>
                <div class="col-4 text-end mb-2">
                    <button class="btn btn-sm btn-light x-button" onclick="ClosePopUP()"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <div id="pop-content"></div>
        </div>
    </div>

    <div id="error-log"></div>



    <div class="popup" id="notification"></div>

    <!-- Add Scripts -->
    <script src="./vendor/jquery/jquery-3.7.1.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>