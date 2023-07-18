<?php

namespace App\Validation;
use App\Models\User;

class Userrules
{
  // public function custom_rule(): bool
  // {
  //     return true;
  // }

  ## Email 존재 판별 (register 사용)
  public function validateExist(string $str, string $fields, array $data) {
    # Model 호출
    $model = new User();
    
    # 이메일 Match Data 가져오기
    $user = $model->where($fields, $data[$fields])
                  ->first(); 

    # Result
    return !$user ? true : false; // true(미존재), false(중복)
  }

  ## Email, PW 일치 판별 (login 사용)
  public function validateUser(string $str, string $fields, array $data) {
      # Model 호출
      $model = new User();

      # 이메일 Match Data 가져오기
      $user = $model->where('email', $data['email'])
                    ->first();

      # Check              
      if(!$user)
        return false;

      # Result  
      // 비밀번호 Hash 비교 결과 Return  
      return password_verify($data['password'], $user['password']);
  }
}
