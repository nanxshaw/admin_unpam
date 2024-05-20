<?php
include "../../component/header/header.php";
include '../../controllers/user/user_controllers.php';

// Handle form submissions
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//   if (isset($_POST['add'])) {
//     addUser($_POST['users_id'],$_POST['username'], $_POST['password'], $_POST['status']);
//   } elseif (isset($_POST['update'])) {
//     updateUser($_POST['user_id'], $_POST['username'], $_POST['password'], $_POST['status']);
//   } elseif (isset($_POST['delete'])) {
//     deleteUser($_POST['user_id']);
//   }
// }

// Retrieve all users
// $users = getAllUsers();

// if (empty($users)) {
//   echo "<p>No users found or an error occurred.</p>";
// }
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>DataTables</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">DataTables</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data User</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="form-group">
                <button type="button" class="btn btn-sm btn-info" id="btn_add">Add Data</button>
                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-default">Edit Data</button>
                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-default">Delete Data</button>
              </div>
              <table id="tabel" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>


                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

<div class="modal fade" id="modal_add">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Form Input Data User</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label for="">User ID</label>
        <input type="text" class="form-control" id="users_id" name="users_id" />
        <label for="">Username</label>
        <input type="text" class="form-control" id="username" name="username" />
        <label for="">Password</label>
        <input type="password" class="form-control" id="password" name="password" />
        <label for="">Status</label>
        <select class="form-control" id="status" name="status">
          <option value="1">Aktif</option>
          <option value="2">Tidak Aktif</option>
        </select>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" name="btn_simpan" id="btn_simpan" class="btn btn-primary">Simpan</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<?php include "../../component/footer/footer.php"; ?>

<script>
  $(function() {
    $("#tabel").DataTable();
    loadData();

    $("#btn_add").click(function() {
      $('#modal_add').modal('show');
      reset();
    })

    function reset() {
      $('#users_id').val('');
      $('#username').val('');
      $('#password').val('');
      $('#status').val('');
    }

    $('#btn_simpan').on('click', function(e) {
      var users_id = $('#users_id').val();
      var username = $('#username').val();
      var password = $('#password').val();
      var status = $('#status').val();

      if (users_id == '')
        alert('User ID wajib diisi!')
      else if (username == '')
        alert('Username wajib diisi!')
      else if (password == '')
        alert('Password wajib diisi!')
      else if (status == '')
        alert('Status wajib diisi!')
      else {
        // var str_data = "users_id=" + users_id + "&username=" + username + "&password=" + password + "$status=" + status;
        $.ajax({
          url: "/admin/controllers/user/user_controllers.php?action=addUser",
          type: 'POST',
          data: {
            users_id: users_id,
            username: username,
            password: password,
            status: status
          },
          success: function(data) {
            console.log(data);
            alert("Data berhasil disimpan");
            loadData();
            $('#modal_add').modal('hide');
          },
          error: function(xhr, status, error) {
            console.error("Error:", error);
          }
        })
      }

    });
  });

  // function loadData() {
  //   $.ajax({
  //     url: "/admin/controllers/user/user_controllers.php?action=getUsers", 
  //     type: 'GET',
  //     success: function(data) {
  //       // $('#tabel').DataTable().fnClearTable();
  //       // $('#tabel').DataTable().fnDraw();
  //       // $('#tabel').DataTable().fnDestroy();
  //       // $('#tabel tbody').html();
  //       // $('#tabel').DataTable();


  //     },
  //     error: function(xhr, status, error) {
  //       console.error("Error:", error);
  //     }
  //   });
  // }

  function loadData() {
    $.ajax({
      url: "/admin/controllers/user/user_controllers.php?action=getUsers",
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        var table = $('#tabel').DataTable();
        table.clear().draw();

        if (data.length > 0) {
          $.each(data, function(index, user) {
            var status = user.status === '1' ? 'Aktif' : 'Tidak Aktif';
            var row = [
              index + 1,
              user.users_id,
              user.username,
              user.password,
              status,
              '<button type="submit" class="btn btn-warning">Edit</button>' +
              '<button type="submit" class="btn btn-danger">Delete</button>'
            ];
            table.row.add(row).draw();
          });
        } else {
          table.row.add(['No users found.', '', '', '', '', '']).draw();
        }
      },
      error: function(xhr, status, error) {
        console.error("Error:", error);
      }
    });
  }
</script>