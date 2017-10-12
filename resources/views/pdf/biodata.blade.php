
<style>

    @page {
        margin: 180px 30px 0px 30px;
    }

    h2,h3,h4,h1,h5{
        margin: 0;
        padding: 0;
    }


    .page-break {
        page-break-after: always;
    }


    .header{
        display: block;
        position: relative;
        top: -150px;
    }
    .header .title{
        padding-top: 80px;
        font-size: 22px;
        font-weight: bold;
        padding-right: 55px;
    }
    .header .img-logo,.header .title,.header .img-picture{
        display: inline-block;
        width: 33%;
    }

    .header .img-logo img{
        padding-top: 30px;
        height: 150px;
        width: 150px;
    }
    .header .img-picture img{
        height: 192px;
        width: 192px;
    }

    .info-title h3{
        border-bottom: 1px solid black;
        border-top: 1px solid black;
        padding: 5px 0;
        margin: 2px 0;
    }
    .info-details{
        position: relative;
        top: -310px;
    }
    .row{
        margin: 0;
        padding: 5px 10px;
       display: block;
    }
    .width-1{
        width: 100%;
    }
    .width-3{
        width: 32%;

        display: inline-block;
    }
    .width-2{
        width: 48%;
        display: inline-block;
    }

    .width-4{
        width: 64%;
        display: inline-block;
    }


    span{
        font-weight: 600;
        margin: 0;
    }

    .childern-1{
        padding-left: 80px;
    }
</style>
<title></title>

<div class="header">
    <div class="img-logo">
        <img src="images/mcoat-logo.png" alt="picture1">
    </div>
    <div class="title">
        <h3>Employee's Bio Data</h3>
    </div>
    <div class="img-picture">
        <img src="images/mcoat-bg.jpg">
    </div>
</div>
<div class="info-details">
    <div class="info-title">
        <h3>Personal Information</h3>
    </div>
   <div class="row">
       <div class="last-name width-3">
           <span>Last Name :</span> {!! $data->last_name !!}
       </div>
       <div class="last-name width-3">
           <span>First Name :</span> {!! $data->first_name !!}
       </div>
       <div class="last-name width-3">
           <span>Middle Name :</span> {!! $data->middle_name !!}
       </div>
   </div>
    <div class="row">
        <div class="address width-4">
            <span>Address :</span> {!! $data->address !!}
        </div>

        <div class="width-3">
            <span>Contact no. :</span> {!! $data->contact_no !!}
        </div>
    </div>
    <div class="row">
        <div class="address width-2">
            <span>Gender :</span> {!! $data->gender !!}
        </div>

        <div class="width-2">
            <span>Status. :</span> {!! $data->status !!}
        </div>
    </div>
    <div class="row">
        <div class="last-name width-3">
            <span>Birth Date :</span> {!! $data->birthdate !!}
        </div>
        <div class="last-name width-3">
            <span>Birth Place :</span> {!! $data->birthplace !!}
        </div>
        <div class="last-name width-3">
            <span>Age :</span> {!! $data->age !!}
        </div>
    </div>
    <div class="row">
        <div class="last-name width-3">
            <span>Date Hired:</span> {!! $data->date_hired !!}
        </div>
        <div class="last-name width-3">
            <span>Position :</span> {!! $data->position !!}
        </div>
        <div class="last-name width-3">
            <span>Branch Hired :</span> {!! $data->branch_hired !!}
        </div>
    </div>
    <div class="row">
        <div class="address width-2">
            <span>TIN no. :</span> {!! $data->tin !!}
        </div>

        <div class="width-2">
            <span>PhilHealth no. :</span> {!! $data->philhealth !!}
        </div>
    </div>
    <div class="row">
        <div class="address width-2">
            <span>SSS no. :</span> {!! $data->sss !!}
        </div>

        <div class="width-2">
            <span>Pag Ibig no. :</span> {!! $data->pagibig !!}
        </div>
    </div>
    <div class="info-title">
        <h3>Background</h3>
    </div>
    <div class="row">
        <div class="last-name width-2">
            <span>Spouse Last Name :</span> {!! $data->spouse_last_name !!}
        </div>
        <div class="last-name width-2">
            <span>Spouse First Name :</span> {!! $data->spouse_first_name !!}
        </div>
    </div>
    <div class="row">
        <div class="width-1">
            <span>Address :</span> {!! $data->spouse_address !!}
        </div>
    </div>
    <div class="row">
        <div class="last-name width-2">
            <span>Occupation :</span> {!! $data->spouse_occupation !!}
        </div>
        <div class="last-name width-2">
            <span>Contact :</span> {!! $data->spouse_contact !!}
        </div>
    </div>
    <div class="row">
        <h4>Name of children/s</h4>
        <div class="childern-1">

            @foreach($child as $key=>$value)
            <div class="row">
                <div class="last-name width-3">
                    <span>Last Name :</span> {!! $value[$key] !!}
                </div>
                <div class="last-name width-3">
                    <span>First Name :</span> {!! $value[$key] !!}
                </div>
                <div class="last-name width-3">
                    <span>Age :</span> {!! $value[$key] !!}
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="last-name width-2">
            <span>Father Last Name :</span> Inhog
        </div>
        <div class="last-name width-2">
            <span>Father First Name :</span> Jenny
        </div>
    </div>
    <div class="row">
        <div class="width-1">
            <span>Address :</span> 0029 F. Manalo St. Sto. Tomas, Pasig City
        </div>
    </div>
    <div class="row">
        <div class="last-name width-2">
            <span>Occupation :</span> Foreman
        </div>
        <div class="last-name width-2">
            <span>Contact :</span> 09282180804
        </div>
    </div>
    <div class="row">
        <div class="last-name width-2">
            <span>Mother Maiden's Last Name :</span> Batang
        </div>
        <div class="last-name width-2">
            <span>Mother First Name :</span> Helen
        </div>
    </div>
    <div class="row">
        <div class="width-1">
            <span>Address :</span> 0029 F. Manalo St. Sto. Tomas, Pasig City
        </div>
    </div>
    <div class="row">
        <div class="last-name width-2">
            <span>Occupation :</span> Housewife
        </div>
        <div class="last-name width-2">
            <span>Contact :</span> 09282180804
        </div>
    </div>
    <div class="row">
        <h4>Name of children/s</h4>
        <div class="childern-1">

            @foreach($child_1 as $key=>$value)
                <div class="row">
                    <div class="last-name width-3">
                        <span>Last Name :</span> {!! $value[$key] !!}
                    </div>
                    <div class="last-name width-3">
                        <span>First Name :</span> {!! $value[$key] !!}
                    </div>
                    <div class="last-name width-3">
                        <span>Age :</span> {!! $value[$key] !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="info-title">
        <h3>In Case of Emergency</h3>
    </div>
    <div class="row">
        <div class="last-name width-2">
            <span>Last Name :</span> Inhog
        </div>
        <div class="last-name width-2">
            <span>First Name :</span> Helen
        </div>
    </div>
    <div class="row">
        <div class="width-1">
            <span>Address :</span> 0029 F. Manalo St. Sto. Tomas, Pasig City
        </div>
    </div>
    <div class="row">
        <div class="last-name width-2">
            <span>Relationship :</span> Mother
        </div>
        <div class="last-name width-2">
            <span>Contact :</span> 09282180804
        </div>
    </div>
</div>





