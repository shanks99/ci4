<!doctype html>
<html lang="ko">

<head>
  <title>섭스 ci4</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
</head>

<body>
  <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
      <svg class="bi me-2" width="40" height="32">
        <use xlink:href="#bootstrap"></use>
      </svg>
      <span class="fs-4">섭스 HomePage</span>
    </a>

    <ul class="nav nav-pills">
      <li class="nav-item"><a href="/" class="nav-link" aria-current="page">Home</a></li>
      <li class="nav-item"><a href="blog" class="nav-link">Blog</a></li>
      <li class="nav-item"><a href="news" class="nav-link">News</a></li>

      <?php if (!session()->get('isLoggedIn')): ?>
        <li class="nav-item"><a href="login" class="nav-link">Login</a></li>
        <li class="nav-item"><a href="register" class="nav-link">Register</a></li>
      <?php else: ?>
        <li class="nav-item"><a href="profile" class="nav-link">Profile</a></li>
        <li class="nav-item"><a href="user_update" class="nav-link">UserModify</a></li>
        <li class="nav-item"><a href="logout" class="nav-link">Logout</a></li>
      <?php endif; ?>
    </ul>
  </header>