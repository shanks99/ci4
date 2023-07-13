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

    /**
     * 등록
     */
    public function create()
    {
        # model 선언
        $model = model(NewsModel::class);

        # 검증
        if ($this->request->getMethod() === 'post' && $this->validate([
            'title' => 'required|min_length[3]|max_length[255]',
            'body'  => 'required',
        ])) {
            $model->save([
                /**
                 * - $this->request->getPost('필드명') : post 넘겨 받은 값
                 * - url_title : 공백->대시('-') 변경. 모두 소문자로 변경. 
                 */
                'title' => $this->request->getPost('title'),
                'slug'  => url_title($this->request->getPost('title'), '-', true),
                'body'  => $this->request->getPost('body'),
            ]);

            return view('news/success');
        }

        # View
        return view('templates/header', ['title' => 'Create a news item'])
            . view('news/create')
            . view('templates/footer');
    }
}