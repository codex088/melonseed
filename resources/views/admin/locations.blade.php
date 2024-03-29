@extends('admin.layouts.app')

@section('admin-content')
<div class="content">
  <div class="container-fluid">
    <div class="card strpied-tabled-with-hover">
      <div class="card-header ">
          <h4 class="card-title">Locations Management</h4>
      </div>
      <div class="row px-3">
        <div class="card-body table-full-width table-responsive m-0 col-md-6 col-12">
          <div class="form-group">
            <label>Region Name</label>
            <select class="form-control" name="region" maxlength="30">
              <option value="Toronto" selected>Toronto</option>
              <option value="York">York</option>
              <option value="Peel">Peel</option>
            </select>
            <label>Location Name</label>
            <input type="text" class="form-control" name="location_name" maxlength="30">
          </div>
          <div class="form-group">
            <button class="btn btn-primary" id="btn-add-location">Add</button>
          </div>
        </div>
        <div class="card-body table-full-width table-responsive m-0 col-md-6 col-12">
          <div class="table">
            <div class="table-head">
              <li class="list-item">
                <div class="location-id">ID</div>
                <div class="location-region">Region</div>
                <div class="location-name">Location Name</div>
              </li>
            </div>
            <ul class="table-body">
              @foreach ($locations as $location)
              <li class="list-item">
                <div class="location-id">{{ $location->id }}</div>
                <div class="location-region">{{ $location->region }}</div>
                <div class="location-name">{{ $location->location_name }}</div>
              </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('adminContentCss')
<style type="text/css">
  .table-head {
    font-weight: bold;
  }
  .table-body {
    list-style: none;
    padding: 0px;
    max-height: 568px;
    overflow: auto;
  }
  .list-item {
    display: inline-block;
    padding: 10px;
    min-width: 300px;
    width: 100%;
    border-bottom: solid 1px #eee;
    cursor: pointer;
  }
  .table-body .list-item:nth-child(odd) {
    background-color: #eee;
  }
  .location-id {
    display: inline-flex;
    width: 50px;
  }
  .location-region {
    display: inline-flex;
    width: 70px;
  }
  .location-name {
    display: inline-flex;
  }
</style>
@endpush
@push('adminContentJs')
<script type="text/javascript">
  $(document).ready( function () {
    // $('#locations-table').DataTable();
  });
  $(document).on('click', '#btn-add-location', function() {
    $.LoadingOverlay("show");
    $.ajax({
      type: 'POST',
      url: base_url + '/admin/locations',
      data: { 
        region: $('input[name=region]').val(), 
        location_name: $('input[name=location_name]').val() 
      },
      success: function(data) {
        // console.log('res-success: ', data);
        $.LoadingOverlay("hide");
        toastr.success(data.message);
        window.location.reload();
      },
      error: function(err) {
        $.LoadingOverlay("hide");
        console.log('err: ', err);
        if(err.responseJSON.region.length) {
          for(var i = 0; i < err.responseJSON.region.length; i++) {
            toastr.error(err.responseJSON.region[i]);
          }
        }
        if(err.responseJSON.location_name.length) {
          for(var i = 0; i < err.responseJSON.location_name.length; i++) {
            toastr.error(err.responseJSON.location_name[i]);
          }
        }
      }
    });
  });
</script>
@endpush
@endsection