<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Reimbursements
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Reimbursement</a></li>
        <li class="active">Approve Reimbursement</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <?php if($this->session->flashdata('success')): ?>
          <div class="col-md-12">
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4><i class="icon fa fa-check"></i> Success!</h4>
                  <?php echo $this->session->flashdata('success'); ?>
            </div>
          </div>
        <?php elseif($this->session->flashdata('error')):?>
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4><i class="icon fa fa-check"></i> Failed!</h4>
                  <?php echo $this->session->flashdata('error'); ?>
            </div>
          </div>
        <?php endif;?>

        <div class="col-xs-12">
          <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Approve Reimbursement</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Staff</th>
                    <th>Photo</th>
                    <th>ID</th>
                    <th>Department</th>
                    <th>Reason</th>
                    <th>Amount</th>
                    <th>Applied On</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                    if(isset($content)):
                    $i=1; 
                    foreach($content as $cnt): 
                  ?>
                      <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $cnt['staff_name']; ?></td>
                        <td><img src="<?php echo base_url(); ?>uploads/profile-pic/<?php echo $cnt['pic'] ?>" class="img-circle" width="50px" alt="User Image"></td>
                        <td><?php echo $cnt['staff_id']; ?></td>
                        <td><?php echo $cnt['department_name']; ?></td>
                        <td><?php echo $cnt['reason']; ?></td>
                        <td><?php echo $cnt['amount']; ?></td>
                        <td><?php echo date('Y-m-d', strtotime($cnt['applied_on'])); ?></td>
                        <td><?php echo date('Y-m-d', strtotime($cnt['updated_on'])); ?></td>
                        <td>
                          <a href="<?php echo base_url(); ?>reimbursement-approved/<?php echo $cnt['id']; ?>/<?php echo $cnt['staff_id']; ?>/<?php 
                            $reimburse_amt = (double) $cnt['amount'];
                            $reimburse_curr = (double) $cnt['reimbursement'];
                            $reimburse_total = $reimburse_amt + $reimburse_curr; 
                            echo $reimburse_total; 
                          ?>/<?php 
                            $reimburse_amt = (double) $cnt['amount'];
                            $reimburse_curr = (double) $cnt['reimbursement'];
                            $allowance = (double) $cnt['allowance'];
                            $basic = (double) $cnt['basic_salary'];
                            $total = $reimburse_amt + $reimburse_curr + $allowance + $basic;
                            echo $total;
                          ?>" class="btn btn-success">Approve</a>
                          <a href="<?php echo base_url(); ?>reimbursement-rejected/<?php echo $cnt['id']; ?>/<?php echo $cnt['staff_id']; ?>" class="btn btn-danger">Reject</a>
                        </td>
                      </tr>
                    <?php 
                      $i++;
                      endforeach;
                      endif; 
                    ?> 
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

    