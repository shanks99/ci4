<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;

class UserController extends BaseController
{
    /**
     * constructor
     */
    public function __construct()
    {
        # 사용할 helper 선언
        helper(['form', 'url']);
    }

    /**
     * User Registration form
     *
     * @return void
     */
    public function index()
    {
        # 기본 회원가입으로 이동
        return view('users/registration');
    }

    /**
     * Register User
     *
     * @return void
     */
    public function create() {
        
        # validate inputs
        $inputs = $this->validate([
            'name' => [
                'label' => '이름',
                'rules' => 'required|min_length[2]',
                'errors' => [
                    'required' => '이름을 입력 해주세요',
                    'min_length' => '2자 이상 입력 해주세요'
                ]
            ],
            'email' => [
                'label' => '이메일',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => '이메일을 입력 해주세요',
                    'valid_email' => '정확한 이메일을 입력 해주세요'
                ]
            ],
            'password' => [
                'label' => '비밀번호',
                'rules' => 'required|min_length[4]|alpha_numeric',
                'errors' => [
                    'required' => '비밀번호를 입력 해주세요',
                    'min_length' => '4자 이상 입력 해주세요',
                    'alpha_numeric' => '알파벳, 숫자만 입력 해주세요'
                ]
            ],
            'confirm_password' => [
                'label' => '비밀번호 재확인',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => '비밀번호 재확인을 입력 해주세요',
                    'matches' => '비밀번호가 일치 하지 않아요'
                ],
            ],
            'phone' => [
                'label' => '휴대폰',
                'rules' => 'required|numeric|regex_match[/^[0-9]{10,11}$/]',
                'errors' => [
                    'required' => '휴대폰을 입력 해주세요',
                    'numeric' => '숫자만 입력 해주세요',
                    'regex_match' => '정확한 휴대폰 번호를 입력 해주세요 (숫자 10~11 자리)'
                ]
            ],
            'address' => [
                'label' => '주소',
                'rules' => 'required|min_length[10]',
                'errors' => [
                    'required' => '주소를 입력 해주세요',
                    'min_length' => '10자 이상 입력 해주세요'
                ]
            ]
        ]);

        # 회원가입 페이지로 이동
        if (!$inputs) {
            return view('users/registration', [
                'validation' => $this->validator
            ]);
        }

        # insert data 
        $user = new User;
        $user->save([
            'name' => $this->request->getVar('name'),
            'email'  => $this->request->getVar('email'),
            'password'  => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'phone'  => $this->request->getVar('phone'),
            'address'  => $this->request->getVar('address')
        ]);

        session()->setFlashdata('success', 'Success! registration completed.');
        return redirect()->to(site_url('/user'));
    }
}
