<!DOCTYPE html>
<html>
<head>
    <title>Zarządzenie kategoriami</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link href="/css/treeview.css" rel="stylesheet">
</head>
<body>
<div class="container col-md-12">
    <div class="panel panel-primary">
        <div class="panel-heading">Zarządzenie kategoriami</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <h3>Lista kategorii</h3>
                    <ul id="tree1">
                        @foreach($categories as $category)
                            <li>
                                {{ $category->name }}
                                @if(count($category->children))
                                    @include('category.subcategory',['children' => $category->children])
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <h3>Dodaj nową kategorię</h3>

                    <form action="{{route('category.store')}}" method="POST">
                        @csrf

                        @if ($message = Session::get('store'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif

                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">

                            <input type="text" name="name" placeholder="name">
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
                            <label for="parent_id">Wybierz węzeł docelowy</label>
                            <select name="parent_id">
                                <option value="">Brak</option>
                                @foreach($allCategories as $categories)
                                    <option value="{{$categories->id}}">{{$categories->name}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('parent_id') }}</span>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-success" type="submit">Dodaj</button>
                        </div>

                    </form>
                </div>

                <div class="col-md-3">
                    <h3>Przenieś</h3>
                    <form action="{{route('category.update')}}" method="post">

                        @if ($message = Session::get('update'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        @if ($message = Session::get('updateLoop'))
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        @if ($message = Session::get('updateMain'))
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif

                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="categoryToUpdate">Wybierz węzeł źródłowy</label>
                            <select name="categoryToUpdate">
                                @foreach($allCategories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="node">Wybierz węzeł docelowy</label>
                            <select name="node">
                                @foreach($allCategories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-warning" type="submit">Przenieś</button>
                        </div>
                    </form>
                </div>

                <div class="col-md-3">
                    <h3>Zmień pozycję</h3>
                    <form action="{{route('category.change')}}" method="post">

                        @if ($message = Session::get('change-ok'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif

                        @if ($message = Session::get('change-fail'))
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif

                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="sourceCategory">Wybierz węzeł do przeniesienia</label>
                            <select name="sourceCategory">
                                @foreach($allCategories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="targetCategory">Wybierz miejsce docelowe</label>
                            <select name="targetCategory">
                                @foreach($allCategories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-info" type="submit">Przenieś</button>
                        </div>
                    </form>
                </div>

                <div class="col-md-3">
                    <h3>Usuń kategorię</h3>
                    <form action="{{route('category.destroy')}}" method="post">

                        @if ($message = Session::get('destroy'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif

                        @csrf
                        @method('DELETE')
                        <div class="form-group">
                            <select name="categoryToDelete">
                                @foreach($allCategories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">Usuń</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<script src="/js/treeview.js"></script>
</body>
</html>
