<div class="content">
    <div class="container">
        <div class="rating-wrapper">
            <div class="header-detail">
                <a class="back-btn" href="<?php echo BASEURL . "transaction"; ?>">
                    <img alt="back" width="26px"
                        src="<?php echo BASEURL; ?>img/back-icon.png"
                    >
                </a>
                <div class="movie-detail">
                    <div class="movie-title">
                        <?php echo $data["movie"]["title"] ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="rating-content">
            <form 
                action="<?php echo BASEURL . 'rating/update?review-id=' .
                    $data["review"]["idReview"] . '&movie-id=' .
                    $data["review"]["idMovie"]; ?>" 
                method="POST" 
                class="form-rating"
            >
                <div class="form-group">
                    <div class="rating-value">
                        <div class="row">
                            <div class="col-2 rating-content-title">Add Rating</div>
                            <div class="col-8 rating-content-value">
                                <?php
                                for ($i = 0; $i < 10; $i++) {
                                    echo '<span class="icon-star" id="star-' . $i .
                                    '">&#9733</span>';
                                }
                                ?>
                                <input 
                                    id="form-value" 
                                    name="value" 
                                    value="<?php echo $data["review"]["value"]; ?>" 
                                    hidden
                                >
                            </div>
                        </div>
                    </div>
                    <div class="rating-detail">
                        <div class="row">
                            <div class="col-2 rating-content-title">Add Review</div>
                            <div class="col-8 rating-content-review">
                                <textarea 
                                    class="form-review form-control" 
                                    name="review"
                                ><?php echo $data["review"]["text"]; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="btn-wrapper">
                        <a 
                            class="btn btn-white btn-rating" 
                            href="<?php echo BASEURL. "transaction" ?>"
                        >
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary btn-rating">
                            Edit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>