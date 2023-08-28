<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Modles\BlogModel;
use CodeIgniter\Files\File;

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
            'blog'  => $model->orderBy('id','DESC')->paginate(10),
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
        
            # File
            // ... Val
            $upfile = $this->request->getFile('upfile'); // 업로드한 파일
            $upfileError = ''; // 업로드 Error Msg

            // ... 존재시 rule 추가
            if ( $upfile ) {
                // -- rule 추가
                $rules['upfile'] = [
                    'label' => '첨부파일',
                    'rules' => 'uploaded[upfile]|is_image[upfile]|mime_in[upfile,image/jpg,image/jpeg,image/gif,image/png,image/webp]|max_size[upfile,100]|max_dims[upfile,1024,768]',
                ];

                // -- Check
                if ( $upfile->hasMoved() ) { 
                    $upfileError = '이미 업로드 된 파일';
                } 
            }

            # validate 판별
            if (!$this->validate($rules) && !empty($upfileError)) { // 실패
                // ... File
                if ( !empty($this->validator->getError['upfile']) && !empty($upfileError) ) {
                    $this->validator->getError['upfile'] = $upfileError;
                }

                // ... Result
                // View에서 $validation->getError('필드명')으로 실패 사유 활용
                return view('layout/header') 
                    . view('blog/create', ["validation" => $this->validator,])
                    . view('layout/footer');
            } else { // 성공
                // ... Model 호출
                $model = model(BlogModel::class);

                 // ... File
                 $fileNewName = '';
                 if ( !$upfile->hasMoved() ) {
                    // echo 'getName : '.$upfile->getName(); echo '<br>'; // sample.jpg    
                    // echo 'getClientName : '.$upfile->getClientName(); echo '<br>'; // sample.jpg   
                    // echo 'getTempName : '.$upfile->getTempName(); echo '<br>'; // /tmp/phpW1Do7r    
                    // echo 'getClientExtension : '.$upfile->getClientExtension(); echo '<br>'; // jpg   
                    // echo 'getRandomName : '.$upfile->getRandomName(); echo '<br>'; // 1690425522_419e24aeb585aa022530.jpg
                    // exit;    

                    $fileNewName = $upfile->getRandomName();
                    $filePath = WRITEPATH . 'uploads/' . $upfile->store('blog/',$fileNewName);

                    $fileInfo = base64_encode(serialize([
                        'origin' => $upfile->getClientName(),
                        'save' => $fileNewName,
                        'path' => WRITEPATH . 'uploads/blog',
                        'url' => 'uploads/blog/'.$fileNewName,
                    ]));
                }    
        
                // ... Data Insert
                $newData = [
                    'title' => $this->request->getVar('title'),
                    'content' => $this->request->getVar('content'),
                    'user_id' => session()->get('id'),
                    'user_email' => session()->get('email'),
                    'upfile' => $fileInfo,
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

        # File
        $data['blog']['upfile_info'] = [];
        if (!empty($data['blog']['upfile'])) {
            $data['blog']['upfile_info'] = unserialize(base64_decode($data['blog']['upfile']));
        }
        print_r($data['blog']['upfile_info']);
        
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

            # File
            // ... Val
            $upfile = $this->request->getFile('upfile'); // 업로드한 파일
            $upfileError = ''; // 업로드 Error Msg

            // ... 존재시 rule 추가
            if ( $upfile ) {
                // -- rule 추가
                $rules['upfile'] = [
                    'label' => '첨부파일',
                    'rules' => 'uploaded[upfile]|is_image[upfile]|mime_in[upfile,image/jpg,image/jpeg,image/gif,image/png,image/webp]|max_size[upfile,100]|max_dims[upfile,1024,768]',
                ];

                // -- Check
                if ( $upfile->hasMoved() ) { 
                    $upfileError = '이미 업로드 된 파일';
                } else {
                    $filePath = WRITEPATH . 'uploads/' . $upfile->store();
                    $fileInfo = new File($filePath);
                    // echo $fileInfo->getBasename(); 
                    // echo $fileInfo->getSizeByUnit('kb'); 
                    // echo $fileInfo->guessExtension(); 
                }
            }

            # validate 판별
            if (isset($rules) && !$this->validate($rules) && !empty($upfileError)) { // 실패
                // ... File
                if ( !empty($this->validator->getError['upfile']) && !empty($upfileError) ) {
                    $this->validator->getError['upfile'] = $upfileError;
                }

                // ... Result
                return view('layout/header') 
                    . view('blog/update', $data, ["validation" => $this->validator,])
                    . view('layout/footer');
            } else { // 성공
                // ... File
                if ( !$upfile->hasMoved() ) {
                    $filePath = WRITEPATH . 'uploads/' . $upfile->store();
                    $fileInfo = new File($filePath);
                    // echo $fileInfo->getBasename(); 
                    // echo $fileInfo->getSizeByUnit('kb'); 
                    // echo $fileInfo->guessExtension(); 
                }

                // ... Data Update
                $newData = [
                    'title' => $this->request->getVar('title'),
                    'content' => $this->request->getVar('content'),
                    'upfile' => $fileInfo->getBasename(),
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
