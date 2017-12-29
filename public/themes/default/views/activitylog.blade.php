{!! Theme::asset()->usePath()->add('activitylogs.js','/js/web/activitylogs.js') !!}
<div class="card-container">
   <div class="container-fluid">
       <div class="row pad_top_20">
           <div class="col-md-6 table-search-input">
               <input type="text" id="search" name="search" class="form-control search-inputs" placeholder="Search..">
           </div>
       </div>
   </div>
    <div class="row">
        <div class="col-md-12">
            <table id="notification-list" class="table table-bordered dt-responsive " cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Action</th>
                    <th class="width_20">Date</th>
                </tr>
                </thead>

            </table>
        </div>
    </div>
</div>
