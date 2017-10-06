<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

    <style>

        html,body{
            height: 100%;
        }

        .wrapper-login{
            display: table;
            width: 100%;
            height: 100%;
            background: url(../../../../../images/mcoat-bg.jpg);
        }

        .panel-body{
            display: table-cell;
            vertical-align: middle;
        }
        .con-employee a{
            color:#f35b32;
        }

        .warehouse{
            color:#a94442;
        }
        .bio-title h4{
            border-bottom: 1px solid #636b6f;
            margin: 4vh auto;
            padding-bottom: 10px ;
            font-weight: bold;
        }
        .form-group{
            margin-bottom: 0;
        }
        .img-container img{
            height: 300px;
            border: 1px solid black;
        }

        .btn-upload{
            padding: 5vh 0;
        }
        .upload-btn-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width:100%;
        }
        .btn-width{
            width:100%;
        }


        .upload-btn-wrapper input[type=file] {
            font-size: 100px;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
        }
        #partner{
            display: none;
        }
        #children-group{
            display: none;
        }
        .add-child-row{
            margin: 5vh 3vh 0 3vh;
        }
        #children-group .form-group{
            padding: 0px 10px;
        }
        .child-number{
            font-weight: bold;
           color:#3097D1;
            font-size: 24px;
        }
        #children-group .form-group .col-md-4:nth-child(1) label,#children-group1 .form-group .col-md-4:nth-child(1) label{
            padding-top: 0px;
        }
        #children-group .form-group .col-md-4 label,#children-group .form-group .col-md-3 label,#children-group1 .form-group .col-md-4 label,#children-group1 .form-group .col-md-3 label{
            padding-top: 15px;
        }

        #children-group .form-group .col-md-4 .remove,#children-group1 .form-group .col-md-4 .remove{
            color:red;
            cursor: pointer;
        }
        #children-group .col-md-12 label{
            margin-bottom: 5px;
            vertical-align: bottom;
        }

        #parents{
            padding: 3vh 0px;
        }
        #button-submit{
            padding: 5vh 0;
        }

        .back{
            background: #3097D1;
            text-align: center;
            color:white;
            text-decoration: none;
        }
        .back:hover{

            color:white;
            text-decoration: none;
            background-color: #2579a9;
            border-color: #1f648b;
        }
        label.error{
            color:red;
            font-size: 11px;
            font-style: italic;
        }

        #button-submit .back,#button-submit .submit-biodata{
            margin: 10px 0;
        }
    </style>
    <div class="wrapper-login">
        <input type="hidden" id="baseURL" value="{{ url('') }}" >
        <div class="panel-body">
            <div class="container">
                <form class="form-horizontal" id="bio-data">
                    {{ csrf_field() }}
                    <div class="bio-title">
                        <h4>Personal Information</h4>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3">
                            <div class="img-container">
                                <img src="" class="img-responsive">
                            </div>
                            <div class="upload-btn-wrapper btn-upload">
                                <button class=" btn btn-primary btn-width">Upload a file</button>
                                <input type="file" name="myfile" class="form-control" />
                            </div>

                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="last_name" class="control-label">Last Name</label>
                                    <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required autofocus>

                                </div>
                                <div class="col-md-4">
                                    <label for="first_name" class="control-label">First Name</label>
                                    <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required>

                                </div>
                                <div class="col-md-4">
                                    <label for="middle_name" class="control-label">Middle Name</label>
                                    <input id="middle_name" type="text" class="form-control" name="middle_name" value="{{ old('first_name') }}" >

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-8">
                                    <label for="address" class="control-label">Address</label>
                                    <input id="address" type="text" class="form-control" name="address"  required>

                                </div>
                                <div class="col-md-4">
                                    <label for="contact_no" class="control-label">Contact No.</label>
                                    <input id="contact_no" type="text" class="form-control" name="contact_no"  required>
                                </div>
                            </div>
                            <div class="form-group">

                                <div class="col-md-6">
                                    <label for="gender" class="control-label">Gender</label>
                                    <select id="gender" class="form-control" name="gender"  required>
                                        <option selected disabled>Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="status" class="control-label">Status</label>
                                    <select id="status"  class="form-control" name="status"  required>
                                        <option selected disabled>Select Status</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Divorced">Divorced</option>
                                        <option value="Widowed">Widowed</option>
                                        <option value="Single Parent">Single Parent</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="birthdate" class="control-label">Birth Date</label>
                                    <input id="birthdate" type="text" class="form-control" name="birthdate" required>

                                </div>
                                <div class="col-md-4">
                                    <label for="birthplace" class="control-label">Birth Place</label>
                                    <input id="birthplace" type="text" class="form-control" name="birthplace"  required>

                                </div>
                                <div class="col-md-4">
                                    <label for="age" class="control-label">Age</label>
                                    <input id="age" type="text" class="form-control" name="age"  required>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="date_hired" class="control-label">Date Hired</label>
                                    <input id="date_hired" type="text" class="form-control" name="date_hired" required>

                                </div>
                                <div class="col-md-4">
                                    <label for="position" class="control-label">Position</label>
                                    <select id="position"  class="form-control" name="position"  required>
                                        <option selected disabled>Select Positon</option>
                                        <option value="Secretary">Secretary</option>
                                        <option value="Tinter">Tintern</option>
                                        <option value="Helper">Helper</option>
                                        <option value="Driver">Driver</option>
                                        <option value="IT">IT</option>
                                    </select>

                                </div>
                                <div class="col-md-4">
                                    <label for="branch_hired" class="control-label">Branch Hired</label>
                                    <select id="branch_hired"  class="form-control" name="branch_hired"  required>
                                        <option selected disabled>Select Branch</option>
                                        @foreach(\App\Branches::get() as $key=>$val)
                                            <option value="{{ $val->name }}">{{$val->name}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="tin" class="control-label">TIN no.</label>
                                    <input id="tin" type="text" class="form-control" name="tin" >

                                </div>
                                <div class="col-md-6">
                                    <label for="philhealth" class="control-label">PhilHealth no.</label>
                                    <input id="philhealth" type="text" class="form-control" name="philhealth"  >

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="sss" class="control-label">SSS no.</label>
                                    <input id="sss" type="text" class="form-control" name="sss" >

                                </div>
                                <div class="col-md-6">
                                    <label for="pagibig" class="control-label">Pag Ibig no.</label>
                                    <input id="pagibig" type="text" class="form-control" name="pagibig"  >

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bio-title">
                        <h4>Background</h4>
                    </div>
                    <div class="form-group"id="partner">
                        <div class="col-md-6">
                            <label for="spouse_first_name" class="control-label">Spouse First Name</label>
                            <input id="spouse_first_name" type="text" class="form-control" name="spouse_first_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="spouse_last_name" class="control-label">Spouse Last Name</label>
                            <input id="spouse_last_name" type="text" class="form-control" name="spouse_last_name" required>
                        </div>
                        <div class="col-md-12">
                            <label for="spouse_address" class="control-label">Address</label>
                            <input id="spouse_address" type="text" class="form-control" name="spouse_address" required>
                        </div>
                        <div class="col-md-6">
                            <label for="spouse_occupation" class="control-label">Occupation</label>
                            <input id="spouse_occupation" type="text" class="form-control" name="spouse_occupation" required>
                        </div>
                        <div class="col-md-6">
                            <label for="spouse_contact" class="control-label">Contact</label>
                            <input id="spouse_contact" type="text" class="form-control" name="spouse_contact" >
                        </div>
                    </div>
                    <div class="form-group" id="children-group">
                        <div class="col-md-12">
                            <label for="spouse_first_name" class="control-label">Name of children/s</label>
                            <span><button type="button" class="btn btn-primary add-child-row">Add more row</button></span>
                        </div>

                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-1">
                                <label for="child_last_name" class="control-label"><span class="child-number">1</span>. Last Name</label>
                                <input id="child_last_name" type="text" class="form-control" name="child_last_name[]" >
                            </div>
                            <div class="col-md-4">
                                <label for="child_first_name" class="control-label">First Nme</label>
                                <input id="child_first_name" type="text" class="form-control" name="child_first_name[]" >
                            </div>
                            <div class="col-md-3">
                                <label for="child_age" class="control-label">Age</label>
                                <input id="child_age" type="text" class="form-control" name="child_age[]" >
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-1">
                                <label for="child_last_name" class="control-label"><span class="child-number">2</span>. Last Name</label>
                                <input id="child_last_name" type="text" class="form-control" name="child_last_name[]" >
                            </div>
                            <div class="col-md-4">
                                <label for="child_first_name" class="control-label">First Nme</label>
                                <input id="child_first_name" type="text" class="form-control" name="child_first_name[]" >
                            </div>
                            <div class="col-md-3">
                                <label for="child_age" class="control-label">Age</label>
                                <input id="child_age" type="text" class="form-control" name="child_age[]" >
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-1">
                                <label for="child_last_name" class="control-label"><span class="child-number">3</span>. Last Name</label>
                                <input id="child_last_name" type="text" class="form-control" name="child_last_name[]" >
                            </div>
                            <div class="col-md-4">
                                <label for="child_first_name" class="control-label">First Nme</label>
                                <input id="child_first_name" type="text" class="form-control" name="child_first_name[]" >
                            </div>
                            <div class="col-md-3">
                                <label for="child_age" class="control-label">Age</label>
                                <input id="child_age" type="text" class="form-control" name="child_age[]" >
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="parents">
                        <div class="col-md-6">
                            <label for="father_last_name" class="control-label">Father Last Name</label>
                            <input id="father_last_name" type="text" class="form-control" name="father_last_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="father_first_name" class="control-label">Father First Name</label>
                            <input id="father_first_name" type="text" class="form-control" name="father_first_name" required>
                        </div>
                        <div class="col-md-12">
                            <label for="father_address" class="control-label">Address</label>
                            <input id="father_address" type="text" class="form-control" name="father_address" required>
                        </div>
                        <div class="col-md-6">
                            <label for="father_occupation" class="control-label">Occupation</label>
                            <input id="father_occupation" type="text" class="form-control" name="father_occupation" required>
                        </div>
                        <div class="col-md-6">
                            <label for="father_contact" class="control-label">Contact</label>
                            <input id="father_contact" type="text" class="form-control" name="father_contact" >
                        </div>

                        <div class="col-md-6">
                            <label for="mother_last_name" class="control-label">Mother Maiden's Last Name</label>
                            <input id="mother_last_name" type="text" class="form-control" name="mother_last_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="mother_first_name" class="control-label">Mother First Name</label>
                            <input id="mother_first_name" type="text" class="form-control" name="mother_first_name" required>
                        </div>
                        <div class="col-md-12">
                            <label for="mother_address" class="control-label">Address</label>
                            <input id="mother_address" type="text" class="form-control" name="mother_address" required>
                        </div>
                        <div class="col-md-6">
                            <label for="mother_occupation" class="control-label">Occupation</label>
                            <input id="mother_occupation" type="text" class="form-control" name="mother_occupation" required>
                        </div>
                        <div class="col-md-6">
                            <label for="mother_contact" class="control-label">Contact</label>
                            <input id="mother_contact" type="text" class="form-control" name="mother_contact" >
                        </div>
                    </div>

                    <div class="form-group" id="children-group1">
                        <div class="col-md-12">
                            <label for="spouse_first_name" class="control-label">Name of children/s from parents.</label>
                            <span><button type="button" class="btn btn-primary add-child-row1">Add more row</button></span>
                        </div>

                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-1">
                                <label for="child_last_name" class="control-label"><span class="child-number">1</span>. Last Name</label>
                                <input id="child_last_name" type="text" class="form-control" name="child_last_name1[]" >
                            </div>
                            <div class="col-md-4">
                                <label for="child_first_name" class="control-label">First Nme</label>
                                <input id="child_first_name" type="text" class="form-control" name="child_first_name1[]" >
                            </div>
                            <div class="col-md-3">
                                <label for="child_age" class="control-label">Age</label>
                                <input id="child_age" type="text" class="form-control" name="child_age1[]" >
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-1">
                                <label for="child_last_name" class="control-label"><span class="child-number">2</span>. Last Name</label>
                                <input id="child_last_name" type="text" class="form-control" name="child_last_name1[]" >
                            </div>
                            <div class="col-md-4">
                                <label for="child_first_name" class="control-label">First Nme</label>
                                <input id="child_first_name" type="text" class="form-control" name="child_first_name1[]" >
                            </div>
                            <div class="col-md-3">
                                <label for="child_age" class="control-label">Age</label>
                                <input id="child_age" type="text" class="form-control" name="child_age1[]" >
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-1">
                                <label for="child_last_name" class="control-label"><span class="child-number">3</span>. Last Name</label>
                                <input id="child_last_name" type="text" class="form-control" name="child_last_name1[]" >
                            </div>
                            <div class="col-md-4">
                                <label for="child_first_name" class="control-label">First Nme</label>
                                <input id="child_first_name" type="text" class="form-control" name="child_first_name1[]" >
                            </div>
                            <div class="col-md-3">
                                <label for="child_age" class="control-label">Age</label>
                                <input id="child_age" type="text" class="form-control" name="child_age[]1" >
                            </div>
                        </div>
                    </div>


                    <div class="bio-title">
                        <h4>In Case of Emergency</h4>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="emergency_last_name" class="control-label">Last Name</label>
                            <input id="emergency_last_name" type="text" class="form-control" name="emergency_last_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="emergency_first_name" class="control-label">First Name</label>
                            <input id="emergency_first_name" type="text" class="form-control" name="emergency_first_name" required>
                        </div>
                        <div class="col-md-12">
                            <label for="emergency_address" class="control-label">Address</label>
                            <input id="emergency_address" type="text" class="form-control" name="emergency_address" required>
                        </div>
                        <div class="col-md-6">
                            <label for="emergency_relationship" class="control-label">Relationship</label>
                            <input id="emergency_relationship" type="text" class="form-control" name="emergency_relationship" required>
                        </div>
                        <div class="col-md-6">
                            <label for="emergency_contact" class="control-label">Contact</label>
                            <input id="emergency_contact" type="text" class="form-control" name="emergency_contact" required>
                        </div>
                    </div>

                    <div class="form-group" id="button-submit">
                        <div class="col-md-3 col-md-offset-6">
                            <a href="{{ url('login') }}" class="back form-control">Back</a>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="form-control btn btn-primary submit-biodata">
                                Submit
                            </button>

                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>


<script>
    var BASEURL = $('#baseURL').val();
    $(document).ready(function () {

        var validator = $('#bio-data').validate();

        $('.add-child-row').on('click',function () {

            var count = parseInt($('#bio-data').find('#children-group .form-group:last-child .col-md-4 .child-number').text()) + 1;

            $('#bio-data').find('#children-group').append(
                '<div class="form-group">' +
                '<div class="col-md-4 col-md-offset-1">' +
                '<label for="child_last_name" class="control-label"><span class="child-number">'+ count +'</span>. Last Name <span class="remove">(REMOVE)</span></label>' +
                '<input id="child_last_name" type="text" class="form-control" name="child_last_name[]" >' +
                '</div>' +
                '<div class="col-md-4">' +
                '<label for="child_first_name" class="control-label">First Nme</label>' +
                '<input id="child_first_name" type="text" class="form-control" name="child_first_name[]" >' +
                '</div>' +
                '<div class="col-md-3">' +
                '<label for="child_age" class="control-label">Age</label>' +
                '<input id="child_age" type="text" class="form-control" name="child_age[]" >' +
                '</div>' +
                '</div>'
            );
        })


        $('body').delegate('#children-group .form-group .col-md-4 .remove','click',function () {
          $(this).parent().closest('.form-group').remove()
        })

        $('.add-child-row1').on('click',function () {

            var count = parseInt($('#bio-data').find('#children-group1 .form-group:last-child .col-md-4 .child-number').text()) + 1;

            $('#bio-data').find('#children-group1').append(
                '<div class="form-group">' +
                '<div class="col-md-4 col-md-offset-1">' +
                '<label for="child_last_name" class="control-label"><span class="child-number">'+ count +'</span>. Last Name <span class="remove">(REMOVE)</span></label>' +
                '<input id="child_last_name" type="text" class="form-control" name="child_last_name1[]" >' +
                '</div>' +
                '<div class="col-md-4">' +
                '<label for="child_first_name" class="control-label">First Nme</label>' +
                '<input id="child_first_name" type="text" class="form-control" name="child_first_name1[]" >' +
                '</div>' +
                '<div class="col-md-3">' +
                '<label for="child_age" class="control-label">Age</label>' +
                '<input id="child_age" type="text" class="form-control" name="child_age1[]" >' +
                '</div>' +
                '</div>'
            );
        })


        $('body').delegate('#children-group1 .form-group .col-md-4 .remove','click',function () {
            $(this).parent().closest('.form-group').remove()
        })

        $('#status').on('change',function (){

            if($(this).val()=='Single'){
                $('#partner').hide();
                $('#children-group').hide()
            }else{
                $('#partner').show();
                $('#children-group').show()
            }
        })

        $('.submit-biodata').on('click',function () {
            var form = $('#bio-data');
            if(form.valid()){
                saveEmployeeRecord()
            }
        })
    })

    function saveEmployeeRecord(){
        swal({
            title: "Are you sure?",
            text: "You want to update this product.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: 'Okay',
            closeOnConfirm: false
        }).then(function () {
            var data_save = $('#bio-data').serializeArray();
            $.ajax({
                url:BASEURL+'/employeebiodata',
                type:'POST',
                data: data_save,
                success: function(data){

                    swal({
                        title: "",
                        text: "Product updated successfully",
                        type:"success"
                    })
                }
            });
        });
    }
</script>

