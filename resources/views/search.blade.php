<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="keywords" content="教务处,教室,在用教室,检索">
    <meta name="description" content="广西师范大学教务处在用教室查询">
    <meta name="author" content="FuRongxin">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>检索 | {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->
    <!-- Font Awesome Icons -->
    <link href="{{ asset('vendor/font-awesome/css/fontawesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/font-awesome/css/brands.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/font-awesome/css/regular.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/font-awesome/css/solid.min.css') }}" rel="stylesheet">
    
    <!---Bootstrap 4 -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- App Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Custom Styles -->
    @stack('styles')
</head>
<body>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-center">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <h2>{{ $calendar->nd }} ~ {{ $calendar->nd + 1 }}学年度{{ $calendar->term->mc }}学期在用教室查询</h2>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </nav>
            <form action="{{ route('search') }}" method="get">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="input-group my-3">
                            <select id="campus" name="campus" class="custom-select">
                                <option value="all">全部校区</option>
                                @foreach ($campuses as $item)
                                    <option value="{{ $item->dm }}" {{ $item->dm == $campus ? 'selected' : ''}}>{{ $item->mc }}</option>
                                @endforeach
                            </select>
                            <select id="building" name="building" class="custom-select">
                                <option value="all" class="all {{ $campuses->implode('dm', ' ') }}">全部教学楼</option>
                                @foreach ($buildings as $item)
                                    <option value="{{ $item->dm }}" class="all {{ $item->xqh }}" {{ $item->dm == $building ? 'selected' : ''}}>{{ $item->mc }}</option>
                                @endforeach
                            </select>
                            <select id="week" name="week" class="custom-select">
                                <option value="all">全部时间</option>
                                @foreach (range(1, 7) as $item)
                                    <option value="{{ $item }}" {{ $item == $week ? 'selected' : '' }}>{{ config('setting.weeks.' . $item) }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" id="search" name="search" value="search">检索</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            @if (!empty($usings))
                <div class="row justify-content-center">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title text-center">常规使用信息</h3>
                                <table id="usingTable" class="table table-striped">
                                    <thead>
                                        <th><i>#</i></th>
                                        <th>校区</th>
                                        <th>教学楼</th>
                                        <th>教室名称</th>
                                        <th>始末周次</th>
                                        <th>始末节次</th>
                                        <th>使用目的</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($usings as $item)
                                            <tr>
                                                <td><i>{{ $loop->iteration }}</i></td>
                                                <td>{{ $item->classroom->campus->mc }}</td>
                                                <td>{{ $item->classroom->building->mc }}</td>
                                                <td>{{ $item->classroom->mc }}</td>
                                                <td>{{ $item->present()->b2eWeek }}</td>
                                                <td>{{ $item->present()->b2eSection }}</td>
                                                <td>{{ $item->md }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (!empty($temp))
                <div class="row justify-content-center">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title text-center">临时教室使用信息</h3>
                                <table id="usingTable" class="table table-striped">
                                    <thead>
                                        <th><i>#</i></th>
                                        <th>校区</th>
                                        <th>教学楼</th>
                                        <th>教室名称</th>
                                        <th>始末周次</th>
                                        <th>始末节次</th>
                                        <th>使用目的</th>
                                        <th>申请人</th>
                                        <th>使用日期</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($temp as $item)
                                            <tr>
                                                <td><i>{{ $loop->iteration }}</i></td>
                                                <td>{{ $item->classroom->campus->mc }}</td>
                                                <td>{{ $item->classroom->building->mc }}</td>
                                                <td>{{ $item->classroom->mc }}</td>
                                                <td>{{ $item->present()->b2eWeek }}</td>
                                                <td>{{ $item->present()->b2eSection }}</td>
                                                <td>{{ $item->sy }}</td>
                                                <td>{{ $item->xm }}</td>
                                                <td>{{ $item->syrq }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    
    <!-- Main Footer -->
    <footer class="main-footer container-fluid">
        &copy; 2019 <a href="http://www.dean.gxnu.edu.cn">广西师范大学教务处</a>. 版权所有.
        <div class="float-right d-done d-sm-inline-block">
            技术支持：广西师范大学教务处信息技术科
        </div>
    </footer>
    
    <!-- Scripts -->
    <!-- jQuery -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.chained.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- App -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Custom Scripts -->
    @stack('scripts')
    
    <script>
    $(function() {
        $('#building').chained('#campus');
    });
    </script>
</body>
</html>
