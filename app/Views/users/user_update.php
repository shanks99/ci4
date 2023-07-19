<div class="container py-4">
      <?php $validation =  \Config\Services::validation(); ?>
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 m-auto">
                <form method="POST" action="<?= base_url('user_update') ?>">
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
                            <h5 class="card-title">회원 정보수정</h5>
                        </div>

                        <div class="card-body p-4">
                        
                            <div class="form-group mb-3 has-validation">
                                <p>이름 : <?= $user['name'] ?></p>
                            </div>

                            <div class="form-group mb-3 has-validation">
                                <p>이메일 : <?= $user['email'] ?></p>
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
                                <input type="text" class="form-control <?php if($validation->getError('phone')): ?>is-invalid<?php endif ?>" name="phone" placeholder="Phone" value="<?php echo set_value('phone', $user['phone']); ?>"/>
                                    <?php if ($validation->getError('phone')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('phone') ?>
                                    </div>                                
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label class="form-label">주소</label>
                                <textarea class="form-control <?php if($validation->getError('address')): ?>is-invalid<?php endif ?>" name="address" placeholder="Address"><?php echo set_value('address', $user['address']); ?></textarea> 
                                    <?php if ($validation->getError('address')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('address') ?>
                                    </div>                                
                                <?php endif; ?>
                            </div>

                        </div>

                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>