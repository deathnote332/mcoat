@extends('layouts.app')
@section('content')
    <style>

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
        #children-group .form-group .col-md-4:nth-child(1) label{
            padding-top: 0px;
        }
        #children-group .form-group .col-md-4 label{
            padding-top: 15px;
        }

        #children-group .form-group .col-md-4 .remove{
            color:red;
            cursor: pointer;
        }
        #children-group .col-md-12 label{
            margin-bottom: 5px;
            vertical-align: bottom;
        }

    </style>
    <div class="wrapper-login">
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
                                <div class="col-md-6">
                                    <label for="last_name" class="control-label">Last Name</label>
                                    <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required autofocus>

                                </div>
                                <div class="col-md-6">
                                    <label for="first_name" class="control-label">First Name</label>
                                    <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required>

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
                                    <input id="position" type="text" class="form-control" name="position"  required>

                                </div>
                                <div class="col-md-4">
                                    <label for="branch_hired" class="control-label">Branch Hired</label>
                                    <select id="branch_hired"  class="form-control" name="branch_hired"  required>
                                        <option selected disabled>Select Branch</option>
                                    </select>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="tin" class="control-label">TIN no.</label>
                                    <input id="tin" type="text" class="form-control" name="tin" required>

                                </div>
                                <div class="col-md-6">
                                    <label for="philhealth" class="control-label">PhilHealth no.</label>
                                    <input id="philhealth" type="text" class="form-control" name="philhealth"  required>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="sss" class="control-label">SSS no.</label>
                                    <input id="sss" type="text" class="form-control" name="sss" required>

                                </div>
                                <div class="col-md-6">
                                    <label for="pagibig" class="control-label">Pag Ibig no.</label>
                                    <input id="pagibig" type="text" class="form-control" name="pagibig"  required>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bio-title">
                        <h4>Background</h4>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="spouse_first_name" class="control-label">Spouse First Name</label>
                            <input id="spouse_first_name" type="text" class="form-control" name="spouse_first_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="spouse_last_name" class="control-label">Spouse Last Name</label>
                            <input id="spouse_last_name" type="text" class="form-control" name="spouse_last_name" required>
                        </div>
                    </div>
                    <div class="form-group" id="children-group">
                        <div class="col-md-12">
                            <label for="spouse_first_name" class="control-label">Name of children/s</label>
                            <span><button type="button" class="btn btn-primary add-child-row">Add more row</button></span>
                        </div>

                        <div class="form-group">
                            <div class="col-md-4">
                                <label for="child_last_name" class="control-label"><span class="child-number">1</span>. Last Name</label>
                                <input id="child_last_name" type="text" class="form-control" name="child_last_name[]" required>
                            </div>
                            <div class="col-md-4">
                                <label for="child_first_name" class="control-label">First Nme</label>
                                <input id="child_first_name" type="text" class="form-control" name="child_first_name[]" required>
                            </div>
                            <div class="col-md-4">
                                <label for="child_age" class="control-label">Age</label>
                                <input id="child_age" type="text" class="form-control" name="child_age[]" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">
                                <label for="child_last_name" class="control-label"><span class="child-number">2</span>. Last Name</label>
                                <input id="child_last_name" type="text" class="form-control" name="child_last_name[]" required>
                            </div>
                            <div class="col-md-4">
                                <label for="child_first_name" class="control-label">First Nme</label>
                                <input id="child_first_name" type="text" class="form-control" name="child_first_name[]" required>
                            </div>
                            <div class="col-md-4">
                                <label for="child_age" class="control-label">Age</label>
                                <input id="child_age" type="text" class="form-control" name="child_age[]" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">
                                <label for="child_last_name" class="control-label"><span class="child-number">3</span>. Last Name</label>
                                <input id="child_last_name" type="text" class="form-control" name="child_last_name[]" required>
                            </div>
                            <div class="col-md-4">
                                <label for="child_first_name" class="control-label">First Nme</label>
                                <input id="child_first_name" type="text" class="form-control" name="child_first_name[]" required>
                            </div>
                            <div class="col-md-4">
                                <label for="child_age" class="control-label">Age</label>
                                <input id="child_age" type="text" class="form-control" name="child_age[]" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">
                                <label for="child_last_name" class="control-label"><span class="child-number">4</span>. Last Name</label>
                                <input id="child_last_name" type="text" class="form-control" name="child_last_name[]" required>
                            </div>
                            <div class="col-md-4">
                                <label for="child_first_name" class="control-label">First Nme</label>
                                <input id="child_first_name" type="text" class="form-control" name="child_first_name[]" required>
                            </div>
                            <div class="col-md-4">
                                <label for="child_age" class="control-label">Age</label>
                                <input id="child_age" type="text" class="form-control" name="child_age[]" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">
                                <label for="child_last_name" class="control-label"><span class="child-number">5</span>. Last Name</label>
                                <input id="child_last_name" type="text" class="form-control" name="child_last_name[]" required>
                            </div>
                            <div class="col-md-4">
                                <label for="child_first_name" class="control-label">First Nme</label>
                                <input id="child_first_name" type="text" class="form-control" name="child_first_name[]" required>
                            </div>
                            <div class="col-md-4">
                                <label for="child_age" class="control-label">Age</label>
                                <input id="child_age" type="text" class="form-control" name="child_age[]" required>
                            </div>
                        </div>
                    </div>





                    <div class="form-group">
                        <div class="col-md-5">
                            <button type="submit" class="form-control btn btn-primary" style="margin-top: 5px">
                                Register
                            </button>
                        </div>
                        <div class="col-md-5 ">

                            <a href="{{ url('login') }}" style="position: relative;top:12px;color:red;font-weight: 700">I already have an account</a>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.add-child-row').on('click',function () {

                var count = parseInt($('#bio-data').find('#children-group .form-group:last-child .col-md-4 .child-number').text()) + 1;

                $('#bio-data').find('#children-group').append(
                    '<div class="form-group">' +
                    '<div class="col-md-4">' +
                    '<label for="child_last_name" class="control-label"><span class="child-number">'+ count +'</span>. Last Name <span class="remove">(REMOVE)</span></label>' +
                    '<input id="child_last_name" type="text" class="form-control" name="child_last_name[]" required>' +
                    '</div>' +
                    '<div class="col-md-4">' +
                    '<label for="child_first_name" class="control-label">First Nme</label>' +
                    '<input id="child_first_name" type="text" class="form-control" name="child_first_name[]" required>' +
                    '</div>' +
                    '<div class="col-md-4">' +
                    '<label for="child_age" class="control-label">Age</label>' +
                    '<input id="child_age" type="text" class="form-control" name="child_age[]" required>' +
                    '</div>' +
                    '</div>'
                );
            })


            $('body').delegate('#children-group .form-group .col-md-4 .remove','click',function () {
              $(this).parent().closest('.form-group').remove()
            })
        })
    </script>

@endsection
