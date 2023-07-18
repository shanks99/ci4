<div class="container py-4">
    <?php $validation =  \Config\Services::validation(); ?>
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 m-auto">
                <form class="" action="<?= base_url('login') ?>" method="post">
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
                            <h5 class="card-title">로그인</h5>
                        </div>

                        <div class="card-body p-4">
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

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Login</button>
                            </div>
                        </div>
                    </div>        
            </div>
        </div>
</div>