<div class="content">
    <div class="container">
        <div class="buy-wrapper">
            <div class="header-detail">
                <div class="back-btn" id="back-btn-id">
                    <img 
                        src="<?php echo BASEURL; ?>img/back-icon.png"
                        alt="back"
                        width="26px"
                    >
                </div>
                <div class="movie-detail">
                    <div class="movie-title" id="movie-title-id">
                        <?php echo $data["movie"]["title"] ?>
                    </div>
                    <div clas="movie-time" id="movie-time-id">
                        <?php echo date_format(
                            date_create($data["schedule"]["dateTime"]),
                            "F d, Y - h:i A"
                        )?>
                    </div>
                </div>
            </div>
            <div class="cinema-layout">
                <div class="chair-layout">
                    <?php
                    for ($i = 1; $i <= 30; $i++) {
                        echo "<button class=\"chair\">" . $i . "</button>";
                        // if (in_array((string) $i, $data["disabled_seat"])) {
                        //     echo "<button class=\"chair\" disabled>" . $i . "</button>";
                        // } else {
                        // }
                    }
                    ?>
                </div>
                <div class="cinema-screen">
                    Screen
                </div>
            </div>
            <input type="text" hidden id="input-seat-number" name="seat-number">
            <input type="text" hidden id="input-user-id" name="user-id" 
                value=<?php echo $data["idUser"]?>
            >
            <div class="booking-summary">
                <div class="booking-title">
                    Booking Summary
                </div>
                <div class="summary-wrapper" id="summary-wrapper-id">
                    <div class="not-selected">
                        You haven't selected any seat yet. 
                        Please click on one of the seat provided.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="buy-modal-wrapper" id="buy-modal-wrapper-id">
        <div class="buy-modal">
            <div class="payment-title" id="payment-title-id">
                Booking Success!
            </div>
            <div class="payment-desc" id="payment-desc-id">
                Your booking is pending.<br>Please transfer Rp 45.000 in 2 minute to 
            </div>
            <div class="goto-transaction nav-item" id="goto-transaction-id">
                <a href="<?php echo BASEURL; ?>transaction">
                    Go to transaction history
                </a>
            </div>
        </div>
    </div>
</div>