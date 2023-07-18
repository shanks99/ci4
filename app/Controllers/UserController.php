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
        helper(['form']);
    }

    /**
     * 로그인
     *
     * @return void
     */
    public function login() {
        # init
        $data = [];

        if ($this->request->getMethod() == 'post') {
            # Validation
            $rules = [
                'email' => [
                    'label' => '이메일',
                    'rules' => 'required|valid_email|validateUser[email]',
                    'errors'=> [
                        'required'  => '이메일을 입력 해주세요',
                        'valid_email' => '정확한 이메일을 입력 해주세요',
                        'validateUser'=> '입력하신 이메일을 확인 해주세요 (가입정보 없음)'
                    ]
                ],
                'password' => [
                    'label' => '비밀번호',
                    'rules' => 'required|min_length[4]|validateUser[password]',
                    'errors'=> [
                        'required'  => '비밀번호를 입력 해주세요',
                        'min_length' => '4자 이상 입력 해주세요',
                        'validateUser'=> '입력하신 비밀번호를 확인 해주세요'
                    ]
                ],
            ];

            # validate 판별
            if (!$this->validate($rules)) { // 실패
                // ... Result
                // View에서 $validation->getError('필드명')으로 실패 사유 활용    
                return view('layout/header') 
                    . view('users/login', [ "validation" => $this->validator,])
                    . view('layout/footer');

            } else { // 성공
                // ... Model 호출
                $model = new User();

                // ... 일치 Data 가져오기
                $user = $model->where('email', $this->request->getVar('email'))
                    ->first();

                // ... Etc    
                $this->setUserSession($user); // 세션부여

                // ... Result
                return redirect()->to(base_url('profile'));

            }
        }

        # Page Default View
        return view('layout/header')
            . view('users/login')
            . view('layout/footer');
    }

    /**
     * 세션 부여
     *
     * @return void
     */
    private function setUserSession($user)
    {
        # 대상 fields 지정
        $data = [
            'id' => $user['id'],
            'name' => $user['name'],
            'phone' => $user['phone'],
            'email' => $user['email'],
            'isLoggedIn' => true,
        ];

        # 세션 부여
        session()->set($data);
        return true;
    }

     /**
     * 회원가입
     *
     * @return void
     */
    public function register() {
        # init
        $data = [];

        if ($this->request->getMethod() == 'post') {
            # Validation
            $rules = [
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
                    'rules' => 'required|valid_email|validateExist[email]',
                    'errors' => [
                        'required' => '이메일을 입력 해주세요',
                        'valid_email' => '정확한 이메일을 입력 해주세요',
                        'validateExist' => '이미 가입된 이메일'
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
                    'rules' => 'required|numeric|regex_match[/^[0-9]{10,11}$/]|validateExist[phone]',
                    'errors' => [
                        'required' => '휴대폰을 입력 해주세요',
                        'numeric' => '숫자만 입력 해주세요',
                        'regex_match' => '정확한 휴대폰 번호를 입력 해주세요 (숫자 10~11 자리)',
                        'validateExist' => '이미 등록된 휴대폰'
                    ]
                ],
            ];

            # validate 판별
            if (!$this->validate($rules)) { // 실패
                // ... Result
                // View에서 $validation->getError('필드명')으로 실패 사유 활용
                return view('layout/header') 
                    . view('users/register', ["validation" => $this->validator,])
                    . view('layout/footer');
            } else { // 성공
                // ... Model 호출
                $model = new User();

                // ... Data Insert
                $newData = [
                    'name' => $this->request->getVar('name'),
                    'phone' => $this->request->getVar('phone'),
                    'email' => $this->request->getVar('email'),
                    'address' => $this->request->getVar('address'),
                    'password' => $this->request->getVar('password'), // 여기서 password_hash 해줘도 되지만, Model > beforeInsert에서 처리 함
                ];
                $model->save($newData);

                // ... Etc
                $session = session();
                $session->setFlashdata('success', 'Successful Registration');

                // ... Result
                return redirect()->to(base_url('login'));
            }
        }

        # Page Default View
        return view('layout/header')
            . view('users/register')
            . view('layout/footer');
    }

     /**
     * 프로필
     *
     * @return void
     */
    public function profile() {
        # init
        $data = [];

        # Model 호출
        $model = new User();

        # 일치 Data 가져오기
        $data['user'] = $model->where('id', session()->get('id'))->first();

        # Result
        return view('layout/header')
            . view('users/profile', $data)
            . view('layout/footer');
    }

    /**
     * 로그아웃
     *
     * @return void
     */
    public function logout() {
        # 세션 remove
        session()->destroy();

        # Result
        return redirect()->to(base_url('login'));
    }

    /**
     * Create User
     *
     * @return void
     */
    /*
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
    */
}
