
//====================Sound================================
function loadContent(num) {
    var bleep = new Audio();
    bleep.src = "assets/audio/mixkit-software-interface-back-2575.wav";
    bleep.play();
    var div1 = document.getElementById("div1");
    div1.innerHTML = "" + num;
}

//====================Sound Cook===========================
function loadContent1(num) {
    var bleep1 = new Audio();
    bleep1.src = "assets/audio/mixkit-clear-announce-tones-2861.wav";
    bleep1.play();
    var div1 = document.getElementById("showSound");
    div1.innerHTML = "" + num;
}


//====================Sound Table===========================

function loadContent2(num1) {
    var bleep2 = new Audio();
    bleep2.src = "assets/audio/Notification_sound.wav";
    bleep2.play();
    var showSound = document.getElementById("showSound");
    showSound.innerHTML = "" + num1;
}

//====================Login From===========================
function service_login(id_from, url_from) {
    $("#" + id_from).on("submit", function(event) {
        event.preventDefault();
        let timerInterval
        Swal.fire({
        // title: 'ແຈ້ງເຕືອນ',
        html: 'ກໍາລັງປະມວນຜົນ',
        timer: 2000,
        width: 250,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading()
            const b = Swal.getHtmlContainer().querySelector('b')
            timerInterval = setInterval(() => {
            b.textContent = Swal.getTimerLeft()
            }, 100)
        },
        willClose: () => {
            clearInterval(timerInterval)
        }
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
                $.ajax({
                    url: "services/sql/" + url_from,
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        var dataResult = JSON.parse(data);
                        if (dataResult.statusCode === 200) {
                            location.href="?main";
                        }else if(dataResult.statusCode === 201){
                            ErrorFuntion('ບັນຊີຂອງທ່ານຖືກລະຫງັບໃຊ້ຊົ່ວຄາວ');
                            loadContent(1);
                        }else {
                            ErrorFuntion('ຂໍອະໄພ ! ລະຫັດບໍ່ຖືກຕ້ອງ');
                            loadContent(1);
                        }
                    }
                })
            }
        })

        
    })
}
//====================Load Data===========================
function load_data_setting(search,limit,orderby,page,path,display){
    $.ajax({
        url: "services/sql/" + path,
        method: "POST",
        data:{search,limit,orderby,page},
        success: function(data) {
            $("." + display).html(data);
        }
    })
}
//====================Insert Data=========================

