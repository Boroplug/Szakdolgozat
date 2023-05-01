$(document).ready(function () {


  //Searc  Filter
  var $search = $('#search').on('input', function () {
    /*  if ($(this).val().length > 2) {
        var matcher = new RegExp($(this).val(), 'gi');
        $('.box')
          .show()
          .not(function () {
            return matcher.test($(this).find('.name, .sku').text());
          })
          .hide();
      } else {
        $('.box').show();
  
      }*/
    keres();
  });
  // Size  Filter

  $('#filter, input[type=checkbox]').on('keyup change', function () {
    /*
    // var filterValue = $('#filter').val().toLowerCase();
    var selectedSizes = $('input[type=checkbox]:checked').map(function () {
      return $(this).val();
    }).get();
    var sor = 1;
    $('.shoe-box').each(function () {


      if (selectedSizes.length > 0) {
        var show = false;
        var size = $(this).find('.size').attr('datasize');


        var sizearray = size.split(",");
        for (let index = 0; index < sizearray.length; index++) {
          const element = sizearray[index];


          if (selectedSizes.indexOf(element) >= 0) {


            show = true;
            break;
          }

        }
        if (show) {
          $(this).show();
        } else {
          $(this).hide();
        }
      }
      else {
        $(this).show();
      }

      sor++;

    });*/
    keres();
  });

  // Price  Filter
  $('#price-filter').submit(function (e) {
    e.preventDefault();
    /*
    var minPrice = $('#min-price').val();
    var maxPrice = $('#max-price').val();
    $('.shoe-box').each(function () {
      var price = $(this).find('.theme-color').data('price');
      if (price < minPrice || price > maxPrice) {
        $(this).hide();
      } else {
        $(this).show();
      }
    });
    */
    keres();
  });








  // Cart Count
  var shoePrices = document.querySelectorAll('#shoe-list span[id="shoe-list"]');

  var shoeQuanty = document.querySelectorAll('#shoe-quanty');

  var total = 0;
  var cartTotal = 0;
  var totalQuanty = 0;

  for (var i = 0; i < shoePrices.length; i++) {
    total += parseFloat(shoePrices[i].textContent) * parseFloat(shoeQuanty[i].textContent);
  }

  for (var i = 0; i < shoeQuanty.length; i++) {
    totalQuanty += parseFloat(shoeQuanty[i].textContent);
  }


  document.getElementById("total-price").innerHTML = total.toFixed() + " Ft";

  document.getElementById('total-quanty').innerHTML = totalQuanty.toFixed();
 

  class PasswordChecker {
    constructor(passwordInputId, confirmPasswordInputId, passwordMatchElementId) {
      this.passwordInput = document.getElementById(passwordInputId);
      this.confirmPasswordInput = document.getElementById(confirmPasswordInputId);
      this.passwordMatchElement = document.getElementById(passwordMatchElementId);

      this.passwordInput.addEventListener("input", () => {
        this.checkPasswords();
      });

      this.confirmPasswordInput.addEventListener("input", () => {
        this.checkPasswords();
      });
    }

    checkPasswords() {
      const password = this.passwordInput.value;
      const confirmPassword = this.confirmPasswordInput.value;

      if (password === confirmPassword) {
        this.passwordMatchElement.innerText = "";
      } else {
        this.passwordMatchElement.innerText = "A két jelszó nem egyezik.";
      }
    }
  }

  const passwordChecker = new PasswordChecker("password", "password1", "password-match");





});
function keres() {


  var keres = $("#search").val();
  var minPrice = $('#min-price').val();
 
  var sor = 1;
  
  $('.shoe-box').each(function () {
    console.log("sor : "+sor);
    var show = true;
    //szures min price alapjan
 
    if (show && minPrice != "") {
      var ar = $(this).attr("ar");
      minPrice = parseInt(minPrice);
      var maxPrice = parseInt($('#max-price').val());
      console.log("ar : "+ar + " min : "+minPrice + " max : "+maxPrice);
      ar = parseInt(ar);
      if (!(minPrice <= ar && ar <= maxPrice)) {
        show = false;
      }
    }
    //szures szöveggel
    if (show && keres != "") {
      console.log("keres : "+keres);
      var matcher = new RegExp(keres, 'gi');
      show = matcher.test($(this).find('.name, .sku').text());
    }
    //szures meretek alapjan
    if (show) {
      
      var selectedSizes = $('input[type=checkbox]:checked').map(function () {
        return $(this).val();
      }).get();
      if (selectedSizes.length > 0) {
        console.log("meret : "+selectedSizes.length);
        var show = false;
        var size = $(this).find('.size').attr('datasize');


        var sizearray = size.split(",");
        for (let index = 0; index < sizearray.length; index++) {
          const element = sizearray[index];
          if (selectedSizes.indexOf(element) >= 0) {
            show = true;
            break;
          }
        }
      }
    }
    if (show) {
      $(this).show();
    } else {
      $(this).hide();
    }

    sor++;


  });


}


$(document).ready(function () {
  var total = 0;
  $('.list-group-item').each(function () {
    var priceText = $(this).find('#price').text().replace('Ft', '').trim();
    var quantityText = $(this).find('#qnty').text().replace('Darab:', '').trim();
    console.log('priceText:', priceText);
    console.log('quantityText:', quantityText);
    var price = parseInt(priceText);
    var quantity = parseInt(quantityText);
    if (!isNaN(price) && !isNaN(quantity)) {
      total += price * quantity;
    }
  });
  $('#total').text(total + ' Ft');
});
