$(document).ready(function(){
    $('.loader_container').addClass('display-none');
    // Basic function
    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    // User Management
    //-----User Modal 
    var table = $('#usertable').DataTable();

    $('#modalbutton').click(function(){
        $("#adduser").modal({backdrop: "static"});
    })

    $("#adduser").on('hidden.bs.modal', function(){
        location.reload();
    });

    // -----Balance Modal
    $('.edit_balance').click(function(){
        $('#balance_modal').modal({backdrop:"static"});
        $('#balance_value').val(Number($(this).attr('balance')));
        $('#balance_value').attr('user_id',$(this).attr('id'));
    })
    $("#balance_modal").on('hidden.bs.modal', function(){
        location.reload();
    });

    $('#submit_balance').click(function(){
        let balance = $('#balance_value').val();
        let id = $('#balance_value').attr('user_id');
        if(balance >= 0){
            $('#submit_balance').html('<span class="spinner-grow spinner-grow-sm"></span>Loading..');
            $('#usubmit_balance').attr('disabled','disabled');
            $('#close').attr('disabled','disabled');
            $.ajax({
                url:'/admin/edit-balance',
                data:{balance:balance,id:id},
                type:'get',
                success:function(data){
                    if(data == 1){
                        swal({
                            title: "Success",
                            text: "Balance successfully added.",
                            icon: "success",
                            button: "OK",
                          }).then(()=>{
                            location.reload();
                        });
                    }
                }
            })
        }
    })

    $('#user-submit').click(function(){
        $('.error').removeClass('display-show');
        $('.form-control').removeClass('border-red');
        let user_id = $('#userid').val().trim();
        let user_name = $('#username').val().trim();
        let user_email = $('#email').val().trim();
        let password = $('#password').val();
        let confirm_password = $('#confirm_password').val();
        if(!validation(user_id,user_email,password,confirm_password)){
            return false;
        }
        let data = {name:user_id,password:password,username:user_name,email:user_email,_token:$('input[name=_token]').val()};
        // console.log(data);
        $('#user-submit').html('<span class="spinner-grow spinner-grow-sm"></span>Loading..');
        $('#user-submit').attr('disabled','disabled');
        $('#close').attr('disabled','disabled');
        $.ajax({
            url:'/admin/add-user',
            type:'post',
            data:data,
            success:function(data){
                console.log(data);
                if(data == 1){
                    swal({
                        title: "Success",
                        text: "User successfully added.",
                        icon: "success",
                        button: "OK",
                      }).then(()=>{
                        location.reload();
                      });
                }else{
                    swal({
                        title: "Fail",
                        text: "The User ID is already stored in the database.",
                        icon: "error",
                        button: "OK",
                      }).then(()=>{
                        $('#userid').addClass('border-red');
                        $('#userid-unique-error').addClass('display-show');
                        $('#user-submit').html('Save');
                        $('#user-submit').removeAttr('disabled');
                        $('#close').removeAttr('disabled');
                      });
                }
            }
        })
    })

    function validation(user_id,user_email,password,confirm_password){
        if(user_id == ''){
            $('#userid').addClass('border-red');
            $('#userid-require-error').addClass('display-show');
            return false;
        }
        if(user_email){
            if(!validateEmail(user_email)){
                $('#email').addClass('border-red');
                $('#email-type-error').addClass('display-show');
                return false;
            }
        }
        if(!password){
            $('#password').addClass('border-red');
            $('#password-require-error').addClass('display-show');
            return false;
        }else if(password.length < 8){
            $('#password').addClass('border-red');
            $('#password-length-error').addClass('display-show');
            return false;
        }
        if(!confirm_password){
            $('#confirm_password').addClass('border-red');
            $('#confirm_password-require-error').addClass('display-show');
            return false;
        }else if(password != confirm_password){
            $('#confirm_password').addClass('border-red');
            $('#password-same-error').addClass('display-show');
            return false;
        }
        return true;
    }

    $('.user_delete').click(function(e){
        e.preventDefault();
        console.log('ok');
        swal({
            title: "Warning",
            text: "Are you sure ?",
            icon: "warning",
            buttons: {
                cancel: "Cancel",                
                default: 'Ok',
              },
          }).then((value)=>{
              switch(value) {
                    case "default" :
                        location.href = ($(this).attr('href'));
                        break;
                    case "cancel" :
                        break;
              }
          });
    })

    $('#setuser').click(function(){
        $('.error').removeClass('display-show');
        $('.form-control').removeClass('border-red');
        let email = $('#set_email').val();
        let cur_password = $('#cur_password').val();
        let set_password = $('#set_password').val();
        let set_confirm_password = $('#set_confirm_password').val();
        if(email){
            if(!validateEmail(email)){
                $('#set_email').addClass('border-red');
                $('#set_email-type-error').addClass('display-show');
                return false;
            }
        }
        if(set_password){
            if(!cur_password){
                $('#cur_password').addClass('border-red');
                $('#cur_password-require-error').addClass('display-show');
                return false;
            }
            if(set_password.length < 8){
                $('#set_password').addClass('border-red');
                $('#set_password-length-error').addClass('display-show');
                return false;
            }
            if(!set_confirm_password){
                $('#set_confirm_password').addClass('border-red');
                $('#set_confirm_password-require-error').addClass('display-show');
                return false;
            }
            if(set_confirm_password != set_password){
                $('#set_confirm_password').addClass('border-red');
                $('#set_password-same-error').addClass('display-show');
                return false;
            }
        }
        if(cur_password || set_confirm_password){
            if(!set_password){
                $('#set_password').addClass('border-red');
                $('#set_password-require-error').addClass('display-show');
                return false;
            }
            
        }
        $('#setform').submit();
    })

    function readURL(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          
          reader.onload = function(e) {
            $('#my_avatar').attr('src', e.target.result);
          }
          
          reader.readAsDataURL(input.files[0]);
        }
      }
      
      $("#photo").change(function() {
        readURL(this);
      });

    
    $(document).on('click','.toggle.btn', function (){
        var checked_val = $(this).find(".status_check").prop('checked');
        checked_val = !checked_val;
        if(checked_val){
            checked_val = 1;
        }else{
            checked_val = 0;
        }
        var target_id = $(this).find(".status_check").attr('id');
        $.ajax({
            url:'/admin/user-block',
            data:{status:checked_val,id:target_id},
            type:'get',
            beforeSend: function () { $('.loader_container').removeClass('display-none'); },
            success:function(data){
            }
        }).done(function () {
            $('.loader_container').addClass('display-none');
        })
    })
})