var btnDelete = document.getElementsByClassName('btn-delete-review');
var bookId = document.getElementsByClassName('book-id');
var movieId = document.getElementsByClassName('movie-id');
var arrBtn = [];

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