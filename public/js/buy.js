var movie_title = document.getElementById("movie-title-id");
var movie_time = document.getElementById("movie-time-id");
var chairs = document.getElementsByClassName("chair");
var summary_wrapper = document.getElementById("summary-wrapper-id");
var input_user_id = document.getElementById("input-user-id");
var back_btn = document.getElementById("back-btn-id");
var buy_modal_wrapper = document.getElementById("buy-modal-wrapper-id");
var content = document.getElementsByClassName("content");
var buy_container = content[0].getElementsByClassName("container");
var chair_layout = document.getElementsByClassName("chair");
var time_out = 3000;
var loc = window.location.pathname;
loc = loc.split("/");
var dir = loc.slice(0, loc.lastIndexOf("public") + 1).join("/");

var urlParams = new URLSearchParams(window.location.search);

function wrapper(number) {
    var title = movie_title.innerText;
    var time = movie_time.innerText;
    return `
        <div class="selected">
            <div class="movie-summary">
                <div class="summary-title">
                    ${title}
                </div>
                <div class="summary-subtitle">
                    ${time}
                </div>
            </div>
            <div class="seat-summary">
                <div class="seat">
                    Seat #${number}
                </div>
            <div class="price">
                Rp 45.000
            </div>
        </div>
    <button class="buy-ticket" id="buy-ticket-id">
        Buy Ticket
    </button>
    </div>`;
}

for (var i = 0; i < chairs.length; i++) {
    chairs[i].addEventListener("click", function () {
        var temp = this.textContent
        // input_seat_number.value = temp;
        summary_wrapper.innerHTML = wrapper(temp);
        var buy_btn = document.getElementById("buy-ticket-id");

        buy_btn.addEventListener("click", function () {
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        buy_container[0].style.opacity = 0.5;
                        buy_modal_wrapper.style.display = "flex";
                        var temp = JSON.parse(xhr.responseText);
                        if (!temp.result) {
                            var title = document.getElementById("payment-title-id");
                            var desc = document.getElementById("payment-desc-id");
                            var btn = document.getElementById("goto-transaction-id");
                            title.innerText = "Payment Fail!";
                            desc.innerText = "Please check your booking seat again."
                            btn.style.display = "none";
                        }
                    }
                }
            }
            var param = `schedule-id=${urlParams.get("schedule-id")}&seat-number=${temp}`;

            xhr.open('POST', dir + "/api/book", true);
            // var urlTransaksi = `http://127.0.0.1:3000/transaksi?idUser=${input_user_id.value}&virtualAccount=0&idMovie=${urlParams.get("movie-id")}&idSchedule=${urlParams.get("schedule-id")}&seat=${temp}`;
            // xhr.open('GET', urlTransaksi, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send(param);

        })
    })
}

back_btn.addEventListener("click", function () {
    window.location.replace(`detail?id=${urlParams.get("movie-id")}`);
})

window.onclick = function (event) {
    if (event.target == buy_modal_wrapper) {
        window.location.reload();
    }
}


function fetchchair() {
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                response.data.forEach(function (item) {
                    chair_layout[item.seat - 1].disabled = true;
                });
                setTimeout(fetchchair, time_out);
            }
        }
    }
    var param = `schedule-id=${urlParams.get("schedule-id")} `;

    var url = dir + '/api/chairCheck?' + param
    xhr.open('GET', url, true);
    xhr.send();
}

window.onload = function () {
    this.setTimeout(fetchchair, time_out);
};

