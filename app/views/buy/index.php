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
                        <?php echo $data["schedule"]["title"] ?>
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
                        if (in_array((string) $i, $data["disabled_seat"])) {
                            echo "<button class=\"chair\" disabled>" . $i . "</button>";
                        } else {
                            echo "<button class=\"chair\">" . $i . "</button>";
                        }
                    }
                    ?>
                </div>
                <div class="cinema-screen">
                    Screen
                </div>
            </div>
            <input type="text" hidden id="input-seat-number" name="seat-number">
            <input type="text" hidden id="input-schedule-id" name="schedule-id" 
                value=<?php echo $data["schedule"]["idSchedule"] ?>
            >
            <input type="text" hidden id="input-movie-id" name="movie-id" 
                value=<?php echo $data["schedule"]["idMovie"] ?>
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
                Payment Success!
            </div>
            <div class="payment-desc" id="payment-desc-id">
                Thank you for purchasing! You can view your purchase now.
            </div>
            <div class="goto-transaction nav-item" id="goto-transaction-id">
                <a href="<?php echo BASEURL; ?>transaction">
                    Go to transaction history
                </a>
            </div>
        </div>
    </div>
</div>