<div class="container py-4">
    <div class="text-right">
        <a href="/blog/create" class="btn btn-primary" role="button">글쓰기</a>
    </div> 

    <?php if (! empty($blog) && is_array($blog)): ?>
    <ul class="list-group">    
        <?php foreach ($blog as $blog_item): ?>
        <li class="list-group-item">
            <a href="/blog/<?= esc($blog_item['id'], 'url') ?>">
                <?= esc($blog_item['title']) ?>
            </a>    
        </li>    
        <?php endforeach ?>
    </ul>    
    <?= $pager->links() ?>
    <?php else: ?>
        <h3>No List</h3>
        <p>등록된 게시물이 없어요</p>
    <?php endif ?>
</div>