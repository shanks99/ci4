<?php
namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        /**
         * 기본 일때 보이는 View
         * - ex) http://localhost:8080
         */
        return view('welcome_message');
    }

    public function view($page = 'home')
    {
        /**
         * 실제 파일이 존재하는지 체크
         * - 존재X => "404 Page not found" 오류
         * - PageNotFoundException 은 기본 오류 페이지 표시하는 예외
         */
        if (! is_file(APPPATH . 'Views/pages/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }

        /**
         * 변수 사용 정의
         * - [Controller] $data['title'] == [View] $title 
         */
        $data['title'] = ucfirst($page); // Capitalize the first letter

        /**
         * Header + Body + Footer 보여주기
         */
        return view('templates/header', $data)
            . view('pages/' . $page)
            . view('templates/footer');
    }
}