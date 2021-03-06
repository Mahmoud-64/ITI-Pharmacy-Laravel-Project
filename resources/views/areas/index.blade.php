@extends('layouts.app')
@section('content')

<div class="container">

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-12">

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">DataTable with default features</h3>
            <a href="{{route('areas.create')}}" class="btn btn-info float-right"><i class="fas fa-plus"></i>Add Area</a>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered" id="areas">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Address</th>
                  <th>Actions</th>
                </tr>
              </thead>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>

<div id="confirmModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h2 class="modal-title">Confirmation</h2>
      </div>
      <div class="modal-body">
        <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#areas').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      ajax: "{{ url('/areas') }}",
      columns: [{
          data: 'id',
          name: 'id'
        },
        {
          data: 'name',
          name: 'name'
        },
        {
          data: 'address',
          name: 'address'
        },
        {
          data: 'action',
          name: 'action'
        },
      ]
    });


    $(document).on('click', '.delete', function() {
      area_id = $(this).attr('id');

      const token = $('meta[name="csrf-token"]').attr('content');
      console.log(token);
      $('#confirmModal').modal('show');
    });

    $('#ok_button').click(function() {
      const token = $('meta[name="csrf-token"]').attr('content');
      $.ajax({
        url: "/areas/" + area_id,
        type: "delete",
        data: {
          'id': area_id,
          '_token': token,
        },
        beforeSend: function() {
          $('#ok_button').text('Deleting...');
        },
        success: function(data) {
          setTimeout(function() {
            $('#confirmModal').modal('hide');
            $('#ok_button').text('OK');
            $('#areas').DataTable().ajax.reload();
          }, 2000);
        }
      })
    });

  })
</script>

@endsection