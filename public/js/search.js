var prevButton = document.getElementById("btn-prev")
var nextButton = document.getElementById("btn-next")
var pageButton = document.getElementsByClassName("btn-page")
var inputPage = document.getElementById("input-page")
var searchWrapper = document.getElementById("search-wrapper-id")
var pageCount = document.getElementById("page-count").value
var keyword = document.getElementById("keyword").value
var btnWrapper = document.getElementById("pagination")

var loc = window.location.pathname;
loc = loc.split("/");
var dir = loc.slice(0, loc.lastIndexOf("public") + 1).join("/");

function formatMovieHtml(result, index) {
    return `
        <div class="row">
            <div class="col-2">
                ${poster}
            </div>
            <div class="col-7 search-detail px-auto">
                <div class="search-title">
                    ${result[index].title}
                </div>
                <div class="search-rating">
                    <img src="${dir + '/img/star.png'}" width="10" height="10"> ${result[index].rating}
                </div>
                <p>${result[index].description}</p>
            </div>
            <div class="search-view">
                <a href="${dir + '/movie/detail?id=' + result[index].idMovie}">
                    View details <img src="${dir + '/img/chevron.png'}" width="15" height="15">
                </a>
            </div>
        </div>`
}

function addMovie(page, parent, xhr) {
    var result = JSON.parse(xhr.responseText);
    var holder = '';
    for (let index = 0; index < result.length; index++) {
        holder += formatMovieHtml(result, index);
    }
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
    xhr.onreadystatechange = function () {

        if (xhr.readyState == 4 && xhr.status == 200) {
            addMovie(page, parent, xhr);
        }
    }
    xhr.open('GET', dir + '/api/search?q=' + keyword + '&page=' + page);
    xhr.send();
}

nextButton.addEventListener("click", function () {
    var page = inputPage.value
    inputPage.value = parseInt(page, 10) + 1
    ajax(inputPage.value, searchWrapper);
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
    ajax(inputPage.value, searchWrapper);
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
        ajax(inputPage.value, searchWrapper);
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