$(document).ready(function() {
  // Check for dark mode cookie
  if (getCookie("darkMode") === "true") {
    enableDarkMode();
  }

  // Toggle dark mode on click
  $("#darkButton").on("click", function() {
    toggleDarkMode();
  });
});

function toggleDarkMode() {
  if ($("body").hasClass("light")) {
    enableDarkMode();
    // Set dark mode cookie
    setCookie("darkMode", "true", 365);
  } else {
    disableDarkMode();
    // Delete dark mode cookie
    deleteCookie("darkMode");
  }
}

function enableDarkMode() {
  var href = $("#color-link").attr("href");
  var split = href.split("/").pop().split(".").shift();
  $("body").removeClass("light").addClass("dark");
  document.getElementById("color-link").setAttribute("href", "/App/Public/template/front-end/assets/css/" + split + "_dark.css");
}

function disableDarkMode() {
  var href = $("#color-link").attr("href");
  var split = href.split("/").pop().split(".").shift().split("_").shift();
  $("body").removeClass("dark").addClass("light");
  document.getElementById("color-link").setAttribute("href", "/App/Public/template/front-end/assets/css/" + split + ".css");
}

// Helper functions for working with cookies
function setCookie(name, value, days) {
  var expires = "";
  if (days) {
    var date = new Date();
    date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
    expires = "; expires=" + date.toUTCString();
  }
  document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function getCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(";");
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == " ") c = c.substring(1, c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
  }
  return null;
}

function deleteCookie(name) {
  document.cookie = name + "=; Max-Age=-99999999;";  
}
