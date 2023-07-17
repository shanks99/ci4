<!doctype html>
<html lang="ko">
  <head>
    <title>회원가입</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
  </head>
  <body>
      <div class="container py-4">
      <?php $validation =  \Config\Services::validation(); ?>
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 m-auto">
                <form method="POST" action="<?= base_url('user') ?>">
                    <?= csrf_field() ?>

                    <!-- display flash data message -->
                    <?php
                        if(session()->getFlashdata('success')):?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="btn-close" data-bs-dismiss="alert">&times;</button>
                                <?php echo session()->getFlashdata('success') ?>
                            </div>
                        <?php elseif(session()->getFlashdata('failed')):?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="btn-close" data-bs-dismiss="alert">&times;</button>
                                <?php echo session()->getFlashdata('failed') ?>
                            </div>
                    <?php endif; ?>

                    <div class="card shadow">
                        <div class="card-header">
                            <h5 class="card-title">Register User</h5>
                        </div>

                        <div class="card-body p-4">
                        
                            <div class="form-group mb-3 has-validation">
                                <label class="form-label">이름</label>
                                <input type="text" class="form-control <?php if($validation->getError('name')): ?>is-invalid<?php endif ?>" name="name" placeholder="Name" value="<?php echo set_value('name'); ?>"/>
                                <?php if ($validation->getError('name')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('name') ?>
                                    </div>                                
                                <?php endif; ?>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">이메일</label>
                                <input type="text" class="form-control <?php if($validation->getError('email')): ?>is-invalid<?php endif ?>" name="email" placeholder="Email" value="<?php echo set_value('email'); ?>"/>
                                    <?php if ($validation->getError('email')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('email') ?>
                                    </div>                                
                                <?php endif; ?>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">비밀번호</label>
                                <input type="password" class="form-control <?php if($validation->getError('password')): ?>is-invalid<?php endif ?>" name="password" placeholder="Password" value="<?php echo set_value('password'); ?>"/>
                                    <?php if ($validation->getError('password')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('password') ?>
                                    </div>                                
                                <?php endif; ?>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">비밀번호 재확인</label>
                                <input type="password" class="form-control <?php if($validation->getError('confirm_password')): ?>is-invalid<?php endif ?>" name="confirm_password" placeholder="Confirm Password" value="<?php echo set_value('confirm_password'); ?>"/>
                                    <?php if ($validation->getError('confirm_password')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('confirm_password') ?>
                                    </div>                                
                                <?php endif; ?>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">휴대폰</label>
                                <input type="text" class="form-control <?php if($validation->getError('phone')): ?>is-invalid<?php endif ?>" name="phone" placeholder="Phone" value="<?php echo set_value('phone'); ?>"/>
                                    <?php if ($validation->getError('phone')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('phone') ?>
                                    </div>                                
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label class="form-label">주소</label>
                                <textarea class="form-control <?php if($validation->getError('address')): ?>is-invalid<?php endif ?>" name="address" placeholder="Address"><?php echo set_value('address'); ?></textarea> 
                                    <?php if ($validation->getError('address')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('address') ?>
                                    </div>                                
                                <?php endif; ?>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
  </body>
</html>