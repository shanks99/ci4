<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    ## Table 지정
    protected $table = 'news';

    ## DB에 저장할 필드 설정
    protected $allowedFields = ['title', 'slug', 'body'];

    public function getNews($slug = false)
    {
        # slug 미존재 -> 전체 가져오기 (obj 반환)
        if ($slug === false) {
            return $this->findAll();
        }

        # slug 존재 -> 첫 데이터 가져오기
        return $this->where(['slug' => $slug])->first();
    }
}