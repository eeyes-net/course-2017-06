<div class="container">
    <nav class="navbar">
        <div class="navbar-brand">
            <a class="navbar-item" href="/">
                <img src="/images/logo/course.png" alt="选课宝典logo" width="28" height="28">
                <span style="margin-left: .5em; font-size: 18px; font-family: 黑体, 微软雅黑, Arial, Helvetica, sans-serif;">{{ config('app.name') }}</span>
            </a>

            <div class="navbar-burger burger" data-target="navMenuExample">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <div class="navbar-menu">
            <div class="navbar-start">
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link is-active" href="{{ action('Web\CourseController@index') }}">
                        课程
                    </a>
                    <div class="navbar-dropdown">
                        @foreach($categories as $category)
                        <a class="navbar-item" href="{{ action('Web\CategoryController@courses', ['name' => $category->name]) }}">
                            {{ $category->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
                <a class="navbar-item" href="{{ action('Web\TeacherController@index') }}">
                    教师
                </a>
            </div>

            <div class="navbar-end">
                <div class="navbar-item">
                    <form action="/s" method="GET">
                        <div class="field is-grouped">
                            <div class="control has-icons-left is-expanded">
                                <input type="search" name="q" class="input is-flat required email" placeholder="搜索课程、教师..." aria-required="true">
                                <span class="icon is-small is-left"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="navbar-item has-dropdown is-hoverable">
                    <div class="navbar-link">
                        关于
                    </div>
                    <div class="navbar-dropdown ">
                        <a class="navbar-item" href="/about" target="_blank">
                            <span class="icon"><img src="/images/logo/course.png" alt="e学堂logo"></span>
                            e学堂
                        </a>
                        <a class="navbar-item" href="https://www.eeyes.net/" target="_blank">
                            <span class="icon"><img src="/images/logo/eeyes_icon.gif" alt="eeyes icon"></span>
                            e瞳网
                        </a>
                    </div>
                </div>
                <div class="navbar-item has-dropdown is-hoverable">
                    <div class="navbar-link">
                        相关链接
                    </div>
                    <div class="navbar-dropdown ">
                        <a class="navbar-item" href="/admin" target="_blank">
                            <span class="icon"><i class="fa fa-gear"></i></span>
                            后台管理
                        </a>
                        <a class="navbar-item" href="/docs" target="_blank">
                            <span class="icon"><i class="fa fa-book"></i></span>
                            开发文档
                        </a>
                        <a class="navbar-item" href="https://github.com/eeyes-net/course-2017-06" target="_blank">
                            <span class="icon"><i class="fa fa-github"></i></span>
                            Fork me on GitHub
                        </a>
                        <a class="navbar-item" href="https://www.eeyes.net/" target="_blank">
                            <span class="icon"><img src="/images/logo/eeyes_icon.gif" alt="eeyes icon"></span>
                            e瞳网
                        </a>
                        <a class="navbar-item" href="http://eux.eeyes.net/" target="_blank">
                            <span class="icon"><img src="/images/logo/eux_icon.gif" alt="eux icon"></span>
                            e瞳前端用户体验中心
                        </a>
                    </div>
                </div>
                <div class="navbar-item">
                    <div class="field is-grouped">
                        <p class="control">
                            <a class="button is-primary weapp-code-modal-show" href="javascript:">
                                <span class="icon"><i class="fa fa-qrcode"></i></span>
                                <span>微信小程序</span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>
<div class="modal weapp-code-modal">
    <div class="modal-background weapp-code-modal-hide"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">e学堂微信小程序二维码</p>
            <button class="delete weapp-code-modal-hide" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
            <p class="has-text-centered">
                <img src="/images/weapp_code_course.jpg" alt="e学堂微信小程序二维码">
            </p>
            <p>打开微信，扫描上方二维码，可打开e学堂微信小程序。</p>
            <p>在小程序中，您还可以对课程和教师发表评论，审核成功后显示在内容下方评论区。</p>
            <p>如果有任何意见也可以在小程序中反馈，我们会仔细阅读每一条意见或建议的。</p>
        </section>
    </div>
</div>
<script>
    (function () {
        var elWeappCodeModal = document.querySelector('.weapp-code-modal');
        document.querySelector('.weapp-code-modal-show').addEventListener('click', function () {
            elWeappCodeModal.className += ' is-active';
        });
        var els = document.querySelectorAll('.weapp-code-modal-hide');
        for (var i = 0; i < els.length; ++i) {
            els[i].addEventListener('click', function () {
                elWeappCodeModal.className = elWeappCodeModal.className.replace(/is-active/g, '');
            });
        }
    })();
</script>