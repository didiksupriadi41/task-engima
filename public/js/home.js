var prevButton = document.getElementById("btn-prev")
var nextButton = document.getElementById("btn-next")
var pageButton = document.getElementsByClassName("btn-page")
var inputPage = document.getElementById("input-page")
var mainMovieWrapper = document.getElementById("main-movie-wrapper-id")
var pageCount = document.getElementById("page-count").value
var btnWrapper = document.getElementById("pagination")

var loc = window.location.pathname;
loc = loc.split("/");
var dir = loc.slice(0, loc.lastIndexOf("public") + 1).join("/");

function formatMovieHtml(result, index) {
    var poster = (result[index].poster == null) ?
        '<i class="no_image_holder"></i>' :
        `<img class="home-poster" src="${result[index].poster}">`;
    return `
        <div class="col-2">
            <a class="movie-link" href="${dir}/movie/detail?id=${result[index].idMovie}">
                <div class="movie-home-wrapper">
                    <div class="home-poster-wrapper">
                        ${poster}
                    </div>
                    <div class="home-movie-title">
                        ${result[index].title}
                    </div>
                    <div class="home-rating-wrapper">
                        <img class="home-star" src="${dir}/img/star.png">
                        <span class="home-rating">
                            ${result[index].rating}
                        </span>
                    </div>
                </div>
            </a>
        </div>`;
}

function addMovie(page, parent, xhr) {
    var result = JSON.parse(xhr.responseText);
    var holder = '';
    var nCol = 5;
    var rowCount = Math.ceil(result.length / nCol);
    var index = 0;
    for (let row = 0; row < rowCount; row++) {
        holder += '<div class="row row-movie">';
        for (var col = 0; col < nCol && index < result.length; col++) {
            holder += formatMovieHtml(result, index);
            index++;
        }
        holder += '</div>';
    }
    console.log(holder);

    parent.innerHTML = holder;
    var pagination = 5;
    if (parseInt(pageCount, 10) < pagination) {
        pagination = parseInt(pageCount, 10);
    }
    if (parseInt(inputPage.value, 10) <= Math.floor(pagination / 2)) {
        for (let i = 0; i < pagination; i++) {
            pageButton[i].innerHTML = i + 1;
            pageButton[i].disabled = false;
            if (i + 1 == inputPage.value) {
                pageButton[i].disabled = true;
            }
        }
    } else if (parseInt(inputPage.value, 10) > parseInt(pageCount, 10) - Math.floor(pagination / 2)) {
        let i = pagination;
        while (i > 0) {
            pageButton[pagination - i].innerHTML = parseInt(pageCount, 10) - i + 1
            pageButton[pagination - i].disabled = false;
            if ((parseInt(pageCount, 10) - i + 1) == inputPage.value) {
                pageButton[pagination - i].disabled = true;
            }
            i -= 1;
        }
    } else {
        for (let i = 0; i < pagination; i++) {
            pageButton[i].innerHTML = parseInt(page, 10) + i - (pagination - Math.ceil(pagination / 2))
            pageButton[i].disabled = false;
            if ((parseInt(page, 10) + i - (pagination - Math.ceil(pagination / 2))) == inputPage.value) {
                pageButton[i].disabled = true;
            }
        }
    }
}


function ajax(page, parent) {
    var xhr = new XMLHttpRequest();
    xhr.withCredentials = true;
    xhr.onreadystatechange = function () {

        if (xhr.readyState == 4 && xhr.status == 200) {
            addMovie(page, parent, xhr);
        }
    }

    xhr.open('GET', dir + '/api/home?page=' + page);
    xhr.send();
}

nextButton.addEventListener("click", function () {
    var page = inputPage.value
    inputPage.value = parseInt(page, 10) + 1
    ajax(inputPage.value, mainMovieWrapper);
    if (parseInt(page, 10) + 1 == parseInt(pageCount, 10)) {
        nextButton.disabled = true;
    }
    if (parseInt(page, 10) - 1 != 1) {
        prevButton.disabled = false;
    }
})

prevButton.addEventListener("click", function () {
    var page = inputPage.value
    inputPage.value = parseInt(page, 10) - 1
    ajax(inputPage.value, mainMovieWrapper);
    if (parseInt(page, 10) + 1 != parseInt(pageCount, 10)) {
        nextButton.disabled = false;
    }
    if (parseInt(page, 10) - 1 == 1) {
        prevButton.disabled = true;
    }
})

for (var i = 0; i < pageButton.length; i++) {
    pageButton[i].addEventListener('click', function () {
        var page = parseInt(this.innerHTML, 10);
        inputPage.value = page;
        ajax(inputPage.value, mainMovieWrapper);
        if (parseInt(page, 10) == parseInt(pageCount, 10)) {
            nextButton.disabled = true;
        } else {
            nextButton.disabled = false;
        }
        if (parseInt(page, 10) == 1) {
            prevButton.disabled = true;
        } else {
            prevButton.disabled = false;
        }
    })
}

window.onload = function () {
    if (pageCount < 2) {
        btnWrapper.style.display = "none";
    } else {
        prevButton.disabled = true;
        pageButton[0].disabled = true;
        if (pageCount == 1) {
            nextButton.disabled = true;
        }

    }
};