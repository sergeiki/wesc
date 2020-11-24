$(document).ready(function () {
  // for fav
  $(".fa-shopping-basket").toggleClass("fav");
  $(".fa-shopping-basket").click(function () {
    $(this).toggleClass("fav");
  });
  // flop
  $(".quick-detail").click(function () {
    id = ".product#p" + $(this).attr("data");
    $(id).toggleClass("flip");
  });
});