function service_insert(id_from, url_from, modal_id,search,limit,orderby,page,path,display) {
    $("#" + id_from).on("submit", function(event) {
        event.preventDefault();
        $.ajax({
            url: "services/sql/" + url_from,
            method: "POST",
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(data) {
                var dataResult = JSON.parse(data);
                if (dataResult.statusCode == 200) {
                    successfuly("ບັນທຶກສໍາເລັດ");
                    $("#" + id_from)[0].reset();
                    $("#" + modal_id).modal("hide");
                    load_data_setting(search,limit,orderby,page,path,display)
                } else if (dataResult.statusCode == 202) {
                    successfuly("ແກ້ໄຂສໍາເລັດແລ້ວ");
                    $("#" + id_from)[0].reset();
                    $("#" + modal_id).modal("hide");
                    load_data_setting(search,limit,orderby,page,path,display)
                }else if (dataResult.statusCode == 204) {
                    Error_warning();
                } else {
                    Error_data();
                }
            }
        })
    })
}
//==================Delete Data=========================
function delete_data(field_id,link_url,search,limit,orderby,page,path,display) {
    Swal.fire({
        title: 'ແຈ້ງເຕືອນ?',
        text: "ຢືນຢັນການລຶບຂໍ້ມູນ!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fas fa-save"></i> ລຶບ',
        cancelButtonText: '<i class="fas fa-times"></i> ປິດ'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "services/sql/" + link_url,
                method: "POST",
                data:{field_id},
                success: function(data) {
                    var dataResult = JSON.parse(data);
                    if (dataResult.statusCode == 200) {
                        successfuly('ລຶບຂໍ້ມູນສໍາເລັດແລ້ວ');
                        load_data_setting(search,limit,orderby,page,path,display)
                    } else {
                        Error_data();
                    }
                }
            });
        }
    })
}
//==================Modal===============================
function modal_open(modal_id,modal_title,from_id,button_name,autofocus,fixed_id1,fixed_id2,fixed_id3,clear_img){
    $("#"+modal_id).modal("show");
    $("#modal_title").html(""+modal_title);
    $("#"+button_name).html("<i class='fas fa-save'></i> ບັນທຶກ");
    if(clear_img !=""){
        $("."+clear_img).attr("src","assets/img/logo/no_logo.jpg");
    }
    $("#"+from_id)[0].reset();
    $('#'+modal_id).on('shown.bs.modal', function () {
        $('#'+autofocus).focus();
        if(fixed_id1 !=""){
            fixed_select_one(fixed_id1);
        }
        if(fixed_id2 !=""){
            fixed_select_one(fixed_id2);
        }
        if(fixed_id3 !=""){
            fixed_select_one(fixed_id3);
        }
    })
    
    
}
//===================Auto Focus==========================
function auto_focus(modal_id,input_name){
    $('#'+modal_id).on('shown.bs.modal', function () {
        $('#'+input_name).focus();
    })
}
//===================Fixed Select========================
function fixed_select_one(fixed_id){
    if (localStorage.getItem(''+fixed_id)) {
        $("."+fixed_id+" option").eq(localStorage.getItem(''+fixed_id)).prop('selected', true);
    }

    $("."+fixed_id).on('change', function() {
        localStorage.setItem(''+fixed_id, $('option:selected', this).index());
    });
}
//===================Error Data===========================
function Error_data(){
    Swal.fire({
        text: "ຂໍອະໄພ ! ຂໍ້ມູນຜິດພາດ",
        icon: 'warning',
        width: 400,
        showCancelButton: false,
        confirmButtonColor: '#e00202',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fas fa-times"></i> ປິດ'
      }).then((result) => {
        if (result.isConfirmed) {

        }
      })
}

function ErrorFuntion(data){
    Swal.fire({
        text: ""+data,
        icon: 'warning',
        width: 400,
        showCancelButton: false,
        confirmButtonColor: '#e00202',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fas fa-times"></i> ປິດ'
      }).then((result) => {
        if (result.isConfirmed) {

        }
      })
}
//===================Logout===============================
$("#logout").click(function(){
    Swal.fire({
        // title: 'ແຈ້ງເຕືອນ?',
        text: "ຕ້ອງການອອກຈາກລະບົບແທ້ ຫຼື ບໍ !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        width:400,
        confirmButtonText: '<i class="fas fa-save"></i> ຕົກລົງ',
        cancelButtonText: '<i class="fas fa-times"></i> ປິດ'
      }).then((result) => {
        if (result.isConfirmed) {
            location.href="../../?logout";
        }
      })
});
//===================Sweetalert===========================
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
//==================Format All============================
function format(class_input) {
    document.querySelectorAll('.'+class_input).forEach(inp => new Cleave(inp, {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
    }));
}
//=================browfile===============================
function load_image(data){
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById(''+data);
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}

//=================Gen barcode=============================
function gen_code(data) {
    var len = 18;
    var gg = parseInt((Math.random() * 9 + 1) * Math.pow(10, len - 1), 10);
    $("."+data).val(gg);
}
//=================Select2=================================
$(".multiple-select2").select2({
    placeholder: "ເລືອກ",
    allowClear: true
});

// $(document).on("click",".menu-active",function(){
//     var menuID=$(this).attr("Id");
//     alert(menuID)
// });

function functionActive(menuID,mainID,subID){
    $.ajax({
        url:"services/sql/service-all.php?active_menu",
        method:"POST",
        data:{menuID,mainID,subID},
        success:function(){
            // location.reload();
        }
    })
}