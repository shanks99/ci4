<div class="container py-4">
    <?php $validation =  \Config\Services::validation(); ?>

    <div class="row">
        <form class="" action="<?= base_url('blog/create') ?>" method="post">
            <?= csrf_field() ?>
                
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="card-title">Blog 등록</h5>
                </div>

                <div class="card-body p-4">
                    <div class="form-group mb-3">
                        <label class="form-label">제목</label>
                        <input type="text" class="form-control <?php if($validation->getError('title')): ?>is-invalid<?php endif ?>" name="title" placeholder="title" value="<?php echo set_value('title'); ?>"/>
                            <?php if ($validation->getError('title')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('title') ?>
                            </div>                                
                        <?php endif; ?>
                    </div>
                
                    <div class="form-group">
                        <label class="form-label">내용</label>
                        <textarea class="form-control <?php if($validation->getError('content')): ?>is-invalid<?php endif ?>" name="content" placeholder="content"><?php echo set_value('content'); ?></textarea> 
                            <?php if ($validation->getError('content')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('content') ?>
                            </div>                                
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">등록</button>
                </div>                
            </div>                
        </form>
    </div>    
</div>