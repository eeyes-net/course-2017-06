<nav class="navbar">
    <div class="navbar-brand">
        <a class="navbar-item" href="/">
            <img src="/images/logo/course.png" alt="选课宝典logo" width="28" height="28">
            <span style="margin-left: .5em; font-size: 18px; font-family: 黑体, 微软雅黑, Arial, Helvetica, sans-serif;">选课宝典</span>
        </a>

        <div class="navbar-burger burger" data-target="navMenuExample">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div id="navMenuExample" class="navbar-menu">
        <div class="navbar-start">
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link is-active" href="{{ action('Web\CourseController@index') }}">
                    课程
                </a>
                <div class="navbar-dropdown ">
                    <a class="navbar-item " href="#">
                        大一课程
                    </a>
                    <a class="navbar-item " href="#">
                        大二课程
                    </a>
                    <a class="navbar-item " href="#">
                        必修课成
                    </a>
                </div>
            </div>
            <a class="navbar-item" href="{{ action('Web\TeacherController@index') }}">
                教师
            </a>
        </div>

        <div class="navbar-end">
            <div class="navbar-item has-dropdown is-hoverable">
                <div class="navbar-link">
                    关于
                </div>
                <div id="moreDropdown" class="navbar-dropdown ">
                    <a class="navbar-item" href="https://github.com/eeyes-net/course-2017-06" target="_blank">
                        <span class="icon">
                            <img src="/images/logo/course.png" alt="选课宝典logo">
                        </span>
                        选课宝典
                    </a>
                    <a class="navbar-item" href="https://github.com/eeyes-net/course-2017-06" target="_blank">
                        <span class="icon"><i class="fa fa-github"></i></span>
                        GitHub
                    </a>
                    <a class="navbar-item" href="https://www.eeyes.net/" target="_blank">
                        <span class="icon"></span>
                        e瞳网
                    </a>
                    <a class="navbar-item" href="http://eux.eeyes.net/" target="_blank">
                        <span class="icon"></span>
                        e瞳前端用户体验中心
                    </a>
                </div>
            </div>
            <div class="navbar-item">
                <div class="field is-grouped">
                    <p class="control">
                        <a class="button is-primary" href="#">
                            <span class="icon"><i class="fa fa-qrcode"></i></span>
                            <span>微信小程序</span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</nav>