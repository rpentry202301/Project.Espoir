    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top w-100">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="/images/icon_coffee_beans.png" style="height: 39px;" alt="喫茶えすぽわぁる">喫茶えすぽわぁる
            </a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <form class="form-inline" method="GET" action="{{ route('top') }}">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select class="custom-select" name="category">
                                    <option value="">全て</option>
                                    @foreach ($categories as $category)
                                        <option value="primary:{{ $category->id }}" class="font-weight-bold">
                                            {{ $category->name }}</option>
                                        @foreach ($category->secondaryCategories as $secondary)
                                            <option value="secondary:{{ $secondary->id }}"> {{ $secondary->name }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                            <input type="text" name="keyword" class="form-control"
                                aria-label="Text input with dropdown button" placeholder="キーワード検索">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-outline-dark">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    @guest
                        {{-- 非ログイン --}}
                        <li class="nav-item">
                            <a class="btn btn-secondary ml-3" href="{{ route('register') }}" role="button">会員登録</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-info ml-2" href="{{ route('login') }}" role="button">ログイン</a>
                        </li>
                    @else
                        {{-- ログイン済み --}}
                        <li class="nav-item dropdown ml-2">
                            {{-- ログイン情報 --}}
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ $user->name }} さん<span class="caret"></span>
                            </a>

                            {{-- ドロップダウンメニュー --}}
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('mypage.edit-profile') }}">
                                    <i class="far fa-address-card text-left" style="width: 30px"></i>プロフィール編集
                                </a>

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt text-left" style="width: 30px"></i>ログアウト
                                </a>

                                <a class="dropdown-item" href="{{ route('show.item.cart') }}">
                                    <i class="fas fa-shopping-cart text-left" style="width: 30px"></i>カート
                                </a>

                                @if (Auth::check())
                                    @if ($user->admin_flag === 1)
                                        <a class="dropdown-item" href="{{ route('sell') }}">
                                            <i class="fas fa-box text-left" style="width:30px;"></i>商品を出品する
                                        </a>
                                    @endif
                                @endif

                                <a class="dropdown-item" href="{{ route('purchase-history') }}">
                                    <i class="fas fa-history" style="width: 30px"></i>購入履歴
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
