var formValue = document.getElementById('form-value');
var value = formValue.value;
var iconStars = [];

for (var i = 0; i < 10; i++) {
  var icon = 'star-' + i;
  var temp = document.getElementById(icon);
  iconStars.push(temp);
}

iconStars.forEach(function (icon) {
  icon.addEventListener("click", function () {
    var index = iconStars.indexOf(this);
    formValue.value = index + 1;
    for (let i = 0; i < 10; i++) {
      iconStars[i].style.color = '#d7d7d7';
    }
    for (let i = 0; i <= index; i++) {
      iconStars[i].style.color = '#fdb703';
    }
  })
})

for (let i = 0; i < value; i++) {
  iconStars[i].style.color = '#fdb703';
}