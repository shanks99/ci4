<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Modles\BlogModel;

class BlogController extends BaseController
{
    // constructor
    public function __construct()
    {
        # 사용할 helper 선언
        helper(['form']);
    }

    /**
	 * List    
	 *
	 * @return void
	 */
    public function index() { 
        # init
        $data = [];

        # Model 호출
        $model = model(BlogModel::class);

        # Data 가져오기
        $data = [
            'blog'  => $model->paginate(10),
            'pager' => $model->pager,
        ];

        # Page Default View
        return view('layout/header')
            . view('blog/index', $data)
            . view('layout/footer');
    }
        
    /**
	 * Write    
	 *
	 * @return void
	 */
    public function create() { 
        # init
        $data = [];
        
        # Validation
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'title' => [
                    'label' => '제목',
                    'rules' => 'required|min_length[2]',
                    'errors' => [
                        'required' => '제목을 입력 해주세요',
                        'min_length' => '2자 이상 입력 해주세요'
                    ]
                ],
                'content' => [
                    'label' => '내용',
                    'rules' => 'required|min_length[5]',
                    'errors' => [
                        'required' => '내용을 입력 해주세요',
                        'min_length' => '5자 이상 입력 해주세요'
                    ]
                ],
            ];
        
            # validate 판별
            if (!$this->validate($rules)) { // 실패
                // ... Result
                // View에서 $validation->getError('필드명')으로 실패 사유 활용
                return view('layout/header') 
                    . view('blog/create', ["validation" => $this->validator,])
                    . view('layout/footer');
            } else { // 성공
                // ... Model 호출
               $model = model(BlogModel::class);
        
                // ... Data Insert
                $newData = [
                    'title' => $this->request->getVar('title'),
                    'content' => $this->request->getVar('content'),
                    'user_id' => session()->get('id'),
                    'user_email' => session()->get('email'),
                ];
                $model->save($newData);
        
                // ... Etc
                $session = session();
                $session->setFlashdata('success', 'Successful Registration');
        
                // ... Result
                return redirect()->to(base_url('blog'));
            }
        }
        
        # Page Default View
        return view('layout/header')
            . view('blog/create')
            . view('layout/footer');
    }

    /**
	 * Read    
	 *
	 * @return void
	 */
    public function view($id = null) { 
        # init
        $data = [];

        # Model 호출
       $model = model(BlogModel::class);

        # 일치 Data 가져오기
        $data['blog'] = $model->where('id', $id)->first();

        # Result
        return view('layout/header')
            . view('blog/view', $data)
            . view('layout/footer');    
    }

    /**
	 * Modify    
	 *
	 * @return void
	 */
    public function update($id = null) { 
        # init
        $data = [];

        # Model 호출
       $model = model(BlogModel::class);

        # 일치 Data 가져오기
        $data['blog'] = $model->where('id', $id)->first();

        # Validation
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'title' => [
                    'label' => '제목',
                    'rules' => 'required|min_length[2]',
                    'errors' => [
                        'required' => '제목을 입력 해주세요',
                        'min_length' => '2자 이상 입력 해주세요'
                    ]
                ],
                'content' => [
                    'label' => '내용',
                    'rules' => 'required|min_length[5]',
                    'errors' => [
                        'required' => '내용을 입력 해주세요',
                        'min_length' => '5자 이상 입력 해주세요'
                    ]
                ],
            ];

            # validate 판별
            if (isset($rules) && !$this->validate($rules)) { // 실패
                // ... Result
                return view('layout/header') 
                    . view('blog/update', $data, ["validation" => $this->validator,])
                    . view('layout/footer');
            } else { // 성공

                // ... Data Update
                $newData = [
                    'title' => $this->request->getVar('title'),
                    'content' => $this->request->getVar('content'),
                ];

                $model->update($id, $newData);

                // ... Etc
                $session = session();
                $session->setFlashdata('success', 'Successful Update');

                // ... Result
                return redirect()->to(base_url('blog/'.$id));
            }
        }

        # Result
        return view('layout/header')
        . view('blog/update', $data)
        . view('layout/footer');
    }

    /**
	 * Delete    
	 *
	 * @return void
	 */
    public function delete($id = null) { 
        # init
        $data = [];

        # Model 호출
       $model = model(BlogModel::class);

        # Process
        $model->delete($id);

        # Result
        return redirect()->to(base_url('blog'));
    }
}
