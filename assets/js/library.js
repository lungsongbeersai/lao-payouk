function payAudio_cook(num) {
        var misicAudio = new Audio();
        misicAudio.src = "assets/audio/i_phone_ding.mp3";
        misicAudio.play();
        var audio = document.getElementsByClassName("audio");
        audio.innerHTML = "" + num;
}

function payAudio_bar(num) {
    var misicAudio1 = new Audio();
    misicAudio1.src = "assets/audio/i_phone_ding.mp3";
    misicAudio1.play();
    var audio1 = document.getElementsByClassName("audio1");
    audio1.innerHTML = "" + num;
}


//============function login=============================
function login(id_form, users_name,login_email, frm_notification) {
    $("#" + id_form).on("submit", function(event) {
        event.preventDefault();
        if ($("#" + users_name).val() == "") {
            $("#" + users_name).focus();
        }else if ($("#" + login_email).val() == "") {
            $("#" + login_email).focus();
        }else{
            $.ajax({
                url: "services/sql/login-sql.php?login",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(data) {
                    var dataResult = JSON.parse(data);
                    if (dataResult.statusCode == 200) {
                        location.href = "app/admin/?main";
                    }else if (dataResult.statusCode == 500) {
                        location.href = "?main";
                    }else if (dataResult.statusCode == 501) {
                        location.href = "?cooks";
                    }else if (dataResult.statusCode == 502) {
                        location.href = "?bars";
                    } else if (dataResult.statusCode == 201) {
                        notification('' + frm_notification, 4000);
                    }else if (dataResult.statusCode == 202) {
                        notification('' + frm_notification, 4000);
                    }
                }
            })
        }
    });
}


function format(format_class) {
    document.querySelectorAll('.'+format_class).forEach(inp => new Cleave(inp, {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
    }));
}

function successfuly(title){
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: '<h4>'+title+"</h4>",
        showConfirmButton: false,
        width:250,
        timer: 1500
    })
}

//============function show password=====================

function myFunction(id) {
    var x = document.getElementById("" + id);
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
