<div class="container py-4">
    <div class="row">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="card-title"><?= esc($blog['title']) ?></h5>
            </div>

            <div class="card-body p-4">
                <div class="form-group mb-3">
                    <p><?= esc($blog['content']) ?></p>
                    <?php if($blog['upfile_info']['origin']) : ?>
                    <img src="<?= base_url('/uploads/blog' . $blog['upfile_info']['save'])?>" alt="">    
                    <?php endif; ?>    
                    <p><?= esc($blog['upfile_info']['origin']) ?></p>
                    <hr>
                    <p>등록 : <?= $blog['created_at'] ?></p>
                    <p>수정 : <?= $blog['updated_at'] ?></p>
                </div>
            </div>
        </div>    
    </div>

    <div class="right">
        <a href="/blog/update/<?= $blog['id'] ?>" class="btn btn-warning" role="button">수정</a>
        <a href="/blog/delete/<?= $blog['id'] ?>" class="btn btn-danger" role="button">삭제</a>
    </div>
</div>