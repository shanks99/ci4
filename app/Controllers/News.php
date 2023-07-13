<?php

namespace App\Controllers;

use App\Models\NewsModel;

class News extends BaseController
{
    /** 
     * 모든 News 가져오기 
     */
    public function index()
    {
        # model
        $model = model(NewsModel::class);

        # data 가져오기
        $data = [
            'news'  => $model->getNews(),
            'title' => 'News archive',
        ];

        # view
        return view('templates/header', $data)
            . view('news/overview')
            . view('templates/footer');
    }

    /**
     * slug 매칭 News 가져오기
     */
    public function view($slug = null)
    {
        # model 선언
        $model = model(NewsModel::class);

        # data 가져오기
        $data['news'] = $model->getNews($slug);

        if (empty($data['news'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the news item: ' . $slug);
        }

        $data['title'] = $data['news']['title'];

        # View
        return view('templates/header', $data)
        . view('news/view')
        . view('templates/footer');
    }
}