<style>
    .changepassword{

    }
    .changepassword:hover{
        color:#337ab7;
        cursor: pointer;
    }




</style>
<div class="account-settings" >
    <div class="container-fluid">
        <form id="user-settings">
            <div class="row">
                <div class="col-md-6  pad_top_20">
                    <input type="text" name="first_name" class="form-control " placeholder="First name" value="{{ \Illuminate\Support\Facades\Auth::user()->first_name }}" id="fname">
                </div>
                <div class="col-md-6  pad_top_20">
                    <input type="text" name="last_name"  class="form-control " placeholder="Last name" value="{{ \Illuminate\Support\Facades\Auth::user()->last_name }}" id="lname">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 pad_top_20">
                    <p class="changepassword">Change password</p>
                </div>
            </div>
            <div class="row change-password-container ">
                <div class="col-md-6 pull-left pad_top_20">
                    <input type="password" name="password" class="form-control " placeholder="Password" id="password">
                </div>
                <div class="col-md-6 pad_top_20">
                    <input type="password" name="re_password" class="form-control " placeholder="Confirm password" id="conpassword">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 pad_top_20">
                    <button type="button" class="btn btn-primary form-control update-profile">Update</button>
                </div>
            </div>



        </form>
    </div>

</div>
<script>
    $(document).ready(function () {

        $('.change-password-container').hide()

        $('.changepassword').on('click',function () {
            $('.change-password-container').toggle()

        })

        $('.update-profile').on('click',function () {
            if($('.change-password-container').is(':visible')){
                if($('#fname').val() == "" && $('#lname').val() == "" && $('#password').val() == "" && $('#conpassword').val() == ""){
                    alert('please input')
                }else if($('#fname').val() != "" && $('#lname').val() != "" && $('#password').val() == "" && $('#conpassword').val() == ""){
                    alert('please password')
                }else if($('#fname').val() != "" && $('#lname').val() != "" && $('#password').val() != "" && $('#conpassword').val() != ""){
                    if($('#password').val().length <=7){
                        alert('password must be 8 or above')
                    }else{
                        if($('#password').val() != $('#conpassword').val()){
                            alert('password mismatch')
                        }else{
                            updateAccount()
                        }
                    }

                }
            }
        })
    })

    function updateAccount() {
        var BASEURL = $('#baseURL').val();
        swal.queue([{
            title: 'Are you sure',
            text: "You want to update your account.",
            type:'warning',
            showLoaderOnConfirm: true,
            showCancelButton: true,
            allowOutsideClick: false,
            closeOnConfirm: false,
            confirmButtonText: 'Okay',
            confirmButtonColor: "#DD6B55",
            preConfirm: function () {
                return new Promise(function (resolve) {
                    var data_save = $('#user-settings').serializeArray();
                    data_save.push({ name : "_token", value: $('meta[name="csrf_token"]').attr('content')})
                    $.ajax({
                        url:BASEURL+'/updateaccount',
                        type:'POST',
                        data: data_save,
                        success: function(data){
                            swal.insertQueueStep(data)
                            $('.change-password-container').toggle()
                            resolve()
                        }
                    });
                })
            }
        }])

    }
</script>