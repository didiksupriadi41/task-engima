var loc = window.location.pathname;
loc = loc.split("/");
var dir = loc.slice(0, loc.lastIndexOf("public") + 1).join("/");
var userId = document.getElementById('user');
var container = document.getElementById('transaction-history-container');
const render_time_out = 1000;
const call_time_out = 1000;

function convertDate(tanggal) {
    let dd = tanggal.getDate();
    let mm = tanggal.getMonth() + 1;
    let yyyy = tanggal.getFullYear();

    let hh = tanggal.getHours();
    let ii = tanggal.getMinutes();
    let ss = tanggal.getSeconds();

    return `${yyyy}-${mm}-${dd} ${hh}:${ii}:${ss}`;
}

function isEmpty(obj) {
    for(var key in obj) {
        if(obj.hasOwnProperty(key))
            return false;
    }
    return true;
}

function setIsRatedWS(isRate, id) {
    let xhr2 = new XMLHttpRequest();
    xhr2.onreadystatechange = function () {
        if (xhr2.readyState == 4 && xhr2.status == 200) {
            location.reload();
        }
    }
    xhr2.open('POST', 'http://34.227.112.253:3000/rate', true);
    let param = {
        idTransaksi: id,
        val: isRate
    };
    xhr2.setRequestHeader("Content-Type", "application/json");
    xhr2.send(JSON.stringify(param));
}

function deleteReview(id) {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            setIsRatedWS(0, id);
        }
    }
    xhr.open('DELETE', 'api/deleteReview?book-id=' + id);
    xhr.send();
}

function createAddReview(transactionDetail, transaction) {
    // <div class="btn-wrapper"> for AddReview
    const btnWrapper1 = document.createElement('div');
    btnWrapper1.setAttribute('class', 'btn-wrapper');
    transactionDetail.appendChild(btnWrapper1);

    //<a class="btn btn-primary btn-transaction" src = ...> Add Review</a>
    const addReviewButton = document.createElement('a');
    addReviewButton.setAttribute('class', 'btn btn-primary btn-transaction');
    addReviewButton.href = dir + '/rating/new?book-id=' + transaction.idTransaksi
        // + '&schedule-id=' + transaction.idSchedule
        + '&movie-id=' + transaction.idMovie;
    addReviewButton.textContent = 'Add Review';
    btnWrapper1.appendChild(addReviewButton);
}

function haveBeenSubmitted(transactionDetail) {
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
    deleteButton.addEventListener("click", function () {
        deleteReview(transaction.idTransaksi)
    });
    btnWrapper2.appendChild(deleteButton);

    // <a class="btn btn-success btn-transaction" href="<?php echo BASEURL . "rating/edit?book-id=" .$book["idBook"] ?>"
    const editLink = document.createElement('a');
    editLink.setAttribute('class', 'btn btn-success btn-transaction');
    editLink.href = dir + '/rating/edit?book-id=' + transaction.idTransaksi
    // + "&schedule-id=" + transaction.idSchedule;
    editLink.textContent = 'Edit Review';
    btnWrapper2.appendChild(editLink);
}

function countDown(parent, fromTime) {
    const transactionTimer = document.createElement('div');
    transactionTimer.setAttribute('class', 'transaction-schedule');
                
    const timer = document.createElement('span');
    timer.textContent = 'Time Left(s): ';
    transactionTimer.appendChild(timer);
    
    let now = new Date();
    let diff = new Date(fromTime - now);
    let min = String(Math.max(Math.floor(diff/(1000*60)), 0));
    let dtk = String(Math.max(Math.floor((diff % (1000*60))/(1000)), 0));
    
    const time = document.createElement('span');

    time.style.color = `rgb(${255-(parseInt(dtk,10) + parseInt(min,10)*60)*2},0,0)`;
    time.innerHTML = `${min.padStart(2,"0")}:${dtk.padStart(2,"0")}`;
    // parent.innerHTML 
    transactionTimer.appendChild(time);
    parent.replaceWith(transactionTimer);
    if (min != "0" || dtk != "0"){
        setTimeout(() => {countDown(transactionTimer, fromTime)},1000);
    }   
}

function generateTransactionWrapper(transaction, parent) {
    let xhr2 = new XMLHttpRequest();
    xhr2.onreadystatechange = function () {
        if (xhr2.status === 200 && xhr2.readyState === 4) {
            const response = JSON.parse(this.response);
            const movieDetail = response.result.movie;
            const movieSchedule = response.result.schedule;

            // <div class="transaction-wrapper">
            const transactionWrapper = document.createElement('div');
            transactionWrapper.setAttribute('class', 'transaction-wrapper');
            transactionWrapper.setAttribute('id', `trans-wrap-${transaction.idTransaksi}`)
            // container.appendChild(transactionWrapper);
            
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
            moviePoster.src = movieDetail.poster ? movieDetail.poster : `${dir}/img/no_img_placeholder.jpg`;
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
            
            transactionSchedule.innerHTML += movieSchedule.dateTime;
            
            // <div class="transaction-schedule">
            const transactionStatus = document.createElement('div');
            transactionStatus.setAttribute('class', 'transaction-schedule');
            transactionDetail.appendChild(transactionStatus);
            
            // <span>Schedule: </span>
            const status = document.createElement('span');
            status.textContent = 'Status: ';
            transactionStatus.appendChild(status);
            
            transactionStatus.innerHTML += transaction.status;
            
            if (transaction.status === "success") {
                transactionStatus.style.color = "green";
            } else if (transaction.status === "cancelled") {
                transactionStatus.style.color = "red";
            } else if (transaction.status === "pending") {
                transactionStatus.style.color = "blue";

                // <div class="transaction-schedule">
                const virtualAccount = document.createElement('div');
                virtualAccount.setAttribute('class', 'transaction-schedule');
                transactionDetail.appendChild(virtualAccount);
                
                // <span>Schedule: </span>
                const VAText = document.createElement('span');
                VAText.textContent = 'Virtual Account: ';
                virtualAccount.appendChild(VAText);
                
                virtualAccount.innerHTML += transaction.virtualAccount;

                const transactionTimer = document.createElement('div');
                transactionDetail.appendChild(transactionTimer);
                var dateLine = new Date(transaction.creationTime);
                dateLine.setMinutes(dateLine.getMinutes() + 2);
                setTimeout(() => {countDown(transactionTimer, dateLine)},1000);
            }
            const jamMovie = new Date(movieSchedule.dateTime);
            if (jamMovie < Date.now() && transaction.status === "success") {
                if (transaction.isRated == 1) {
                    haveBeenSubmitted(transactionDetail);
                    createEditDeleteReview(transactionDetail, transaction);
                } else {
                    createAddReview(transactionDetail, transaction);
                }
            }
            parent.replaceWith(transactionWrapper);
        }
    }
    xhr2.open('GET', 'api/getTransaction?movie-id=' + transaction.idMovie + '&schedule-id=' + transaction.idSchedule);
    xhr2.send();
}

