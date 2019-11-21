var loc = window.location.pathname;
loc = loc.split("/");
var dir = loc.slice(0, loc.lastIndexOf("public") + 1).join("/");
var btnDelete = document.getElementsByClassName('btn-delete-review');
var bookId = document.getElementsByClassName('book-id');
var movieId = document.getElementsByClassName('movie-id');
var userId = document.getElementById('user');
var arrBtn = [];
var page = document.getElementById('transaction-container');
var isTransactionSuccessExist = false;

for (let i = 0; i < btnDelete.length; i++) {
    arrBtn.push(btnDelete[i]);
}

for (let i = 0; i < btnDelete.length; i++) {
    btnDelete[i].addEventListener('click', function () {
        var id = arrBtn.indexOf(this);
        var idBook = bookId[id].value;
        var idMovie = movieId[id].value;

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                location.reload();
            }
        }
        xhr.open('DELETE', 'api/deleteReview?book-id=' + idBook + '&movie-id=' + idMovie);
        xhr.send();
    })
}

function createAddReview(transactionDetail, transaction) {
    // <div class="btn-wrapper"> for AddReview
    const btnWrapper1 = document.createElement('div');
    btnWrapper1.setAttribute('class', 'btn-wrapper');
    transactionDetail.appendChild(btnWrapper1);

    //<a class="btn btn-primary btn-transaction" src = ...> Add Review</a>
    const addReviewButton = document.createElement('a');
    addReviewButton.setAttribute('class', 'btn btn-primary btn-transaction');
    addReviewButton.href = dir + '/rating/new?book-id=' + transaction.idTransaksi;
    addReviewButton.textContent = 'Add Review';
    btnWrapper1.appendChild(addReviewButton);
}

function haveBeenSubmitted(transactionDetail){
    // <div class="transaction-text">Your review has been submitted</div>
    const transactionText = document.createElement('div');
    transactionText.setAttribute('class', 'transaction-text');
    transactionText.textContent = "Your review has been submitted";
    transactionDetail.appendChild(transactionText);
}

function createEditDeleteReview(transactionDetail, transaction) {
    // <div class="btn-wrapper">
    const btnWrapper2 = document.createElement('div');
    btnWrapper2.setAttribute('class', 'btn-wrapper');
    transactionDetail.appendChild(btnWrapper2);
    
    // <button class="btn btn-danger btn-transaction btn-delete-review" id="<?php echo $i?>">
    const deleteButton = document.createElement('button');
    deleteButton.setAttribute('class', 'btn btn-danger btn-transaction btn-delete-review');
    deleteButton.setAttribute('id', transaction.idTransaksi);
    deleteButton.textContent = 'Delete';
    btnWrapper2.appendChild(deleteButton);

    // <a class="btn btn-success btn-transaction" href="<?php echo BASEURL . "rating/edit?book-id=" .$book["idBook"] ?>"
    const editLink = document.createElement('a');
    editLink.setAttribute('class', 'btn btn-success btn-transaction');
    editLink.href = dir + './rating/edit?book-id=' + transaction.idTransaksi;
    editLink.textContent = 'Edit Review';
    btnWrapper2.appendChild(editLink); 
}

function cekDBMovie(transaction) {
    var xhr2 = new XMLHttpRequest();
    xhr2.onreadystatechange = function () {
        if (xhr2.status === 200 && xhr2.readyState === 4) {
            

            const response = JSON.parse(this.response);
            const movieDetail = response.result.movie;
            const movieSchedule = response.result.schedule;

            // <div class="transaction-wrapper">
            const transactionWrapper = document.createElement('div');
            transactionWrapper.setAttribute('class', 'transaction-wrapper');
            page.appendChild(transactionWrapper);

            
            // <div class="row">
            const row = document.createElement('div');
            row.setAttribute('class', 'row');
            transactionWrapper.appendChild(row);

            // <div class="col-1 transaction-poster-wrapper">
            const posterWrapper = document.createElement('div');
            posterWrapper.setAttribute('class', 'col-1 transaction-poster-wrapper');
            row.appendChild(posterWrapper);

            // img src = ...
            const moviePoster = document.createElement('img');
            moviePoster.src = movieDetail.poster;
            moviePoster.setAttribute('class', 'transaction-poster');
            posterWrapper.appendChild(moviePoster);
            
            // <div class="col-9 transaction-detail px-auto">
            const transactionDetail = document.createElement('div');
            transactionDetail.setAttribute('class', 'col-9 transaction-detail px-auto');
            row.appendChild(transactionDetail);

            // <div class="transaction-title">
            const transactionTitle = document.createElement('div');
            transactionTitle.setAttribute('class', 'transaction-title');
            transactionTitle.textContent = movieDetail.title;
            transactionDetail.appendChild(transactionTitle);
            

            // <div class="transaction-schedule">
            const transactionSchedule = document.createElement('div');
            transactionSchedule.setAttribute('class', 'transaction-schedule');
            transactionDetail.appendChild(transactionSchedule);

            // <span>Schedule: </span>
            const schedule = document.createElement('span');
            schedule.textContent = 'Schedule: ';
            transactionSchedule.appendChild(schedule);

            transactionDetail.textContent = movieSchedule.dateTime;

            // CEK WAKTU
            const jamMovie = new Date(movieSchedule.dateTime);
            if (jamMovie < Date.now()){
                // createAddReview(transactionDetail, transaction);
                if (movieSchedule.isRated == 1) {
                    createEditDeleteReview(transactionDetail, transaction);
                } else {
                    createAddReview(transactionDetail, transaction);
                }
            } 
        }
    }
    xhr2.open('GET', 'api/getTransaction?movie-id=' + transaction.idMovie + '&schedule-id=' + transaction.idSchedule);
    xhr2.send();
}

function transactionHistory() {
    var xhr = new XMLHttpRequest();
    
    console.log(userId.value);
    xhr.onreadystatechange = function () {
        if (xhr.status === 200 && xhr.readyState === 4) {
            const dataTransaksi = JSON.parse(this.response);

            // console.log(dataTransaksi);

            dataTransaksi.transaction.forEach((transaction) => {
                if (transaction.status == 'success') {
                    cekDBMovie(transaction);
                    isTransactionSuccessExist = true;
                } else if (transaction.status == 'pending') {
                    // panggil ws-bank
                    // kalau udah bayar maka editTransaction dipanggil
                    // kalau belum yaudah
                } else { //transaction.status == 'cancelled'

                }
            })

            if (isTransactionSuccessExist){
                document.getElementById('loading').style.display = "none";
            } else {
                document.getElementById('loading').textContent = "No Transaction Found";
            }
        }
    }
    xhr.open('GET', 'http://34.227.112.253:3000/get?idUser=' + userId.value);
    xhr.send();
}


window.onload = function () {
    transactionHistory();
}