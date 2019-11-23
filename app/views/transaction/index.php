<div class="content">
    <div class="container" id="transaction-container">
        <h1 class="main-title">Transaction History</h1>
        <input 
            type="hidden" 
            id="user"
            value="<?php echo $data['userId'] ?>"
        >
        <p id='loading'>
            Loading....
        </p>
        <div id="transaction-history-container"></div>
        <!-- <?php
            $books = $data["books"];
        for ($i = 0; $i < count($books); $i++) {
            $book = $books[$i];
            ?>
        <div class="transaction-wrapper">
            <div class="row">
                <div class="col-1 transaction-poster-wrapper">
                    <img 
                        src=<?php echo BASEURL . $book['poster'] ?> 
                        class="transaction-poster"
                    >
                </div>
                <div class="col-9 transaction-detail px-auto">
                    <div class="transaction-title">
                    <?php echo $book["title"] ?>
                    </div>
                    <div class="transaction-schedule">
                        <span>Schedule: </span>
                    <?php
                        echo date_format(
                            date_create($book["dateTime"]),
                            "F d, Y - h:i A"
                        );
                    ?>
                    </div>
                    <?php
                    date_default_timezone_set('Asia/Jakarta');
                    if (strtotime($book["dateTime"]) <= time()) {
                        if ((int) $book["isRate"] == 0) {
                            ?>
                    <div class="btn-wrapper">
                        <a 
                            class="btn btn-primary btn-transaction" 
                            href="<?php echo BASEURL . "rating/new?book-id=" .
                            $book["idBook"] ?>"
                        >
                            Add Review
                        </a>
                    </div>
                            <?php
                        } else {
                            ?>
                    <div class="transaction-text">
                        Your review has been submitted
                    </div>
                    <input 
                        type="hidden" 
                        class="book-id" 
                        value="<?php echo $book["idBook"] ?>"
                    >
                    <input 
                        type="hidden" 
                        class="movie-id" 
                        value="<?php echo $book["idMovie"] ?>"
                    >
                    <div class="btn-wrapper">
                        <button 
                            class="btn btn-danger btn-transaction btn-delete-review" 
                            id="<?php echo $i?>"
                        >
                            Delete Review
                        </button>
                        <a 
                            class="btn btn-success btn-transaction" 
                            href="<?php echo BASEURL . "rating/edit?book-id=" .
                            $book["idBook"] ?>"
                        >
                            Edit Review
                        </a>
                    </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
            <?php
            if ($i + 1 != count($books)) {
                echo "<hr>";
            }
        }
        ?> -->
    </div>
</div>