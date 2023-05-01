function getcart()
{ 
    $.get(
        '.php',
        //{'darab':20}
        $('#gomb1').serialize()
    )
    .done(function(data,statusz) {
        if(data=="OK")
            alert('kész'+"\n"+statusz);
        else
            alert(data);
    })
    .fail(function(adatok, statusz){
        alert(adatok+"\n"+statusz);
    });



}