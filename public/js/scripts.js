/*!
    * Start Bootstrap - SB Admin v7.0.7 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2023 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    // 
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

    const loader = document.querySelector(".full-body-loader");
    loader.style.display = "none";  // Hides the loader after the page has loaded
});


let ajax_cnt = 0;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

let ShowProg = function() {
    $('.full-body-loader').fadeIn(100);
}
let HideProg = function() {
    $('.full-body-loader').fadeOut(100);
}

let removeScriptTags = function(str) {
    return str.replace(/<\/?script\b[^>]*>/gi, '');
} 

let searchdata = function(page, str, recId, frm ,otherform="") {
    ajax_cnt++;
    if (ajax_cnt > 0) {
        ShowProg();
    }
    let dt = '';
    if (frm != '') {
        if ($('#' + frm).prop("tagName") == 'FORM') {
            dt += $('#' + frm).serialize();
        } else {
            dt += $('#' + frm).find('input').serialize();
            dt += '&' + $('#' + frm).find('select').serialize();
        }
    }
    if (str != '') {
        dt += (dt != '' ? '&' : '') + str;
    }
    if (otherform != '')
    {
        dt += (dt != '' ? '&' : '') + $('#' + otherform).serialize();
    }
    
    $.ajax({type: 'GET', url: page, data: dt, success: function(data) {
        ReceiveData(recId,data);
    }});
}

let ReceiveData = function(recId, data) {
    ajax_cnt--;
    if (ajax_cnt == 0) {
        HideProg();
    }
    if (data != '') {
        if (recId != '' && $('#'+recId).length) {
            if (data.indexOf("|g|") > 0) {
                let arr = data.split("|g|");
                if (arr[0].trim() == 'script') {
                    $('#' + recId).html(arr[1]).fadeIn(1000);
                    setTimeout(removeScriptTags(arr[2]), 1);
                    
                }
            } else {
                $('#' + recId).html(data).fadeIn(1000);
            }
        }else{
            $('#' + recId).html('<p>Invalid Id!</p>').fadeIn(1000);
        }
    }
}

function printElementById(id) {
    var printContents = document.getElementById(id).innerHTML;
    var originalContents = document.body.innerHTML;

    // Replace the body content with the content of the element to be printed
    document.body.innerHTML = printContents;

    // Trigger print dialog
    window.print();

    // Restore the original page content after printing
    document.body.innerHTML = originalContents;
}

let bindAjax = function(){
    if ($('*').hasClass('iconpicker')) {
        $('.iconpicker').iconpicker().on('iconpickerSelected', function(event) {
            if(this.value!=this.defaultValue){
               $(this).trigger('blur');
            }
        });
    } 

    if ($('*').hasClass('select2')) {
        $('.select2').select2();
    }   
}

let message = function(){
    if ($('#successMessage').length) {
      $('#successMessage').fadeIn(500).delay(5000).fadeOut(500);  // Fade in, wait for 5 seconds, then fade out
    }

    // Show error message with fade-in effect
    if ($('#errorMessage').length) {
      $('#errorMessage').fadeIn(500).delay(5000).fadeOut(500);  // Fade in, wait for 5 seconds, then fade out
    }

    setTimeout(() => {
        $('.fade-out').fadeTo(500, 0, function () {
            $(this).hide();
        });
    }, 5000);
}

bindAjax();
message();