function transactionHistory(successTransaction) {
    
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.status === 200 && xhr.readyState === 4) {
            const dataTransaksi =JSON.parse(this.response);
            for (let index = 0; index < dataTransaksi.transaction.length; index++) {
                const transaction = dataTransaksi.transaction[index];
                if (successTransaction.filter(
                    trans => 
                    trans.id === transaction.idTransaksi).length == 0) {                   
                        
                    successTransaction.push({
                        id: transaction.idTransaksi,
                        status: transaction.status
                    });
                    let tempDiv = document.createElement('div');
                    container.appendChild(tempDiv);
                    generateTransactionWrapper(transaction, tempDiv);
                } else if (successTransaction.filter(
                    trans => 
                    trans.id === transaction.idTransaksi &&
                    trans.status === "pending").length > 0 && transaction.status != "pending") {
                        
                    let tempDiv = document.getElementById(`trans-wrap-${transaction.idTransaksi}`);
                    generateTransactionWrapper(transaction, tempDiv);
                }
            }

            if (dataTransaksi.transaction.length) {
                document.getElementById('loading').style.display = "none";
            } else {
                document.getElementById('loading').textContent = "No Transaction Found";
            }
            setTimeout(() => {transactionHistory(successTransaction)}, render_time_out);
        }
    }
    xhr.open('GET', 'http://34.227.112.253:3000/get?idUser=' + userId.value);
    xhr.send();
}

async function cekPayStatus() {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.status === 200 && xhr.readyState === 4) {
            const dataTransaksi = JSON.parse(this.response);
            const data = dataTransaksi.transaction;
            data.forEach((transaction) => {
                if (transaction.status == 'pending') {
                    let dateLine = new Date(transaction.creationTime);
                    dateLine.setMinutes(dateLine.getMinutes() + 2);

                    let xhr2 = new XMLHttpRequest();
                    
                    let soapRequest = 
                    '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ws="http://ws.test.org/">'
                    + '<soapenv:Header/>'
                    + '<soapenv:Body>'
                        + '<ws:checkTransactionBetween>'
                            + '<linkedNumber>' + transaction.virtualAccount + '</linkedNumber>'
                            + '<amount>45000</amount>'
                            + '<startDate>' + transaction.creationTime + '</startDate>'
                            + '<endDate>' + convertDate(dateLine) + '</endDate>'
                        + '</ws:checkTransactionBetween>'
                    + '</soapenv:Body>'
                    + '</soapenv:Envelope>';
    
                    xhr2.open('POST', dir + '/api/wsdl', true);
                    xhr2.onreadystatechange = function () {
                        if (xhr2.status === 200 && xhr2.readyState === 4) {

                            response = JSON.parse(xhr2.response);
                            let waktu = response.return.Body.checkTransactionBetweenResponse.return;
                            if (isEmpty(waktu)) {
                                let now = new Date();
                                if (dateLine < now) {
                                    let xhr3 = new XMLHttpRequest();
                                    xhr3.open('POST', 'http://34.227.112.253:3000/edit', true);
                                    let param1 = {
                                        idTransaksi: transaction.idTransaksi,
                                        waktuBayar: convertDate(now)
                                    };
                                    xhr3.setRequestHeader("Content-Type", "application/json");
                                    xhr3.send(JSON.stringify(param1));
                                } 
                            } else {
                                let xhr4 = new XMLHttpRequest();
                                xhr4.open('POST', 'http://34.227.112.253:3000/edit', true);
                                let param2 = {
                                    idTransaksi: transaction.idTransaksi,
                                    waktuBayar: waktu
                                };
                                xhr4.setRequestHeader("Content-Type", "application/json");
                                xhr4.send(JSON.stringify(param2));
                            }
                        }
                    }
                    xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr2.send("envelope=" + soapRequest);
                }
            })
        }
    }
    xhr.open('GET', 'http://34.227.112.253:3000/get?idUser=' + userId.value);
    xhr.send();
    return new Promise(() => {
        setTimeout(() => { cekPayStatus() }, call_time_out)
    })
}

window.onload = async function () {
    let successTransaction = []; 
    cekPayStatus();
    transactionHistory(successTransaction);
}
