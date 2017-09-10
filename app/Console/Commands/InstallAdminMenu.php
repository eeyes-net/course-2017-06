<?php

namespace App\Console\Commands;

use Encore\Admin\Auth\Database\Menu;
use Illuminate\Console\Command;

class InstallAdminMenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:menu:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create self defined admin page in menu list';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $menus = [
            ['title' => '课程列表', 'icon' => 'fa-bookmark', 'uri' => 'course'],
            ['title' => '教师列表', 'icon' => 'fa-user', 'uri' => 'teacher'],
            ['title' => '课程分类', 'icon' => 'fa-tags', 'uri' => 'category'],
            ['title' => '下载链接', 'icon' => 'fa-link', 'uri' => 'download'],
            ['title' => '所有评论', 'icon' => 'fa-comment', 'uri' => 'comment'],
            ['title' => '所有反馈', 'icon' => 'fa-retweet', 'uri' => 'feedback'],
            ['title' => 'API记录', 'icon' => 'fa-history', 'uri' => 'api_log'],
        ];
        foreach ($menus as $menu) {
            /** @var Menu $menu_model */
            $menu_model = Menu::firstOrNew(['uri' => $menu['uri']]);
            if ($menu_model->exists) {
                $this->info("Menu {$menu['title']} already exist");
            } else {
                $menu_model->title = $menu['title'];
                $menu_model->icon = $menu['icon'];
                $menu_model->save();
                $this->info("Menu {$menu['title']} added ok");
            }
        }
    }
}
