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
    <div class="container-fluid">

        <!-- Content wrapper -->
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content">
                <div class="container">
                    <form action="{{ route('search') }}" method="get">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="input-group my-3">
                                    <input type="text" name="keyword" id="keyword" class="form-control form-control-lg" placeholder="数据库检索"" aria-label="数据库检索"" aria-describedby="btnSearch" value="{{ old('keyword', $keyword) }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary btn-lg" type="submit" id="search">{{ __('Search') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <dl class="row">
                                            <dt class="col-sm-2 text-right">首字母</dt>
                                            <dd class="col-sm-10">
                                                @foreach (range('A', 'Z') as $item)
                                                    <div class="form-check form-check-inline">
                                                        <input type="checkbox" name="letters[]" id="{{ $item }}" class="form-check-input" value="{{ $item }}" {{ !is_null($letters) && in_array($item, $letters) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="{{ $item }}">{{ $item }}</label>
                                                    </div>
                                                @endforeach
                                                <div class="form-check form-check-inline">
                                                    <input type="checkbox" name="letters[]" id="number" class="form-check-input" value="number" {{ !is_null($letters) && in_array('number', $letters) ? 'checked' : ''}}>
                                                    <label class="form-check-label" for="number">0~9</label>
                                                </div>
                                            </dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-2 text-right">学科</dt>
                                            <dd class="col-sm-10">
                                                @foreach ($subjects as $item)
                                                    <div class="form-check form-check-inline">
                                                        <input type="checkbox" name="subjects[]" id="subject-{{ $item->id }}" class="form-check-input" value="{{ $item->id }}" {{ !is_null($subject) && in_array($item->id, $subject) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="subject-{{ $item->id }}">{{ $item->name }}</label>
                                                    </div>
                                                @endforeach
                                            </dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-2 text-right">内容类型</dt>
                                            <dd class="col-sm-10">
                                                @foreach ($types as $item)
                                                    <div class="form-check form-check-inline">
                                                        <input type="checkbox" name="types[]" id="type-{{ $item->id }}" class="form-check-input" value="{{ $item->id }}" {{ !is_null($type) && in_array($item->id, $type) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="type-{{ $item->id }}">{{ $item->name }}</label>
                                                    </div>
                                                @endforeach
                                            </dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-2 text-right">语种</dt>
                                            <dd class="col-sm-10">
                                                @foreach ($languages as $item)
                                                    <div class="form-check form-check-inline">
                                                        <input type="checkbox" name="languages[]" id="language-{{ $item->id }}" class="form-check-input" value="{{ $item->id }}" {{ !is_null($language) && in_array($item->id, $language) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="language-{{ $item->id }}">{{ $item->name }}</label>
                                                    </div>
                                                @endforeach
                                            </dd>
                                        </dl>
                                        <dl class="row">
                                            <dt class="col-sm-2 text-right">状态</dt>
                                            <dd class="col-sm-10">
                                                <div class="form-check form-check-inline">
                                                    <input type="checkbox" name="statuses[]" id="trial" class="form-check-input" value="0" {{ !is_null($status) && in_array(0, $status) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="trial">{{ __('Trial') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="checkbox" name="statuses[]" id="normal" class="form-check-input" value="1" {{ !is_null($status) && in_array(1, $status) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="normal">{{ __('Normal') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="checkbox" name="statuses[]" id="open" class="form-check-input" value="2" {{ !is_null($status) && in_array(2, $status) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="open">{{ __('Opening') }}</label>
                                                </div>
                                            </dd>
                                        </dl>
                                    </div>

                                    <table id="itemsTable" class="table table-striped datatable">
                                        <thead>
                                            <th width="30%">数据库名称</th>
                                            <th width="40%">数据库简介</th>
                                            <th>访问地址</th>
                                            <th width="8%">状态</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($databases as $database)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('database.show', $database) }}" title="{{ $database->name }}">{{ $database->name }}</a>
                                                    </td>
                                                    <td>
                                                        @empty($database->brief)
                                                            {{ \Illuminate\Support\Str::limit($database->content, 120) }}
                                                        @else
                                                            {{ $database->brief }}
                                                        @endempty
                                                    </td>
                                                    <td>
                                                        @unless (empty($database->remote_url))
                                                            <div>
                                                                远程包库：
                                                                @foreach (explode('|', $database->remote_url) as $url)
                                                                    <a href="{{ $url }}" title="{{ __('Link') . $loop->iteration }}" target="_blank">{{ __('Link') . $loop->iteration }}</a>
                                                                @endforeach
                                                            </div>
                                                        @endunless
                                                        @unless (empty($database->local_url))
                                                            <div>
                                                                本地镜像：
                                                                @foreach (explode('|', $database->local_url) as $url)
                                                                    <a href="{{ $url }}" title="{{ __('Link') . $loop->iteration }}" target="_blank">{{ __('Link') . $loop->iteration }}</a>
                                                                @endforeach
                                                            </div>
                                                        @endunless
                                                    </td>
                                                    <td>{{ $database->present()->status }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="justify-content-center">
                                    {{ $databases->appends($_GET)->links() }}
                                </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>

        <!-- Main Footer -->
        <footer class="main-footer">
            &copy; 2019 <a href="http://www.dean.gxnu.edu.cn">广西师范大学教务处</a>. 版权所有.
            <div class="float-right d-done d-sm-inline-block">
                技术支持：广西师范大学教务处信息技术科
            </div>
        </footer>
    </div>
    
    <!-- Scripts -->
    <!-- jQuery -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- App -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Custom Scripts -->
    @stack('scripts')
</body>
</html>
