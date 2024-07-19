<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        :root {
            --bs-body-bg: var(--bs-gray-100);
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{route('frontend.home')}}">Ecommerce</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{route('frontend.home')}}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="{{route('category.index')}}" class="nav-link @yield('category')">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                            Category
                          </p>
                        </a>
                      </li> --}}
                      {{-- <li class="nav-item">
                        <a href="{{route('product.index')}}" class="nav-link @yield('product')">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                            Product
                          </p>
                        </a>
                      </li> --}}

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Category
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{route('frontend.productList', ['slug' => 'all'])}}" class="nav-link">All</a></li>
                            @foreach($categories as $category)
                            <li><a class="dropdown-item" href="{{route('frontend.productList', $category->slug)}}" class="nav-link">{{$category->name}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                
                </ul>
                
            </div>
        </div>
    </nav>

   @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
